<!DOCTYPE html>
<?php
    $conn = mysqli_connect('localhost', 'root', '', 'ntm');
    session_start();
?>
<?php
$sql = "SELECT distinct(NAME) FROM DESIGN ";
$result = mysqli_query($conn, $sql);
$sql1 = "SELECT distinct(CLOTH_TYPE) FROM DESIGN ";
$resul = mysqli_query($conn, $sql1);

?>
<?php 
if($_SESSION["login"]){
    if (isset($_POST['save'])) {
        unset($_POST['save']);
        $flag=0;
        $uid = $_POST['billno'];
        $cname = $_POST['cname'];
        $date = $_POST['billdate'];
        $sql = "INSERT INTO SALES_ORDER  values ('$uid','$cname','$date')";
        if (mysqli_query($conn, $sql)) {
            echo "BILL  Added successfully<br>";
        }
        else{
            exit("BILL ALREADY EXISTS OR OTHER ERROR");
        }
        unset($_POST['billno']);
        unset($_POST['cname']);
        unset($_POST['billdate']);
        $itemnos = array();       
        foreach (array_keys($_POST) as $key) {
            if (strpos($key, 'name') !== false) {
                array_push($itemnos,substr($key, -1));
            }
        }
        foreach($itemnos as $item){
            $type = $_POST['itemtype_'.$item];
            $name = $_POST['itemname_'.$item];
            $rate = $_POST['itemrate_'.$item];
            $quantity =  $_POST['itemquantity_'.$item];
            $sql = "INSERT INTO SALES_ORDER_DETAILS  values ('$uid','$name','$quantity','$rate','$type')";
            if (mysqli_query($conn, $sql)) {
                echo "<br>ITEM  Added<br>";
            }
            echo $type." | ".$name." | ".$rate." | ".$quantity."<br>";
        }
    }}
?>
<html>

<head>
    <title>Billing</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<center>
    <h2>Billing System</h2>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js">
    </script>
    <script>
        $(document).ready(function() {
            var i = 0;

            $('#add').click(function() {
                // Get inputs created (if any)
                var inputs = $('input');
                console.log(inputs.length);
                
                // Verify if there are 7 or more inputs
                if (inputs.length >= 14) {
                    console.log('Only six inputs allowed');
                    return;
                }
                // Get last input to avoid duplicated IDs / names
                if (inputs.last().length > 1) {
                    // Split name to get only last part of name, the numeric one
                    i = parseInt(inputs.last()[0].name.split('_')[1]);
                }
                i++;
                console.log(i);
                $('#dynamic_field').append('<div id="row' + i +
                    '"><label" for="member_' + i +
                    '"><b>Item</b></label><button type="button" class="btn_remove" name="remove" id="' + i +
                    '">Delete</button><br>'+
                    '<select name="itemname_' + i + 
                    '" style="width: 10rem;padding: 0.35rem 0.35rem;margin: 8px 0;display: inline-block;border: 1px solid #ccc;border-radius: 6px;box-sizing: border-box;">' + 
                    "<?php while ($row = $result->fetch_assoc()) { echo "<option value='" . $row['NAME'] . "'>" . $row['NAME'] . "</option>";}?>" 
                    + '</select>&emsp;'+
                    '<select name="itemtype_' + i + 
                    '" style="width: 10rem;padding: 0.35rem 0.35rem;margin: 8px 0;display: inline-block;border: 1px solid #ccc;border-radius: 6px;box-sizing: border-box;">' + 
                    "<?php while ($row1 = $resul->fetch_assoc()) { echo "<option value='" . $row1['CLOTH_TYPE'] . "'>" . $row1['CLOTH_TYPE'] . "</option>";}?>" 
                    + '</select><br>'+
                    '<input type="number" placeholder="enter rate" name="itemrate_'+ i +
                    '" value="" required><input type="number" placeholder="enter quantity" name="itemquantity_' + i +
                    '" value="" required><br></div>')
            });
            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });
    </script>
    <form action="billing.php" method="post">
        <input type="number" placeholder="enter challan number" name="billno" value="">
            <br><b>Party Name </b></b><select name="cname" style="width: 10rem;padding: 0.35rem 0.35rem;margin: 8px 0;display: inline-block;border: 1px solid #ccc;border-radius: 6px;box-sizing: border-box;">
        <?php 
            $sql2 = "SELECT distinct(cusname) FROM CUSTOMER ";
            $res = mysqli_query($conn, $sql2);
            
            while ($row = $res->fetch_assoc()) {
                echo "<option value='" . $row['cusname'] . "'>" . $row['cusname'] . "</option>";}
        ?>
        </select>
        <input type="date" placeholder="dd-mm-yyyy" value=""
        min="1997-01-01" max="2030-12-31" name="billdate" value="">
        <br><br>
            <div id="dynamic_field"></div>
            <button type="button" name="add" id="add">Add New Item</button>
            <button type="submit" name="save">Submit</button>
    </form><br><br>
    <a href="billdisplay.php">DISPLAY</a></center>
</body>

</html>