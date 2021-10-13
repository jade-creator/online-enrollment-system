<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Classlist</title>
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
                <td class="center truncate-widest">CLASSLIST - BSIT4E</td>
            </tr>
        </table>
        <table class="ordinary-table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Balance</th>
            </tr>
            @for ($i = 0; $i <= 100; $i++)
                <tr>
                    <td class="center">STD00001</td>
                    <td>Mark Lawrence Parone Samson</td>
                    <td class="center">Enrolled</td>
                    <td class="right">PHP 100,000.00</td>
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