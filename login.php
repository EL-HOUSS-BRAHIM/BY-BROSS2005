<!DOCTYPE html>
<html>
  <head>
    <title>Login Page</title>
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
    height: 100vh; /* 100% of the viewport height */
    z-index: 100px;
  }

  /* Add some padding and margin to the form */
  .index-login form {
    padding: 40px;
    margin: 20px;
    position: relative;
    left: none;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
  }

  /* Style the form inputs and buttons */
  .index-login input,
  .index-login button {
    padding: 10px;
    margin: 10px;
    font-size: 18px;
    border: none;
    border-radius: 5px;
    background-color: rgba(255, 255, 255, 0.1);
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
  }

  /* Style the form labels */
  .index-login label {
    font-size: 20px;
    margin-bottom: 10px;
  }

  /* Style the submit button */
  .index-login button[type="submit"] {
    background-color: #0077ff;
    color: white;
    font-size: 20px;
    cursor: pointer;

    transition: background-color 0.3s ease;
  }

  /* Change the submit button color on hover */
  .index-login button[type="submit"]:hover {
    background-color: #0055cc;
  }
.error-mess {
    color: red;
position: relative;
bottom: 180px;
right: 330px;
}
@media (max-width: 1000px) { /* styles for screens with width less than 600px */
    .error-mess {
        position: relative;
        top: auto;
        right: 330px;
        bottom: 180px;

    }
}
</style>
  </head>
  <body>
    <section class="index-login">
        <form action="theme-assets/inc/login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="uid" placeholder="Enter your username">
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="pwd" placeholder="Enter your password">
            <br>
            <button type="submit" name="submit">LOGIN</button>
        </form>
            <div class="error-mess"><?php 
if(isset($_GET['error'])) {
    $error = $_GET['error'];
    if($error == "emptyInput") {
        echo "<div class='error'>Please fill in all fields!</div>";
    }
    else if($error == "usernotfound") {
        echo "<div class='error'>Invalid username!</div>";
    }
    else if($error == "wrongpassword") {
        echo "<div class='error'>Passwords Incorrect!</div>";
    }
}
?></div>
    </section>
  </body>
</html>
