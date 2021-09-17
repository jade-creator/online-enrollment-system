var gender = document.getElementById("genderChart").getContext("2d");
var oldNew = document.getElementById("oldNewChart").getContext("2d");
var studentStatus = document.getElementById("statusChart").getContext("2d");
var program = document.getElementById("programChart").getContext("2d");

var genderChart = new Chart(gender, {
    type: "doughnut",
    data: {
        labels: ["Female", "Male"],
        datasets: [
            {
                label: "Gender",
                data: [500, 419],
                backgroundColor: [
                    "rgba(255, 99, 132, 0.5)",
                    "rgba(54, 162, 235, 0.5)",
                ],
                borderColor: ["rgba(255, 99, 132, 1)", "rgba(54, 162, 235, 1)"],
                borderWidth: 1,
            },
        ],
    },
    options: {
        plugins: {
            legend: {
                position: "right",
                labels: {
                    boxWidth: 10,
                },
            },
            title: {
                display: true,
                text: "Gender",
                position: "top",
            },
        },
    },
});

var oldNewChart = new Chart(oldNew, {
    type: "doughnut",
    data: {
        labels: ["Old", "New"],
        datasets: [
            {
                label: "Student",
                data: [245, 419],
                backgroundColor: [
                    "rgba(241, 196, 15, 0.5)",
                    "rgba(54, 162, 235, 0.5)",
                ],
                borderColor: ["rgba(241, 196, 15, 1)", "rgba(54, 162, 235, 1)"],
                borderWidth: 1,
            },
        ],
    },
    options: {
        plugins: {
            legend: {
                position: "right",
                labels: {
                    boxWidth: 10,
                },
            },
            title: {
                display: true,
                text: "Student",
                position: "top",
            },
        },
    },
});

var statusChart = new Chart(studentStatus, {
    type: "doughnut",
    data: {
        labels: ["Enrolled", "Unenrolled", "Pending"],
        datasets: [
            {
                label: "Status",
                data: [245, 419, 203],
                backgroundColor: [
                    "rgba(255, 99, 132, 0.5)",
                    "rgba(54, 162, 235, 0.5)",
                    "rgba(39, 174, 96, 0.5)",
                ],
                borderColor: [
                    "rgba(255, 99, 132, 1)",
                    "rgba(54, 162, 235, 1)",
                    "rgba(39, 174, 96, 1)",
                ],
                borderWidth: 1,
            },
        ],
    },
    options: {
        plugins: {
            legend: {
                position: "right",
                labels: {
                    boxWidth: 10,
                },
            },
            title: {
                display: true,
                text: "Status",
                position: "top",
            },
        },
    },
});

var programChart = new Chart(program, {
    type: "bar",
    data: {
        labels: [
            "BSIT",
            "BSCS",
            "BSBA",
            "BSHM",
            "BSCE",
            "BSCOMM",
            "BEEd",
            "BSed",
            "BSECE",
            "BSHRM",
        ],
        datasets: [
            {
                label: "Programs",
                data: [245, 419, 203, 200, 1000, 50, 300, 500, 600, 506],
                backgroundColor: [
                    "rgba(255, 99, 132, 0.5)",
                    "rgba(54, 162, 235, 0.5)",
                    "rgba(39, 174, 96, 0.5)",
                    "rgba(52, 73, 94, 0.5)",
                    "rgba(155, 89, 182, 0.5)",
                ],
                borderColor: [
                    "rgba(255, 99, 132, 1)",
                    "rgba(54, 162, 235, 1)",
                    "rgba(39, 174, 96, 1)",
                    "rgba(52, 73, 94,1.0)",
                    "rgba(155, 89, 182,1.0)",
                ],
                borderWidth: 1,
            },
        ],
    },
    options: {
        scale: {
            y: {
                beginAtZero: true,
            },
        },
        plugins: {
            subtitle: {
                display: true,
                text: "Number of program per college as of 2020-2021 S.Y",
            },
        },
    },
});
