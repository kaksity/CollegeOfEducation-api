<?php

namespace App\Http\Resources\V1\Admin\Bursary;

use App\Http\Resources\V1\AcademicSession\NceAcademicSessionResource;
use App\Http\Resources\V1\Course\CourseResource;
use App\Http\Resources\V1\Student\Nce\StudentResource;
use App\Models\NcePersonalData;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class ProcessedApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = $this->user->ncePersonalData;
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'status' => $this->status,
            'reference_code' => $this->reference_code,
            'student' => [
                'surname' => $user->surname,
                'other_names' => $user->other_names,
            ],
            'date_of_payment' => Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->timezone('Africa/Lagos')->format('M j, Y H:i'),
        ];
    }
}
