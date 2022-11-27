<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href={{ asset('css/pdf.css') }} />
    <title>Course Registration</title>
    <style>
        *{
            font-size: 10px;
            font-family: sans-serif;
        }
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
            margin-bottom: 0.5rem;
            border-collapse: collapse;
        }

        th,
        td,
        tr {
            /* padding: 0.5rem; */
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
        .no-margin-and-padding {
            margin: 0px;
            padding: 0px;
        }
        .passport {
            height: 7rem;
            width: 7rem;
            object-fit: cover;
        }
        .logo {
            height: 5rem;
            width: 5rem;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div>
        <div class="row">
            <table class="table">
                <tbody>
                        <tr>
                            <td class="no-margin-and-padding heading">
                                <img class="logo" src="{{ public_path('image/logo.png') }}" alt="">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="no-margin-and-padding heading">
                                                    <h1>MOHAMMET LAWAN COLLEGE OF AGRICULTURE</h1>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="no-margin-and-padding heading">
                                                    <b>Student's Registration</b>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="no-margin-and-padding heading">
                                                    <b>{{"{$currentSession->start_year}/{$currentSession->end_year}"}} Academic Session</b>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
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
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td colspan="3">
                                            <b>Full Name</b>: {{ $personalData->surname }} {{ $personalData->other_names }}
                                        </td>
                                        <td colspan="2">
                                            <b>Date of Birth</b>: {{ $personalData->date_of_birth }}
                                            <div></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <b>Gender</b>: {{ $personalData->sex }}
                                        </td>
                                        <td colspan="2">
                                            <b>Marital Status</b>: {{ $personalData->maritalStatus->name ?? 'N/A' }}
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
            <h4>Contact Details</h4>
        </div>
        <div class="row table-responsive">
            <table class="table">
                <tbody class="">
                    <tr>
                        <td width="100%">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td colspan="3">
                                            <b>Home Town</b>: {{ $personalData->home_town }}
                                        </td>
                                        <td colspan="2">
                                            <b>LGA</b>: {{ $personalData->home_town }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <b>State of Origin</b>: {{ $personalData->state->name ?? 'N/A' }}
                                        </td>
                                        <td colspan="2">
                                            <b>Nationality</b>: {{ $personalData->nationality }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <b>Phone Number</b>: {{ $contactData->phone_number }}
                                        </td>
                                        <td colspan="2">
                                            <b>Email Address</b>: {{ $contactData->email_address }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <b>Contact Address</b>: {{ $contactData->contact_address }}
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
            <h4>Course Registration</h4>
        </div>
        <div class="row table-responsive">
            <table class="table">
                <tbody class="">
                    <tr>
                        <td width="100%">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td colspan="6">
                                            <b>ID Number</b>: {{ $student->id_number }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <b>Level</b>: {{ $courseData->year_group }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <b>Department</b>: {{ $admittedCourse->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <b>Programme</b>: {{ $courseGroup->name }} ({{ $courseGroup->name }})
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
