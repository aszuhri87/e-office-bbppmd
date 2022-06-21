<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class PositionController extends Controller
{
    public function index()
    {
        $unit = Unit::all();

        return view('admin.master_data.position.index', ['unit' => $unit]);
    }

    public function dt()
    {
        $data = DB::table('positions')
        ->select([
            'positions.*',
        ])
        ->whereNull('positions.deleted_at');

        return DataTables::query($data)->addIndexColumn()->make(true);
    }

    public function store(Request $request)
    {
        try {
            $data = Position::create([
                'name' => $request->name,
                'level' => $request->level,
            ]);

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
        $data = Position::select('*')->where('id', $id)->first();

        return Response::json($data);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Position::where('id', $id)->update([
                'name' => $request->name ? $request->name : $data->name,
                'level' => $request->level ? $request->level : $data->level,
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
            $result = Position::find($id);

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
