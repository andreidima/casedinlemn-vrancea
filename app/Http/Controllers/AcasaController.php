<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\Proiect;
use Illuminate\Support\Facades\DB;

class AcasaController extends Controller
{
    public function acasa()
    {
        // Define date ranges
        // $startOfThisMonth = Carbon::now()->startOfMonth();
        // $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        // $endOfLastMonth   = Carbon::now()->subMonth()->endOfMonth();

        // 1. Count projects by created_at
        // $allProiecteCount   = Proiect::count();
        // $proiecteThisMonth  = Proiect::whereDate('created_at', '>=', $startOfThisMonth)->count();
        // $proiecteLastMonth  = Proiect::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

        return view('acasa'
            // , compact(
                // 'allProiecteCount',
                // 'proiecteThisMonth',
                // 'proiecteLastMonth',
            // )
        );
    }
}
