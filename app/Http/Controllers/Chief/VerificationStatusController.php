<?php

namespace App\Http\Controllers\Chief;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class VerificationStatusController extends Controller
{
    public function index()
    {
        return view('chief.verification_status.index');
    }

    public function find(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $letters = DB::table('letters')
        ->select([
            'letters.id',
            'letters.created_by',
            DB::raw("CONCAT(letters.letter_number,' - ',letters.from) as name"),
            ])
        ->where('letters.letter_number', 'ilike', '%'.$term.'%')
        ->whereNull('letters.deleted_at')
        ->get();

        $formatted_tags = [];

        foreach ($letters as $letter) {
            $formatted_tags[] = ['id' => $letter->id, 'text' => $letter->name, 'create' => $letter->created_by];
        }

        return \Response::json($formatted_tags);
    }

    public function show($id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $data = Letter::select([
            'letters.*',
            'letters.id',
            'users.name as created',
        ])
        ->with(['unit_letter' => function ($query) {
            $query->select(
                ['unit_letters.*', 'letter_wishes.unit_letter_id', 'letter_wishes.*', 'letter_wishes.wish_id', 'wishes.id as wishes_id', 'wishes.name as wish_name']
                )

                ->join('letter_wishes', 'letter_wishes.unit_letter_id', 'unit_letters.id')
                ->leftJoin('wishes', 'wishes.id', 'letter_wishes.wish_id')
                ->whereNull('unit_letters.deleted_at');
        },
        ])
        ->with(['letter_user' => function ($query) {
            $query->select(
                [
                    'letter_users.*',
                    'letter_users.user_id',
                    'positions.id as position_id',
                    DB::raw("CASE
                    WHEN positions.level='Admin' OR positions.level='Super Admin'
                    THEN CONCAT(positions.level,' pada ', to_char(letter_users.created_at , ' dd TMMonth YYYY, HH24:mi'))
                    ELSE CONCAT(positions.level,' ', positions.name,' pada ', to_char(letter_users.created_at , ' dd TMMonth YYYY, HH24:mi'))
                     END as p_level"),
                    DB::raw("
                    CASE
                    WHEN letter_users.notes IS NOT NULL
                    THEN CONCAT(letter_users.notes,' - ',positions.level,' ', positions.name)
                    END as note"),
                ], )
                ->join('users', 'users.id', 'letter_users.user_id')
                ->leftJoin('positions', 'positions.user_id', 'users.id')
                ->whereNull(['letter_users.deleted_at', 'users.deleted_at', 'positions.deleted_at'])
                ->orderBy('created_at', 'ASC')
                ->groupBy(['letter_users.id', 'positions.id', 'users.id']);
        },
        ])
        ->join('letter_users', 'letter_users.letter_id', 'letters.id')
        ->join('users', 'users.id', 'letters.created_by')
        ->where('letters.id', $id)
        ->whereNull('letters.deleted_at')
        ->first();

        return Response::json($data);
    }
}
