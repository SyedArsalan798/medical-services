<!DOCTYPE html>
<html>
<head>
    <title>Manage Appointments</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0-beta3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
    body {
      background-color: #f8f9fa;
    }
    
    .card {
      border-radius: 0px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .card-title {
      font-size: 1.25rem;
      margin-bottom: 1rem;
    }
    .card-text {
      font-size: 1rem;
      margin-bottom: 0.5rem;
    }
    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;

    }
    .btn-primary:hover {
      background-color: #0069d9;
      border-color: #0062cc;
    }
    .form-label {
      margin-bottom: 0.5rem;
    }
    .form-control {
      font-size: 1rem;
      padding: 0.5rem 1rem;
      margin-bottom: 1rem;
    }
    .form-control:focus {
      box-shadow: none;
    }
    .big-number {
      font-size: 3rem;
      font-weight: bold;
      margin-bottom: 0.5rem;
    }
    .last-added {
      font-size: 0.8rem;
      color: #6c757d;
      margin-bottom: 0.5rem;
    }
    .add-button {
      margin-bottom: 2rem;
    }
  </style>
</head>
<body>
    <?php include 'navbarAdmin.php'; ?>
    <div class="container">
    <div class="alert alert-success d-none" role="alert"></div>
        <h1 class="text-center display-6">Manage Appointments</h1>
        <?php
            include '../conn.php';

            // Retrieve appointments from database
            $sql = "SELECT a.appointment_id, d.first_name AS doctor_first_name, d.last_name AS doctor_last_name, p.first_name AS patient_first_name, p.last_name AS patient_last_name, a.appointment_date, a.appointment_time
                    FROM hms.appointments a
                    INNER JOIN hms.doctors d ON a.doctor_id = d.doctor_id
                    INNER JOIN hms.patients p ON a.patient_id = p.patient_id
                    ORDER BY a.appointment_date, a.appointment_time ASC";
            $result = mysqli_query($conn, $sql);

            // Display appointments in Bootstrap cards format
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $appointment_id = $row['appointment_id'];
                    $card_id = "card-".$appointment_id;
                    echo '<div class="mb-2 card" id="'.$card_id.'">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row["doctor_first_name"] . ' ' . $row["doctor_last_name"] . '</h5>';
                    echo '<h6 class="card-subtitle mb-2 text-muted">' . $row["patient_first_name"] . ' ' . $row["patient_last_name"] . '</h6>';
                    echo '<p class="card-text">' . $row["appointment_date"] . ' at ' . $row["appointment_time"] . '</p>';
                    echo '<form method="POST" action="' . $_SERVER["PHP_SELF"] . '">';
                    echo '<input type="hidden" name="appointment_id" value="' . $row["appointment_id"] . '">';
                    echo '<button type="submit" name="delete" class="btn btn-danger">Delete</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<p class='text-center lead'>No appointments found.</p>";
            }

            // Handle appointment deletion
            if (isset($_POST["delete"])) {
                $appointment_id = $_POST["appointment_id"];
                $card_id = "card-".$appointment_id;
                $sql = "DELETE FROM hms.appointments WHERE appointment_id = $appointment_id";
                if (mysqli_query($conn, $sql)) {
                    echo "<script>$(document).ready(function() { $('.alert-success').removeClass('d-none').text('Appointment deleted successfully.'); });</script>";
                    // Get reference to card element and remove it from the DOM
                    echo '<script>$(document).ready(function() { $("#'.$card_id.'").remove(); });</script>';
                }
                
                 else {
                    echo '<div class="alert alert-danger" role="alert">Error deleting appointment: ' . mysqli_error($conn) . '</div>';
                }
            }

            // Close database connection
            mysqli_close($conn);
        ?>
    </div>
</body>
</html>
