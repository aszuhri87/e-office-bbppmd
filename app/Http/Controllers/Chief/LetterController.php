<?php

namespace App\Http\Controllers\Chief;

use App\Http\Controllers\ApiController;
use App\Models\Letter;
use App\Models\LetterUser;
use App\Models\LetterWish;
use App\Models\Position;
use App\Models\UnitLetter;
use App\Models\User;
use App\Models\Wish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Mail;
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

        // if ($user->hasRole('admin') || $user->hasRole('superadmin')) {
        //     $letter_user->where('positions.level', '!=', 'Admin')
        //     ->where('positions.level', '!=', 'Super Admin');
        // }

        // dd($letter_wish->get());

        $data = Letter::select([
            'letters.*',
            'letters.id',
            DB::raw("to_char(letters.created_at , 'dd FMMonthFM YYYY HH24:mi' ) as tanggal"),
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
                    THEN CONCAT(positions.level,' pada ', to_char(letter_users.created_at , 'dd FMMonthFM YYYY HH24:mi'))
                    ELSE CONCAT(positions.level,' ', positions.name,' pada ', to_char(letter_users.created_at , 'dd FMMonthFM YYYY HH24:mi'))
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

        // $admin = Admin::where('user_id', Auth::id())->first();

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

                // dd($request->forwarded);
                // foreach ($request->input('forwarded') as $forward) {
                //     $position = Position::whereIn('id', [$forward])->first();
                //     // $user_id = $position[$i]['user_id'];

                //     $letter_user = LetterUser::create([
                //     'letter_id' => $data->id,
                //     'user_id' => $position->user_id,
                // ]);

                //     $unit_letter = UnitLetter::create([
                //     'letter_id' => $letter_user->letter_id,
                //     'letter_user_id', $letter_user->id,
                // ]);
                // }

                // for ($i = 0; $i < count($request->forwarded); ++$i) {
                //     $position[$i] = Position::whereIn('id', [$request->forwarded[$i]])->first();
                //     $user_id = $position[$i]['user_id'];

                //     $letter_user = LetterUser::create([
                //         'letter_id' => $data->id,
                //         'user_id' => $user_id,
                //     ]);

                //     $unit_letter = UnitLetter::create([
                //         'letter_id' => $letter_user->letter_id,
                //         'letter_user_id', $letter_user->id,
                //     ]);
                // }

                // foreach ($request->input('wish') as $w) {
                //     $letter_wish = LetterWish::create([
                //         'unit_letter_id' => $unit_letter->id,
                //         'wish_id' => $w,
                //     ]);
                // }

                // dd($position->user_id);

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
        // $doc_category_req = DocumentCategoryRequirement::select([
        //     'requirement_types.data_type as data_type',
        //     'requirement_types.description as title', 'document_category_requirements.*',
        // ])
        // ->leftJoin('requirement_types', 'requirement_types.requirement_type', 'document_category_requirements.requirement_type')
        // ->whereNull(['document_category_requirements.deleted_at', 'requirement_types.deleted_at']);

        $letter_unit = UnitLetter::select(
            ['unit_letters.*', 'letter_wishes.unit_letter_id', 'letter_wishes.*', 'letter_wishes.wish_id', 'wishes.id as wishes_id', 'wishes.name as wish_name']
            )

            ->join('letter_wishes', 'letter_wishes.unit_letter_id', 'unit_letters.id')
            ->leftJoin('wishes', 'wishes.id', 'letter_wishes.wish_id')
            ->where('unit_letters.letter_id', $id)
            ->whereNull('unit_letters.deleted_at');
        // ->first();

        $letter_user = LetterUser::select(
            ['letter_users.*', 'letter_users.user_id', 'positions.id as position_id', DB::raw("CONCAT(positions.level,' ', positions.name) as p_level")],
            )
            ->join('users', 'users.id', 'letter_users.user_id')
            ->leftJoin('positions', 'positions.user_id', 'users.id')
            ->where('letter_users.letter_id', $id)
            ->whereNull(['letter_users.deleted_at', 'users.deleted_at', 'positions.deleted_at'])
            ->groupBy(['letter_users.id', 'positions.id', 'users.id']);

        // dd($letter_wish->get());

        $data = Letter::select([
            'letters.*',
            'letters.id',
            // 'letter_unit.wishes_id',
            // 'letter_user.position_id',
            // 'letter_user.p_level',
        ])

        // ->join('letter_users', 'letter_users.letter_id', 'letters.id')
        // ->leftJoin('users', 'users.id', 'letter_users.user_id')
        // ->leftJoin('positions', 'positions.user_id', 'users.id')
        // ->join('unit_letters', 'unit_letters.letter_id', 'letters.id')
        // ->leftJoinSub('letter_wishes', 'letter_wishes.unit_letter_id', 'unit_letters.id')
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
        ->with(['letter_user' => function ($query) {
            $query->select(
                ['letter_users.*', 'letter_users.user_id', 'positions.id as position_id', DB::raw("CONCAT(positions.level,' ', positions.name) as p_level"),
                DB::raw("
                CASE
                WHEN letter_users.notes IS NOT NULL AND positions.level IS NOT NULL AND positions.name IS NOT NULL
                THEN CONCAT(letter_users.notes,' - ',positions.level,' ', positions.name)
                END as note"), ],
                )
                ->join('users', 'users.id', 'letter_users.user_id')
                ->leftJoin('positions', 'positions.user_id', 'users.id')
                // ->where('letter_users.letter_id', $id)
                ->whereNull(['letter_users.deleted_at', 'users.deleted_at', 'positions.deleted_at'])
                ->groupBy(['letter_users.id', 'positions.id', 'users.id']);
        },
        ])

        // ->joinSub($letter_user, 'letter_user', function ($join) {
        //     $join->on('letter_user.letter_id', 'letters.id');
        // })
        // ->joinSub($letter_unit, 'letter_unit', function ($join) {
        //     $join->on('letter_unit.letter_id', 'letters.id');
        // })
        // ->leftJoin('wishes', 'wishes.id', 'letter_wishes.wish_id')
        ->distinct('letter_file')
        ->where('letters.id', $id)
        ->whereNull('letters.deleted_at')
        ->groupBy(['letters.id'])
        ->first();
        // dd(count($data->unit_letter));

        // ->with(['wishes' => function ($query) {
        //     $query->select(['wishes.id as wish_id', 'wishes.name as wish_name']);
        // },
        // ])

        // dd($data);

        return Response::json($data);
    }

    public function update(Request $request, $id)
    {
        try {
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

                        // dd($position);
                        // $user_id = $position[$i]['user_id'];

                        // $letter_users = LetterUser::where('letter_id', $id)->first();

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
                    }

                    foreach ($request->input('wish') as $w) {
                        $letter_wish = LetterWish::updateOrCreate([
                                        'unit_letter_id' => $unit_letter->id,
                                        'wish_id' => $w,
                                    ]);
                    }
                }

                // if
            // $position = Position::where('id', $request->forwarded)->first();

            // $letter_user = LetterUser::create([
            //     'user_id' => $position->user_id,
            // ]);
            //     return $data;
            // });
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
}
