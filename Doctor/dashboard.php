<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Dashboard</title>
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
    .table {
      font-size: 1rem;
    }
    .table th {
      border-top: none;
    }
    .table td {
      font-size: 1rem;
      border-top: none;
    }
    .table .btn {
      font-size: 1rem;
      padding: 0.5rem 1rem;
    }
    .availability-list {
      list-style: none;
      margin: 0;
      padding: 0;
    }
    .availability-list li {
      font-size: 1rem;
      margin-bottom: 0.5rem;
      padding: 0.5rem;
      background-color: #fff;
    }
    .availability-list li i {
      margin-right: 0.5rem;
      color: #007bff;
    }
  </style>
</head>
<body>

    <?php include 'navbarDoctor.php'; 
    session_start();
    
    include '../conn.php';

    if(!(isset($_SESSION['demail'])) && !(isset($_SESSION['dpassword']))){
      header("Location: dlogin.php");
      exit;
    }

    $demail = $_SESSION['demail'];
    $dpassword = $_SESSION['dpassword'];

    $query1 = "SELECT doctor_id FROM doctors WHERE email = '$demail' AND password = '$dpassword'";
    $result1 = mysqli_query($conn, $query1);

    $doctor_id = NULL;

    if (mysqli_num_rows($result1) == 1){
      $row = mysqli_fetch_assoc($result1);
      $doctor_id = $row['doctor_id'];
    }
    
    ?>
      <?php
      $query2 = "SELECT * FROM doctors WHERE doctor_id = '$doctor_id'";
      $result2 = mysqli_query($conn, $query2);
      $row = mysqli_fetch_assoc($result2);
  ?>

<div class="container py-5">
    <p><b>You are:</b> <?php echo $row['availability']; ?></p>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Profile Details</h5>
                    <p class="card-text">Name: <?php echo $row['first_name'].' '.$row['last_name'] ; ?></p>
                    <p class="card-text">Specialty: <?php echo $row['specialty']; ?></p>
                    <p class="card-text">Email: <?php echo $row['email']; ?></p>
                    <p class="card-text">Phone: <?php echo $row['phone_number']; ?></p>
                    <a href="profile.php" class="btn btn-primary rounded-0 w-100">Edit Profile</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Appointments</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Patient Name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query = "SELECT appointments.appointment_date, appointments.appointment_time, patients.first_name as fn, patients.last_name as ln
                                        FROM appointments
                                        JOIN patients ON appointments.patient_id = patients.patient_id
                                        JOIN doctors ON appointments.doctor_id = doctors.doctor_id
                                        WHERE doctors.doctor_id = '$doctor_id'";

                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                  <!-- here patient name and doctor names are same as hamza khan -->
                                    <td><?php echo date("M d, Y", strtotime($row['appointment_date'])); ?></td>
                                    <td><?php echo date("h:ia", strtotime($row['appointment_time'])); ?></td>
                                    <td><?php echo $row['fn']. ' '.$row['ln']; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- php -->
<?php
  if(isset($_POST['add_availability'])) 
{

  $date = date('Y-m-d', strtotime($_POST['date'])); 
  $start_time = date('H:i:s', strtotime($_POST['start_time'])); 
  $end_time = date('H:i:s', strtotime($_POST['end_time']));
  $query = "INSERT INTO doctor_availability (doctor_id, date, start_time, end_time) VALUES ('$doctor_id', '$date', '$start_time', '$end_time')"; 
  $result = mysqli_query($conn, $query);
  if($result)
  {
    echo "<script>
    $(document).ready(function() {
      $('.loo').prepend('<div class=\'alert alert-success\' role=\'alert\'>Availability added successfully.</div>');
      setTimeout(function() {
        $('.alert-success').fadeOut('slow', function() {
          $(this).remove();
        });
      }, 5000);
    });
    </script>";
  }
  else
  {
    echo 'Error while adding';
  }
}
?>
<?php
    if(isset($_POST['update_availability'])) {
      $availability_id = $_POST['availability_id'];
      $doctor_id = $_POST['doctor_id'];
      $date = $_POST['edit_date'];
      $start_time = $_POST['edit_start_time'];
      $end_time = $_POST['edit_end_time'];
    
      $query = "UPDATE doctor_availability SET date='$date', start_time='$start_time', end_time='$end_time' WHERE availability_id='$availability_id' AND doctor_id='$doctor_id'";
      $result = mysqli_query($conn, $query);
    
      if($result) {
        echo "<script>
        $(document).ready(function() {
          $('.loo').prepend('<div class=\'alert alert-success\' role=\'alert\'>Availability Updated successfully.</div>');
          setTimeout(function() {
            $('.alert-success').fadeOut('slow', function() {
              $(this).remove();
            });
          }, 5000);
        });
        </script>";
      } else {
        echo "Error updating availability: " . mysqli_error($conn);
      }
    }

    
?>
<div class="container py-5">
  <h1 class="text-center mb-3 display-6">Availability</h1>
  <div class="row">
    <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Add Availability</h5>
        <form method="POST" id="add-availability-form">
          <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
          </div>
          <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="time" class="form-control" id="start_time" name="start_time" required>
          </div>
          <div class="mb-3">
            <label for="end_time" class="form-label">End Time</label>
            <input type="time" class="form-control" id="end_time" name="end_time" required>
          </div>
          <button type="submit" class="btn btn-primary rounded-0 w-100" name="add_availability">Add</button>
        </form>
      </div>
    </div>
    </div>
    <div class="col-md-8">
      <div class="card">
        <div class="loo card-body">
          <h5 class="card-title">Availability Calendar</h5>
          <p class="card-text">You are available on the following dates:</p>
          <ul class="availability-list">
          <?php
            $query = "SELECT * FROM doctor_availability WHERE doctor_id = '$doctor_id'";
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result) > 0) {
              $previous_end_time = null;
              while ($row = mysqli_fetch_assoc($result)) {
                $date = date("M j, Y", strtotime($row['date']));
                $start_time = date("g:ia", strtotime($row['start_time']));
                $end_time = date("g:ia", strtotime($row['end_time']));
                $availability_id = $row['availability_id'];

                if($previous_end_time != null && $previous_end_time != $start_time) {
                  echo "<li style='margin-top: -40px;'></li>";
                }

                echo "<li><i class='fas fa-calendar-alt'></i> $date - $start_time to $end_time
                      <form method='POST' style='display: inline-block;' class='delete-availability-form'>
                        <input type='hidden' name='availability_id' value='$availability_id'>
                        <input type='hidden' name='doctor_id' value='$doctor_id'>
                        <button type='submit' class='btn btn-link text-danger' name='delete_availability'><i class='fas fa-trash'></i></button>
                      </form>
                      <button type='button' class='btn btn-link text-primary' data-toggle='modal' data-target='#editAvailabilityModal$availability_id'><i class='fas fa-edit'></i></button>
                      </li>";

                // Create a modal for the edit availability form
                echo "<div class='modal fade' id='editAvailabilityModal$availability_id' tabindex='-1' role='dialog' aria-labelledby='editAvailabilityModalLabel$availability_id' aria-hidden='true'>
                        <div class='modal-dialog' role='document'>
                          <div class='modal-content'>
                            <div class='modal-header'>
                              <h5 class='modal-title' id='editAvailabilityModalLabel$availability_id'>Edit Availability</h5>
                              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                              </button>
                            </div>
                            <div class='modal-body'>
                              <form method='POST'>
                                <div class='form-group'>
                                  <label for='edit_date'>Date</label>
                                  <input type='date' class='form-control' id='edit_date' name='edit_date' value='$row[date]' required>
                                </div>
                                <div class='form-group'>
                                  <label for='edit_start_time'>Start Time</label>
                                  <input type='time' class='form-control' id='edit_start_time' name='edit_start_time' value='$row[start_time]' required>
                                </div>
                                <div class='form-group'>
                                  <label for='edit_end_time'>End Time</label>
                                  <input type='time' class='form-control' id='edit_end_time' name='edit_end_time' value='$row[end_time]' required>
                                </div>
                                <input type='hidden' name='availability_id' value='$availability_id'>
                                <input type='hidden' name='doctor_id' value='$doctor_id'>
                                <a href='#availability-card'><button type='submit' class='btn btn-primary' name='update_availability'>Save changes</button></a>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>";

                $previous_end_time = $end_time;
              }
            } else {
              echo "<b>You have no availability scheduled.</b>";
            }
            ?>

          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<a id="availability-card"></a>

<script>
  window.onload = function() {
    var anchor = document.getElementById("availability-card");
    if(anchor) {
      anchor.scrollIntoView({ behavior: 'smooth' });
    }
  }
</script>

<script>
$(document).ready(function() {
  $('.delete-availability-form').submit(function(event) {
    event.preventDefault();
    var form = $(this);
    var availability_id = form.find('input[name="availability_id"]').val();
    var doctor_id = <?php echo $doctor_id; ?>;
    $.ajax({
      url: 'availability_ajax.php',
      type: 'POST',
      data: {delete_availability: true, availability_id: availability_id, doctor_id:doctor_id},
      cache: false,
      success: function(response) {
        form.closest('li').remove();
      }
    });
  });
});
</script>



  <?php include '../jsFiles.php'; ?>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0-beta3/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>
