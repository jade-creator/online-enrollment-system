<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Registration</title>
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
                <td>Pre Registration Info</td>
                <td>Lorem ipsum dolor sit amet.</td>
            </tr>
        </table>
        <table class="container-details">
                <tr>
                    <td>Registration ID: <span>Lorem ipsum dolor sit amet.</span></td>
                    <td>Status: <span>Enrolled</span></td>
                </tr>
                <tr>
                    <td>Level: <span>1st Year</span></td>
                    <td>Program: <span>BSIT</span></td>
                </tr>
                <tr>
                    <td>Term: <span>First term</span></td>
                    <td>School Year: <span>2020-2021</span></td>
                </tr>
                <tr>
                    <td>Section: <span>1E</span></td>
                </tr>
        </table>
    </div>

    <div class="container">
        <table class="container-title">
            <tr>
                <td>Student Details</td>
            </tr>
        </table>
        <table class="container-details">
            <tr>
                <td>Student ID: <span>STD-0001</span></td>
                <td>Type: <span>New</span></td>
            </tr>
            <tr>
                <td>Name: <span>Andrew E. Ferrer</span></td>
                <td>Email: <span>andrewferrer80@gmail.com</span></td>
            </tr>
            <tr>
                <td>Mobile Number: <span>09696969696</span></td>
                <td>Address: <span>#69 Trust st., Orange Carbon Fiber City</span></td>
            </tr>
            <tr>
                <td>Birthdate: <span>June 6, 1969</span></td>
                <td>Birthplace: <span>Fiber City</span></td>
            </tr>
            <tr>
                <td>Gender: <span>Male</span></td>
                <td>Civil Status: <span>Single</span></td>
            </tr>
            <tr>
                <td>Religion: <span>Atheist</span></td>
                <td>Nationality: <span>Philippines</span></td>
            </tr>
        </table>
    </div>

    <div class="container">
        <table class="container-title">
            <tr>
                <td>Class Schedules</td>
                <td>Total Units: 69</td>
            </tr>
        </table>
        <table class="container-details">
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Title</th>
                <th>Unit</th>
                <th>Pre Requisite</th>
            </tr>

            <tr>
                <td class="center">ICT</td>
                <td class="center">IT49</td>
                <td class="center">Lorem ipsum dolor sit amet.</td>
                <td class="center">3</td>
                <td class="center">

                        <span>IT48</span>
                        <span>IT48</span>
                        <span>IT48</span>

                </td>
            </tr>

        </table>
    </div>

    <div class="double-container">
        <div class="left-container">
            <table class="container-title">
                <tr>
                    <td>Assessment</td>
                    <td>Total: PHP 234,304</td>
                </tr>
            </table>
            <table class="container-details">
                    <tr>
                        <td >Computer lab</td>
                        <td>PHP 333.00</td>
                    </tr>
                    <!-- <tr>
                        <td rowspan="2">No Payment Found.</td>
                    </tr> -->
            </table>
        </div>
        <div class="right-container">
            <div id="signatures">
                <h4>Present this certificate for any transaction within the University.</h6>
                <p>Student Signature</p>
                <p>Approved By:</p>
            </div>
        </div>
    </div>

    <footer>
        <p>{{ Carbon\Carbon::parse(now())->format('F j, Y') }}</p>
        <p>Pasig City, Metro Manila 1600 | Visit us: university.edu.ph</p>
    </footer>
</body>
</html>