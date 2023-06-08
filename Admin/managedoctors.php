<?php
  session_start();
// Include database connection file
include "../conn.php";

// Add doctor to database
if(isset($_POST['addDoctor'])) {
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $phoneNumber = $_POST['phoneNumber'];
  $address = $_POST['address'];
  $specialty = $_POST['specialty'];
  $cityId = $_POST['cityId'];
  $availability = $_POST['availability'];
  $_SESSION['demail'] =$email;
  $_SESSION['dpassword'] = $password;

  // Insert doctor into doctors table
  $result = mysqli_query($conn, "INSERT INTO hms.doctors(first_name, last_name, email,password, phone_number, address, specialty, city_id, availability) VALUES('$firstName', '$lastName', '$email', $password, '$phoneNumber', '$address', '$specialty', $cityId, '$availability')");
  
  // Redirect to current page after adding doctor
  header("Location: ".$_SERVER['PHP_SELF']);
  exit();
  mysqli_close();
}
include "../conn.php";
// Delete doctor from database
if(isset($_GET['deleteDoctor'])) {
  $doctorId = $_GET['deleteDoctor'];

  // Delete doctor from doctors table
  $result = mysqli_query($conn, "DELETE FROM hms.doctors WHERE doctor_id=$doctorId");

  // Redirect to current page after deleting doctor
  header("Location: ".$_SERVER['PHP_SELF']);
  exit();
  mysqli_close();
}
include "../conn.php";
// Edit doctor in database
if(isset($_POST['editDoctor'])) {
  $doctorId = $_POST['doctorId'];
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $phoneNumber = $_POST['phoneNumber'];
  $address = $_POST['address'];
  $specialty = $_POST['specialty'];
  $cityId = $_POST['cityId'];
  $availability = $_POST['availability'];

  // Update doctor in doctors table
  $result = mysqli_query($conn, "UPDATE hms.doctors SET first_name='$firstName', last_name='$lastName', email='$email', password='$password', phone_number='$phoneNumber', address='$address', specialty='$specialty', city_id=$cityId, availability='$availability' WHERE doctor_id=$doctorId");


  // Redirect to current page after editing doctor
  header("Location: ".$_SERVER['PHP_SELF']);
  exit();
  mysqli_close();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Doctors</title>
  <link rel="stylesheet" href="../css/style.css">
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

  <div class="container py-5">
    <div class="row">
      <div class="col-md-12">
        <button class="btn btn-primary add-button rounded-0" data-bs-toggle="modal" data-bs-target="#addDoctorModal">+ Add Doctor</button>
      </div>
    </div>
    <div class="row">
    <?php
      // Fetch doctors from database
      $result = mysqli_query($conn, "SELECT * FROM hms.doctors INNER JOIN hms.cities ON doctors.city_id = cities.city_id");
      while($row = mysqli_fetch_array($result)) {
        echo '<div class="col-md-4">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">'.$row['first_name'].' '.$row['last_name'].'</h5>
                    <p class="card-text">Specialty: '.$row['specialty'].'</p>
                    <p class="card-text">City: '.$row['city_name'].'</p>
                    <div class="d-flex justify-content-between">
                      <a href="?deleteDoctor='.$row['doctor_id'].'" class="btn btn-danger rounded-0 w-50 me-1">Delete</a>
                      <button class="btn btn-primary rounded-0 w-50 ms-1" data-bs-toggle="modal" data-bs-target="#editDoctorModal'.$row['doctor_id'].'">Edit</button>
                    </div>
                  </div>
                </div>
              </div>';

        // Edit Doctor Modal
        echo '<div class="modal fade" id="editDoctorModal'.$row['doctor_id'].'" tabindex="-1" aria-labelledby="editDoctorModalLabel'.$row['doctor_id'].'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editDoctorModalLabel'.$row['doctor_id'].'">Edit Doctor</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="post">
                        <input type="hidden" name="doctorId" value="'.$row['doctor_id'].'">
                        <div class="mb-3">
                          <label for="firstName" class="form-label">First Name</label>
                          <input type="text" class="form-control" id="firstName" name="firstName" value="'.$row['first_name'].'" required>
                        </div>
                        <div class="mb-3">
                          <label for="lastName" class="form-label">Last Name</label>
                          <input type="text" class="form-control" id="lastName" name="lastName" value="'.$row['last_name'].'" required>
                        </div>
                        <div class="mb-3">
                          <label for="email" class="form-label">Email</label>
                          <input type="email" class="form-control" id="email" name="email" value="'.$row['email'].'" required>
                        </div>
                        <div class="mb-3">
                          <label for="password" class="form-label">Password</label>
                          <input type="password" class="form-control" id="password" name="password" value="'.$row['password'].'" required>
                        </div>
                        <div class="mb-3">
                          <label for="phoneNumber" class="form-label">Phone Number</label>
                          <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" value="'.$row['phone_number'].'" required>
                        </div>
                        <div class="mb-3">
                          <label for="address" class="form-label">Address</label>
                          <input type="text" class="form-control" id="address" name="address" value="'.$row['address'].'" required>
                        </div>
                        <div class="mb-3">
                          <label for="specialty" class="form-label">Specialty</label>
                          <input type="text" class="form-control" id="specialty" name="specialty" value="'.$row['specialty'].'" required>
                        </div>
                        <div class="mb-3">
                          <label for="city" class="form-label">City</label>
                          <select class="form-control" id="city" name="cityId" required>
                            <option value="'.$row['city_id'].'">'.$row['city_name'].'</option>';
                            // Fetch cities from database
                            $cityResult = mysqli_query($conn, "SELECT * FROM hms.cities");
                            while($cityRow = mysqli_fetch_array($cityResult)) {
                              echo '<option value="'.$cityRow['city_id'].'">'.$cityRow['city_name'].'</option>';
                            }
        echo '            </select>
                        </div>
                        <div class="mb-3">
                          <label for="availability" class="form-label">Availability</label>
                          <select class="form-control" id="availability" name="availability" required>
                            <option value="'.$row['availability'].'">'.$row['availability'].'</option>
                            <option value="Available">Available</option>
                            <option value="Unavailable">Unavailable</option>
                          </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="editDoctor">Save Changes</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>';
      }
      ?>
    </div>
  </div>

  <!-- Add Doctor Modal -->
  <div class="modal fade" id="addDoctorModal" tabindex="-1" aria-labelledby="addDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addDoctorModalLabel">Add Doctor</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post">
            <div class="mb-3">
              <label for="firstName" class="form-label">First Name</label>
              <input type="text" class="form-control" id="firstName" name="firstName" required>
            </div>
            <div class="mb-3">
              <label for="lastName" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="lastName" name="lastName" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
              <label for="phoneNumber" class="form-label">Phone Number</label>
              <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" required>
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="mb-3">
              <label for="specialty" class="form-label">Specialty</label>
              <input type="text" class="form-control" id="specialty" name="specialty" required>
            </div>
            <div class="mb-3">
              <label for="city" class="form-label">City</label>
              <select class="form-control" id="city" name="cityId" required>
                <option value="">Select a city</option>
                <?php
                // Fetch cities from database
                $result = mysqli_query($conn, "SELECT * FROM hms.cities");
                while($row = mysqli_fetch_array($result)) {
                  echo "<option value=\"".$row['city_id']."\">".$row['city_name']."</option>";
                }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="availability" class="form-label">Availability</label>
              <select class="form-control" id="availability" name="availability" required>
                <option value="">Select availability</option>
                <option value="Available">Available</option>
                <option value="Unavailable">Unavailable</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary" name="addDoctor">Add Doctor</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php include '../jsFiles.php'; ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0-beta3/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>
