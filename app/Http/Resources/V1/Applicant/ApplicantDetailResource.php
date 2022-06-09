<?php

namespace App\Http\Resources\V1\Applicant;

use App\Http\Resources\V1\Applicant\ContactDataResource;
use App\Http\Resources\V1\Applicant\EducationalBackgroundDataResource;
use App\Http\Resources\V1\Applicant\EmploymentDataResource;
use App\Http\Resources\V1\Applicant\ExaminationDataResource;
use App\Http\Resources\V1\Applicant\ExtraCurricularActivityDataResource;
use App\Http\Resources\V1\Applicant\HeldResponsibilityDataResource;
use App\Http\Resources\V1\Applicant\PersonalDataResource;
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
            'passport' => new PassportResource($this->dipPassport),
            'personal_data' => new PersonalDataResource($this->dipPersonalData),
            'contact_data' => new ContactDataResource($this->dipContactData),
            'employment_data' => EmploymentDataResource::collection($this->dipEmploymentData),
            'examination_data' => ExaminationDataResource::collection($this->dipExaminationData),
            'educational_background_data' => EducationalBackgroundDataResource::collection($this->dipEducationalBackground),
            'extra_curricular_activity_data' => ExtraCurricularActivityDataResource::collection($this->dipExtraCurricularActivityData),
            'held_responsibility_data' => HeldResponsibilityDataResource::collection($this->dipHeldResponsibilityData),
            // 'application_status' => new ApplicationStatusResource($this->user->dipApplicationStatus),
            // 'course_data' => new CourseDataResource($this->user->dipCourseData),
        ];
    }
}
