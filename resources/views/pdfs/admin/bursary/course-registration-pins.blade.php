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
                                                    <b>Student Registration Pins</b>
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
        <div class="row">
            <table>
                <tbody>
                    @foreach($cards as $card => $value)
                        <tr>
                            <table style="border: 1px solid; width:100%">
                                <tr>
                                    <td><b>Course:</b></td>
                                    <td> {{ $value['course'] }}</td>
                                </tr>
                                <tr>
                                    <td><b>Session:</b> </td>
                                    <td>{{ $value['academic_session'] }}</td>
                                </tr>
                                <tr>
                                    <td><b>Serial Number:</b></td>
                                    <td>{{ $value['serial_number'] }}</td>
                                </tr>
                                <tr>
                                    <td><b>Pin:</b></td>
                                    <td>{{ $value['pin'] }}</td>
                                </tr>
                            </table>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
