<?php

namespace App\Http\Controllers;

use App\Models\Infografis;
use Illuminate\Http\Request;

class InfografisController extends Controller
{
    public function index()
    {
        $infografis = Infografis::latest()->get();
        return view('infografis.index', compact('infografis'));
    }
}
