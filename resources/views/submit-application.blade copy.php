<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Laravel 7 PDF Example</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <style>
        .passport {
            height: 10rem;
            width: 10rem;
            object-fit: cover;
        }
    </style>
<body>
    <div class="card-body">
        <form class="row g-3">
            <div class="row">
                <h2>PERSONAL DATA</h2>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="passport"><img src="http://localhost:5000/storage/passports/1662134502631228e6704f1.png" class="passport"></div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6"><label class="form-label" for="inputSurname"><b>Surname</b></label>
                    <div>Test</div>
                </div>
                <div class="col-md-6"><label class="form-label" for="inputOtherNames"><b>Other Names</b></label>
                    <div>Test Test</div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-5"><label class="form-label" for="inputPlaceOfBirth"><b>Place of Birth</b></label>
                    <div>Maiduguri</div>
                </div>
                <div class="col-md-4"><label class="form-label" for="Date of Birth"><b>Date of Birth</b></label>
                    <div>2022-09-02</div>
                </div>
                <div class="col-md-3"><label class="form-label" for="inputSex"><b>Sex</b></label>
                    <div>Male</div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4"><label class="form-label" for="inputMaritalStatus"><b>Marital Status</b></label>
                    <div>Single</div>
                </div>
                <div class="col-md-4"><label class="form-label" for="inputState"><b>State</b></label>
                    <div>Borno</div>
                </div>
                <div class="col-md-4"><label class="form-label" for="inputLga"><b>Local Government Area</b></label>
                    <div>Maiduguri</div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6"><label class="form-label" for="inputSurname"><b>Home Town</b></label>
                    <div>Maidugru</div>
                </div>
                <div class="col-md-6"><label class="form-label" for="inputOtherNames"><b>Nationality</b></label>
                    <div>Nigeria</div>
                </div>
            </div>
            <div class="row mt-2">
                <h2>CONTACT ADDRESS DATA</h2>
            </div>
            <div class="row mt-2">
                <div class="col-md-6"><label class="form-label" for="inputNameOfGuardian"><b>Name of Guardian</b></label>
                    <div>Dauda Pona</div>
                </div>
                <div class="col-md-6"><label class="form-label" for="inputAddressOfGuardian"><b>Address of Guardian</b></label>
                    <div>Behind Maiduguri International Hotel</div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6"><label class="form-label" for="inputNameOfEmployer"><b>Name of Employer</b></label>
                    <div>Harun Abubakar</div>
                </div>
                <div class="col-md-6"><label class="form-label" for="inputAddressOfEmployer"><b>Address of Employer</b></label>
                    <div>Behind Maiduguri International Hote</div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4"><label class="form-label" for="inputContactAddress"><b>Contact Address</b></label>
                    <div>Behind Maiduri International Hotel</div>
                </div>
                <div class="col-md-4"><label class="form-label" for="inputEmailAddress"><b>Email Address</b></label>
                    <div>test@test.com</div>
                </div>
                <div class="col-md-4"><label class="form-label" for="inputPhoneNumber"><b>Phone Number</b></label>
                    <div>07012853911</div>
                </div>
            </div>
            <div class="row mt-2">
                <h2>EDUCATIONAL BACKGROUND</h2>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" rowspan="2"> Name of Institute </th>
                                <th colspan="2" scope="col"> Year Of Study </th>
                                <th scope="col" rowspan="2"> Certificate Awarded </th>
                            </tr>
                            <tr>
                                <th scope="col"> From </th>
                                <th scope="col"> To </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>SSS</td>
                                <td>2022-09-02</td>
                                <td>2022-09-02</td>
                                <td>SSCE</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-2">
                <h2>EXAMINATION DATA</h2>
            </div>
            <div class="row mt-2">
                <div class="col-md-5"><label class="form-label" for="inputPlaceOfBirth"><b>Examination Number</b></label>
                    <div>123</div>
                </div>
                <div class="col-md-4"><label class="form-label" for="Date of Birth"><b>Center Number</b></label>
                    <div>1213</div>
                </div>
                <div class="col-md-3"><label class="form-label" for="inputSex"><b>Date of Examination</b></label>
                    <div>2022-09-02</div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12"><label class="form-label" for="inputPlaceOfBirth"><b>Overall Result</b></label>
                    <div>123</div>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col"> Examination Category </th>
                                <th scope="col"> Examination Subject </th>
                                <th scope="col"> Grade </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Test Examination Category</td>
                                <td>Test Examination Subject</td>
                                <td>A1</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-2">
                <h2>PROPOSED COURSE OF STUDY</h2>
            </div>
            <div class="row mt-2">
                <div class="col-md-4"><label class="form-label" for="inputSurname"><b>First Choice Course</b></label>
                    <div>Animal Technology</div>
                </div>
                <div class="col-md-4"><label class="form-label" for="inputSex"><b>Second Choice Course</b></label>
                    <div>Animal Technology</div>
                </div>
                <div class="col-md-4"><label class="form-label" for="inputSex"><b>Third Choice Course</b></label>
                    <div>Animal Technology</div>
                </div>
            </div>
            <div class="row mt-2">
                <h2>RECORD OF EMPLOYMENT</h2>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col"> Name of Employer </th>
                                <th scope="col"> Type of Employment </th>
                                <th scope="col"> Duration </th>
                                <th scope="col"> Salary Scale </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-2">
                <h2>UPLOADED REQUIRED DOCUMENTS</h2>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col"> Uploaded required documents </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>SSCE</td>
                            </tr>
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
                        <thead>
                            <tr>
                                <th scope="col"> Extra Curricular Activity </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Test</td>
                            </tr>
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
                        <thead>
                            <tr>
                                <th scope="col"> Held Responsibility </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Test</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <div>
                        <h2>DECLARATION</h2>
                    </div>
                    <p> I hereby declare that the information provided stated above is to the best of my knowledge and belief accurate in every details </p>
                    <p> If admitted I will also comply strictly with the Rules and Regulations of the College </p>
                </div>
            </div>
        </form>
    </div>
</body>

</html>