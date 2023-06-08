<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
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
include "../conn.php";
session_start();
if (isset($_SESSION['demail']) && isset($_SESSION['dpassword'])) {
  header('Location: dashboard.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['demail'];
  $password = $_POST['dpassword'];

  $query = "SELECT * FROM doctors WHERE email = '$email' AND password = '$password'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['demail'] = $email;
    $_SESSION['dpassword'] = $password;
    header('Location: dashboard.php');
    exit;
  } else {
    unset($_SESSION['demail'] );
    unset($_SESSION['dpassword']);
    // If the user does not exist, display an error message
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
                <input type="email" class="form-control" id="demail" name="demail" required>
              </div>

              <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="dpassword" name="dpassword" required>
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
          demail: {
            required: true,
            email: true
          },
          dpassword: {
            required: true,
            minlength: 6
          }
        },
        messages: {
          demail: {
            required: "Please enter your email address",
            email: "Please enter a valid email address"
          },
          dpassword: {
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
    <?php include '../jsFiles.php'; ?>

</body>
</html>
