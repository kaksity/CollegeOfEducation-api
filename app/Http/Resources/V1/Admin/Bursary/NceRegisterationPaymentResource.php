<?php

namespace App\Http\Resources\V1\Admin\Bursary;

use App\Http\Resources\V1\AcademicSession\NceAcademicSessionResource;
use App\Http\Resources\V1\Course\CourseResource;
use App\Http\Resources\V1\Student\Nce\StudentResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class NceRegisterationPaymentResource extends JsonResource
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
            'amount' => $this->amount,
            'status' => $this->status,
            'reference_code' => $this->payment_gateway == 'interswitch' ? "Interswitch - {$this->reference_code}" : "Remita - {$this->rrr}",
            'session' => new NceAcademicSessionResource($this->nceSession),
            'course' => new CourseResource($this->nceCourse),
            'student' => new StudentResource($this->nceStudent),
            'date_of_payment' => Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->timezone('Africa/Lagos')->format('M j, Y H:i'),
        ];
    }
}
