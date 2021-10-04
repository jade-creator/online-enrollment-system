<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
    <style>
        /*PDF SIZE*/
        @page { size: 20cm 30cm landscape; }
    </style>
</head>

<body>
    <div class="center mb-3">
        <img src="https://drive.google.com/uc?id=1l2yy9vCB5pFaJwewAGiiOMU3BmQdsG8Q" width="100" height="100">
    </div>

    <div class="container">
        <table class="container-title">
            <tr>
                <td class="center truncate-widest">REPORT OF GRADES</td>
            </tr>
        </table>
        <table class="container-details">
            <tr>
                <td>Student ID: <span>STD-0001</span></td>
                <td>Status: <span>ENROLLED</span></td>
            </tr>
            <tr>
                <td>Student Name: <span>Patrick Henry Vervo Samson</span></td>
                <td>Student Type: <span>Old</span></td>
            </tr>
            <tr>
                <td>Section: <span>BSIT-5E</span></td>
                <td>Year Level: <span>5</span></td>
            </tr>
            <tr>
                <td>Program: <span>BSIT - Bachelor of Science in Information Technology</span></td>
                <td>School Year: <span>2020-2021</span></td>
            </tr>
        </table>
    </div>
    <div class="container">
        <table class="container-details center">
            <tr class="uppercase">
                <th>Subject</th>
                <th class="w-6">Title</th>
                <th>Section</th>
                <th>Grade</th>
                <th>Remark</th>
                <th>Unit Earned</th>
            </tr>
            <tr>
                <td>COMP 106</td>
                <td class="whitespace-normal left">Application Development and Emerging Technologies</td>
                <td>BSIT-5E</td>
                <td>5.00</td>
                <td>PSD</td>
                <td>3.00</td>
            </tr>
            <tr>
                <td>COMP 106</td>
                <td class="whitespace-normal left">Application Development and Emerging Technologies</td>
                <td>BSIT-5E</td>
                <td>5.00</td>
                <td>PSD</td>
                <td>3.00</td>
            </tr>
            <tr>
                <td>COMP 106</td>
                <td class="whitespace-normal left">Application Development and Emerging Technologies</td>
                <td>BSIT-5E</td>
                <td>5.00</td>
                <td>PSD</td>
                <td>3.00</td>
            </tr>
        </table>
    </div>
    
                
                


{{--   
<!-- 
    <div>
        <p><span>(LOGO)</span> University Name</p>
        <p><span>{{ $registration->prospectus->program->code ?? 'N/A' }} -</span> {{ $registration->prospectus->program->program ?? 'N/A' }}</p>
    </div>
    <p>---------------------------------</p>
    <div>
        <p>Student ID: <span>{{ $registration->student->custom_id ?? 'N/A' }}</span></p>
        <p>Student Name: <span>{{ $registration->student->user->person->full_name ?? 'N/A' }}</span></p>
        <p>Section: <span>{{ $registration->section->name ?? 'N/A' }}</span></p>
        <p>School Year: <span>{{ $registration->school_year ?? 'N/A' }}</span></p>
    </div>
    <p>---------------------------------</p>

    <p><span>{{ $registration->prospectus->level->level ?? 'N/A' }} </span>-<span> {{ $registration->prospectus->term->term ?? 'N/A' }}</span></p>

    <table>
        <tr>
            <th>subject</th>
            <th>title</th>
            <th>section</th>
            <th>grade</th>
            <th>remark</th>
        </tr>
        <tbody>
        @forelse ($collectionGrades as $grade)
            <tr>
                <td>{{ $grade->prospectus_subject->subject->code ?? 'N/A' }}</td>
                <td>{{ $grade->prospectus_subject->subject->title ?? 'N/A' }}</td>
                <td>{{ $registration->section->name ?? 'N/A' }}</td>
                <td>{{ $grade->value ?? 'N/A' }}</td>
                <td>{{ $grade->mark->name ?? 'N/A' }}</td>
            </tr>
        @empty
        @endforelse
        </tbody>
        <p>Computed Grade: <span>{{ number_format($computedGrade, '2', '.', '') ?? 'N/A' }}</span></p>
    </table> -->--}}
</body>

</html>
