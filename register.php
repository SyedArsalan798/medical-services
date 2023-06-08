<?php
include 'conn.php';
session_start();

if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
  header('Location: home.php');
  exit;
}

// Get the list of cities from the database
$cities_query = "SELECT * FROM cities";
$cities_result = mysqli_query($conn, $cities_query);
$cities = mysqli_fetch_all($cities_result, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the form data
  $email = $_POST['email'];
  $password = $_POST['password'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $address = $_POST['address'];
  $phone = $_POST['phone'];
  $city_id = $_POST['city_id'];

  // Save the data in session
  $_SESSION['email'] = $email;
  $_SESSION['password'] = $password;


  // Check if the email already exists in the database
  $stmt = "SELECT * FROM patients WHERE email = '$email'";
  $result = mysqli_query($conn, $stmt);

  if (mysqli_num_rows($result) > 0) {
    http_response_code(400);
    echo 'Email already exists';
    unset($_SESSION['email']);
    unset($_SESSION['password']);
    exit;
  }

  // Insert the patient registration information into the database
  $stmt = "INSERT INTO patients (first_name, last_name, email, password, address, phone_number, city_id) VALUES ('$first_name', '$last_name', '$email', '$password', '$address', '$phone', '$city_id')";
  mysqli_query($conn, $stmt);

  $query = "SELECT patient_id FROM patients WHERE email = '$email' AND password = '$password'";
  $result1 = mysqli_query($conn, $query);


  $row = mysqli_fetch_assoc($result1);
  $_SESSION['patient_id'] = $row['patient_id'];

  // Close the connection
  mysqli_close($conn);

  header('Location: home.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
  <title>Register</title>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .form-container {
      max-width: 500px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .form-control {
      border-radius: 0;
    }
    .btn-primary {
      border-radius: 0;
    }
    .text-danger {
      color: red;
    }
  </style>
</head>
<body>

  <div class="container mt-4">
    <div class="row">
      <div class="col-md-12">
        <div class="form-container">
          <h2 class="text-center mb-2">Patient Registration</h2>
          <form id="registration-form" method="post" action="">
            <div class="form-group">
              <label for="first_name">First Name:</label>
              <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
              <label for="last_name">Last Name:</label>
              <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
              <label for="address">Address:</label>
              <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label for="phone">Phone Number:</label>
              <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group">
              <label for="city_id">City:</label>
              <select class="form-control" id="city_id" name="city_id" required>
                <option value="">Select a city</option>
                <?php foreach ($cities as $city) { ?>
                  <option value="<?php echo $city['city_id']; ?>"><?php echo $city['city_name']; ?></option>
                <?php } ?>
              </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block mt-2 w-100">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#registration-form').validate({
        rules: {
          first_name: {
            required: true,
            minlength: 2
          },
          last_name: {
            required: true,
            minlength: 2
          },
          email: {
            required: true,
            email: true
          },
          password: {
            required: true,
            minlength: 6
          },
          address: {
            required: true,
            minlength: 10
          },
          phone: {
            required: true,
            minlength: 10
          },
          city_id: {
            required: true
          }
        },
        messages: {
          first_name: {
            required: "Please enter your first name",
            minlength: "Your first name must be at least 2 characters long"
          },
          last_name: {
            required: "Please enter your last name",
            minlength: "Your last name must be at least 2 characters long"
          },
          email: {
            required: "Please enter your email address",
            email: "Please enter a valid email address"
          },
          password: {
            required: "Please enter your password",
            minlength: "Your password must be at least 6 characters long"
          },
          address: {
            required: "Please enter your address",
            minlength: "Your address must be at least 10 characters long"
          },
          phone: {
            required: "Please enter your phone number",
            minlength: "Your phone number must be at least 10 characters long"
          },
          city_id: {
            required: "Please select a city"
          }
        },
        errorClass: 'text-danger', // sets the class for the error message
        errorElement: 'span', // sets the HTML element for the error message
        highlight: function(element, errorClass) {
          $(element).addClass(errorClass); // adds the error class to the element
        },
        unhighlight: function(element, errorClass) {
          $(element).removeClass(errorClass); // removes the error class from the element
        },
        submitHandler: function(form) {
          // Submit the form using AJAX
          $.ajax({
            url: form.action,
            type: form.method,
            data: $(form).serialize(),
            success: function(response) {
              // If the registration is successful, redirect to the home page
              window.location.href = 'home.php';
            },
            error: function(xhr, status, error) {
              // If there is an error, display the error message
              alert(xhr.responseText);
            }
          });
        }
      });
    });
  </script>

  <?php include 'jsFiles.php'; ?>

</body>
</html>
