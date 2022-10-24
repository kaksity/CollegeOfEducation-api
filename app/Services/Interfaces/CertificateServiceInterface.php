<?php

namespace App\Services\Interfaces;

interface CertificateServiceInterface {
    public function getAllCertificates();

    public function createNewCertificate(array $data): void;

    public function getCertificateById($certificateId);

    public function updateCertificate($certificate): void;

    public function deleteCertificate($certificate): void;
}
