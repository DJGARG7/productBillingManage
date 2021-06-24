<!DOCTYPE html>
<?php
// connect to database
$conn = mysqli_connect('localhost', 'root', '', 'ntm');
session_start();
?>
<?php
if ($_SESSION["login"]) {
  if (isset($_POST['save'])) {
    $uid = $_REQUEST['uid'];
    $jwn = $_REQUEST['jwn'];
    $jln = $_REQUEST['jln'];
    $jdn = $_REQUEST['jdn'];
    $dname = $_REQUEST['dname'];
    $ctype = $_REQUEST['ctype'];
    $bcost = $_REQUEST['bcost'];
    $wcost = $_REQUEST['wcost'];
    $lcost = $_REQUEST['lcost'];
    $dcost = $_REQUEST['dcost'];
    $pcost = $_REQUEST['pcost'];
    $mu = $_REQUEST['mu'];
    $sql = "INSERT INTO DESIGN (DN_NO,NAME,CLOTH_TYPE,BASIC_COST,WORK_COST,LACE_COST,DIAMOND_COST,PACKING_COST,MU,WORK_JOB,LACE_JOB,DIAM_JOB) values
        ('$uid','$dname','$ctype','$bcost','$wcost','$lcost','$dcost','$pcost','$mu','$jwn','$jln','$jdn')";
    if (mysqli_query($conn, $sql)) {
      echo "Design uploaded successfully<br>";
    }

    $cal = ($bcost + $wcost + $lcost + $dcost + $pcost) * 100 / (100 - $mu);
    echo " Price before MU " . round($bcost + $wcost + $lcost + $dcost + $pcost);
    echo "<br><br>Price with MU " . round($cal);
  }
}
?>
<html>

<head>
  <title>Design Registration Form</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <center>
    <center>
      <form action="Register.php" method="post" enctype="multipart/form-data">
        <h3>Insert Design</h3><br><br>
        <div>
          Enter DesignNo: <input type="number" name="uid" id="uid" required>
          Enter DesignName: <input type="text" name="dname" id="dname" required>
          Enter ClothType: <input type="text" name="ctype" id="ctype" required>
        </div><br>
        <div>
          Enter BasicCost: <input type="number" name="bcost" id="bcost" required><br><br>
          Enter WorkCost: <input type="number" name="wcost" id="wcost" required>
          Enter JOB WORK Name: <input type="text" name="jwn" id="jwn" required><br><br>
          Enter LaceCost: <input type="number" name="lcost" id="lcost" required>
          Enter JOB LACE Name: <input type="text" name="jln" id="jln" required><br><br>
        </div><br>
        <div>
          Enter DiamondCost: <input type="number" name="dcost" id="dcost" required>
          Enter JOB DIAMAND Name: <input type="text" name="jdn" id="jdn" required><br><br>
          Enter PackingCost: <input type="number" name="pcost" id="pcost" required>
          Enter MU: <input type="number" name="mu" id="mu" required>
        </div><br>
        <button type="submit" class="btn btn-danger ml-3" name="save">Add Deisgn</button>
      </form>
      <a href="billdisplay.php">DISPLAY</a>
    </center>

</body>

</html>