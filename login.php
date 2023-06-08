<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <title>Login</title>
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
<?php
include 'conn.php';
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    // If the user is already logged in, redirect to the dashboard page
    header('Location: home.php');
    exit;
  }
  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the form data
  $email = $_POST['email'];
  $password = $_POST['password'];

  $query = "SELECT * FROM patients WHERE email = '$email' AND password = '$password'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    header('Location: home.php');
    exit;
  } else {
    // If the user does not exist, display an error message
    unset($_SESSION['email'] );
    unset($_SESSION['password'] );
    echo "<script>alert('Invalid email or password. Please try again.')</script>";
  }
}
?>

<div class="container mt-4">
    <div class="row">
      <div class="col-md-12">
        <div class="form-container">
          <h2 class="text-center mb-2">Login</h2>
            <form id="login_form" method="post" action="">
              <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" id="email" name="email" required>
              </div>

              <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block mt-2 w-100">Login</button>
            </form>
        </div>
      </div>
    </div>
  </div>

<script>
    $(document).ready(function() {
      $('#login_form').validate({
        rules: {
          email: {
            required: true,
            email: true
          },
          password: {
            required: true,
            minlength: 6
          }
        },
        messages: {
          email: {
            required: "Please enter your email address",
            email: "Please enter a valid email address"
          },
          password: {
            required: "Please enter your password",
            minlength: "Your password must be at least 6 characters long"
          }

        },
        errorClass: 'text-danger', // sets the class for the error message
        errorElement: 'span', // sets the HTML element for the error message
        highlight: function(element, errorClass) {
            $(element).addClass(errorClass); // adds the error class to the element
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass); // removes the error class from the element
        }
      });
    });
  </script>
    <?php include 'jsFiles.php'; ?>

</body>
</html>
