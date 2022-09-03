<?php

namespace App\Http\Resources\V1\Admin;

use App\Http\Resources\V1\Applicant\Nce\ContactDataResource;
use App\Http\Resources\V1\Applicant\Nce\CourseDataResource;
use App\Http\Resources\V1\Applicant\Nce\EducationalBackgroundDataResource;
use App\Http\Resources\V1\Applicant\Nce\EmploymentDataResource;
use App\Http\Resources\V1\Applicant\Nce\ExaminationCenterDataResource;
use App\Http\Resources\V1\Applicant\Nce\ExaminationDataResource;
use App\Http\Resources\V1\Applicant\Nce\ExtraCurricularActivityDataResource;
use App\Http\Resources\V1\Applicant\Nce\HeldResponsibilityDataResource;
use App\Http\Resources\V1\Applicant\Nce\PassportResource;
use App\Http\Resources\V1\Applicant\Nce\PersonalDataResource;
use App\Http\Resources\V1\Applicant\Nce\RequiredDocumentDataResource;
use App\Http\Resources\V1\Applicant\Nce\ApplicationStatusResource;
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
            'personal_data' => new PersonalDataResource($this->ncePersonalData),
            'passport' => new PassportResource($this->ncePassport),
            'contact_data' => new ContactDataResource($this->nceContactData),
            'employment_data' => EmploymentDataResource::collection($this->nceEmploymentData),
            'examination_data' => ExaminationDataResource::collection($this->nceExaminationData),
            'educational_background_data' => EducationalBackgroundDataResource::collection($this->nceEducationalBackground),
            'extra_curricular_activity_data' => ExtraCurricularActivityDataResource::collection($this->nceExtraCurricularActivityData),
            'held_responsibility_data' => HeldResponsibilityDataResource::collection($this->nceHeldResponsibilityData),
            'application_status' => new ApplicationStatusResource($this->nceApplicationStatus),
            'course_data' => new CourseDataResource($this->nceCourseData),
            'examination_center_data' => new ExaminationCenterDataResource($this->nceExaminationCenterData),
            'required_document_data' => RequiredDocumentDataResource::collection($this->nceRequiredDocumentData)
        ];
    }
}
