<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilDesaController extends Controller
{
    public function index() {
        return view ("user.profil-desa", [
            'title' => 'Profil Desa'
        ]);
    }
}
