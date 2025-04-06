<?php
include("connection.php"); // Include your database connection file

// Initialize variables
$studentID = $first_name = $middle_name = $last_name = $age = $gender = $year_level = $course = $discount = $payment = '';
$studentNotFound = false; // Flag to check if student is found

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $studentID = $_POST['studentID'];
    // Query to retrieve student information based on the provided studentID
    $sql = "SELECT * FROM students WHERE id = '$studentID'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Populate the variables with retrieved information
        $first_name = $row['fname'];
        $middle_name = $row['mname'];
        $last_name = $row['lname'];
        $age = $row['age'];
        $gender = $row['gender'];
        $year_level = $row['yearlevel'];
        $course = $row['course'];
        $discount = $row['discount'];
        $payment = $row['payment'];     
    } else {
        $studentNotFound = true; // Set the flag to true if no student is found
    }

    // If student is found, continue with the payment query
    if (!$studentNotFound) {
        $sql2 = "SELECT * FROM stud_payment WHERE id = '$studentID'";
        $result1= mysqli_query($conn, $sql2);

        if ($result1 && mysqli_num_rows($result1) > 0) {
            $rowpayment = mysqli_fetch_assoc($result1);
            $tuitionrate = $rowpayment['tuitionrate'];
            $tuition = $rowpayment['tuition'];
            $otherfees = $rowpayment['otherfees'];
            $discountrate = $rowpayment['discount'];
            $totalfee = $rowpayment['totalfee'];
            $lesspayments = 0;
            $finals = $rowpayment['finals'];
            $termpay = $rowpayment['downpayment'];

            if ($payment === "Full") {
                $balance = 0;
                $lesspayments = $totalfee;
            } elseif ($payment === "Installment") {
                $balance = ($termpay * 3) + $finals;
                $lesspayments = $termpay;
            }
        }
    }
}

// Display the error message in a user-friendly way if the student is not found
if ($studentNotFound) {
    echo "<p style='color:red;'>Student not found! Please check the student ID and try again.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>

</style>
<body>
    <header>
        <div class="logo">
            <a href="admin_main.php">
                <img src="../resources/school-logo.png" alt="School Logo" width="70">
            </a>
        </div>
        <h1 class="sschool-name">SYSTEMS PLUS COLLEGE FOUNDATION</h1>
        <p class ="sadmin">Admin</p> 
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
            <div class="search-container">
                <input type="text" name="studentID" id="studentID" placeholder="Student ID" required>
                <button type="submit" class="logo-button">
                    <img src="sear.png" width="35">
                </button>
            </div>
        </form>
        <div id="student-container" class="student-container">
            <div class="container-left">
                <caption><h2>Student Profile</h2><br></caption>
                <table border="1">
                <tr>
                    <td>Student Name:</td>
                    <td>
                        <?php
                        $studentName = (isset($last_name) && isset($first_name) && isset($middle_name)) ? $last_name . ", " . $first_name . " " . $middle_name : "";
                        echo $studentName;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Age:</td>
                    <td><?php echo isset($age) ? $age : ""; ?></td>
                </tr>
                <tr>
                    <td>Gender:</td>
                    <td><?php echo isset($gender) ? $gender : ""; ?></td>
                </tr>
                <tr>
                    <td>Year Level:</td>
                    <td><?php echo isset($year_level) ? $year_level : ""; ?></td>
                </tr>
                <tr>
                    <td>Course:</td>
                    <td><?php echo isset($course) ? $course : ""; ?></td>
                </tr>
                <tr>
                    <td>Discount:</td>
                    <td><?php echo isset($discount) ? $discount : ""; ?></td>
                </tr>
                <tr>
                    <td>Payment Mode:</td>
                    <td><?php echo isset($payment) ? $payment : ""; ?></td>
                </tr>
                </table>
            </div>
            <div class="container-right">
            <h2><br><br>Student Subjects</h2>
            <table border="1">
                <tr>
                    <th>CLASS CODE</th>
                    <th>SUBJECT DESCRIPTION</th>
                    <th>UNITS</th>
                    <th>SCHEDULE</th>
                    <th>DAYS</th> <!-- Added DAYS column -->
                    <th>ROOMS</th>
                </tr>
                <tr>
                    <td>113067</td>
                    <td>HCIL - Human-Computer Interaction -</td>
                    <td>3.00</td>
                    <td>9AM - 12NN, 9AM - 12NN</td>
                    <td>Mon, Thu</td> <!-- Added DAYS information -->
                    <td>LAB 3, CISCO LAB</td>
                </tr>
                <tr>
                    <td>113064</td>
                    <td>NET2L - Basic Router Configuration -</td>
                    <td>3.00</td>
                    <td>1PM - 3PM, 3PM - 6PM</td>
                    <td>Fri</td> <!-- Added DAYS information -->
                    <td>CISCO LAB</td>
                </tr>
                <tr>
                    <td>113066</td>
                    <td>PLL - Programming Languages and Paradigms</td>
                    <td>3.00</td>
                    <td>2PM - 4PM, 4PM - 7PM</td>
                    <td>Mon, Tue</td> <!-- Added DAYS information -->
                    <td>RVJ 4, LAB 3</td>
                </tr>
                <tr>
                    <td>113068</td>
                    <td>CMORL - Computer Architecture and Organization</td>
                    <td>3.00</td>
                    <td>4PM - 7PM, 10AM - 12NN</td>
                    <td>Thu, Fri</td> <!-- Added DAYS information -->
                    <td>LAB 3, RVJ</td>
                </tr>
                <tr>
                    <td>113069</td>
                    <td>ELEC1_CS - CS Elective 1</td>
                    <td>3.00</td>
                    <td>9AM - 12NN, 8AM - 10AM</td>
                    <td>Mon, Wed</td> <!-- Added DAYS information -->
                    <td>LAB 3, RVJ 4</td>
                </tr>
                <tr>
                    <td>113063</td>
                    <td>IAS1L - Fundamentals of Information Assurance and Security</td>
                    <td>3.00</td>
                    <td>1PM - 4PM</td>
                    <td>Tue, Thu</td> <!-- Added DAYS information -->
                    <td>CISCO LAB, RVJ 9</td>
                </tr>
                <tr>
                    <td>113065</td>
                    <td>AULT - Automata and Language Theory</td>
                    <td>3.00</td>
                    <td>8AM - 12 PM</td>
                    <td>Tue</td> <!-- Added DAYS information -->
                    <td>RVJ 9</td>
                </tr>
                <tr>
                    <td>113062</td>
                    <td>LWR - Life and Works of Rizal</td>
                    <td>3.00</td>
                    <td>10:30 AM - 12NN, 2:30 PM - 4PM</td>
                    <td>Wed</td> <!-- Added DAYS information -->
                    <td>RVJ 3</td>
                </tr>
            </table>
        </div>
        <div id ="payment-container" class="payment-container">
            <table>
                <tr>
                    <td>
                        <div>
                        <h2>Account Summary</h2><br>
                        <table border="1">
                            <tr>
                                <th>DESCRIPTION</th>
                                <th>AMOUNT</th>
                            </tr>
                            <tr>
                                <td>Tuition Fee (24 @ <?php echo isset($tuitionrate) ? $tuitionrate : "0.00"; ?>)</td>
                                <td><?php echo isset($tuition) ? $tuition : "0.00"; ?></td>
                            </tr>
                            <tr>
                                <td>SUB-TOTAL</td>
                                <td><?php echo isset($tuition) ? $tuition : "0.00"; ?></td>
                            </tr>
                            <tr>
                                <td>Other Fees:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Athletic Fee/Learning Management System</td>
                                <td>1,200.00</td>
                            </tr>
                            <tr>
                                <td>COMMUNITY EXTENSION</td>
                                <td>100.00</td>
                            </tr>
                            <tr>
                                <td>FACILITY FEE</td>
                                <td>450.00</td>
                            </tr>
                            <tr>
                                <td>Guidance</td>
                                <td>1,000.00</td>
                            </tr>
                            <tr>
                                <td>ID FEE</td>
                                <td>400.00</td>
                            </tr>
                            <tr>
                                <td>INTERNET FEE</td>
                                <td>1,000.00</td>
                            </tr>
                            <tr>
                                <td>Library Fee</td>
                                <td>1,750.00</td>
                            </tr>
                            <tr>
                                <td>Medical/Dental</td>
                                <td>950.00</td>
                            </tr>
                            <tr>
                                <td>REGISTRATION FEE</td>
                                <td>1,200.00</td>
                            </tr>
                            <tr>
                                <td>System Development Fee</td>
                                <td>1,000.00</td>
                            </tr>
                            <tr>
                                <td>Computer Lab(0)</td>
                                <td>10,800.00</td>
                            </tr>
                            <tr>
                                <td>SUB-TOTAL</td>
                                <td><?php echo isset($otherfees) ? $otherfees : "0.00"; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $discount; ?></td>
                                <td><?php echo isset($discountrate) ? $discountrate : "0.00"; ?></td>
                            </tr>
                            <tr>
                                <td>Total Enrollment Fee</td>
                                <td><?php echo isset($totalfee) ? $totalfee : "0.00"; ?></td>
                            </tr>
                            <tr>
                                <td>Less Payments</td>
                                <td><?php echo isset($lesspayments) ? $lesspayments : "0.00"; ?></td>
                            </tr>
                            <tr>
                                <td>Total Refund</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>BALANCE</td>
                                <td><?php echo isset($balance) ? $balance : '0.00'; ?></td>
                            </tr>
                        </table>
                        </div>
                    </td>
                    <td>
                        <div class="installment" style="display: <?php echo $payment === 'Installment' ? 'block' : 'none'; ?>">
                            <br><h2>Payment Schedule</h2><br>
                                <table border="1">
                                    <tr>
                                        <th>PAYMENT SCHEDULE</th>
                                        <th>DUE DATE</th>
                                        <th>AMOUNT</th>
                                        <th>NON-SCH</th>
                                        <th>TOTAL</th>
                                    </tr>
                                    <tr>
                                        <td>Down Payment</td>
                                        <td>2023-08-14</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Prelim</td>
                                        <td>2023-09-25</td>
                                        <td><?php echo isset($termpay) ? $termpay : '0.00'; ?></td>
                                        <td>0.00</td>
                                        <td><?php echo isset($termpay) ? $termpay : '0.00'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>MidTerm</td>
                                        <td>2023-10-23</td>
                                        <td><?php echo isset($termpay) ? $termpay : '0.00'; ?></td>
                                        <td>0.00</td>
                                        <td><?php echo isset($termpay) ? $termpay : '0.00'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Pre-finals</td>
                                        <td>2023-11-20</td>
                                        <td><?php echo isset($termpay) ? $termpay : '0.00'; ?></td>
                                        <td>0.00</td>
                                        <td><?php echo isset($termpay) ? $termpay : '0.00'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Finals</td>
                                        <td>2023-12-11</td>
                                        <td><?php echo isset($finals) ? $finals : ''; ?></td>
                                        <td>0.00</td>
                                        <td><?php echo isset($finals) ? $finals : '0.00'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>TOTAL</td>
                                        <td></td>
                                        <td><?php echo isset($balance) ? $balance : '0.00'; ?></td>
                                        <td>0.00</td>
                                        <td><?php echo isset($balance) ? $balance : '0.00'; ?></td>
                                    </tr>
                                </table>
                        </div>
                        <div class="full" style="display: <?php echo $payment === 'Full' ? 'block' : 'none'; ?>">
                            <br><h2>Payment Schedule</h2><br>
                                <table border="1">
                                    <tr>
                                        <th>PAYMENT SCHEDULE</th>
                                        <th>DUE DATE</th>
                                        <th>AMOUNT</th>
                                        <th>NON-SCH</th>
                                        <th>TOTAL</th>
                                    </tr>
                                    <tr>
                                        <td>Full Payment</td>
                                        <td>2023-08-14</td>
                                        <td><?php echo $totalfee; ?></td>
                                        <td>0.00</td>
                                        <td><?php echo $totalfee; ?></td>
                                    </tr>
                                    <tr>
                                        <td></td><td></td><td></td><td></td> <td></td>   
                                    </tr>
                                    <tr>
                                        <td></td><td></td><td></td><td></td> <td></td>   
                                    </tr>
                                    <tr>
                                        <td></td><td></td><td></td><td></td> <td></td>   
                                    </tr>
                                    <tr>
                                        <td></td><td></td><td></td><td></td> <td></td>   
                                    </tr>
                                    <tr>
                                        <td>TOTAL</td>
                                        <td></td>
                                        <td><?php echo $totalfee; ?></td>
                                        <td>0.00</td>
                                        <td><?php echo $totalfee; ?></td>
                                    </tr>
                            </table>
                        </div>                          
                    </td>
                </tr>
            </table>
        </div>
        <script>
            function toggleContainer(containerId) {
                const container = document.getElementById(containerId);
                // Hide all containers except the selected one
                const containers = document.querySelectorAll(".info-container");
                containers.forEach((otherContainer) => {
                    if (otherContainer.id !== containerId) {
                        otherContainer.style.display = "none";
                    }
                });
                // Toggle the selected container
                container.style.display = container.style.display === "block" ? "none" : "block";
            }
        </script>
    </main>
</body>
</html>
