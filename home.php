<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Home</title>

</head>
<body>


    <?php include 'navbarPatient.php'; ?>
    <section class="hero">
      <img src="images/health.jpg" class="bg-image h-100">
      <div class="search-form">
        <h1 class="display-6">Hey Welcome!</h1><p class="lead">Now, you can find the Best Healthcare Services Near you</p>
      <form method="get" action="search.php">
      <div class="row gx-1">
        <div class="col-md-5">
          <div class="form-group">
            <select class="form-control form-control-lg rounded-0" style="width: 250px;" id="location" name="location">
              <option value="">Select a location</option>
              <option value="karachi">Karachi</option>
              <option value="lahore">Lahore</option>
              <option value="islamabad">Islamabad</option>
              <option value="quetta">Quetta</option>
              <option value="peshawar">Peshawar</option>
            </select>
          </div>
        </div>
        <div class="col-md-5">
          <div class="form-group">
            <select class="form-control form-control-lg rounded-0" style="width: 250px;" id="specialty" name="specialty">
              <option value="">Select a specialty</option>
              <option value="cardiology">Cardiology</option>
              <option value="dermatology">Dermatology</option>
              <option value="endocrinology">Endocrinology</option>
              <option value="gastroenterology">Gastroenterology</option>
              <option value="neurology">Neurology</option>
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <button class="btn btn-lg btn-primary rounded-0" type="submit">Search</button>
        </div>
      </div>
    </form>
            

      </div>
    </section>

    <?php include 'jsFiles.php'; ?>
</body>
</html>
