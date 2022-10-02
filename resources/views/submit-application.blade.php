<?php
    // $avatarUrl = env('APP_URL').'/storage/passports/'.$passport->file_path;
    // $arrContextOptions=array(
    //             "ssl"=>array(
    //                 "verify_peer"=>false,
    //                 "verify_peer_name"=>false,
    //             ),
    //         );
    // $type = pathinfo($avatarUrl, PATHINFO_EXTENSION);
    // $avatarData = file_get_contents($avatarUrl, false, stream_context_create($arrContextOptions));
    // $avatarBase64Data = base64_encode($avatarData);
    // $imageData = 'data:image/' . $type . ';base64,' . $avatarBase64Data;
    // echo $imageData;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href={{ asset('css/pdf.css') }} />
    <title>Application Form</title>
    <style>
        .row {
            flex-shrink: 0;
            width: 100%;
            max-width: 100%;
            display: flex;
            padding-right: calc(var(--cui-gutter-x) * 0.5);
            padding-left: calc(var(--cui-gutter-x) * 0.5);
        }

        .col-6 {
            flex: 0 0 auto;
            width: 50%;
        }

        .col-5 {
            flex: 0 0 auto;
            width: 41.66666667%;
        }

        .col-4 {
            flex: 0 0 auto;
            width: 33.33333333%;
        }

        .col-3 {
            flex: 0 0 auto;
            width: 25%;
        }

        .mt-2 {
            margin-top: 0.5rem !important;
        }

        .table-responsive {
            overflow-x: auto;
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

        .table-bordered {
            border: solid black 1px;
        }

        .bordered {
            border: solid black 1px;
        }
        .heading {
            text-align: center;
        }
        .heading-school-title {
            font-size: 100px;
        }
        .no-margin-and-padding {
            margin: 0px;
            padding: 0px;
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
                                <div class="no-margin-and-padding">
                                    <b>APPLICATION FORM</b>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr class="no-margin-and-padding">
    </div>
    <div class="row mt-2">
        <h2>PERSONAL DATA</h2>
    </div>
    <div>
        <div class="row mt-2 table-responsive">
            <table class="table">
                <tbody class="">
                    <tr>
                        <td>
                            {{-- <img src="{{ '../../storage/public/passports/'.$passport->file_path }}" alt=""> --}}
                        </td>
                        <td>
                            <b>Surname</b>
                            <div>{{ $personalData->surname }}</div>
                        </td>
                        <td>
                            <b>Other Names</b>
                            <div>{{ $personalData->other_names }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Place of Birth</b>
                            <div>{{ $personalData->place_of_birth }}</div>
                        </td>
                        <td>
                            <b>Date of Birth</b>
                            <div>{{ $personalData->date_of_birth }}</div>
                        </td>
                        <td>
                            <b>Sex</b>
                            <div>{{ $personalData->sex }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Marital Status</b>
                            <div>{{ $personalData->maritalStatus->name ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <b>State of Origin</b>
                            <div>{{ $personalData->state->name ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <b>Local Government Area</b>
                            <div>{{ $personalData->lga->name ?? 'N/A' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Home Town</b>
                            <div>{{ $personalData->home_town }}</div>
                        </td>
                        <td>
                            <b>Nationality</b>
                            <div>{{ $personalData->nationality }}</div>
                        </td>
                        <td>
                            <b>Application Tracking Code</b>
                            <div>{{ $applicationStatus->admission_number }}</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row mt-2">
            <h2>CONTACT ADDRESS DATA</h2>
        </div>
        <div class="row mt-2 table-responsive">
            <table class="table">
                <tbody class="">
                    <tr>
                        <td>
                            <b>Name of Guardian</b>
                            <div>{{ $contactData->name_of_guardian }}</div>
                        </td>
                        <td>
                            <b>Address of Guardian</b>
                            <div>{{ $contactData->address_of_guardian }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Name of Employer</b>
                            <div>{{ $contactData->name_of_employer }}</div>
                        </td>
                        <td>
                            <b>Address of Employer</b>
                            <div>{{ $contactData->address_of_employer }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Contact Address</b>
                            <div>{{ $contactData->contact_address }}</div>
                        </td>
                        <td>
                            <b>Email Address</b>
                            <div>{{ $contactData->phone_number }}</div>
                        </td>
                        <td>
                            <b>Phone Number</b>
                            <div>{{ $contactData->email_address }}</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row mt-2">
            <h2>EDUCATIONAL BACKGROUND</h2>
        </div>
        <div class="row mt-2 table-responsive">
            <table class="table table-bordered">
                <thead class="bordered">
                    <tr class="bordered">
                        <th class="bordered" scope="col" rowspan="2"> Name of Institute </th>
                        <th class="bordered" colspan="2" scope="col"> Year Of Study </th>
                        <th class="bordered" scope="col" rowspan="2"> Certificate Awarded </th>
                    </tr>
                    <tr class="bordered">
                        <th class="" scope="col"> From </th>
                        <th class="" scope="col"> To </th>
                    </tr>
                </thead>
                <tbody class="bordered">
                    @foreach($educationalBackgroundData as $educationalBackground => $value)
                    <tr class="bordered">
                        <td class="bordered">{{ $value->name_of_institute}}</td>
                        <td class="bordered">{{ $value->from_date }}</td>
                        <td class="bordered">{{ $value->to_date }}</td>
                        <td class="bordered">{{ $value->certificate->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row mt-2">
            <h2>EXAMINATION DATA</h2>
        </div>
        <div class="row mt-2 table-responsive">
            <table class="table">
                <tbody class="">
                    <tr>
                        <td>
                            <b>Examination Number</b>
                            <div>{{ $examinationCenterData->examination_number }}</div>
                        </td>
                        <td>
                            <b>Center Number</b>
                            <div>{{ $examinationCenterData->center_number }}</div>
                        </td>
                        <td>
                            <b>Date of Examination</b>
                            <div>{{ $examinationCenterData->date_of_examination }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <b>Overall Result</b>
                            <div>{{ $examinationCenterData->overall_result }}</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bordered">
                    <tr class="bordered">
                        <th class="bordered" scope="col"> Examination Category </th>
                        <th class="bordered" scope="col"> Examination Subject </th>
                        <th class="bordered" scope="col"> Grade </th>
                    </tr>
                </thead>
                <tbody class="bordered">
                    @foreach($examinationData as $examination => $value)
                    <tr class="bordered">
                        <td class="bordered">{{ $value->examinationCategory->category }}</td>
                        <td class="bordered">{{ $value->examinationSubject->subject }}</td>
                        <td class="bordered">{{ $value->grade }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <div class="row mt-2">
            <h2>PROPOSED COURSE OF STUDY</h2>
        </div>
        <div class="row mt-2 table-responsive">
            <table class="table">
                <tbody class="">
                    <tr>
                        <td>
                            <b>First Choice Course</b>
                            <div>{{ $courseData->NceCourseDataFirstChoice->name ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <b>Second Choice Course</b>
                            <div>{{ $courseData->NceCourseDataSecondChoice->name ?? 'N/A'}}</div>
                        </td>
                        <td>
                            <b>Third Choice Course</b>
                            <div>{{ $courseData->NceCourseDataThirdChoice->name ?? 'N/A'}}</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row mt-2">
            <h2>RECORD OF EMPLOYMENT</h2>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bordered">
                            <th class="bordered" scope="col"> Name of Employer </th>
                            <th class="bordered" scope="col"> Type of Employment </th>
                            <th class="bordered" scope="col"> Duration </th>
                            <th class="bordered" scope="col"> Salary Scale </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employmentData as $employment => $value)
                        <tr class="bordered">
                            <td class="bordered"> {{ $value->name_of_employer }} </td>
                            <td class="bordered"> {{ $value->type_of_employment }} </td>
                            <td class="bordered"> {{ $value->duration.' '.$value->unit }} </td>
                            <td class="bordered"> {{ $value->average_salary }} </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-2">
            <h2>UPLOADED REQUIRED DOCUMENTS</h2>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bordered">
                        <tr class="bordered">
                            <th scope="col"> Uploaded required documents </th>
                        </tr>
                    </thead>
                    <tbody class="bordered">
                        @foreach($requiredDocumentData as $requiredDocument => $value)
                        <tr class="bordered">
                            <td class="bordered">{{ $value->requiredDocument->name }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-2">
            <h2>EXTRA-CURRICULAR ACTIVITIES</h2>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bordered">
                        <tr class="bordered">
                            <th class="bordered" scope="col"> Extra Curricular Activity </th>
                        </tr>
                    </thead>
                    <tbody class="bordered">
                        @foreach($extraCurricularActivityData as $key => $value)
                        <tr class="bordered">
                            <td class="bordered">{{ $value->activity }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <h2>POSITION OF RESPONSIBILITY HELD</h2>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bordered">
                        <tr class="bordered">
                            <th class="bordered" scope="col"> Held Responsibility </th>
                        </tr>
                    </thead>
                    <tbody class="bordered">
                        @foreach($heldResponsibilityData as $key => $value)
                        <tr class="bordered">
                            <td class="bordered">{{ $value->responsibility }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <div>
                    <h2>DECLARATION</h2>
                </div>
                <p> I <b><u>{{ $personalData->surname.' '.$personalData->other_names }}</u></b> hereby declare that the information provided above is to the best of my knowledge and belief accurate in every details </p>
                <p> If admitted I will also comply strictly with the Rules and Regulations of the College </p>
                <p>Sign ............................................</p>
            </div>
        </div>
</body>

</html>
