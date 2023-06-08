<?php
// Include database connection file
include "../conn.php";

// Add city to database
if(isset($_POST['addCity'])) {
  $cityName = $_POST['cityName'];
  $stateName = $_POST['stateName'];
  $countryName = $_POST['countryName'];

  // Insert city into cities table
  $result = mysqli_query($conn, "INSERT INTO hms.cities(city_name, state, country) VALUES('$cityName', '$stateName', '$countryName')");

  // Redirect to current page after adding city
  header("Location: ".$_SERVER['PHP_SELF']);
  exit();
}

// Delete city from database
if(isset($_GET['deleteCity'])) {
  $cityId = $_GET['deleteCity'];

  // Delete city from cities table
  $result = mysqli_query($conn, "DELETE FROM hms.cities WHERE city_id=$cityId");

  // Redirect to current page after deleting city
  header("Location: ".$_SERVER['PHP_SELF']);
  exit();
}

// Edit city in database
if(isset($_POST['editCity'])) {
  $cityId = $_POST['cityId'];
  $cityName = $_POST['cityName'];
  $stateName = $_POST['stateName'];
  $countryName = $_POST['countryName'];

  // Update city in cities table
  $result = mysqli_query($conn, "UPDATE hms.cities SET city_name='$cityName', state='$stateName', country='$countryName' WHERE city_id=$cityId");

  // Redirect to current page after editing city
  header("Location: ".$_SERVER['PHP_SELF']);
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Cities</title>
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
        <button class="btn btn-primary add-button rounded-0" data-bs-toggle="modal" data-bs-target="#addCityModal">+ Add City</button>
      </div>
    </div>
    <div class="row">
      <?php
      // Fetch cities from database
      $result = mysqli_query($conn, "SELECT * FROM hms.cities");
      while($row = mysqli_fetch_array($result)) {
        echo '<div class="col-md-4">
                <div class="card mb-3">
                  <div class="card-body">
                    <h5 class="card-title">'.$row['city_name'].'</h5>
                    <p class="card-text">State: '.$row['state'].'</p>
                    <p class="card-text">Country: '.$row['country'].'</p>
                    <div class="d-flex justify-content-between">
                      <a href="?deleteCity='.$row['city_id'].'" class="btn btn-danger rounded-0 w-50 me-1">Delete</a>
                      <button class="btn btn-primary rounded-0 w-50 ms-1" data-bs-toggle="modal" data-bs-target="#editCityModal'.$row['city_id'].'">Edit</button>
                    </div>
                  </div>
                </div>
              </div>';

        // Edit City Modal
        echo '<div class="modal fade" id="editCityModal'.$row['city_id'].'" tabindex="-1" aria-labelledby="editCityModalLabel'.$row['city_id'].'" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editCityModalLabel'.$row['city_id'].'">Edit City</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="post">
                        <input type="hidden" name="cityId" value="'.$row['city_id'].'">
                        <div class="mb-3">
                          <label for="cityName" class="form-label">City Name</label>
                          <input type="text" class="form-control" id="cityName" name="cityName" value="'.$row['city_name'].'" required>
                        </div>
                        <div class="mb-3">
                          <label for="stateName" class="form-label">State Name</label>
                          <input type="text" class="form-control" id="stateName" name="stateName" value="'.$row['state'].'" required>
                        </div>
                        <div class="mb-3">
                          <label for="countryName" class="form-label">Country Name</label>
                          <input type="text" class="form-control" id="countryName" name="countryName" value="'.$row['country'].'" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="editCity">Save Changes</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>';
      }
      ?>
    </div>
  </div>

  <!-- Add City Modal -->
  <div class="modal fade" id="addCityModal" tabindex="-1" aria-labelledby="addCityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addCityModalLabel">Add City</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post">
            <div class="mb-3">
              <label for="cityName" class="form-label">City Name</label>
              <input type="text" class="form-control" id="cityName" name="cityName" required>
            </div>
            <div class="mb-3">
              <label for="stateName" class="form-label">State Name</label>
              <input type="text" class="form-control" id="stateName" name="stateName" required>
            </div>
            <div class="mb-3">
              <label for="countryName" class="form-label">Country Name</label>
              <input type="text" class="form-control" id="countryName" name="countryName" required>
            </div>
            <button type="submit" class="btn btn-primary" name="addCity">Add City</button>
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
