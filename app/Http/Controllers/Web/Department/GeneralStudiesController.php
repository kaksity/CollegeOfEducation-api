<?php

namespace App\Http\Controllers\Web\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralStudiesController extends Controller
{
    function index()
    {
        return view('departments.general-studies');
    }
}
