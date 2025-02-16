<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Schedules;

class HomeController extends Controller
{
    public function index()
    {
        // $rute = Rute::count();
        // $pendapatan = Pemesanan::where('status', 'Sudah Bayar')->sum('total');
        // $transportasi = Transportasi::count();
        $schedules = Schedules::count();
        
        return view('pages.home.index', compact('schedules'));
    }
}
