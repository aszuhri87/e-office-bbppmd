<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class InputLetterController extends Controller
{
    public function index()
    {
        $wish = DB::table('wishes')
        ->select('*')
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'asc')
        ->get();

        $position = DB::table('positions')
        ->select([
            'id',
            DB::raw("CONCAT(positions.level,' ', positions.name) as p_level"),
        ])
        ->where('positions.level', '!=', 'Admin')
        ->where('positions.level', '!=', 'Super Admin')
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'asc')
        ->get();

        // dd($position);

        return view('admin.input_letter.index',
            [
                'wish' => $wish,
                'position' => $position,
            ]
    );
    }

    public function print($id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $data = Letter::select([
            'letters.*',
            'letters.id',
            DB::raw("to_char(letters.date , 'dd-MM-YYYY' ) as date"),
            DB::raw("to_char(letters.received_date , 'dd-MM-YYYY' ) as received_date"),
            // 'letter_unit.wishes_id',
            // 'letter_user.position_id',
            // 'letter_user.p_level',
        ])

        ->with(['unit_letter' => function ($query) {
            $query->select(
                ['unit_letters.*', 'letter_wishes.unit_letter_id', 'letter_wishes.*', 'letter_wishes.wish_id', 'wishes.id as wishes_id', 'wishes.name as wish_name', 'letter_wishes.other_wishes']
                )

                ->join('letter_wishes', 'letter_wishes.unit_letter_id', 'unit_letters.id')
                ->leftJoin('wishes', 'wishes.id', 'letter_wishes.wish_id')
                // ->where('unit_letters.letter_id', $id)
                ->whereNull('unit_letters.deleted_at');
        },
        ])
        ->with(['letter_user' => function ($query) {
            $query->select(
                ['letter_users.*', 'letter_users.user_id', 'positions.id as position_id',
                    DB::raw("
                    CASE
                    WHEN letter_users.notes IS NOT NULL
                    THEN CONCAT(positions.level,' ', positions.name,' - ',letter_users.notes)
                    END as note"),
                    DB::raw("CONCAT(positions.level,' ', positions.name) as p_level"), ],
                )
                ->join('users', 'users.id', 'letter_users.user_id')
                ->leftJoin('positions', 'positions.user_id', 'users.id')
                // ->where('letter_users.letter_id', $id)
                ->whereNull(['letter_users.deleted_at', 'users.deleted_at', 'positions.deleted_at'])
                ->groupBy(['letter_users.id', 'positions.id', 'users.id']);
        },
        ])
        ->where('letters.id', $id)
        ->whereNull('letters.deleted_at')
        ->first();

        $wish = DB::table('wishes')
        ->select('*')
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'asc')
        ->get();

        $position = DB::table('positions')
        ->select([
            'id',
            DB::raw("CONCAT(positions.level,' ', positions.name) as p_level"),
        ])
        ->where('positions.level', '!=', 'Admin')
        ->where('positions.level', '!=', 'Super Admin')
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'asc')
        ->get();

        $wish_val = [];

        foreach ($data->unit_letter as $val) {
            $wish_val[] = $val->wish_id;
        }

        $pdf = PDF::loadView('admin/letter/print',
        [
                'data' => $data,
                'wish' => $wish,
                'position' => $position,
                'wish_val' => $wish_val,
                'logo' => base64_encode(file_get_contents(public_path('logo.png'))),
            ]
        )->setOptions(['defaultFont' => 'sans-serif'])->setPaper('A4', 'potrait');

        $name = date('Y-m-d_s').' '.$data->letter_number.'.pdf';

        Storage::put('public/pdf/'.$name, $pdf->output());

        return $pdf->stream($name);
    }

    public function download_all($id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $data = Letter::select([
            'letters.*',
            'letters.id',
            DB::raw("to_char(letters.date , 'dd-MM-YYYY' ) as date"),
            DB::raw("to_char(letters.received_date , 'dd-MM-YYYY' ) as received_date"),
            // 'letter_unit.wishes_id',
            // 'letter_user.position_id',
            // 'letter_user.p_level',
        ])

        ->with(['unit_letter' => function ($query) {
            $query->select(
                ['unit_letters.*', 'letter_wishes.unit_letter_id', 'letter_wishes.*', 'letter_wishes.wish_id', 'wishes.id as wishes_id', 'wishes.name as wish_name', 'letter_wishes.other_wishes']
                )

                ->join('letter_wishes', 'letter_wishes.unit_letter_id', 'unit_letters.id')
                ->leftJoin('wishes', 'wishes.id', 'letter_wishes.wish_id')
                // ->where('unit_letters.letter_id', $id)
                ->whereNull('unit_letters.deleted_at');
        },
        ])
        ->with(['letter_user' => function ($query) {
            $query->select(
                ['letter_users.*', 'letter_users.user_id', 'positions.id as position_id',
                    DB::raw("
                    CASE
                    WHEN letter_users.notes IS NOT NULL
                    THEN CONCAT(positions.level,' ', positions.name,' - ',letter_users.notes)
                    END as note"),
                    DB::raw("CONCAT(positions.level,' ', positions.name) as p_level"), ],
                )
                ->join('users', 'users.id', 'letter_users.user_id')
                ->leftJoin('positions', 'positions.user_id', 'users.id')
                // ->where('letter_users.letter_id', $id)
                ->whereNull(['letter_users.deleted_at', 'users.deleted_at', 'positions.deleted_at'])
                ->groupBy(['letter_users.id', 'positions.id', 'users.id']);
        },
        ])
        ->where('letters.id', $id)
        ->whereNull('letters.deleted_at')
        ->first();

        $pdfVersion = '1.4';
        $newFile = public_path('files/new/'.date('Y-m-d_s').'_'.$data->letter_number.'.pdf');
        $currentFile = public_path('files/'.$data->letter_file);

        echo shell_exec("gs -sDEVICE=pdfwrite -dCompatibilityLevel=$pdfVersion -dNOPAUSE -dBATCH -sOutputFile=$newFile $currentFile");

        $wish = DB::table('wishes')
        ->select('*')
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'asc')
        ->get();

        $position = DB::table('positions')
        ->select([
            'id',
            DB::raw("CONCAT(positions.level,' ', positions.name) as p_level"),
        ])
        ->where('positions.level', '!=', 'Admin')
        ->where('positions.level', '!=', 'Super Admin')
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'asc')
        ->get();

        $wish_val = [];

        foreach ($data->unit_letter as $val) {
            $wish_val[] = $val->wish_id;
        }

        $pdf = PDF::loadView('admin/letter/print',
        [
                'data' => $data,
                'wish' => $wish,
                'position' => $position,
                'wish_val' => $wish_val,
                'logo' => base64_encode(file_get_contents(public_path('logo.png'))),
        ]
            )->setOptions(['defaultFont' => 'sans-serif'])->setPaper('A4', 'potrait');

        Storage::put('public/pdf/'.date('Y-m-d_s').' '.$data->letter_number.'.pdf', $pdf->output());

        $pdfMerge = PDFMerger::init();

        // foreach ($request->file('filenames') as $key => $value) {
        //     $pdf->addPDF($value->getPathName(), 'all');

        // }

        $pdfMerge->addPDF(storage_path('app/public/pdf/'.date('Y-m-d_s').' '.$data->letter_number.'.pdf'), 'all');
        $pdfMerge->addPDF($newFile, 'all');

        $fileName = 'dokumen_lengkap_'.time().'.pdf';
        $pdfMerge->merge();
        $pdfMerge->save(public_path($fileName));

        echo ob_end_flush();

        return $pdfMerge->download(public_path($fileName));
    }
}
