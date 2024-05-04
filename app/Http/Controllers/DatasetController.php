<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use Illuminate\Http\Request;

class DatasetController extends Controller
{
    public function index()
    {
        return view('pages.datasets.index');
    }

    public function show()
    {
        return view('pages.datasets.show');
    }
}
