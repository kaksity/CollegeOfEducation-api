<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NceAcademicSession;
use App\Models\UsedCourseRegisterationPin;
use Exception;

class VerifyIsCourseRegistered
{
    public function __construct(NceAcademicSession $session, UsedCourseRegisterationPin $usedCourseRegisterationPin)
    {
        $this->nceAcademicSession = $session;
        $this->usedCourseRegisterationPin = $usedCourseRegisterationPin;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try
        {
            $courseData = Auth::user()->nceCourseData;
            $currentSession = $this->nceAcademicSession->getCurrentSession($courseData->course_group_id);
            $usedCourseRegisterationPin = $this->usedCourseRegisterationPin->where([
                'academic_session_id' => $currentSession->id,
                'user_id' => Auth::id()
            ])->first();
            if($usedCourseRegisterationPin == null)
            {
                $data['message'] = 'Student is yet to use enter course registeration pin';
                $data['error_code'] = 'YET_TO_USE_COURSE_REGISTERATION_CARD';
                return errorParser($data, 403);
            }
            
            return $next($request);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
        
    }
}
