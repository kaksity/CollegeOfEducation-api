<?php

namespace App\Http\Controllers\Web\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EntrepreneurshipCenterController extends Controller
{
    public function index()
    {
        return view('web.departments.entrepreneurship-center');
    }
}
