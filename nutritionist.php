<!DOCTYPE HTML> 
<html>
<?php
include 'database.php';
session_start();

// Function to check if there are upcoming appointments within the next week
function hasUpcomingAppointments($email) {
    global $conn;

    $stmt = $conn->prepare("SELECT app_date FROM appointment WHERE email = ? AND app_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are any upcoming appointments
    $hasUpcoming = $result->num_rows > 0;

    $stmt->close();
    return $hasUpcoming;
}

function storeAppointment($name, $email, $app_date, $app_time, $app_status) {
    global $conn;

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO appointment (name, email, app_date, app_time, status) VALUES (?, ?, ?, ?, ?)");
    
    // Bind parameters
    $stmt->bind_param("sssss", $name, $email, $app_date, $app_time, $app_status);
    
    // Execute the statement and check for success
    $success = $stmt->execute();

    // Close the statement
    $stmt->close();
    
    return $success; // Return true if the appointment was stored successfully
}

// Check for upcoming appointments and set session variable
$_SESSION['hasUpcomingAppointments'] = hasUpcomingAppointments($_SESSION['email']);

// Function to fetch appointments for the logged-in user
function getAppointmentsByEmail($email) {
    global $conn;

    // Query to fetch appointments based on the logged-in user's email, sorted by date (closest first)
    $stmt = $conn->prepare("SELECT name, app_date, app_time, status FROM appointment WHERE email = ? ORDER BY app_date ASC");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all appointments and return them
    $appointments = $result->fetch_all(MYSQLI_ASSOC);
    return $appointments;
}

$showModal = false;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $email = $_SESSION['email'];
    $app_date = isset($_POST['date']) ? $_POST['date'] : null;
    $app_time = isset($_POST['time']) ? $_POST['time'] : null;
    $app_status = "Pending"; // Default status

    // Ensure that all required fields are filled
    if ($name && $app_date && $app_time) {
        // Attempt to store the appointment
        if (storeAppointment($name, $email, $app_date, $app_time, $app_status)) {
            // Redirect to prevent resubmission and show modal
            header("Location: " . $_SERVER['PHP_SELF'] . "?submitted=true");
            exit;
        } else {
            echo "<script>console.log('Error: Unable to create appointment.');</script>";
        }
    } else {
        echo "<script>console.log('Error: Please fill in all required fields.');</script>";
    }
}

// Check if the form was submitted successfully
if (isset($_GET['submitted']) && $_GET['submitted'] == 'true') {
    $showModal = true; // Show modal after successful submission
}

// Pagination setup
$limit = 10; // Items per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Current page
$offset = ($page - 1) * $limit; // Offset for SQL query

// Get the total number of appointments
$totalAppointments = getAppointmentCount($_SESSION['email']);

// Calculate total pages
$totalPages = ceil($totalAppointments / $limit);

// Fetch appointments for the current page
$appointments = getAppointmentsByEmailWithPagination($_SESSION['email'], $limit, $offset);

// Only close the connection here after all queries
$conn->close();

// Function to get appointments with pagination
function getAppointmentsByEmailWithPagination($email, $limit, $offset) {
    global $conn;

    $stmt = $conn->prepare("SELECT name, app_date, app_time, status FROM appointment WHERE email = ? ORDER BY app_date ASC LIMIT ? OFFSET ?");
    $stmt->bind_param("sii", $email, $limit, $offset);

    $stmt->execute();
    $result = $stmt->get_result();
    $appointments = [];

    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }

    $stmt->close();
    return $appointments;
}

// Function to get the total number of appointments for pagination
function getAppointmentCount($email) {
    global $conn;

    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM appointment WHERE email = ?");
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_assoc()['total'];

    $stmt->close();
    return $count;
}
?>

<head>
    <link rel="stylesheet" href="css/nut.css">
</head>
<body>
    <header>
        <h1 style="font-size: 40px">Huan Fitness Pal</h1>
        <h4 style="font-size: 20px"><i>For all your fitness needs...</i></h4>
    </header>

    <div class="nut">
        <h3> Welcome to Huan Fitness Pal, <?php echo $_SESSION['email']; ?>! </h3>

        <div class="container">
            <div class="left-column">
                <div class="img-border"></div>
                <div class="info">
                    <p style="font-size: 25px;margin-bottom: -35px;">Dr. Emily Carter</p><br>
                    <p>Nutrition Specialist,<br> Wellness & Nutrition Center Hospital</p>
                </div>
            </div>

            <div class="right-column">
                <form method="POST">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $_SESSION['email']; ?>" placeholder="Enter your email" disabled>

                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" min="<?php echo date('Y-m-d'); ?>" required>

                    <label for="time">Time:</label>
                    <input type="time" id="time" name="time" required>

                    <input type="submit" value="Schedule Meetup">
                    <input type="button" onclick="openPopup()" value="Track Request Status">
                    <input type="button" onclick="window.location.href='user.php'" value="Back">
                </form>
            </div>

            <!-- Modal for Request Status -->
            <div id="statusModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeStatusModal()">&times;</span>
                    <h2>Your Appointments</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($appointments) > 0) {
                                $counter = $offset + 1; // Initialize counter for No. and adjust for pagination
                                foreach ($appointments as $appointment) {
                                    $statusClass = '';
                                    if ($appointment['status'] === 'Pending') {
                                        $statusClass = 'status-pending';
                                    } elseif ($appointment['status'] === 'Confirmed') {
                                        $statusClass = 'status-confirmed';
                                    } elseif ($appointment['status'] === 'Declined') {
                                        $statusClass = 'status-declined';
                                    } elseif ($appointment['status'] === 'Cancelled') {
                                        $statusClass = 'status-cancelled';
                                    }

                                    echo "<tr>";
                                    echo "<td>" . $counter++ . "</td>";
                                    echo "<td>" . htmlspecialchars($appointment['name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($appointment['app_date']) . "</td>";
                                    echo "<td>" . htmlspecialchars($appointment['app_time']) . "</td>";
                                    echo "<td class='$statusClass'>" . htmlspecialchars($appointment['status']) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No appointments found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Pagination Controls -->
                    <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>" class="prev">&laquo; Previous</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?php echo $page + 1; ?>" class="next">Next &raquo;</a>
                    <?php endif; ?>
                </div>
                </div>
            </div>

            <div id="myModal" class="modal" style="display: <?php echo $showModal ? 'block' : 'none'; ?>">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2>Request Submitted!</h2>
                    <p>Your request has been successfully submitted.</p>
                </div>
            </div>

            <!-- Reminder Modal -->
            <div id="reminderModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <span class="close" onclick="closeReminderModal()">&times;</span>
                    <h2>Upcoming Appointment Reminder</h2>
                    <p>You have upcoming appointments scheduled within the next week. Please check your schedule!</p>
                </div>
            </div>

        </div>
    </div>
</body>
<footer>
    <h4>
        <i>Huan Sdn. Bhd</i><br>
        <i>All Rights Reserved&copy</i>
    </h4>
</footer>
<script>
    // Function to open the status modal
    function openPopup() {
        document.getElementById("statusModal").style.display = "block";
        localStorage.setItem('statusModalOpen', 'true');
    }

    // Function to close the status modal
    function closeStatusModal() {
        document.getElementById("statusModal").style.display = "none";
        localStorage.removeItem('statusModalOpen');
    }

    // Function to open the reminder modal
    function openReminderPopup() {
        document.getElementById("reminderModal").style.display = "block";
    }

    // Function to close the reminder modal
    function closeReminderModal() {
        document.getElementById("reminderModal").style.display = "none";
    }

    // Function to close the myModal
    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }

    // Prevent form submission when clicking outside of modal and form
    window.onclick = function(event) {
        const statusModal = document.getElementById("statusModal");
        const myModal = document.getElementById("myModal");
        const form = document.querySelector('form'); // Select your form element

        // If the target is the status modal, close it
        if (event.target === statusModal) {
            closeStatusModal();
        }

        // If the target is the myModal, close it and reload
        if (event.target === myModal) {
            closeModal();
            window.location.href = "nutritionist.php";
        }

        // Prevent the form from submitting when clicking outside of it
        if (form && !form.contains(event.target)) {
            event.preventDefault(); // Prevent form submission
        }
    };

    // Check if the user has upcoming appointments when the page loads
    window.onload = function() {
        console.log("Page loaded:", window.location.pathname, window.location.search);

        // Open the status modal if it was set in local storage
        if (localStorage.getItem('statusModalOpen') === 'true') {
            openPopup();
        }

        // Check if user has upcoming appointments from PHP session
        <?php if (isset($_SESSION['hasUpcomingAppointments']) && $_SESSION['hasUpcomingAppointments']): ?>
            console.log('Checking for upcoming appointments.');
            if (window.location.pathname === '/nutritionist.php' && window.location.search === '') {
                console.log('Opening reminder modal because the conditions were met.');
                openReminderPopup();
            } else {
                console.log('Not opening reminder modal. Conditions not met.');
            }
        <?php endif; ?>

        // Close myModal after a delay if it was shown
        <?php if ($showModal): ?>
            setTimeout(() => {
                closeModal();
            }, 3000); // 3 seconds delay
        <?php endif; ?>
    };
</script>
</html>
