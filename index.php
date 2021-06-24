<?php
session_start();
if (!isset($_SESSION['login']) || empty($_SESSION['login'])) {
    $_SESSION["login"] = false;
}
?>

<?php

if (isset($_POST['save'])) {
    if ($_POST['user'] === 'bkgarg' && $_POST['pass'] === 'bkgarg') {
        $_SESSION["login"] = true;
    }
}
if (isset($_POST['save1'])) {
    $_SESSION["login"] = false;
}

?>
<?php

if ($_SESSION["login"]) {
    echo "<a href='billing.php' target='_blank'>+ Bill </a>&emsp;";
    echo "<a href='Register.php' target='_blank'>+ Design</a>&emsp;<br><br>";
    echo "<a href='customer.php' target='_blank'>+ Customer</a>&emsp;<br><br>";
    echo "<a href='billdisplay.php' target='_blank'>Display Bill</a>";
}

?>

<html>

<head>
    <title>LOGIN</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <center>
        <h3>HOME PAGE</h3><br>

        <form action="index.php" method="post">
            Enter USERNAME: <input type="text" name="user" id="user" required><br><br>
            Enter PASSWORD: <input type="password" name="pass" id="pass" required><br><br>
            <button type="submit" class="btn btn-danger ml-3" name="save">LOGIN </button>

        </form><br><br>
        <form action="index.php" method="post">
            <button type="submit" class="btn btn-danger ml-3" name="save1">LOGOUT </button>
        </form>
    </center>
</body>

</html>