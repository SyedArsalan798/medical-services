<?php
include '../conn.php';

$doctor_id = $_POST['doctor_id'];
$first_name = mysqli_real_escape_string($conn, $_POST['firstName']);
$last_name = mysqli_real_escape_string($conn, $_POST['lastName']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$phone_number = mysqli_real_escape_string($conn, $_POST['phoneNumber']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$city_id = $_POST['city_id'];
$specialty = mysqli_real_escape_string($conn, $_POST['specialty']);

$sql = "UPDATE doctors SET first_name='$first_name', last_name='$last_name', email='$email', password='$password', phone_number='$phone_number', address='$address', city_id=$city_id, specialty='$specialty' WHERE doctor_id=$doctor_id";
$result = mysqli_query($conn, $sql);

if ($result) {
  $response = array('success' => true);
  echo json_encode($response);
} else {
    $response = array('success' => false, 'message' => mysqli_error($conn));
    echo json_encode($response);
}
    mysqli_close($conn);
?>