<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class WishController extends Controller
{
    public function index()
    {
        return view('admin.master_data.wish.index');
    }

    public function dt()
    {
        $data = DB::table('wishes')
        ->select([
            'wishes.*',
        ])
        ->whereNull('wishes.deleted_at');

        // $admin = Admin::where('user_id', Auth::id())->first();

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function store(Request $request)
    {
        try {
            $data = Wish::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            // return $data;

            Alert::success('Sukses', 'Berhasil Menambahkan Data!');

            return redirect()->back();

            return response([
                'data' => $data,
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
        $data = Wish::select('*')->where('id', $id)->first();

        return Response::json($data);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Wish::where('id', $id)->update([
                'name' => $request->name ? $request->name : $data->name,
                'description' => $request->description ? $request->description : $data->description,
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
            $result = Wish::find($id);

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
