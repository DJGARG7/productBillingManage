<!DOCTYPE html>
<?php
$conn = mysqli_connect('localhost', 'root', '', 'ntm');
session_start();
?>
<<html>

<head>
    <title>Design Details</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <center>
        <center>
            <h3>DISPLAY PAGE</h3><br>
            <?php
            if ($_SESSION["login"]) {
                if (isset($_POST['save1'])) {

                    $uid = $_REQUEST['uid'];
                    $ctype = $_REQUEST['ctype'];

                    $sql = "SELECT * FROM DESIGN WHERE NAME='$uid' and CLOTH_TYPE='$ctype'";
                    if ($result = mysqli_query($conn, $sql)) {
                        $row = $result->fetch_assoc();
                        echo "<table>";
                        echo "<tr><td>Design No:</td><td>" . $row['DN_NO'] . "</td><td>" . "" . "</td></tr>";
                        echo "<tr><td>Design Name:</td><td> " . $row['NAME'] . "</td><td>" . "" . "</td></tr>";
                        echo "<tr><td>Cloth Type:</td><td> " . $row['CLOTH_TYPE'] . "</td><td>" . "" . "</td></tr>";
                        echo "<tr><td>MU percent:</td><td> " . $row['MU'] . "</td><td>" . "" . "</td></tr>";
                        echo "<tr><td>Basic Cost:</td><td> " . $row['BASIC_COST'] . "</td><td>" . "" . "</td></tr>";
                        echo "<tr><td>Work Cost:</td><td> " . $row['WORK_COST'] . "</td><td>" . $row['WORK_JOB'] . "</td></tr>";
                        echo "<tr><td>Lace Cost:</td><td> " . $row['LACE_COST'] . "</td><td>" . $row['LACE_JOB'] . "</td></tr>";
                        echo "<tr><td>Diamond Cost: </td><td>" . $row['DIAMOND_COST'] . "</td><td>" . $row['DIAM_JOB'] . "</td></tr>";
                        echo "<tr><td>Packing Cost:</td><td> " . $row['PACKING_COST'] . "</td><td>" . "" . "</td></tr>";
                        echo "<tr><td>Calculated Price </td><td>" . $row['CALC_PRICE'] . "</td><td>" . "" . "</td></tr>";
                        echo "</table>";
                        $dname = $row['NAME'];
                        $sql1 = "SELECT * FROM SALES_ORDER natural join SALES_ORDER_DETAILS WHERE NAME='$dname' and TYPE='$ctype'";
                        if ($res = mysqli_query($conn, $sql1)) {
                            echo "<table><tr><th>Bill Number</th><th>Bill Date</th><th>Customer Name</th><th>Rate</th><th>Quantity</th></tr>";
                            while ($row1 = $res->fetch_assoc()) {
                                echo "<tr>
                            <td>" . $row1['BILL_NO'] . "</td>
                            <td>" . $row1['ORDER_DATE'] . "</td>
                            <td>" . $row1['CNAME'] . "</td>
                            <td>" . $row1['RATE'] . "</td>
                            <td>" . $row1['QTY'] . "</td>
                            </tr>";
                            }
                            echo "</table>";
                        }
                        else{
                            echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
                        }
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                }
                if (isset($_POST['save2'])) {

                    $bno = $_REQUEST['bno'];

                    $sql = "SELECT * FROM SALES_ORDER WHERE BILL_NO='$bno'";
                    if ($result = mysqli_query($conn, $sql)) {
                        $row = $result->fetch_assoc();
                        echo "<table>";
                        echo "<tr><td>Challan No:</td><td>" . $row['BILL_NO'] . "</td></tr>";
                        echo "<tr><td>Customer Name:</td><td> " . $row['CNAME'] . "</td></tr>";
                        echo "<tr><td>Purchase Date:</td><td> " . $row['ORDER_DATE'] . "</td></tr>";
                        echo "</table>";
                        $sql1 = "SELECT * FROM SALES_ORDER_DETAILS WHERE BILL_NO='$bno'";
                        if ($res = mysqli_query($conn, $sql1)) {
                            echo "<table><tr><th>DESIGN NAME</th><th>TYPE</th><th>Rate</th><th>Quantity</th></tr>";
                            while ($row1 = $res->fetch_assoc()) {
                                echo "<tr>
                            <td>" . $row1['NAME'] . "</td>
                            <td>" . $row1['TYPE'] . "</td>
                            <td>" . $row1['RATE'] . "</td>
                            <td>" . $row1['QTY'] . "</td>
                            </tr>";
                            }
                            echo "</table><br><br><br>";
                        }
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                }
            }
            ?>
            <form action="billdisplay.php" method="post">

                Enter DesignNo: 
                <select name="uid" style="width: 10rem;padding: 0.35rem 0.35rem;margin: 8px 0;display: inline-block;border: 1px solid #ccc;border-radius: 6px;box-sizing: border-box;">
                <?php 
                    $sql = "SELECT distinct(NAME) FROM DESIGN ";
                    $result = mysqli_query($conn, $sql);
                    while ($row = $result->fetch_assoc()) 
                    { echo "<option value='" . $row['NAME'] . "'>" . $row['NAME'] . "</option>";}
                ?>
                </select>
                Enter Cloth Type:
                <select name="ctype" style="width: 10rem;padding: 0.35rem 0.35rem;margin: 8px 0;display: inline-block;border: 1px solid #ccc;border-radius: 6px;box-sizing: border-box;">
                <?php 
                    $sql1 = "SELECT distinct(CLOTH_TYPE) FROM DESIGN ";
                    $res = mysqli_query($conn, $sql1);
                    while ($row = $res->fetch_assoc()) 
                    { echo "<option value='" . $row['CLOTH_TYPE'] . "'>" . $row['CLOTH_TYPE'] . "</option>";}
                ?>
                </select>
                <button type="submit" class="btn btn-danger ml-3" name="save1">Display </button>
            </form><br><br>
            <form action="billdisplay.php" method="post">

                Enter bill No: <input type="number" name="bno" id="bno">
                <button type="submit" class="btn btn-danger ml-3" name="save2">Display </button>
            </form><br>
            <a href="billing.php"> + BILL</a>
            <a href="Register.php"> + DESIGN</a>
        </center>
</body>

</html>