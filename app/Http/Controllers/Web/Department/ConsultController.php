<?php

namespace App\Http\Controllers\Web\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConsultController extends Controller
{
    function index()
    {
        return view('departments.consult');
    }
}
