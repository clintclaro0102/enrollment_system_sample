<?php
include("connection.php");

if (!$conn) {
    die("Connection Failed");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $year_level = $_POST['year_level'];
    $course = $_POST['course'];
    $discount = $_POST['discount'];
    $payment = $_POST['payment'];
    $password = $_POST['password'];

    $add = "INSERT INTO students (fname, mname, lname, age, gender, yearlevel, course, discount, payment, password)
            VALUES ('$first_name', '$middle_name', '$last_name', $age, '$gender', '$year_level', '$course', '$discount', '$payment', '$password')";

    if (mysqli_query($conn, $add)) {
        // Data inserted successfully
    }else {
        echo "Error: " . $add . "<br>" . mysqli_error($conn);
    }

    $studentUserID = "";
    $sql = "SELECT * FROM students WHERE fname = '$first_name'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $studentUserID = $row['id'];
    }

    $add1 = "INSERT INTO student_acc (user, pass)
    VALUES ('$studentUserID', '$password')";

    if (mysqli_query($conn, $add1)) {
        // Data inserted successfully
    } else {
        echo "Error: " . $add1 . "<br>" . mysqli_error($conn);
    }

    $units = 24; // Example: Number of units
    $otherfees = 19850;
    // Define tuition rates
    if ($payment === "Full") {
        $tuitionRate = 891.63;
    } elseif ($payment === "Installment") {
        $tuitionRate = 936.21;
    } 

    // Define discount rate based on the received discount value
    if ($discount === "ACADEMIC SCHOLAR (100)") {
        $discountRate = 1;
    } elseif ($discount === "ACADEMIC SCHOLAR (75)") {
        $discountRate = 0.75;
    } elseif ($discount === "ACADEMIC SCHOLAR (50)") {
        $discountRate = 0.50;
    } elseif ($discount === "ALUMNI (20)") {
        $discountRate = 0.20;
    } else {
        $discountRate = 0;
    }
    function roundUpToHundred($value) {
        return ceil($value / 100) * 100;
    }
    // Calculate total tuition fee
    $tuitionFee = $tuitionRate * $units;
    // Calculate the discount amount
    $discountAmount = $tuitionFee * $discountRate;
    // Calculate total fees
    $totalFee = $tuitionFee + $otherfees - $discountAmount;
    // Calculate per-term rate
   
    $perTermRate = roundUpToHundred($totalFee / 5);

    $final = $totalFee - 4 * $perTermRate;

    $addPayment = "INSERT INTO stud_payment(id, units, tuitionrate, tuition, otherfees, discount, totalfee, downpayment, prelim, midterm, prefinals, finals)
    VALUES ('$studentUserID','$units', '$tuitionRate','$tuitionFee','$otherfees', '$discountAmount', '$totalFee', '$perTermRate', '$perTermRate', '$perTermRate', '$perTermRate', '$final')";


    if (mysqli_query($conn, $addPayment)) {
        // Payment information inserted successfully
    } else {
        echo "Error: " . $addPayment . "<br>" . mysqli_error($conn);
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="styles2.css"> 
</head>
<body>
    <header>
        <div class="logo">
            <a href="admin_main.php">
                <img src="school-logo.png" alt="School Logo" width="70">
            </a>
        </div>
        <h1 class="school-name">SYSTEMS PLUS COLLEGE FOUNDATION</h1>
        <p class ="admin">Admin</p>
        <a href="admin_main.php">Go Back</a>  
        <a href="javascript:void(0);" onclick="logout()">Logout</a>
        <script>
            function logout() {
                var confirmLogout = confirm("You are logging out...");
                if (confirmLogout) {
                    window.location.href = "index.php";
                }
            }
        </script> 
    </header>
    <main>
        <form method="POST">
            <div class="form-container"> <!-- Add the form container here -->
                <table>
                    <caption><br><h2>Student Registration</h2><br></caption>
                    <tr>
                        <td><label for="first_name">First Name:</label></td>
                        <td><input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required></td>
                    </tr>
                    <tr>
                        <td><label for="middle_name">Middle Name:</label></td>
                        <td><input type="text" id="middle_name" name="middle_name" placeholder="Enter your middle name"></td>
                    </tr>
                    <tr>
                        <td><label for="last_name">Last Name:</label></td>
                        <td><input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required></td>
                    </tr>
                    <tr>
                        <td><label for="age">Age:</label></td>
                        <td><input type="number" id="age" name="age" placeholder="Enter your age" required></td>
                    </tr>
                    <tr>
                        <td><label>Gender:</label></td>
                        <td class="radio-label">
                            <label for="male" class="radio-label">
                                <input type="radio" id="male" name="gender" value="Male" required> Male
                            </label>
                            <label for="female" class="radio-label">
                                <input type="radio" id="female" name="gender" value="Female" required> Female
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="year_level">Year Level:</label></td>
                        <td>
                            <select id="year_level" name="year_level">
                                <option disable>Please Choose</option>
                                <option value="1st year">1st Year</option>
                                <option value="2nd year">2nd Year</option>
                                <option value="3rd year">3rd Year</option>
                                <option value="4th year">4th Year</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="course">Course:</label></td>
                        <td>
                            <select id="course" name="course" required>
                                <option disable>Please Choose</option>
                                <option value="Information Technology">Information Technology (IT)</option>
                                <option value="Computer Science">Computer Science (CS)</option>
                                <option value="Computer Engineering">Computer Engineering (CE)</option>
                                <option value="Electrical Engineering (EE)">Electrical Engineering (EE)</option>
                            </select>
                        </td>
                    </tr>
                
                    <tr>
                        <td><label for="discount">Discount/Scholarship:</label></td>
                        <td>
                            <select id="discount" name="discount">
                                <option disable>Please Choose</option>
                                <option value="Not">None</option>
                                <option value="ACADEMIC SCHOLAR (100)">ACADEMIC SCHOLAR (100)</option>
                                <option value="ACADEMIC SCHOLAR (75)">ACADEMIC SCHOLAR (75)</option>
                                <option value="ACADEMIC SCHOLAR (50)">ACADEMIC SCHOLAR (50)</option>
                                <option value="ALUMNI (20)">ALUMNI (20)</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="payment">Payment Mode:</label></td>
                        <td>
                            <select id="payment" name="payment">
                                <option disable>Please Choose</option>
                                <option value="Full">Full</option>
                                <option value="Installment">Installment</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="password">Password:</label></td>
                        <td><input type="password" id="password" name="password" placeholder="must be 8 to 16 characters long" required></td>
                    </tr>
                        <td><button type="submit" id="register-button" onclick="submitForm()">Register</button></td>

                </table> 
            </div> 
        </form>
            <div class="info-container" id="info-container">
                <caption><h2>Student Information</h2><br></caption>
                <table>
                    <tr>
                        <td>Student Username/ID:</td>
                        <td><?php echo $studentUserID; ?></td>
                    </tr>
                    <tr>
                        <td>Student Name:</td>
                        <td><?php echo $last_name. ", " . $first_name . " " . $middle_name; ?></td>
                    </tr>
                    <tr>
                        <td>Age:</td>
                        <td><?php echo $age; ?></td>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <td><?php echo $gender; ?></td>
                    </tr>
                    <tr>
                        <td>Year Level:</td>
                        <td><?php echo $year_level; ?></td>
                    </tr>
                    <tr>
                        <td>Course:</td>
                        <td><?php echo $course; ?></td>
                    </tr>
                    <tr>
                        <td>Discount:</td>
                        <td><?php echo $discount; ?></td>
                    </tr>
                    <tr>
                        <td>Payment Mode:</td>
                        <td><?php echo $payment; ?></td>
                    </tr>
                </table>
                <button class="ok-button"onclick="toggleInfoContainer()"><h2>x<h2></button>
            </div>
            <script>
                // Function to toggle the visibility of the info container
                function toggleInfoContainer() {
                    const infoContainer = document.getElementById("info-container");
                    infoContainer.style.display = infoContainer.style.display === "block" ? "none" : "block";

                function submitForm() {
                    const registerButton = document.querySelector('#register-button');
                    registerButton.disabled = true;  // Disable the button to prevent multiple submissions
                    document.querySelector('form').submit();  // Submit the form
                }
                }
                // Check if the registration form is submitted
                <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        echo 'toggleInfoContainer();';
                    }
                ?>
            </script>
        </main>
    </body>
</html>
