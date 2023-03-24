<?php
if(isset($_POST["submit"]))
{
   $uid = $_POST["uid"];
   $pwd = $_POST["pwd"];
   $pwdRepeat = $_POST["pwdRepeat"];
   $email = $_POST["email"];

   include "../classes/dph.php";
   include "../classes/signup.php";
   include "../classes/signup-controller.php";
$signup = new SignupContr($uid, $pwd, $pwdRepeat, $email);
$signup->signupUser();
header("location: ../../index.php?error=none");
}

