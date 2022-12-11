<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function studentAffairs()
    {
        return view('web.policy.student-affairs');
    }
    public function admissionPolicy()
    {
        return view('web.policy.admission-fees');
    }
}
