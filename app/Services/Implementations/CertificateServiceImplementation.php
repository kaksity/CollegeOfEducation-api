<?php
namespace App\Services\Implementations;

use App\Models\Certificate;
use App\Models\MaritalStatus;
use App\Services\Interfaces\CertificateServiceInterface;

class CertificateServiceImplementation implements CertificateServiceInterface
{
    public function getAllCertificates()
    {
        return Certificate::latest()->get();
    }

    public function createNewCertificate(array $data): void
    {
        Certificate::create($data);
    }

    public function getCertificateById($certificateId)
    {
        return Certificate::where([
            'id' => $certificateId
        ])->first();
    }

    public function updateCertificate($certificate): void
    {
        $certificate->save();
    }

    public function deleteCertificate($certificate): void
    {
        $certificate->delete();
    }
}
