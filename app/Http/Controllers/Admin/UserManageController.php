<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class UserManageController extends Controller
{
    public function index()
    {
        $data = DB::table('users')
        ->select('*')
        ->get();

        $unit = DB::table('units')
        ->select([
         '*',
        ])
        ->whereNull('deleted_at')->get();

        $positions = DB::table('positions')
        ->select([
         '*',
        ])
        ->whereNull('deleted_at')->get();

        return view(
            'admin.user_management.index',
            [
                'data' => $data,
                'unit' => $unit,
                'position' => $positions,
            ]
        );
    }

    public function dt()
    {
        $data = DB::table('users')
        ->select([
            'users.*',
            ])
        ->leftJoin('units', 'units.id', 'users.unit_id')
        ;

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function show($id)
    {
        $data = DB::table('users')
        ->select('users.*', 'positions.id as position_id')
        ->join('positions', 'positions.user_id', 'users.id')
        ->leftJoin('units', 'units.id', 'users.unit_id')
        ->where('users.id', $id)
        ->first();

        return Response::json($data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $result = DB::transaction(function () use ($request) {
                $position = Position::where('id', $request->select_position);

                $unit = Unit::where('name', $position->first()->level)->first();
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'unit_id' => $unit->id,
                ]);

                $position->update(
                    [
                     'user_id' => $user->id,
                    ]
                );

                $role_user = User::select('positions.level as level')
                ->leftJoin('positions', 'positions.user_id', 'users.id')
                ->where('users.id', $user->id)
                ->first();

                if ($role_user->level == 'Kepala Bagian') {
                    $user->assignRole('chief_of_division');
                } elseif ($role_user->level == 'Kepala Sub Bagian') {
                    $user->assignRole('chief_of_sub_division');
                } elseif ($role_user->level == 'Kepala') {
                    $user->assignRole('chief');
                } elseif ($role_user->level == 'Koordinator') {
                    $user->assignRole('coordinator');
                } elseif ($role_user->level == 'Admin') {
                    $user->assignRole('admin');
                } elseif ($role_user->level == 'Super Admin') {
                    $user->assignRole('superadmin');
                } else {
                    $user->assignRole('personil');
                }

                return $user;
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

    public function update(Request $request, $id)
    {
        try {
            $result = DB::transaction(function () use ($request, $id) {
                $position = Position::where('id', $request->select_position);

                $unit = Unit::where('name', $position->first()->level)->first();

                $user = User::find($id);
                $user->update([
                'name' => $request->name ? $request->name : $user->name,
                'email' => $request->email ? $request->email : $user->email,
                'username' => $request->username ? $request->username : $user->username,
                'password' => Hash::make($request->password) ? Hash::make($request->password) : $user->password,
                'unit_id' => $unit->id,
            ]);

                $position->update(
                [
                 'user_id' => $id,
                ]
            );

                $role_data = User::select('positions.level as level')
            ->leftJoin('positions', 'positions.user_id', 'users.id')
            ->where('users.id', $id)
            ->first();

                if ($role_data->level == 'Kepala Bagian') {
                    $user->syncRoles('chief_of_division');
                } elseif ($role_data->level == 'Kepala Sub Bagian') {
                    $user->syncRoles('chief_of_sub_division');
                } elseif ($role_data->level == 'Koordinator') {
                    $user->syncRoles('coordinator');
                } elseif ($role_data->level == 'Admin') {
                    $user->syncRoles('admin');
                } elseif ($role_data->level == 'Super Admin') {
                    $user->syncRoles('superadmin');
                } else {
                    $user->syncRoles('personil');
                }

                return $user;
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

    public function update_password(Request $request, $id)
    {
        try {
            $user = User::where('id', $id);
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return response([
                'data' => $data,
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
            $result = User::find($id);

            DB::transaction(function () use ($result) {
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
