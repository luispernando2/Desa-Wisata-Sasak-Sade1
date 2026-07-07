<?php

namespace App\Http\Controllers;

use App\Models\PackageTour;

class PackageDetailController extends Controller
{
    public function show(PackageTour $package)
    {
        return view('packages.show', compact('package'));
    }
}

