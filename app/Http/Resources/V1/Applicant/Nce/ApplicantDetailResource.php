<?php

namespace App\Http\Resources\V1\Applicant\Nce;

use App\Http\Resources\V1\Applicant\Nce\ContactDataResource;
use App\Http\Resources\V1\Applicant\Nce\EducationalBackgroundDataResource;
use App\Http\Resources\V1\Applicant\Nce\EmploymentDataResource;
use App\Http\Resources\V1\Applicant\Nce\ExaminationDataResource;
use App\Http\Resources\V1\Applicant\Nce\ExtraCurricularActivityDataResource;
use App\Http\Resources\V1\Applicant\Nce\HeldResponsibilityDataResource;
use App\Http\Resources\V1\Applicant\Nce\PersonalDataResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'passport' => new PassportResource($this->NcePassport),
            'personal_data' => new PersonalDataResource($this->NcePersonalData),
            'contact_data' => new ContactDataResource($this->NceContactData),
            'employment_data' => EmploymentDataResource::collection($this->NceEmploymentData),
            'examination_data' => ExaminationDataResource::collection($this->NceExaminationData),
            'educational_background_data' => EducationalBackgroundDataResource::collection($this->dipEducationalBackground),
            'extra_curricular_activity_data' => ExtraCurricularActivityDataResource::collection($this->NceExtraCurricularActivityData),
            'held_responsibility_data' => HeldResponsibilityDataResource::collection($this->NceHeldResponsibilityData),
            // 'application_status' => new ApplicationStatusResource($this->user->NceApplicationStatus),
            'course_data' =>  new CourseDataResource($this->NceCourseData),
            'examination_center_data' => new ExaminationCenterDataResource($this->NceExaminationCenterData),
            
        ];
    }
}
