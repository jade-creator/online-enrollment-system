<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
    <style>
        body {
            position: relative;
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            width: 100%;
            margin-bottom: 10px;
            border: 1px solid #ecf0f1;
            border-top-left-radius: 0.375rem;
            border-top-right-radius: 0.375rem;
            overflow: hidden;
        }

        .title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: rgba(71, 120, 185, 0.2);
            padding: 0 1.5rem;
            font-weight: 600;
        }

        .title .right-portion {
            font-weight: 400;
            font-size: 0.75rem;
        }

        .table-container {
            padding: 1rem;
            font-size: 0.75rem;
            line-height: 1rem;
        }

        table {
            width: 100%;
        }

        td {
            padding-bottom: 0.2rem;
        }

        .td-center {
            text-align: center;
        }

        .td-bold {
            font-weight: bold;
        }

        td span {
            color: rgba(107, 114, 128, 1);
            padding-left: 0.5rem;
        }

        .assessment-signatures {
            display: flex;
            align-items: flex-start;
        }

        .assessment,
        .signatures {
            width: 50%;
        }

        .assessment {
            height: auto;
        }

        .signatures {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            text-align: right;
            font-size: 10px;
        }

        .signature-line {
            width: 50%;
        }

        .signature-line p {
            text-align: center;
            padding-top: 5px;
            margin-top: 2rem;
            text-transform: uppercase;
            border-top: 1px solid black;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            text-align: left;
            font-size: 12px;
            font-weight: bolder;
        }

        /*PDF SIZE*/
        @page { size: 20cm 30cm landscape; }
    </style>
</head>

<body>
    <p>University</p>

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
    </table>
</body>

</html>
