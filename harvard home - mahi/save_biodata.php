<?php
// DB connection
$host = "localhost";
$user = "root";
$password = "";
$db = "mydb";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form data
$fullName = $_POST['fullName'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$maritalStatus = $_POST['maritalStatus'];
$address = $_POST['address'] ?? "N/A";

// Handle photo upload
$photo = $_FILES['photo'];
$targetDir = "uploads/";
$photoName = basename($photo["name"]);
$targetFile = $targetDir . time() . "_" . $photoName;

if (move_uploaded_file($photo["tmp_name"], $targetFile)) {
  // Insert into DB
  $stmt = $conn->prepare("INSERT INTO biodata (full_name, dob, gender, email, phone, marital_status, address, photo_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssssss", $fullName, $dob, $gender, $email, $phone, $maritalStatus, $address, $targetFile);

  if ($stmt->execute()) {
    echo "<h2>Bio Data Saved Successfully</h2>";
    echo "<img src='$targetFile' width='150' style='border-radius:10px;'><br><br>";
    echo "<b>Name:</b> $fullName <br>";
    echo "<b>DOB:</b> $dob <br>";
    echo "<b>Gender:</b> $gender <br>";
    echo "<b>Email:</b> $email <br>";
    echo "<b>Phone:</b> $phone <br>";
    echo "<b>Marital Status:</b> $maritalStatus <br>";
    echo "<b>Address:</b> $address <br>";
  } else {
    echo "Database error: " . $stmt->error;
  }

  $stmt->close();
} else {
  echo "Error uploading file.";
}

$conn->close();
?>
