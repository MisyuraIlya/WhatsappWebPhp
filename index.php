<?php
session_start();
if(isset($_SESSION["user"]))
{
    Header("Location: ./main.php");
}
// =====================================REGISTRATION==============================
$msg = "";

$MySQLdb = new PDO("mysql:host=127.0.0.1;dbname=whatsapp", "root", "");
$MySQLdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if(isset($_POST['password1']) && isset($_POST['password2']) && isset($_POST['username']) && isset($_POST['name']) && isset($_POST['pin'])){
    $password1   = $_POST['password1'];
    $password2   = $_POST['password2'];
    $username   = $_POST['username'];
    $name = $_POST['name'];
    $pin = $_POST['pin'];

    $cursor = $MySQLdb->prepare("SELECT username FROM users WHERE username=:username");
    $cursor->execute( array(":username"=>$username) );

        /* New User */
        if(!($cursor->rowCount()))
    {
      $cursor = $MySQLdb->prepare("INSERT INTO users (name, username, password, pin) value (:name,:username,:password,:pin)");
      $cursor->execute(array(":name"=>$name, ":password"=>$password1, ":username"=>$username, ":pin"=>$pin));
      $msg = "You have successfully registered<br>";
        }
        /* Already exists */
        else
        {
            $msg = "username already exists in the system<br>";
        }
}
// ======================================================================================
// =================================SIGNIN===============================================
if(isset($_POST['l_username']) && isset($_POST['l_password'])){
  $l_username = $_POST['l_username'];
  $l_password = $_POST['l_password'];

  $cursor = $MySQLdb->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
  $cursor->execute(array(":password"=>$l_password, ":username"=>$l_username));

  if(!$cursor->rowCount())
  {
      $msg = "Wrong Username/Password!<br>";
  }
  else
  {
$return_array = $cursor->fetch();

      $_SESSION["user"]    = $return_array["username"];
      // echo   $_SESSION["user"];
      // $_SESSION["userid"]  = $return_array["id"];

/* set cookie */
      die(Header("Location: main.php"));
  }
}
// ========================================================================================
// ============================ForgotPassword==============================================

 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title></title>
  </head>
  <body>

    <p><?php echo $msg; ?></p>
    <div class="container" id="container">
    	<div class="form-container sign-up-container">
    		<form action="#" method="POST">
    			<h1>Create Account</h1>
          <p><?php echo $msg; ?></p>
    			<div class="social-container">
    				<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
    				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
    				<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
    			</div>
    			<span>or use your email for registration</span>
    			<input type="text" placeholder="Name"  name="name"/>
    			<input type="text" placeholder="username" name="username"/>
    			<input type="password" placeholder="Password" name="password1"/>
          <input type="password" placeholder="Password repeat" name="password2"/>
          <input type="text" placeholder="write pincode" name="pin"/>
    			<button name="action">Sign Up</button>
    		</form>
    	</div>
    	<div class="form-container sign-in-container">
    		<form action="#" method="POST">
    			<h1>Sign in</h1>
    			<div class="social-container">
    				<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
    				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
    				<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
    			</div>
    			<span>or use your account</span>
    			<input type="text" placeholder="Email" name="l_username" />
    			<input type="password" placeholder="Password" name="l_password"/>
    			<button>Sign In</button>
          <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal">Forget password?</button>
    		</form>
    	</div>
    	<div class="overlay-container">
    		<div class="overlay">
    			<div class="overlay-panel overlay-left">
    				<h1>Welcome Back!</h1>
    				<p>To keep connected with us please login with your personal info</p>
    				<button class="ghost" id="signIn">Sign In</button>
    			</div>
    			<div class="overlay-panel overlay-right">
    				<h1>Hello, Friend!</h1>
    				<p>Enter your personal details and start journey with us</p>
    				<button class="ghost" id="signUp">Sign Up</button>
    			</div>
    		</div>
    	</div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Forgot password?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <form class="" action="#" method="post">
            what is your name? : <input type="text" name="s_name" value="">
            what is your username? : <input type="text" name="s_username" value="">
            what is your secret pin? : <input type="text" name="s_pin" value="">
            Enter new password : <input type="password" name="s_pass1" value="">
            repeat the new password : <input type="password" name="s_pass2" value="">
            <div class="modal-footer">
              <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
              <button type="button" class="btn btn-primary" name="savechange" id="btn1">Save changes</button>
            </div>
          </form>
          </div>

        </div>
      </div>
    </div>
    <footer>
    	<p>
    		Created with <i class="fa fa-heart"></i> by
    		<a target="_blank" href="https://florin-pop.com">Florin Pop</a>
    		- Read how I created this and how you can join the challenge
    		<a target="_blank" href="https://www.florin-pop.com/blog/2019/03/double-slider-sign-in-up-form/">here</a>.
    	</p>
    </footer>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript">
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
          container.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
          container.classList.remove("right-panel-active");
        });
    </script>


    <script type="text/javascript">
    $("btn1").click(function(){
      $.get("login.php",{"action":"select","data":$("#inp1").val()},function(data){
        console.log(data);
      })
    });
    </script>
  </body>
</html>
