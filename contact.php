<?php
$success_message = $error_message = ''...;

// Database connection details
$host = 'localhost';        // XAMPP uses localhost for MySQL
$username = 'root';         // Default MySQL username for XAMPP
$password = '';             // Default MySQL password for XAMPP (empty)
$database = 'foodmenu';          // Your database name (foodmenu)

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Connect to the database
    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        $error_message = "Connection failed: " . $conn->connect_error;
    } else {
        // Prepare SQL query using prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO contact_form (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message); // "ssss" means 4 string parameters

        if ($stmt->execute()) {
            $success_message = "Your message has been sent successfully!";
        } else {
            $error_message = "There was an error submitting your message. Please try again.";
        }
        $stmt->close();
        $conn->close();
    }
}
?>

<!-- Display success or error message -->
<?php if ($success_message): ?>
    <div class="alert alert-success"><?php echo $success_message; ?></div>
<?php elseif ($error_message): ?>
    <div class="alert alert-danger"><?php echo $error_message; ?></div>
<?php endif; ?>


