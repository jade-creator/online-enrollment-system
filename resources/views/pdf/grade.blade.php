<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Grade</title>
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
        <p class="italic">GWA:</p>
        <p>5.00</p>
    </div>

    <div class="container">
        <table class="container-title">
            <tr>
                <td class="center truncate-widest">REPORT OF GRADES</td>
            </tr>
        </table>
        <table class="container-details">
            <tr>
                <td>Student ID: <span>STD0001</span></td>
                <td>Status: <span>Enrolled</span></td>
            </tr>
            <tr>
                <td>Student Name: <span>Mark Lawrence Parone</span></td>
                <td>Student Type: <span>New</span></td>
            </tr>
            <tr>
                <td>Section: <span>BSIT-3E</span></td>
                <td>Year Level: <span>4th year</span></td>
            </tr>
            <tr>
                <td>Program: <span>BSIT</span>-<span> Bachelor of Science in Information Technology</span></td>
                <td>School Year: <span>2020 - 2021</span></td>
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
                    <td>MATH</td>
                    <td class="whitespace-normal left">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem, expedita?</td>
                    <td>BSIT-3E</td>
                    <td>3.00</td>
                    <td>PASSED</td>
                    <td>3</td>
                </tr>

        </table>
    </div>
</body>

</html>
