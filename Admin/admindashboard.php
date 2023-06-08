<?php
  include '../conn.php';

  // Fetch total patients
  $result = mysqli_query($conn, "SELECT COUNT(*) AS total_patients, MAX(last_added) AS last_added FROM hms.patients");
  $row = mysqli_fetch_array($result);
  $total_patients = $row['total_patients'];
  $last_added_patients = date('F j, Y', strtotime($row['last_added']));

  // Fetch total doctors
  $result = mysqli_query($conn, "SELECT COUNT(*) AS total_doctors, MAX(last_added) AS last_added FROM hms.doctors");
  $row = mysqli_fetch_array($result);
  $total_doctors = $row['total_doctors'];
  $last_added_doctors = date('F j, Y', strtotime($row['last_added']));

  // Fetch total cities
  $result = mysqli_query($conn, "SELECT COUNT(*) AS total_cities, MAX(last_added) AS last_added FROM hms.cities");
  $row = mysqli_fetch_array($result);
  $total_cities = $row['total_cities'];
  $last_added_cities = date('F j, Y', strtotime($row['last_added']));
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0-beta3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
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
  </style>
<body>

    <?php include 'navbarAdmin.php'; ?>

    <div class="container py-5">
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Total Patients</h5>
            <p class="big-number"><?php echo $total_patients; ?></p>
            <p class="card-text">Patients</p>
            <p class="last-added">Last added on <?php echo $last_added_patients; ?></p>
            <a href="managePatients.php" class="btn btn-primary rounded-0 w-100">Manage Details</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Total Doctors</h5>
            <p class="big-number"><?php echo $total_doctors; ?></p>
            <p class="card-text">Doctors</p>
            <p class="last-added">Last added on <?php echo $last_added_doctors; ?></p>
            <a href="manageDoctors.php" class="btn btn-primary rounded-0 w-100">Manage Details</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Total Cities</h5>
            <p class="big-number"><?php echo $total_cities; ?></p>
            <p class="card-text">Cities</p>
            <p class="last-added">Last added on <?php echo $last_added_cities; ?></p>
            <a href="manageCities.php" class="btn btn-primary rounded-0 w-100">Manage Details</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include '../jsFiles.php'; ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0-beta3/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>
