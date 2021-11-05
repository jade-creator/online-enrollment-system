<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Overview</title>
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
                <td class="center truncate-widest">OVERVIEW</td>
            </tr>
        </table>
    </div>
    <div class="cards">
            <div class="card">
                <div class="card-text">
                    <p>Users</p>
                    <p>9999</p>
                </div>
            </div>
            <div class="card">
                <div class="card-text">
                    <p>Pre Registrations</p>
                    <p>9999</p>
                </div>
            </div>
            <div class="card">
                <div class="card-text">
                    <p>Sections</p>
                    <p>9999</p>
                </div>
            </div>
            <div class="card">
                <div class="card-text">
                    <p>Subjects</p>
                    <p>9999</p>
                </div>
            </div>
    </div>
    <div class="container">
        <table class="ordinary-table">
            <tr>
                <th class="left text-primary">
                    <p class="pl-1">Gender</p>
                    <p class="lighter text-gray size-14 pl-1">Total number per gender category in the system</p>
                </th>
                <td>
                    <table>
                        <tr>
                            <th>Female</th>
                            <td class="right w-one-fourth">500</th>
                        </tr>
                        <tr>
                            <th>Male</th>
                            <td class="right w-one-fourth">500</th>
                        </tr>
                        <tr>
                            <th>Other</th>
                            <td class="right w-one-fourth">500</th>
                        </tr>
                        <tr>
                            <th>Prefer not to say</th>
                            <td class="right w-one-fourth">500</th>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <th class="left text-primary">
                    <p class="pl-1">Users</p>
                    <p class="lighter text-gray size-14 pl-1">Total number of registered users</p>
                </th>
                <td>
                    <table>
                        <tr>
                            <th>Admin</th>
                            <td class="right w-one-fourth">500</th>
                        </tr>
                        <tr>
                            <th>Student</th>
                            <td class="right w-one-fourth">500</th>
                        </tr>
                        <tr>
                            <th>Registrar</th>
                            <td class="right w-one-fourth">500</th>
                        </tr>
                        <tr>
                            <th>Dean</th>
                            <td class="right w-one-fourth">500</th>
                        </tr>
                        <tr>
                            <th>Faculty Members</th>
                            <td class="right w-one-fourth">500</th>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <th class="left text-primary">
                    <p class="pl-1">Registration Status</p>
                    <p class="lighter text-gray size-14 pl-1">Total number registration per status</p>
                </th>
                <td>
                    <table>
                        <tr>
                            <th>Enrolled</th>
                            <td class="right w-one-fourth">500</th>
                        </tr>
                        <tr>
                            <th>Finalized</th>
                            <td class="right w-one-fourth">500</th>
                        </tr>
                        <tr>
                            <th>Confirming</th>
                            <td class="right w-one-fourth">500</th>
                        </tr>
                        <tr>
                            <th>Pending</th>
                            <td class="right w-one-fourth">500</th>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <h4>Number of students per program as of SY. 2021 - 2022</h4>
    <div class="cards">
        <!-- PRE pag pang 5th na card, nasisira design amp AHAHAHAH sa video gawin nalang apat na program para di masira -->
        @for($i = 0; $i < 4; $i++)
            <div class="card">
                <div class="card-text">
                    <p>Program name</p>
                    <p>9999</p>
                </div>
            </div>
        @endfor
    </div>

    <footer>
        <p>{{ Carbon\Carbon::parse(now())->format('F j, Y') }}</p>
        <p>Pasig City, Metro Manila 1600 | Visit us: university.edu.ph</p>
    </footer>

</body>
</html>