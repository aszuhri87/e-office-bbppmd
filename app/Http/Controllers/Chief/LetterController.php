<?php

namespace App\Http\Controllers\Chief;

use App\Http\Controllers\ApiController;
use App\Models\Letter;
use App\Models\LetterUser;
use App\Models\LetterWish;
use App\Models\Position;
use App\Models\UnitLetter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Mail;
use PDF;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use Yajra\DataTables\Facades\DataTables;

class LetterController extends ApiController
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
        ->where('positions.level', '!=', 'Kepala')
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'asc')
        ->get();

        // dd($position);

        return view('chief.letter.index',
            [
                'wish' => $wish,
                'position' => $position,
            ]
    );
    }

    public function dt()
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = User::where('id', Auth::id())->first();

        $user->with('roles')->where('id', Auth::id())->first();

        $data = Letter::select([
            'letters.*',
            'letters.id',
            DB::raw("to_char(letters.created_at , 'dd TMMonth YYYY, HH24:mi' ) as tanggal"),
            // 'letter_user.position_id',
            // 'letter_user.p_level',
        ])
        ->with(['unit_letter' => function ($query) {
            $query->select(
                ['unit_letters.*', 'letter_wishes.unit_letter_id', 'letter_wishes.*', 'letter_wishes.wish_id', 'wishes.id as wishes_id', 'wishes.name as wish_name']
                )

                ->join('letter_wishes', 'letter_wishes.unit_letter_id', 'unit_letters.id')
                ->leftJoin('wishes', 'wishes.id', 'letter_wishes.wish_id')
                // ->where('unit_letters.letter_id', $id)
                ->whereNull('unit_letters.deleted_at');
        },
        ])
        ->with(['letter_user' => function ($query) use ($user) {
            $query->select(
                [
                    'letter_users.*',
                    'letter_users.user_id',
                    'positions.id as position_id',
                    DB::raw("CASE
                    WHEN positions.level='Admin' OR positions.level='Super Admin'
                    THEN CONCAT(positions.level,' pada ', to_char(letter_users.created_at , 'dd TMMonth YYYY, HH24:mi'))
                    ELSE CONCAT(positions.level,' ', positions.name,' pada ', to_char(letter_users.created_at , 'dd TMMonth YYYY, HH24:mi'))
                     END as p_level"),
                    DB::raw("
                    CASE
                    WHEN letter_users.notes IS NOT NULL
                    THEN CONCAT(letter_users.notes,' - ',positions.level,' ', positions.name)
                    END as note"),
                ], )
                ->join('users', 'users.id', 'letter_users.user_id')
                ->leftJoin('positions', 'positions.user_id', 'users.id')
                // ->where('letter_users.letter_id', $id)
                ->whereNull(['letter_users.deleted_at', 'users.deleted_at', 'positions.deleted_at'])
                ->orderBy('created_at', 'ASC')
                ->groupBy(['letter_users.id', 'positions.id', 'users.id']);

            if ($user->hasRole('chief_of_division')) {
                $query->where('positions.level', '!=', 'Admin')
                    ->where('positions.level', '!=', 'Super Admin')
                    ->where('positions.level', '!=', 'Kepala');
            } elseif ($user->hasRole('chief_of_sub_division')) {
                $query->where('positions.level', '!=', 'Admin')
                    ->where('positions.level', '!=', 'Super Admin')
                    ->where('positions.level', '!=', 'Kepala')
                    ->where('positions.level', '!=', 'Kepala Bagian');

                if ($query->orderBy('created_at', 'desc') == true) {
                    $query->where('positions.level', '!=', 'Admin')
                        ->where('positions.level', '!=', 'Super Admin')
                        ->where('positions.level', '!=', 'Kepala')
                        ->where('positions.level', '!=', 'Kepala Bagian');
                }
            } elseif ($user->hasRole('coordinator')) {
                $query->where('positions.level', '!=', 'Admin')
                    ->where('positions.level', '!=', 'Super Admin')
                    ->where('positions.level', '!=', 'Kepala')
                    ->where('positions.level', '!=', 'Kepala Bagian')
                    ->where('positions.level', '!=', 'Kepala Sub Bagian');
            } elseif ($user->hasRole('personil')) {
                $query->where('positions.level', '!=', 'Admin')
                    ->where('positions.level', '!=', 'Super Admin')
                    ->where('positions.level', '!=', 'Kepala')
                    ->where('positions.level', '!=', 'Kepala Bagian')
                    ->where('positions.level', '!=', 'Kepala Sub Bagian')
                    ->where('positions.level', '!=', 'Koordinator');
            }
        },
        ])
        ->join('letter_users', 'letter_users.letter_id', 'letters.id')
        ->whereNull('letters.deleted_at')
        ->orderBy('created_at', 'desc')
        ->groupBy('letters.id');

        return DataTables::eloquent($data)->addIndexColumn()->make(true);
    }

    public function store(Request $request)
    {
        try {
            date_default_timezone_set('Asia/Jakarta');

            $result = DB::transaction(function () use ($request) {
                if ($request->hasFile('letter_file')) {
                    $file = $request->file('letter_file');
                    $name = date('Y-m-d_s').'_'.$file->getClientOriginalName();
                    $file->move(storage_path().'/files/', $name);
                    // $path[] = $request->file('requirement_value')->store('public/files');
                }
                $data = Letter::create([
                        'name' => $request->name,
                        'from' => $request->from,
                        'letter_number' => $request->letter_number,
                        'date' => $request->date,
                        'received_date' => $request->received_date,
                        'agenda_number' => $request->agenda_number,
                        'trait' => $request->sifat,
                        'about' => $request->about,
                        // 'signature' => $request->signature,
                        'letter_file' => $name,
                        'created_by' => Auth::id(),
                ]);

                $letter_user = LetterUser::create([
                    'letter_id' => $data->id,
                    'user_id' => Auth::id(),
                     ]);

                return $data;
            });

            return response([
                'data' => $result,
                'message' => 'Data Tersimpan',
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $data = Letter::select([
            'letters.*',
            'letters.id',
            DB::raw("to_char(letters.date , 'dd-MM-YYYY' ) as date"),
            DB::raw("to_char(letters.received_date , 'dd-MM-YYYY' ) as received_date"),
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
                ['letter_users.*', 'letter_users.user_id', 'positions.id as position_id', DB::raw("CONCAT(positions.level,' ', positions.name) as p_level"),
                DB::raw("
                CASE
                WHEN letter_users.notes IS NOT NULL AND positions.level IS NOT NULL AND positions.name IS NOT NULL
                THEN CONCAT(positions.level,' ', positions.name,' - ',letter_users.notes)
                END as note"), ],
                )
                ->join('users', 'users.id', 'letter_users.user_id')
                ->leftJoin('positions', 'positions.user_id', 'users.id')
                // ->where('letter_users.letter_id', $id)
                ->whereNull(['letter_users.deleted_at', 'users.deleted_at', 'positions.deleted_at'])
                ->groupBy(['letter_users.id', 'positions.id', 'users.id']);
        },
        ])
        ->distinct('letter_file')
        ->where('letters.id', $id)
        ->whereNull('letters.deleted_at')
        ->groupBy('letters.id')
        ->first();

        return Response::json($data);
    }

    public function update(Request $request, $id)
    {
        try {
            // dd($request->lain);
            date_default_timezone_set('Asia/Jakarta');

            $result = DB::transaction(function () use ($request,$id) {
                $user = User::where('id', Auth::id())->first();

                $user->with('roles')->where('id', Auth::id())->first();

                // if ($user->hasRole('chief')) {
                if (!empty($request->notes)) {
                    $notes = LetterUser::create(
                       [
                        'letter_id' => $id,
                            'notes' => $request->notes,
                            'user_id' => Auth::id(),
                        ]);
                }
                // }

                if (!empty($request->input('forwarded'))) {
                    $forward[] = $request->input('forwarded');
                    foreach ($forward as $f) {
                        $position = Position::whereIn('id', $f)->get();

                        foreach ($position as $p) {
                            $letter_user = LetterUser::updateOrCreate([
                                        'letter_id' => $id,
                                        'user_id' => $p->user_id,
                                      ]);

                            $unit_letter = UnitLetter::updateOrCreate([
                                        'letter_id' => $id,
                                        'letter_user_id' => $letter_user->id,
                                    ]);

                            $user = User::where('id', $p->user_id)->first();
                            $user_now = User::where('id', Auth::id())->first();
                        }
                        Mail::send('email', [
                            'name' => $user->name,
                            'email' => $user->email,
                            'from' => $user_now->name,
                            'greet' => 'Permisi,', ],
                            function ($message) use ($user) {
                                $message->from('achmad.s.zuhri182@gmail.com', 'SITA SUTRO BBPPM');
                                $message->to($user->email, $user->name)
                                    ->subject('Notifikasi disposisi');
                            });
                    }

                    foreach ($request->input('wish') as $w) {
                        $letter_wish = LetterWish::updateOrCreate([
                                        'unit_letter_id' => $unit_letter->id,
                                        'wish_id' => $w,
                                        'other_wishes' => $request->input('lain'),
                                    ]);
                    }
                }
            });

            return response([
                'data' => $result,
                'message' => 'Data Terubah',
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $result = Letter::find($id);

            DB::transaction(function () use ($result,$id) {
                $file = Letter::where('id', $id)->get();
                foreach ($file as $f) {
                    $destinationPath[] = storage_path().'/files/'.$f->letter_file;
                    File::delete($destinationPath);
                }

                $result->delete();
            });

            if ($result->trashed()) {
                return response([
                    'message' => 'Successfully deleted!',
                ], 200);
            }
        } catch (Exception $e) {
            throw new Exception($e);

            return response([
                'message' => $e->getMessage(),
            ]);
        }
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

        $pdf = PDF::loadView('chief/letter/print',
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

        $pdf = PDF::loadView('chief/letter/print',
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
        $pdfMerge->addPDF(public_path('files/'.$data->letter_file), 'all');

        $fileName = 'dokumen_lengkap_'.time().'.pdf';
        $pdfMerge->merge();
        $pdfMerge->save(public_path($fileName));

        return response()->download(public_path($fileName));
    }
}
