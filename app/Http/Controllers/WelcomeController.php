<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use App\Models\Knowledge;

class WelcomeController extends Controller
{
    public function index()
    {
        $informasi = Informasi::latest()->first();
        $pengetahuan = Knowledge::inRandomOrder()->first();
        return view('welcome', [
            'informasi' => $informasi,
            'pengetahuan' => $pengetahuan,
        ]);
    }
}
