<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Devo generare in session un nuovo gioco se non già presente
        if (!Session::has('game')) {
            Session::forget('game');
        }
        $this->initSession();
        return view('dashboard');
    }

    private function initSession()
    {
        $now = Carbon::now();
        $cells = [];
        foreach(range(1, 9) as $y) {
            foreach(range(1, 9) as $x) {
                $cells[] = [
                    'xcoord' => $this->toLetter($x),  
                    'ycoord' => $y,
                    'value' => '',
                    'possibilities' => [],
                ];
            }
        }        
        
        $game = [
            'date' => $now->format('Y-m-d'),
            'time' => $now->format('H:i:s'),
            'cells' => $cells,
        ];

        Session::put('game', $game);
    }

    private function toLetter($value): string
    {
        return match($value) {
            1 => "A",
            2 => "B",
            3 => "C",
            4 => "D",
            5 => "E", 
            6 => "F",
            7 => "G",
            8 => "H",
            9 => "I"
        };
    }
}
