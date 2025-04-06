<?php
include('connection.php');

if (!$conn) {
    die("Connection Failed");
}
session_start(); // Start a session to maintain user authentication

if (isset($_SESSION['user'])) {
    $studentUserID = $_SESSION['user']; // Retrieve the student's username from the session
}

// Query to retrieve student information
$sql = "SELECT * FROM students WHERE id = '$studentUserID'";
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
}

$sql2 = "SELECT * FROM stud_payment WHERE id = '$studentUserID'";
$result1= mysqli_query($conn, $sql2);

$rowpayment = mysqli_fetch_assoc($result1);
$tuitionrate = $rowpayment['tuitionrate'];
$tuition = $rowpayment['tuition'];
$otherfees = $rowpayment['otherfees'];
$discountrate = $rowpayment['discount'];
$totalfee = $rowpayment['totalfee'];
$lesspayments = 0;
$finals = $rowpayment['finals'];

$termpay = $rowpayment['downpayment'];//4 term

if ($payment === "Full") {
    $balance = 0;
    $lesspayments = $totalfee;
} elseif ($payment === "Installment") {
    $balance = ($termpay * 3) + $finals;
    $lesspayments = $termpay;
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
</head>
<link rel="stylesheet" href="styles1.css">
<body>
    <header>
        <div class="school-logo">
            <img src="school-logo.png" alt="School Logo" width="70">
        </div>
        <h1 class="school-name">SYSTEMS PLUS COLLEGE FOUNDATION</h1>
        <p class="admin"> <?php echo $studentUserID; ?></p> 
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
        <table class="logo-table">
            <tr>
                <td>
                    <div class="logo-button" onclick="toggleContainer('profile-container')">
                        <img class="profile-logo" src="profile.png" alt="Profile">
                    </div>
                </td>
                <td>
                    <div class="logo-button" onclick="toggleContainer('subjects-container')">
                        <img class="subjects-logo" src="subsched.png" alt="Subjects">
                    </div>
                </td>
            </tr>
        </table>
                <div onclick="toggleContainer('payment-container')">
                    <img class="payment-logo" src="paysched.png" alt="Payment">
                </div>
        <!-- Create containers for Profile, Subjects, and Payment (initially hidden) -->
        <div id="profile-container" class="profile-container">
            <caption><h2>Student Profile</h2><br></caption>
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
        </div>

        <div id="subjects-container" class="subjects-container">
            <h2>Student Subjects<br><br></h2>
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
                                <td>Tuition Fee (24 @ <?php echo $tuitionrate; ?>)</td>
                                <td><?php echo $tuition; ?></td>
                            </tr>
                            <tr>
                                <td>SUB-TOTAL</td>
                                <td><?php echo $tuition; ?></td>
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
                                <td><?php echo $otherfees; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $discount; ?></td>
                                <td><?php echo $discountrate; ?></td>
                            </tr>
                            <tr>
                                <td>Total Enrollment Fee</td>
                                <td><?php echo $totalfee; ?></td>
                            </tr>
                            <tr>
                                <td>Less Payments</td>
                                <td><?php echo $lesspayments; ?></td>
                            </tr>
                            <tr>
                                <td>Total Refund</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td>BALANCE</td>
                                <td><?php echo $balance; ?></td>
                            </tr>
                        </table>
                        </div>
                    </td>
                    <td>
                    <div class="installment" style="display: <?php echo $payment === 'Installment' ? 'block' : 'none'; ?>">
                            <br><h2>Payment Schedule</h2><br>
                                <table border="0">
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
                                        <th>DATE</th>
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
            let currentOpenContainer = null; // Track the currently open container

            function toggleContainer(containerId) {
                const container = document.getElementById(containerId);

                // Check if a different container is currently open
                if (currentOpenContainer && currentOpenContainer !== container) {
                    currentOpenContainer.style.display = "none"; // Close the previously open container
                }

                // Toggle the selected container
                container.style.display = container.style.display === "block" ? "none" : "block";

                // Update the currently open container
                if (container.style.display === "block") {
                    currentOpenContainer = container;
                } else {
                    currentOpenContainer = null;
                }
            }
        </script>
    </main>
</body>
</html>