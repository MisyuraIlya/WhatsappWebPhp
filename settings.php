<?php
error_reporting(E_ALL ^ E_WARNING);
$msg1 ="";
$msg2 ="";
$msg3 ="";
$msg4 ="";
session_start();
if(!isset($_SESSION["user"]))
{
    Header("Location: ./index.php");
}



$username = $_SESSION["user"];
// echo $username;

$MySQLdb = new PDO("mysql:host=127.0.0.1;dbname=whatsapp", "root", "");
$MySQLdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$cursor = $MySQLdb->prepare("SELECT * FROM users WHERE username=:username");
$cursor->execute( array(":username"=>$username) );

if($cursor->rowCount()){
	while($row = $cursor->fetch()) {
		$name = $row['name'];
		$password = $row['password'];
    $pin = $row['pin'];
    $phone = $row['phone'];
    $image = $row['image'];
    // echo $name.$password.$pin.$image;
	}
}
// ===================================settings====================================
if(isset($_POST["update"])){
  $cursor = $MySQLdb->prepare("UPDATE users SET phone=:phone,name=:name   WHERE username=:username");
  $cursor->execute( array(":phone"=>$_POST["phone"], ":username"=>$_SESSION["user"] , ":name"=>$_POST["name"]) );
  $msg1 = '<div class="alert alert-primary" role="alert"> Settings curentrly changed </div>';
}
if(isset($_POST["updatephone"])){
  $cursor = $MySQLdb->prepare("UPDATE users SET phone=:phone  WHERE username=:username");
  $cursor->execute( array(":phone"=>$_POST["phone"], ":username"=>$_SESSION["user"]) );
  $msg4 = '<div class="alert alert-primary" role="alert"> phone curentrly changed </div>';
}
// ===============================================================================
// ===================================password change====================================
if(isset($_POST["updatepassword"])){
  if($_POST["pass1"] == $_POST["pass2"]){
    $cursor = $MySQLdb->prepare("UPDATE users SET password=:password  WHERE username=:username");
    $cursor->execute( array(":password"=>$_POST["pass1"], ":username"=>$_SESSION["user"]) );
    $msg2 = '<div class="alert alert-primary" role="alert"> Password curentrly changed </div>';
  }else {
    $msg2 = '<div class="alert alert-danger" role="alert">The passwords not exists</div>';
  }
}
// ===============================================================================
// ===================================photochange====================================

$target_dir = "profile/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$newFileName = $target_dir .$username.'.'. pathinfo($_FILES["fileToUpload"]["name"] ,PATHINFO_EXTENSION); //get the file extension and append it to the new file name
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));



// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    // echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    $msg5 =  '<div class="alert alert-danger" role="alert">this not a image file</div>';
    $uploadOk = 0;
  }




// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  $msg5 =  '<div class="alert alert-danger" role="alert">the file is to lare max 5 mb</div>';
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  $msg5 = '<div class="alert alert-danger" role="alert">Sorry, only JPG, JPEG, PNG & GIF files are allowed</div>';
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 1) {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newFileName)) {
    $cursor = $MySQLdb->prepare("UPDATE users SET image=:image  WHERE username=:username");
    $cursor->execute( array(":image"=>$newFileName, ":username"=>$_SESSION["user"]) );
    $msg5 = '<div class="alert alert-primary" role="alert"> Image uploaded </div>';
  } else {
    $msg5 = '<div class="alert alert-danger" role="alert">Error in upload the image</div>';

  }
// if everything is ok, try to upload file
}

}







// ===============================================================================
 ?>



 <!doctype html>
 <html lang="en">
   <head>
     <!-- Required meta tags -->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
     <title>Hello, <?php echo $name; ?></title>
   </head>
   <body>
     <nav class="navbar navbar-expand-lg navbar-light bg-light">
       <div class="container-fluid">
         <a class="navbar-brand" href="main.php">Chat</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
           <ul class="navbar-nav me-auto mb-2 mb-lg-0">
             <li class="nav-item">
               <a class="nav-link" href="settings.php">settings</a>
             </li>
           </ul>
           <form class="d-flex">
             <button class="btn btn-outline-success" type="submit" id="logout1">Logout</button>
           </form>
         </div>
       </div>
      </nav>

     <div class="container">
       <div class="row">
         <div class="col">
           <div class="card mb-3" style="max-width: 540px; margin-top:70px;">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="images/WhatsApp.jpg" class="img-fluid" alt="...">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">Current settings</h5>
                  <p class="card-text">name: <?php echo $name; ?> </p>
                  <p class="card-text">Username: <?php echo $username; ?></p>
                  <p class="card-text">phone: <?php echo $phone; ?></p>
                </div>
              </div>
            </div>
          </div>
          <div class="card mb-3" style="max-width: 540px; margin-top:235px;">
           <div class="row g-0">
             <div class="col-md-4">
               <img src="images/whatsapp2.png" class="img-fluid" alt="...">
             </div>
             <div class="col-md-8">
               <div class="card-body">
                 <h5 class="card-title">Current password</h5>
                 <p class="card-text">password: <?php echo $password; ?></p>
               </div>
             </div>
           </div>
         </div>
         </div>
         <div class="col-5">
          <h2 style="text-align: center;">change name</h2>
           <hr>
            <?php echo $msg1; ?>
           <form class="" action="settings.php" method="POST">
               <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" placeholder="name" name="name">
                <label for="floatingInput">name</label>
              </div>
              <!-- <div class="form-floating mb-3">
               <input type="text" class="form-control" id="floatingInput" placeholder="username">
               <label for="floatingInput">username</label>
             </div> -->
            <!-- <button type="button" class="btn btn-primary" style="display: block; margin-left: auto; margin-right: auto; width: 50%;" name="update">Submit</button> -->
            <input type="submit" class="btn btn-primary" style="display: block; margin-left: auto; margin-right: auto; width: 50%;" name="update" >
          </form>
        <hr>
        <br>
        <h2 style="text-align: center;">change phone</h2>
         <hr>
          <?php echo $msg4; ?>
         <form class="" action="settings.php" method="POST">
            <!-- <div class="form-floating mb-3">
             <input type="text" class="form-control" id="floatingInput" placeholder="username">
             <label for="floatingInput">username</label>
           </div> -->
           <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" name="phone" placeholder="phone">
            <label for="floatingInput">phone</label>
          </div>
          <!-- <button type="button" class="btn btn-primary" style="display: block; margin-left: auto; margin-right: auto; width: 50%;" name="update">Submit</button> -->
          <input type="submit" class="btn btn-primary" style="display: block; margin-left: auto; margin-right: auto; width: 50%;" name="updatephone" id="phoneUpdater">
        </form>
        <hr>
        <br>
        <br>
        <h2 style="text-align: center;">change password</h2>
        <hr>
       <?php echo $msg2; ?>
        <form class="" action="settings.php" method="POST">
            <div class="form-floating">
              <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="pass1">
              <label for="floatingPassword">Password</label>
            </div>
            <br>
            <div class="form-floating">
              <input type="password" class="form-control" id="floatingPassword" placeholder="Password2" name="pass2">
              <label for="floatingPassword">Password repeat</label>
            </div>
            <br>
            <!-- <button type="button" class="btn btn-primary" style="display: block; margin-left: auto; margin-right: auto; width: 50%;">Submit</button> -->
            <input type="submit" class="btn btn-primary" style="display: block; margin-left: auto; margin-right: auto; width: 50%;" name="updatepassword" >
            <hr>
           </div>
       </form>
         <div class="col">
           <h2 style="text-align: center;">Upload Image</h2>
           <?php echo $msg5; ?>
           <img src="<?php echo $image; ?>" class="" alt="..." style="border-radius: 50%; height:190px; width:200px; display: block;
                margin-left: auto;
                margin-right: auto;
                width: 50%;">

          <div class="mb-3">
            <form action="settings.php" method="post" enctype="multipart/form-data">
              Select image to upload:
              <input type="file" name="fileToUpload" id="fileToUpload">
              <input type="submit" value="Upload Image" name="submit">
            </form>
          </div>
                <button type="button" class="btn btn-primary" style="display: block; margin-left: auto; margin-right: auto; width: 50%;">upload</button>
         </div>
       </div>
     </div>


     <!-- Optional JavaScript; choose one of the two! -->
     <script type="text/javascript">
     $("#logout1").click(function () {
         $.post("api.php",{"action":"logout"},function () {
             document.location="index.php";
         });
     });

     $("#phoneUpdater").click(function(){
       // $.post("api.php", {"action":"phoneUpdate","phone":$("#phone").val()},function(data){

       });
     // });




     </script>
     <!-- Option 1: Bootstrap Bundle with Popper -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

     <!-- Option 2: Separate Popper and Bootstrap JS -->
     <!--
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
     -->
   </body>
 </html>
