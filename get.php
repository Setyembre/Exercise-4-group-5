<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mysecdb"; // Ensure this matches your actual database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'id' is provided in the GET request
if (!empty($_GET['id'])) {
    $id = (int)$_GET['id']; // Cast to integer
    
    // Prepare and bind
    $stmt = $conn->prepare("SELECT lastname, firstname, middlename, email, contact_number, age, address, gender FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    $stmt->execute();
    $stmt->bind_result($lastname, $firstname, $middlename, $email, $contact_number, $age, $address, $gender);
    
    if ($stmt->fetch()) {
        $message = "<h2>User Information</h2>
                    Name: " . htmlspecialchars($lastname) . ", " . htmlspecialchars($firstname) . " " . htmlspecialchars($middlename) . "<br>
                    Email: " . htmlspecialchars($email) . "<br>
                    Contact Number: " . htmlspecialchars($contact_number) . "<br>
                    Age: " . htmlspecialchars($age) . "<br>
                    Address: " . htmlspecialchars($address) . "<br>
                    Gender: " . htmlspecialchars($gender) . "<br>";
    } else {
        $message = "<h2>No data found for ID: " . htmlspecialchars($id) . "</h2>";
    }
    
    $stmt->close();
} else {
    $message = "<h2>ID parameter is missing.</h2>";
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="get.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Retrieve Data</title>
 
</head>
<body>
    <div class="container">
        <!-- Form for GET request -->
        <h2>Retrieve Data using GET</h2>
        <form action="get.php" method="get">
            <label for="id">Enter User ID:</label>
            <input type="number" id="id" name="id" required>
            <input type="submit" value="View Data">
        </form>

        <!-- Display message if set -->
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
