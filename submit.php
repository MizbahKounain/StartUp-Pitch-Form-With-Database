<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "startup_pitches"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $founderName = mysqli_real_escape_string($conn, $_POST['founderName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $startUpName = mysqli_real_escape_string($conn, $_POST['StartUpName']);
    $pitchDesc = mysqli_real_escape_string($conn, $_POST['pitchDesc']);

    $sql = "INSERT INTO pitches (founderName, email, contact, country, startUpName, pitchDesc) 
            VALUES ('$founderName', '$email', '$contact', '$country', '$startUpName', '$pitchDesc')";

    if ($conn->query($sql) === TRUE) {
        echo "<h2>Pitch Submitted Successfully!</h2>";
        echo "<p><strong>Founder Name:</strong> $founderName</p>";
        echo "<p><strong>Email:</strong> $email</p>";
        echo "<p><strong>Contact Number:</strong> $contact</p>";
        echo "<p><strong>Country:</strong> $country</p>";
        echo "<p><strong>Startup Name:</strong> $startUpName</p>";
        echo "<p><strong>Pitch Description:</strong> $pitchDesc</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }

    // Stop further rendering if a POST request is handled
    exit;
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startup Pitch Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #8c8cc1;
            margin: 15px;
            padding: 10px;
        }

        .container {
            width: 40%;
            margin: 50px auto;
            background: #7273b3;
            padding: 20px;
            border-radius: 15px;
            box-shadow: black(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #000000;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input, textarea, button {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #6e7e91;
            color: #050000;
            border-radius: 50px;
            cursor: pointer;
        }

        button:hover {
            background-color: #3d3c89;
        }

        #result {
            margin-top: 20px;
            font-size: 18px;
        }

        .country {
            height: 30px;
            border-radius: 10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#pitchForm').on('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: '', // The same PHP file handles submission
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $('#result').html(response);
                    },
                    error: function (xhr, status, error) {
                        console.error("XHR Object:", xhr);
                        console.error("Status:", status);
                        console.error("Error:", error);
                        $('#result').html('<p>There was an error processing your request. Check console for details.</p>');
                    },
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Submit Your Startup Pitch</h1>
        <form id="pitchForm" method="POST" enctype="multipart/form-data">

            <label for="founderName">Founder Name:</label>
            <input type="text" id="founderName" name="founderName" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="contact">Contact Number:</label>
            <input type="tel" id="contact" name="contact" required>

            <label for="country">Country:</label>
            <select class="country" id="country" name="country" required>
                <option value="IN">Select a Country</option>
                <option value="India">India</option>
                <option value="UK">United Kingdom</option>
                <option value="Canada">Canada</option>
                <option value="Australia">Australia</option>
                <option value="Others">Other</option>
            </select>

            <label for="StartUpName">StartUp Name:</label>
            <input type="text" id="StartUpName" name="StartUpName" required>

            <label for="pitchDesc">Pitch Description:</label>
            <textarea class="pitch" id="pitchDesc" name="pitchDesc" rows="5" required></textarea>

            <button type="submit">Submit Pitch</button>
        </form>
        <div id="result"></div>
    </div>
</body>
</html>
