<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Masterlist</title>
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
</head>

<body>
    <div class="watermark"></div>
    <div class="logo-container mb-3 center">
        <img src="https://drive.google.com/uc?export=view&id=1l2yy9vCB5pFaJwewAGiiOMU3BmQdsG8Q" alt="logo" width="50" height="50">
        <p class="truncate-widest bold">UNIVERSITY</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet, amet.</p>
    </div>
    <div class="container">
        <table class="container-title">
            <tr>
                <td class="center truncate-widest">MASTERLIST S.Y 2021-2022</td>
            </tr>
        </table>
        <table class="ordinary-table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Program</th>
                <th>Section</th>
                <th>Status</th>
            </tr>
            @for ($i = 0; $i <= 100; $i++)
                <tr>
                    <td class="center">STD00001</td>
                    <td>Mark Lawrence Parone Samso</td>
                    <td>HRDMS</td>
                    <td>HRDMS-5A</td>
                    <td class="center">Enrolled</td>
                </tr>
            @endfor
        </table>
    </div>

    <footer>
        <p>{{ Carbon\Carbon::parse(now())->format('F j, Y') }}</p>
        <p>Pasig City, Metro Manila 1600 | Visit us: university.edu.ph</p>
    </footer>
</body>
</html>