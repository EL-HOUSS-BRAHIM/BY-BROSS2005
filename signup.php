<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">    
    <title>MIDNIGHT SINGUP</title></title>
    <link rel="shortcut icon" type="image/x-icon" href="theme-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  </head>
  <body>
    <style>
 /* Set the background color to black */
  body {
    background-color: black;
    color: white;
    font-family: 'Open Sans', sans-serif;
  }
/* Center the login section */
.index-login {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

/* Add some padding and margin to the form */
.index-login form {
    padding: 40px;
    margin: 89px;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 17px;
    border: 4px solid blue;
    box-shadow: 0 0 40px rgba(0, 0, 0.2, 0.2);
}

/* Style the form inputs and buttons */
.index-login input,
.index-login button {
    padding: 18px;
    margin: 18px;
    font-size: 18px;
    border: none;
    border-radius: 17px;
    background-color: rgba(255, 255, 255, 0.1);
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

/* Style the form labels */
.index-login label {
    font-size: 40px;
    margin-bottom: 30px;
}

/* Style the submit button */
.index-login button[type="submit"] {
    background-color: #0077ff;
    color: white;
    font-size: 20px;
    position: relative;
    left: 64px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
header h3 {
    margin-bottom: 6px;
}
header h4 {
    margin-bottom: 70px;
    font-size: 30px;
    font-weight: bold;
}
/* Change the submit button color on hover */
.index-login button[type="submit"]:hover {
    background-color: #0055cc;
}
.error-mess {
    color: red;
position: relative;
bottom: 300px;
right: 380px;
font-weight: bold;
}
</style>
<h4 style="font-size: 25px;">SIGN UP</h4>
<p style="font-size: 25px;">Don't have a account yet? sign up now!</p>
<section class="index-login">
<form action="theme-assets/inc/signup.php" method="post">
<input type="text" name="uid" placeholder="Username"><br>
<input type="password" name="pwd" placeholder="Password"><br>
<input type="password" name="pwdRepeat" placeholder="Repeat Password"><br>
<input type="text" name="email" placeholder="E-mail">
<br><br>
<button type="submit" name="submit">SIGN UP</button>
</form>
<div class="error-mess"><?php 
if(isset($_GET['error'])) {
    $error = $_GET['error'];
    if($error == "emptyinput") {
        echo "<div class='error'>Please fill in all fields!</div>";
    }
    else if($error == "username") {
        echo "<div class='error'>Invalid username!</div>";
    }
    else if($error == "email") {
        echo "<div class='error'>Invalid email!</div>";
    }
    else if($error == "passwordmatch") {
        echo "<div class='error'>Passwords don't match!</div>";
    }
    else if($error == "useroremailtaken") {
        echo "<div class='error'>Username or email already taken!</div>";
    }
}
?></div>
</section>

  </body>
</html>