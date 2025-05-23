<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\Produs;
use Illuminate\Support\Facades\DB;

class AcasaController extends Controller
{
    public function acasa()
    {
        $lowStock = Produs::whereColumn('cantitate','<=','prag_minim')->get();

        return view('acasa'
            , compact(
                'lowStock',
            )
        );
    }
}
