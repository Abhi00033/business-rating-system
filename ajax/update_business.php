<?php
include('../config/db.php');

$id = $_POST['id'];
$name = trim($_POST['name']);
$address = trim($_POST['address']);
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);

// ✅ ID validation
if (empty($id) || !is_numeric($id)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
    exit;
}

// ✅ Name validation
if (empty($name)) {
    echo json_encode(['status' => 'error', 'message' => 'Name is required']);
    exit;
}

// ✅ Phone validation
if (!empty($phone) && !preg_match('/^[0-9]{10}$/', $phone)) {
    echo json_encode(['status' => 'error', 'message' => 'Enter valid 10 digit phone number']);
    exit;
}

// ✅ Email validation
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email address']);
    exit;
}

// ✅ Duplicate email check (exclude current ID)
if (!empty($email)) {
    $check = $conn->prepare("SELECT id FROM businesses WHERE email=? AND id != ?");
    $check->bind_param("si", $email, $id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Email already exists'
        ]);
        exit;
    }
}

// ✅ Update query
$stmt = $conn->prepare("UPDATE businesses SET name=?, address=?, phone=?, email=? WHERE id=?");
$stmt->bind_param("ssssi", $name, $address, $phone, $email, $id);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'id' => $id,
        'name' => $name,
        'address' => $address,
        'phone' => $phone,
        'email' => $email
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Update failed']);
}
