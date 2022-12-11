<?php

namespace App\Http\Controllers\Web\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IctController extends Controller
{
    public function index()
    {
        return view('web.departments.ict');
    }
}
