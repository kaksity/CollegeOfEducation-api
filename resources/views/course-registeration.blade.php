<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href={{ asset('css/pdf.css') }} />
    <title>Submit Application</title>
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
                                    <b>REGISTRATION FORM</b>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>
    </div>
    <div class="row mt-2">
        <h4>Personal Data</h4>
    </div>
    <div>
        <div class="row table-responsive">
            <table class="table">
                <tbody class="">
                    <tr>
                        <td width="5%">
                            <img class="passport" src="{{storage_path('app/public/passports/'.$passport->file_path)}}" alt="">
                        </td>
                        <td width="95%">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>
                                            <b>Surname</b>
                                            <div>{{ $personalData->surname }}</div>
                                        </td>
                                        <td>
                                            <b>Other Names</b>
                                            <div>{{ $personalData->other_names }}</div>
                                        </td>
                                        <td>
                                            <b>Student Registration Number</b>
                                            <div>{{ $student->id_number }}</div>
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
                                        <td>
                                            <b>Marital Status</b>
                                            <div>{{ $personalData->maritalStatus->name ?? 'N/A' }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>State of Origin</b>
                                            <div>{{ $personalData->state->name ?? 'N/A' }}</div>
                                        </td>
                                        <td>
                                            <b>Local Government Area</b>
                                            <div>{{ $personalData->lga->name ?? 'N/A' }}</div>
                                        </td>
                                        <td>
                                            <b>Home Town</b>
                                            <div>{{ $personalData->home_town }}</div>
                                        </td>
                                        <td>
                                            <b>Nationality</b>
                                            <div>{{ $personalData->nationality }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Name of Guardian</b>
                                            <div>{{ $contactData->name_of_guardian }}</div>
                                        </td>
                                        <td>
                                            <b>Address of Guardian</b>
                                            <div>{{ $contactData->address_of_guardian }}</div>
                                        </td>
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
                                            <div>{{ $contactData->email_address }}</div>
                                        </td>
                                        <td>
                                            <b>Phone Number</b>
                                            <div>{{ $contactData->phone_number }}</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row mt-2">
            <h4>First Semester</h4>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bordered">
                            <th class="bordered" scope="col"> S/No </th>
                            <th class="bordered" scope="col"> Course Code </th>
                            <th class="bordered" scope="col"> Course Title </th>
                            <th class="bordered" scope="col"> Course Unit </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($firstSemesterCourses as $key => $value)
                        <tr class="bordered">
                            <td class="bordered" width="10%"> {{ $key + 1 }} </td>
                            <td class="bordered" width="20%"> {{ $value->course_code }} </td>
                            <td class="bordered" width="60%"> {{ $value->course_title }} </td>
                            <td class="bordered" width="10%"> {{ $value->course_unit }} </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-2">
            <h4>Second Semester</h4>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bordered">
                            <th class="bordered" scope="col"> S/No </th>
                            <th class="bordered" scope="col"> Course Code </th>
                            <th class="bordered" scope="col"> Course Title </th>
                            <th class="bordered" scope="col"> Course Unit </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($secondSemesterCourses as $key => $value)
                        <tr class="bordered">
                            <td class="bordered" width="10%"> {{ $key + 1 }} </td>
                            <td class="bordered" width="20%"> {{ $value->course_code }} </td>
                            <td class="bordered" width="60%"> {{ $value->course_title }} </td>
                            <td class="bordered" width="10%"> {{ $value->course_unit }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-2">
            <div class="row mt-2 table-responsive">
                <table class="table">
                    <tbody class="">
                        <tr>
                            <td  colspan="3">
                                <b>HEAD OF DEPARTMENT AGT/AHP/FOT/HRE</b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>Signature........................................</div>
                            </td>
                            <td>
                                <div>Date.....................................</div>
                            </td>
                        </tr>
                        <tr>
                            <td  colspan="3">
                                <b>GNS DEPARTMENT</b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>Signature........................................</div>
                            </td>
                            <td>
                                <div>Date.....................................</div>
                            </td>
                        </tr>
                        <tr>
                            <td  colspan="3">
                                <b>FARM DEPARTMENT</b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>Signature........................................</div>
                            </td>
                            <td>
                                <div>Date.....................................</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <b>ENTREPRENEURSHIP DEVELOPMENT CENTER</b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>Signature........................................</div>
                            </td>
                            <td>
                                <div>Date.....................................</div>
                            </td>
                        </tr>
                        <tr>
                            <td  colspan="3">
                                <b>STUDENT AFFAIRS OFFICE (SAO)</b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>Signature........................................</div>
                            </td>
                            <td>
                                <div>Date.....................................</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <b>FINAL REGISTRATION PERMIT</b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>Course.....................................</div>
                            </td>
                            <td>
                                <div>Signature........................................</div>
                            </td>
                            <td>
                                <div>Date.....................................</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                               I <b><u>{{ $personalData->surname }} {{ $personalData->other_names }}</u></b> hereby declare that all information provided herein is to the best of my knowledge true and correct, and if found to be false, the College may take appropriate action against me.
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>Signature.....................................</div>
                            </td>
                            <td>
                                <div>Date.....................................</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
</body>

</html>
