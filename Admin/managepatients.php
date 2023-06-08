<?php
  // Include database connection
  include '../conn.php';

  // Handle delete patient request
  if(isset($_GET['deletePatient'])) {
    $patientId = $_GET['deletePatient'];
    mysqli_query($conn, "DELETE FROM hms.patients WHERE patient_id=$patientId");
    header('location: managePatients.php');
    exit();
  }

  // Handle edit patient request
  if(isset($_POST['editPatient'])) {
    $patientId = $_POST['patientId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $address = $_POST['address'];
    $cityId = $_POST['cityId'];

    mysqli_query($conn, "UPDATE hms.patients SET first_name='$firstName', last_name='$lastName', email='$email', phone_number='$phoneNumber', address='$address', city_id=$cityId WHERE patient_id=$patientId");
    header('location: managepatients.php');
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Patients</title>
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
      font-size: 1.25;
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
    .button-group {
      display: flex;
      justify-content: flex-end;
    }
    .button-group button {
      margin-left: 1rem;
    }
  </style>
</head>
<body>

  <?php include 'navbarAdmin.php'; ?>

  <div class="container py-5">
    <div class="row">
      <div class="col-md-12">
        <h1 class="mb-4 display-6 text-center">Manage Patients</h1>
      </div>
    </div>
    <table class="table">
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Phone Number</th>
      <th>Address</th>
      <th>City</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
      // Fetch patients from database
      $result = mysqli_query($conn, "SELECT * FROM hms.patients INNER JOIN hms.cities ON patients.city_id=cities.city_id where 1=1");
      while($row = mysqli_fetch_assoc($result)) {
        echo '<tr>
                <td>'.$row['first_name'].' '.$row['last_name'].'</td>
                <td>'.$row['email'].'</td>
                <td>'.$row['phone_number'].'</td>
                <td>'.$row['address'].'</td>
                <td>'.$row['city_name'].'</td>
                <td>
                  <div class="button-group">
                    <button class="btn btn-primary rounded-0 w-50 me-1" data-bs-toggle="modal" data-bs-target="#editPatientModal'.$row['patient_id'].'">Edit</button>
                    <a href="?deletePatient='.$row['patient_id'].'" class="btn btn-danger rounded-0 w-50 ms-1">Delete</a>
                  </div>
                </td>
              </tr>';
      }
    ?>
  </tbody>
</table>

<?php
  // Create Edit Patient Modals
  $result = mysqli_query($conn, "SELECT * FROM hms.patients INNER JOIN hms.cities ON patients.city_id=cities.city_id where 1=1");
  while($row = mysqli_fetch_assoc($result)) {
    echo '<div class="modal fade" id="editPatientModal'.$row['patient_id'].'" tabindex="-1" aria-labelledby="editPatientModalLabel'.$row['patient_id'].'" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editPatientModalLabel'.$row['patient_id'].'">Edit Patient</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post">
            <input type="hidden" name="patientId" value="'.$row['patient_id'].'">
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
              <label for="phoneNumber" class="form-label">Phone Number</label>
              <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" value="'.$row['phone_number'].'" required>
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" name="address" value="'.$row['address'].'" required>
            </div>
            <div class="mb-3">
              <label for="city" class="form-label">City</label>
              <select class="form-control" id="city" name="cityId" required>
                <option value="'.$row['city_id'].'">'.$row['city_name'].'</option>';
                // Fetch cities from database
                $result = mysqli_query($conn, "SELECT * FROM hms.cities");
                while($cityRow = mysqli_fetch_array($result)) {
                  echo "<option value=\"".$cityRow['city_id']."\">".$cityRow['city_name']."</option>";
                }
              echo '</select>
            </div>
            <button type="submit" class="btn btn-primary" name="editPatient">Save Changes</button>
          </form>
        </div>
      </div>
    </div>
  </div>';

              }

            ?>
          </tbody>
        </table>
      </div>

  <?php include '../jsFiles.php'; ?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0-beta3/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>



