<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $registration->student->user->person->full_name ?? 'Print Grade' }}</title>
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
    <style>
        /*PDF SIZE*/
        @page { size: 20cm 30cm landscape; }
    </style>
</head>

<body>
    <div class="watermark"></div>
    <div class="logo-container mb-3 center">
        <img src="https://drive.google.com/uc?export=view&id=1l2yy9vCB5pFaJwewAGiiOMU3BmQdsG8Q" alt="logo" width="50" height="50">
        <p class="truncate-widest bold">UNIVERSITY</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet, amet.</p>
    </div>

    <!-- GENERAL WEIGHTED AVERAGE -->
    <div id="gwa">
        <p class="italic">CWA:</p>
        <p>{{ number_format((float)$computedGrade, 2, '.', '') }}</p>
    </div>

    <div class="container">
        <table class="container-title">
            <tr>
                <td class="center truncate-widest">REPORT OF GRADES</td>
            </tr>
        </table>
        <table class="container-details">
            <tr>
                <td>Student ID: <span>{{ $registration->custom_id ?? 'N/A' }}</span></td>
                <td>Status: <span>{{ $registration->status->name ?? 'N/A' }}</span></td>
            </tr>
            <tr>
                <td>Student Name: <span>{{ $registration->student->user->person->full_name ?? 'N/A' }}</span></td>
                <td>Student Type: <span>{{ $registration->isNew ?? 'N/A' }}</span></td>
            </tr>
            <tr>
                <td>Section: <span>{{ $registration->section->name ?? 'N/A' }}</span></td>
                <td>Year Level: <span>{{ $registration->prospectus->level->level ?? 'N/A' }}</span></td>
            </tr>
            <tr>
                <td>Program: <span>{{ $registration->prospectus->program->code ?? 'N/A' }}</span>-<span> {{ $registration->prospectus->program->program ?? 'N/A' }}</span></td>
                <td>School Year: <span>{{ $registration->school_year ?? 'N/A' }}</span></td>
            </tr>
        </table>
    </div>
    <div class="container">
        <table class="container-details center">
            <tr class="uppercase">
                <th>Subject</th>
                <th class="w-6">Title</th>
                <th>Professor</th>
                <th>Section</th>
                <th>Grade</th>
                <th>Remark</th>
                <th>Unit Earned</th>
            </tr>

            @foreach ($registration->grades as $grade)
                <tr>
                    <td>{{ $grade->prospectus_subject->subject->code ?? 'N/A' }}</td>
                    <td class="whitespace-normal left">{{ $grade->prospectus_subject->subject->title ?? 'N/A' }}</td>
                    <td>{{ $professors[$grade->subject_id][0] ?? 'N/A' }}</td>
                    <td>{{ $registration->section->name ?? 'N/A' }}</td>
                    <td>{{ $grade->value ?? 'N/A' }}</td>
                    <td>{{ $grade->mark->name ?? 'N/A' }}</td>
                    <td>{{ $professors[$grade->subject_id][1] ?? 'N/A' }}</td>
                </tr>
            @endforeach

            @if ($registration->extensions->isNotEmpty())
                @foreach ($registration->extensions as $extension)
                    @foreach ($extension->registration->grades as $grade)
                        <tr>
                            <td>{{ $grade->prospectus_subject->subject->code ?? 'N/A' }}</td>
                            <td class="whitespace-normal left">{{ $grade->prospectus_subject->subject->title ?? 'N/A' }}</td>
                            <td>{{ $professors[$grade->subject_id][0] ?? 'N/A' }}</td>
                            <td>{{ $registration->section->name ?? 'N/A' }}</td>
                            <td>{{ $grade->value ?? 'N/A' }}</td>
                            <td>{{ $grade->mark->name ?? 'N/A' }}</td>
                            <td>{{ $professors[$grade->subject_id][1] ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @endif
        </table>

        @if (isset($notComputed) && is_array($notComputed) && count($notComputed) > 0)
            <p class="text-sm py-2"><span class="font-bold text-base">&#9432</span> Not Computed:
                @forelse ($notComputed as $subject)
                    {{ $loop->first ? '' : ', '  }}
                    <span>{{ $subject[0] ?? 'N/A' }}</span>
                    {{ $loop->last ? '.' : ''  }}
                @empty
                    <span class="text-gray-400">N/A</span>
                @endforelse
            </p>
        @endif
    </div>
</body>

</html>
