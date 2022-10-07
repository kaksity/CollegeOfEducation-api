<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href={{ asset('css/pdf.css') }} />
    <title>Admission Letter</title>
    <style>
        .row {
            flex-shrink: 0;
            width: 100%;
            max-width: 100%;
            display: flex;
        }

        .heading {
            text-align: center;
        }

        .header-address {}

        .parent-container {
            margin: 0% 10%;
        }

        .admission-content {
            text-align: justify;
            text-justify: inter-word;
        }

        .admission-course-title {
            text-align: center;
        }

        .heading-school-title {
            font-size: 100px;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
        }

        th,
        td,
        tr {
            padding: 1rem;
        }

    </style>
</head>

<body>
    <div>
        <div class="row mt-2 table-responsive">
            <table class="table">
                <tbody class="">
                    <tr>
                        <td width="5%">
                            <img src="{{ public_path('image/logo.png') }}" alt="">
                        </td>
                        <td width="95%">
                            <div class="heading">
                                <div style="heading-school-title">
                                    <b>MOHAMMET LAWAN COLLEGE OF AGRICULTURE</b>
                                </div>
                                P.M.B 14277, MAIDUGURI <br>
                                BORNO STATE, NIGERIA <br>
                                OFFICE OF THE REGISTRAR <br>
                                (ACADEMIC DIVISION)
                                <div>
                                    Telephone: 070-39443472 
                                    Email Address: admissionoffice@molca.edu.ng
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>
    </div>
    <div class="parent-container">
        <p style="text-align: right">{{ $dateOfAdmission }}</p>
        <p>
            {{ $personalData->surname }} {{ $personalData->other_names }}<br>
            {{ $applicationStatus->admission_number }}
        </p>
        <div class="admission-course-title">
            <p><b><u>OFFER OF PROVISIONAL ADMISSION INTO {{ strtoupper($courseData->courseGroup->name) }} PROGRAMME {{$applicationStatus->nceSession->start_year.'/'.$applicationStatus->nceSession->end_year}} ACADEMIC SESSION</u></b></p>
            <p><b>PROGRAMME: {{ strtoupper($courseData->courseGroup->code) }} {{ strtoupper($courseData->NceCourseDataAdmittedCourse->name) }}</b></p>
        </div>
        <div class="admission-content">
            <p>
                I am pleased to inform you that you have been offered admission into {{ strtoupper($courseData->courseGroup->name) }} programme of the above named course of this College. Details of registeration and fees will be provided to you at the time of registration.
            </p>
            <p>
                You are required to present the original of all credenitals at the
                time of registration. If it is discovered at any time that you do not possess
                any of the qualifications, which you claim to have obtained or any of the
                information you provided are false, you will be withdrawn from the College.
            </p>
            <p>
                Accept my congratulations on your admission.
            </p>
        </div>
        <p>
            <b>Umar Mohammed Banki <br> For: REGISTRAR</b>
        </p>
    </div>
</body>

</html>
