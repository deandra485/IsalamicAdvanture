<?php

namespace App\Http\Controllers;

use App\Models\Package;

class PackageController extends Controller
{
    public function index()
    {
        return view('packages.index');
    }

    public function show(Package $package)
    {
        return view('packages.show', compact('package'));
    }
}
