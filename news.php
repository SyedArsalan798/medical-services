<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <title>Medical News</title>
</head>
<body>
    <?php include 'conn.php'; ?>
    <?php include 'navbarPatient.php'; ?>

    <div class="container mt-4">
        <div class="display-6 text-center mb-3">Medical News</div>
        <div class="row">
            <?php

                // Select the latest medical news from the database
                $sql = "SELECT * FROM medical_news ORDER BY date DESC LIMIT 3";
                $result = mysqli_query($conn, $sql);

                // Loop through the results and display them as cards
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    echo '<img class="card-img-top" src="' . $row['image'] . '" alt="' . $row['title'] . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['title'] . '</h5>';
                    echo '<p class="card-text">' . $row['description'] . '</p>';
                    echo '<a href="' . $row['link'] . '" class="btn btn-primary rounded-0 w-100">Read More</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }

                // Close the database connection
                mysqli_close($conn);
            ?>
        </div>
    </div>

    <?php include 'jsFiles.php'; ?>

</body>
</html>
