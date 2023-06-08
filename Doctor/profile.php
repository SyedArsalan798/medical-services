<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Profile</title>
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
    .availability-list {
      list-style: none;
      margin: 0;
      padding: 0;
    }
    .availability-list li i {
      margin-right: 0.5rem;
      color: #007bff;
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
    .button-group{
      display: flex;
      justify-content: flex-end;
    }
    .button-group button {
      margin-left: 1rem;
    }
  </style>
</head>
<body>

  <?php include 'navbarDoctor.php'; 
    session_start();
    include '../conn.php';

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
      $query2 = "SELECT * FROM doctors inner join cities on cities.city_id = doctors.city_id WHERE doctor_id = '$doctor_id'";
      $result2 = mysqli_query($conn, $query2);
      $row = mysqli_fetch_assoc($result2);
  ?>
  <div class="container py-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title" id="doctorFirstLast">Dr. <?php echo $row['first_name'].' '.$row['last_name'] ; ?></h5>
            <p class="card-text" id="doctorEmail">Email: <?php echo $row['email']; ?></p>
            <p class="card-text" id="doctorPassword">Password: <?php echo $row['password']; ?></p>
            <p class="card-text">Phone Number: <?php echo $row['phone_number']; ?></p>
            <p class="card-text" id="doctorAddress">Address: <?php echo $row['address']; ?></p>
            <p class="card-text" id="doctorSpecialty">Specialty: <?php echo $row['specialty']; ?></p>
            <p class="card-text" id="doctorCity">City: <?php echo $row['city_name']; ?></p>
            <p class="card-text">Availability: <?php echo $row['availability']; ?></p>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editDoctorModal">Edit Profile</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Doctor Modal -->
  <div class="modal fade" id="editDoctorModal" tabindex="-1" aria-labelledby="editDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editDoctorModalLabel">Edit Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="firstName" class="form-label">First Name</label>
              <input type="text" class="form-control" id="firstName" value="<?php echo $row['first_name']?>" required>
            </div>
            <div class="mb-3">
              <label for="lastName" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="lastName" value="<?php echo $row['last_name']?>" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" value="<?php echo $row['email']?>" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" value="<?php echo $row['password']?>" required>
            </div>
            <div class="mb-3">
              <label for="phoneNumber" class="form-label">Phone Number</label>
              <input type="tel" class="form-control" id="phoneNumber" value="<?php echo $row['phone_number']?>" required>
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" value="<?php echo $row['address']?>" required>
            </div>
            <div class="mb-3">
              <label for="city_id" class="form-label">City</label>
              <select class="form-control" id="city" required>
              <?php echo '<option value="'.$row['city_id'].'">'.$row['city_name'].'</option>';?>
                <?php
                  $sql = "SELECT * FROM cities";
                  $result = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result) > 0) {
                      while($roww = mysqli_fetch_assoc($result)) {?>
                          <option value="<?php echo $roww['city_id']; ?>"><?php echo $roww['city_name']; ?></option>
                      <?php }
                  }
                  ?>

              </select>
            </div>
            <div class="mb-3">
              <label for="specialty" class="form-label">Specialty</label>
              <input type="text" class="form-control" id="specialty" value="<?php echo $row['specialty']?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="update_changes">Save Changes</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
$(document).ready(function(){
  $('#editDoctorModal form').submit(function(event){
    event.preventDefault(); // prevent the form from submitting normally
    
    // get the form data
    var formData = {
      'doctor_id': <?php echo $row['doctor_id']; ?>,
      'firstName': $('#firstName').val(),
      'lastName': $('#lastName').val(),
      'email': $('#email').val(),
      'password': $('#password').val(),
      'phoneNumber': $('#phoneNumber').val(),
      'address': $('#address').val(),
      'city_id': $('#city').val(),
      'specialty': $('#specialty').val()
    };
    
    // send the AJAX request
    $.ajax({
      type: 'POST',
      url: 'update_doctor_profile.php',
      data: formData,
      dataType: 'json',
      encode: true
    })
    .done(function(response){
      if (response.success) {
        // update the doctor profile on the page
        $('#doctorFirstLast').text('Dr. '+formData.firstName+' '+formData.lastName);
        $('#doctorEmail').text('Email: '+formData.email);
        $('#doctorPassword').text('Password: '+formData.password);
        $('#doctorPhoneNumber').text('Phone Number: '+formData.phoneNumber);
        $('#doctorAddress').text('Address: '+formData.address);
        $('#doctorCity').text('City: '+$('#city option:selected').text());
        $('#doctorSpecialty').text('Specialty: '+formData.specialty);
        alert('Updated successfully.');
        $('#editDoctorModal').modal('hide');
      } else {
        alert('Error while updaing profile');
      }
    });
  });
});
</script>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0-beta3/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>
