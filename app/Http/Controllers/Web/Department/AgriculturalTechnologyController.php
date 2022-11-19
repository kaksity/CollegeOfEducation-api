<?php

namespace App\Http\Controllers\Web\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgriculturalTechnologyController extends Controller
{
    public function index()
    {
        return view('departments.agricultural-technology');
    }
}
