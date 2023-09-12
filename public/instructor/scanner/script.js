document.addEventListener("DOMContentLoaded", function () {
    const qrCodeScanner = new Html5Qrcode("qr-code-scanner");
    const resultContainer = document.getElementById("result");
    const stopButton = document.getElementById("stopButton");

    qrCodeScanner.start(
        { facingMode: "environment" },
        {
            fps: 10,
            qrbox: 250,
        },
        (data) => {
            resultContainer.innerHTML = `QR Code Scanned: ${data}`;
            // console.log("QR Code Scanned: " + data);

            sendStudentNumberAndSubjectIdToServer(data);
        },
        (error) => {
            console.error("QR Code Scanner Error: " + error);
        }
    );

    function sendStudentNumberAndSubjectIdToServer(data) {
        const url = 'check-student.php';

        const subjectId = window.subjectId;
        // console.log("studentNumber:", data);
        // console.log("subjectId:", subjectId);

        const formData = new FormData();
        formData.append('studentNumber', data); 
        formData.append('subject_id', subjectId); 

        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(result => {
            // console.log("Server Response:", result);
            if (result.message === 'Student found and enrolled') {
                resultContainer.innerHTML += '<br>Student found in the database.';
            } else if (result.message === 'Duplicate attendance record') {
                resultContainer.innerHTML += '<br>Attendance already recorded.';
            } else if (result.message === 'Student is present') {
                resultContainer.innerHTML += '<br>Attendance recorded successfully.';
            } else if (result.message === 'Failed to insert data') {
                resultContainer.innerHTML += '<br>Error: ' + result.message;
            } else {
                resultContainer.innerHTML += '<br>Student not found in the database.';
            }
        })
        .catch(error => {
            // console.error('Error sending data to server:', error);
            resultContainer.innerHTML += '<br>Error communicating with the server: There was an issue sending the data to the server.';
        });
    }
});
