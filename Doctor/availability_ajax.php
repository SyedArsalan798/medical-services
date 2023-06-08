<?php
  include '../conn.php';

if(isset($_POST['delete_availability'])) 
{
  $availability_id = $_POST['availability_id'];
  $doctor_id = $_POST['doctor_id'];
  $query = "DELETE FROM doctor_availability WHERE availability_id = '$availability_id' AND doctor_id = '$doctor_id'";
  echo '<script>console.log($query);</script>';
  $result = mysqli_query($conn, $query); 
  if($result)
  {
    echo 'success';
  }
  else
  {
    echo 'Error';
  }
  mysqli_close($conn);
}

?>