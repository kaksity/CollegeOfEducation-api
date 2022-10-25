<?php
namespace App\Services\Implementations\Bursary;

use App\Models\CourseRegisterationCard;
use App\Services\Interfaces\Bursary\CourseRegistrationCardServiceInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class CourseRegistrationCardServiceImplementation implements CourseRegistrationCardServiceInterface
{
    public function getAllCourseRegistrationCard($perPage)
    {
        return CourseRegisterationCard::with(['academicSession', 'courseGroup'])->latest()->paginate($perPage);
    }

    public function createNewCourseRegistrationCards(array $data)
    {
        try
        {
            DB::beginTransaction();

            for($i=0; $i < $data['number_of_cards']; $i++)
            {
                
                $serialNumber = generateRandomNumber().generateRandomNumber().generateRandomNumber().generateRandomNumber();
                $pin = generateRandomNumber().generateRandomString().generateRandomNumber().generateRandomString();

                CourseRegisterationCard::create([
                    'academic_session_id' => $data['academic_session_id'],
                    'course_group_id' => $data['course_group_id'],
                    'serial_number' => $serialNumber,
                    'used_counter' => 0,
                    'status' => 'active',
                    'pin' => $pin
                ]);
            }
            DB::commit();
        }
        catch(Exception $ex)
        {
            DB::rollBack();
            throw $ex;
        }
    }

    public function getCourseRegistrationCardById($cardId)
    {
        return CourseRegisterationCard::where([
            'id' => $cardId
        ])->first();
    }

    public function updateCourseRegistrationCard($courseRegistrationCard)
    {
        $courseRegistrationCard->save();
    }

}
