<?php
include('../config/db.php');

$name = trim($_POST['name']);
$address = trim($_POST['address']);
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);

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

// ✅ Check duplicate email (AFTER validation)
if (!empty($email)) {
    $check = $conn->prepare("SELECT id FROM businesses WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Business with this email already exists'
        ]);
        exit;
    }
}

$stmt = $conn->prepare("INSERT INTO businesses (name, address, phone, email) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $address, $phone, $email);
$stmt->execute();

$id = $stmt->insert_id;

// Return row HTML
$row = "
<tr id='row_$id'>
    <td>$id</td>
    <td>$name</td>
    <td>$address</td>
    <td>$phone</td>
    <td>$email</td>
    <td><div class='rating' data-score='0'></div></td>
    <td>
        <button class='btn btn-warning btn-sm editBtn' data-id='$id'>Edit</button>
        <button class='btn btn-danger btn-sm deleteBtn' data-id='$id'>Delete</button>
        <button class='btn btn-info btn-sm rateBtn' data-id='$id'>Rate</button>
    </td>
</tr>
";

echo json_encode([
    'status' => 'success',
    'row_html' => $row
]);
