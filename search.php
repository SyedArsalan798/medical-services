<?php
  include 'conn.php';
  session_start();
  if (!(isset($_SESSION['email'])) && !(isset($_SESSION['password']))) {
      // If the user is already logged in, redirect to the dashboard page
      header('Location: login.php');
      exit;
    }

  if (isset($_GET['location']) && isset($_GET['specialty'])) {
    $location = $_GET['location'];
    $specialty = $_GET['specialty'];

    // SQL query to retrieve doctors based on user input
    $query = "SELECT doctors.doctor_id, doctors.first_name, doctors.last_name, doctors.email, doctors.specialty, doctors.availability, doctor_availability.date, doctor_availability.start_time, doctor_availability.end_time
              FROM doctors
              JOIN cities ON doctors.city_id = cities.city_id
              LEFT JOIN doctor_availability ON doctors.doctor_id = doctor_availability.doctor_id
              WHERE cities.city_name = '$location' AND doctors.specialty = '$specialty'";
    $result = mysqli_query($conn, $query);
    $emailP = $_SESSION['email'];
    $passwordP = $_SESSION['password'];

    $query2 = "SELECT patient_id FROM patients WHERE email = '$emailP' AND password = '$passwordP'";
    $result1 = mysqli_query($conn, $query2);
  
  
    $row = mysqli_fetch_assoc($result1);
    $patient_id = $row['patient_id'];
  }
  else{
    header("Location: home.php");
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>Book Appointment</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0-beta3/css/bootstrap.min.css">
</head>
<body>
  <?php include 'navbarPatient.php';?>

  <div class="container py-3">
    <h1 class="text-center mb-5 display-6">Book Appointment</h1>
    <div class="row row-cols-1 row-cols-md-4 g-4">
      <?php
        // loop through the query results and display them in cards
        while ($row = mysqli_fetch_assoc($result)) {
          $doctor_id = $row['doctor_id'];
          $first_name = $row['first_name'];
          $last_name = $row['last_name'];
          $email = $row['email'];
          $specialty = $row['specialty'];
          $availability = $row['availability'];
          $date = $row['date'];
          $start_time = $row['start_time'];
          $end_time = $row['end_time'];
          $availability_text = $date ? "$date $start_time - $end_time" : $availability;
          echo "
            <div class='col'>
              <div class='card shadow-sm'>
                <div class='card-body'>
                  <h5 class='card-title'>$first_name $last_name</h5>
                  <p class='card-text mb-0'><b>Specialty:</b> $specialty</p>
                  <p class='card-text mb-0'><b>Contact Info:</b> 
                  <a href = 'mailto:$email'>$email</a>
                  </p>
                  <p class='card-text'><b>Availability:</b> $availability_text</p>
                  <a href='#' class='btn btn-primary rounded-0 w-100 book-appointment' data-doctor-id='$doctor_id'>Book Appointment</a>
                </div>
              </div>
            </div>
          ";
        }
      ?>
    </div>
  </div>

  <?php include 'jsFiles.php'; ?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0-beta3/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.book-appointment').click(function(e) {
        e.preventDefault();
        var doctorId = $(this).data('doctor-id');
        var appointmentDate = prompt('Enter appointment date (YYYY-MM-DD):');
        var appointmentTime = prompt('Enter appointment time (HH:MM:SS):');
        var patientId = <?php echo $patient_id; ?>;

        if (appointmentDate && appointmentTime) {
          $.ajax({
            url: 'bookAppointment.php',
            type: 'POST',
            data: {
              doctor_id: doctorId,
              patient_id: patientId,
              appointment_date: appointmentDate,
              appointment_time: appointmentTime
            },
            success: function(response) {
              alert('You have appointed ' + response + ' doctor.');
            }
          });
        }
      });
    });
  </script>
</body>
</html>
