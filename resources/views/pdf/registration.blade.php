<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style type="text/css" media="all">
        body{
            font-family: Arial, Helvetica, sans-serif;
        }

        .container{
            width: 100%;
            margin-bottom: 10px;
        }

        .title{
            position: relative;
            width: 100%;
            background-color: rgb(71, 120, 185, 0.2);
            padding-top: 2px;
            padding-bottom: 2px;
            padding-left: 10px;
            border-top-left-radius: 0.375rem;
            border-top-right-radius: 0.375rem;
            font-weight: 600;
        }

        .title .right-portion{
            font-weight: 400;
            font-size: 0.75rem;
            position: absolute;
            right: 10px;
            top: 23px;
        }

        .table-container{
            padding: 1rem;
            font-size: 0.75rem;
            line-height: 1rem;
        }

        table{
            width: 100%;
        }

        td{
            padding-bottom: 1rem;
        }

        .td-center{
            text-align: center;
        }

        .td-bold{
            font-weight: bold;
        }

        td span{
            color: rgba(107, 114, 128, 1);
            padding-left: 0.5rem;
        }

        .logo-container{
            text-align: left;
        }

        .container-flexy{
            position:  relative;
        }

        .assessment-container{
            width: 50%;
        }

        .approved-container{
            position: absolute;
            top: 0;
            right: 0;
            font-size: 12px;
            text-align: right;
        }

        .sign-container{
            margin-top: 10px;
            position: absolute;
            right: 0;
        }

        /* #sign-1{
            top: 5px;
        } */

        #sign-line-1{
            top: 10px;
        }
        #sign-line-2{
            top: 10px;
        }
        #sign-2{
            top: 90px;
        }

        .signs{
            height: 1px;
            width: 150px;
            position: absolute;
            right: 0;
            background-color: black;
        }

        footer{
            text-align: left;
            font-size: 12px;
            font-weight: bolder;
        }
        
        .sign-approved{
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container logo-container">
        <img src="https://drive.google.com/uc?id=1OBzJloHutLsDw2E9V-VTLc26ZIetJLrW" alt="logo">
    </div>
    <div class="container">
        <div class="title">
            <p>Pre Registration Info</p>
            <p class="right-portion">{{ Carbon\Carbon::parse($registration->created_at)->format('F j, Y') }}</p>
        </div>
        <div class="table-container">
            <table>
                    <tr>
                        <td>Registration ID: <span>{{ $registration->id ?? 'N/A' }}</span></td>
                        <td>Status: <span>{{ $registration->status->name ?? 'N/A'  }}</span></td>
                    </tr>
                    <tr>
                        <td>Level: <span>{{ $registration->prospectus->level->level ?? 'N/A' }}</span></td>
                        <td>Program: <span>{{ $registration->prospectus->program->code ?? 'N/A'  }}</span></td>
                    </tr>
                    <tr>
                        <td>Track: <span>{{ $registration->prospectus->strand->track->track ?? 'N/A' }}</span></td>
                        <td>Strand: <span>{{ $registration->prospectus->strand->code ?? 'N/A'  }}</span></td>
                    </tr>
                    <tr>
                        <td>Term: <span class="text-gray-500 pl-2">{{ $registration->prospectus->term->term ?? 'N/A' }}</span></td>
                        <td>School Year: <span>{{ Carbon\Carbon::parse($registration->created_at)->format('Y') .' - '. Carbon\Carbon::parse($registration->created_at)->addYear()->format('Y') }}</span></td>
                    </tr>
                    <tr>
                        <td>Section: <span>{{ $registration->section->name ?? 'N/A' }}</span></td>
                    </tr>
            </table>
        </div>
    </div>

    <div class="container">
        <div class="title">
            <p>Student Details</p>
        </div>
        <div class="table-container">
            <table>
                <tr>
                    <td>Student ID: <span>{{ $registration->student->isStudent ? $registration->student->custom_student_id : 'N/A' }}</span></td>
                    <td>Type: <span>{{ $registration->isNew ? 'New' : 'Old' }}</span></td>
                </tr>
                <tr>
                    <td>Name: <span>{{ $registration->student->user->person->full_name ?? 'N/A' }}</span></td>
                    <td>Email: <span>{{ $registration->student->user->email ?? 'N/A'  }}</span></td>
                </tr>
                <tr>
                    <td>Mobile Number: <span>{{ $registration->student->user->person->contact->mobile_number ?? 'N/A' }}</span></td>
                    <td>Address: <span>{{ $registration->student->user->person->contact->address ?? 'N/A'  }}</span></td>
                </tr>
                <tr>
                    <td>Birthdate: <span>{{ Carbon\Carbon::parse($registration->student->user->person->detail->birthdate)->format('F j, Y') ?? 'N/A' }}</span></td>
                    <td>Birthplace: <span>{{ $registration->student->user->person->detail->birthplace ?? 'N/A'  }}</span></td>
                </tr>
                <tr>
                    <td>Gender: <span>{{ $registration->student->user->person->detail->gender ?? 'N/A' }}</span></td>
                    <td>Civil Status: <span>{{ $registration->student->user->person->detail->civil_status ?? 'N/A'  }}</span></td>
                </tr>
                <tr>
                    <td>Religion: <span>{{ $registration->student->user->person->detail->religion ?? 'N/A' }}</span></td>
                    <td>Nationality: <span>{{ $registration->student->user->person->detail->country->name ?? 'N/A'  }}</span></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="container">
        <div class="title">
            <p>Subjects</p>
            <p class="right-portion">Total Units: {{ $registration->prospectus->subjects->sum('unit') }}</p>
        </div>
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Title</th>
                    <th>Unit</th>
                    <th>Pre Requisite</th>
                </tr>
                @forelse ($registration->prospectus->subjects as $subject)
                    <tr>
                        <td class="td-center">{{ $subject->id ?? 'N/A' }}</td>
                        <td class="td-center">{{ $subject->code ?? 'N/A' }}</td>
                        <td class="td-center">{{ $subject->title ?? 'N/A' }}</td>
                        <td class="td-center">{{ $subject->unit ?? 'N/A' }}</td>
                        <td class="td-center">
                            @forelse ($subject->requisites as $requisite)
                                {{ $loop->first ? '' : ', '  }}
                                <span>&nbsp;{{ $requisite->code }}</span>
                            @empty

                            @endforelse
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td rowspan="4">No Subject Found.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>

    <div class="container container-flexy">
        <div class="assessment-container">
            <div class="title">
                <p>Assessment</p>
                <p class="right-portion">Total: PHP {{ number_format((float)$registration->prospectus->fees->sum('price'), 2, '.', '') }}</p>
            </div>
            <div class="table-container">
                <table>
                    @forelse ($registration->prospectus->fees as $fee)
                        <tr>
                            <td >{{ $fee->name ?? 'N/A' }}</td>
                            <td>PHP{{ $fee->price ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td rowspan="2">No Payment Found.</td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
        <div class="approved-container">
            <p>Present this certificate for any transaction within the University.</p>
            <div class="">
                <div id="sign-1" class="sign-container">
                    <div id="sign-line-1" class="signs">&nbsp;</div>
                    <p>STUDENT'S SIGNATURE</p>
                </div>
                <div id="sign-2" class="sign-container">
                    <div id="sign-line-2" class="signs">&nbsp;</div>
                    <p>APPROVED BY</p>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>{{ Carbon\Carbon::parse(now())->format('F j, Y') }}</p>
        <p>Pasig City, Metro Manila 1600 | Visit us: university.edu.ph</p>
    </footer>
</body>

</html>