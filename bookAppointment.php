<?php
  include 'conn.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctorId = $_POST['doctor_id'];
    $patientId = $_POST['patient_id'];
    $appointmentDate = $_POST['appointment_date'];
    $appointmentTime = $_POST['appointment_time'];

    $query = "INSERT INTO appointments (doctor_id, patient_id, appointment_date, appointment_time) VALUES ('$doctorId', '$patientId', '$appointmentDate', '$appointmentTime')";
    $result = mysqli_query($conn, $query);

    if ($result) {
      $query = "SELECT CONCAT(first_name, ' ', last_name) AS doctor_name FROM doctors WHERE doctor_id = '$doctorId'";
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_assoc($result);
      echo $row['doctor_name'];
    }
    else {
      echo "Error";
    }
  }
?>
