<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function dateReport($date)
    {
        dd($date);
    }

    public function monthReport($month, $year)
    {
        dd($month);
    }

    public function yearReport($year)
    {
        dd($year);
    }
}
