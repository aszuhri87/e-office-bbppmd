<?php

namespace App\Http\Controllers;

use App\Models\User;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    public function dt()
    {
        $users = DB::table('users')
            ->select([
                'uuid as id',
                'name',
                'email',
            ])
            ->whereNull('deleted_at');

        return DataTables::query($users)->addIndexColumn()->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return response([
                'data' => $user,
                'message' => 'Data Tersimpan',
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::table('users')
        ->select('*')
        ->leftJoin('units', 'units.id', 'users.unit_id')
        ->where('users.id', $id)
        ->first();

        return Response::json($data);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::where('uuid', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return response([
                'data' => $user,
                'message' => 'Data Terubah',
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::where('uuid', $id)->delete();

            return response([
                'message' => 'Data Terhapus',
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
