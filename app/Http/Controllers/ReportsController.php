<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sold;
use Illuminate\Http\Request;
use App\Http\Resources\Sold\SoldCollection;

class ReportsController extends Controller
{
    public function list(Request $request)
    {
        $sold = Sold::query();
        if($request->filled('date')) {
            $sold = $sold->where('created_at', '=', Carbon::parse($request->input('date')))->get();
        } else if ($request->filled('month') && $request->filled('month_year')) {
            $sold = $sold->whereYear('created_at', '=', $request->input('month_year'));
            $sold = $sold->whereMonth('created_at', '=', $request->input('month'))->get();
        } else if ($request->filled('year')) {
            $sold = $sold->whereYear('created_at', '=', $request->input('year'))->get();
        } else {
            $sold = $sold->get();
        }

        $data = new SoldCollection($sold);
        return response()->json($data);
    }
}
