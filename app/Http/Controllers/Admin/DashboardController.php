<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Models\Letter;
use Illuminate\Support\Facades\DB;

class DashboardController extends ApiController
{
    public function index()
    {
        $chart = Letter::select(DB::raw('count(letters.id) as count'), DB::raw("to_char(letters.created_at, 'FMMonth') as month_name"))
        ->where('letters.id', '!=', null)
        ->whereYear('letters.created_at', date('Y'))
        ->groupBy('month_name')
        ->get();

        // dd($c_docs);

        $c_data = [];
        foreach ($chart as $row) {
            $c_data['label'][] = $row['month_name'];
            $c_data['data'][] = (int) $row['count'];
        }

        $json = json_encode($c_data, JSON_FORCE_OBJECT);

        // return view('admin/home', compact('widget', 'laporan', 'data'));

        return view('admin.dashboard.index',
        [
            'c_data' => $c_data,
        ]);
    }
}
