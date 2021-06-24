<!DOCTYPE html>
<?php
// connect to database
$conn = mysqli_connect('localhost', 'root', '', 'ntm');
session_start();
?>
<?php
if($_SESSION["login"]){
if (isset($_POST['save'])) {
  $cusname = $_REQUEST['cusname'];
  $loc = $_REQUEST['loc'];
  $sql = "INSERT INTO CUSTOMER  values  ('$cusname','$loc')";
  if (mysqli_query($conn, $sql)) {
    echo "Customer added successfully<br>";
  }
  else{
      echo mysqli_error($conn);
  }
}}
?>
<html>

<head>
  <title>Customer Entry Form</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <center>
    <center>
      <form action="customer.php" method="post" enctype="multipart/form-data">
        <h3>Add customer</h3><br><br>
        <div>
          Enter Customer Name: <input type="text" name="cusname"  required><br><br>
          Enter Location <input type="text" name="loc" required>
        </div><br>
        <button type="submit" class="btn btn-danger ml-3" name="save">Add Customer</button><br><br>
      </form>
      <a href="billing.php">DISPLAY</a>
    </center>

</body>

</html>