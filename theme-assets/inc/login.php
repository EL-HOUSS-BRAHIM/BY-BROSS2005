<?php
if(isset($_POST["submit"]))
{
   $uid = $_POST["uid"];
   $pwd = $_POST["pwd"];

   include "../classes/dph.php";
   include "../classes/login.php";
   include "../classes/login-controller.php";
$login = new LoginContr($uid, $pwd);
$login->loginUser();
header("location: ../../index.php");
}

