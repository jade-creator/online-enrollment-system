<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Schedule</title>
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
</head>

<body>
    <div class="watermark"></div>
    <div class="logo-container mb-3 center">
        <img src="https://drive.google.com/uc?export=view&id=1l2yy9vCB5pFaJwewAGiiOMU3BmQdsG8Q" alt="logo" width="50" height="50">
        <p class="truncate-widest bold">UNIVERSITY</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet, amet.</p>
    </div>
    @for ($j = 0; $j <= 6; $j++)
        <div class="mb-4 container">
            <table class="container-title">
                <tr>
                    <td class="center truncate-widest">BSIT4E SCHEDULE</td>
                </tr>
            </table>
            <table class="ordinary-table">
                <tr>
                    <th>Code</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                    <th>Saturday</th>
                    <th>Sunday</th>
                </tr>
                @for ($i = 0; $i <= 5; $i++)
                    <tr>
                        <td>MATH</td>
                        <td class="center">05:13pm - 05:13pm</td>
                        <td class="center">05:13pm - 05:13pm</td>
                        <td class="center">05:13pm - 05:13pm</td>
                        <td class="center">05:13pm - 05:13pm</td>
                        <td class="center">05:13pm - 05:13pm</td>
                        <td class="center">05:13pm - 05:13pm</td>
                        <td class="center">05:13pm - 05:13pm</td>
                    </tr>
                @endfor
            </table>
        </div>
    @endfor

    <footer>
        <p>{{ Carbon\Carbon::parse(now())->format('F j, Y') }}</p>
        <p>Pasig City, Metro Manila 1600 | Visit us: university.edu.ph</p>
    </footer>
</body>
</html>