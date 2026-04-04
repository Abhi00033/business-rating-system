<?php
include('../config/db.php');

$business_id = $_POST['business_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$rating = $_POST['rating'];

// Check existing rating
$query = "SELECT id FROM ratings WHERE business_id=? AND (email=? OR phone=?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iss", $business_id, $email, $phone);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update
    $row = $result->fetch_assoc();
    $update = $conn->prepare("UPDATE ratings SET rating=? WHERE id=?");
    $update->bind_param("di", $rating, $row['id']);
    $update->execute();
} else {
    // Insert
    $insert = $conn->prepare("INSERT INTO ratings (business_id, name, email, phone, rating) VALUES (?, ?, ?, ?, ?)");
    $insert->bind_param("isssd", $business_id, $name, $email, $phone, $rating);
    $insert->execute();
}

// Get new average
$avgQuery = $conn->prepare("SELECT AVG(rating) as avg_rating FROM ratings WHERE business_id=?");
$avgQuery->bind_param("i", $business_id);
$avgQuery->execute();
$avgResult = $avgQuery->get_result()->fetch_assoc();

echo json_encode([
    'status' => 'success',
    'business_id' => $business_id,
    'avg_rating' => round($avgResult['avg_rating'], 1)
]);
