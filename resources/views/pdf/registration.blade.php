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
    </style>
</head>

<body>
    <div class="logo-container">
        <img src="https://drive.google.com/uc?id=1OBzJloHutLsDw2E9V-VTLc26ZIetJLrW" alt="logo">
    </div>
    <div class="container">
        <div class="title">
            <p>Pre Registration Info</p>
            <p class="right-portion">Lorem ipsum dolor sit amet.</p>
        </div>
        <div class="table-container">
            <table>
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
    </div>

    <div class="container">
        <div class="title">
            <p>Student Details</p>
        </div>
        <div class="table-container">
            <table>
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
    </div>

    <div class="container">
        <div class="title">
            <p>Class Schedules</p>
            <p class="right-portion">Total Units: 69</p>
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

                    <tr>
                        <td class="td-center">ICT</td>
                        <td class="td-center">IT49</td>
                        <td class="td-center">Lorem ipsum dolor sit amet.</td>
                        <td class="td-center">3</td>
                        <td class="td-center">

                                <span>IT48</span>

                        </td>
                    </tr>

            </table>
        </div>
    </div>

    <div class="assessment-signatures">
        <div class="container assessment">
            <div class="title">
                <p>Assessment</p>
                <p class="right-portion"><b>Total: PHP 234,304</b></p>
            </div>
            <div class="table-container">
                <table>
                        <tr>
                            <td >Computer lab</td>
                            <td>PHP 333.00</td>
                        </tr>
                        <!-- <tr>
                            <td rowspan="2">No Payment Found.</td>
                        </tr> -->
                </table>
            </div>
        </div>
        <div class="signatures">
            <h4>Present this certificate for any transaction within the University.</h4>
            <div class="signature-line">
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