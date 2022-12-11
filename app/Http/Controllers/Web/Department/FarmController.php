<?php

namespace App\Http\Controllers\Web\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FarmController extends Controller
{
    public function index()
    {
        return view('web.departments.farm');
    }
}
