<?php

	session_start();
	if(!isset($_SESSION["user"]))
	{
			Header("Location: ./index.php");
	}
!



$username = $_SESSION["user"];
// echo $username;

$MySQLdb = new PDO("mysql:host=127.0.0.1;dbname=whatsapp", "root", "");
$MySQLdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$cursor = $MySQLdb->prepare("SELECT * FROM users WHERE username=:username");
$cursor->execute( array(":username"=>$username) );

if($cursor->rowCount()){
	while($row = $cursor->fetch()) {
		$id = $row['id'];
		$name = $row['name'];
		$password = $row['password'];
    $pin = $row['pin'];
    $phone = $row['phone'];
    $image = $row['image'];
    echo $id;
	}
}
// ===============================================================
$cursorid = $MySQLdb->prepare("SELECT * FROM posts WHERE username=:username");
$cursorid->execute( array(":username"=>$username) );
if($cursor->rowCount()){
	while($row = $cursorid->fetch()) {
		$postid = $row['user_id'];
    echo $postid;
	}
}
// =====================send==================================


if(isset($_POST["send"])){
	$cursor = $MySQLdb->prepare("INSERT INTO posts (user_id,post_data,username) value (:id,:post_data,:name)");
	$cursor->execute(array(":id"=>$id, ":post_data"=>$_POST["message"],":name"=>$username));
	echo "ok";
}else {
	echo "no";
}



// ==================================================

 ?>

 <html lang="en">

 <head>
   <title>Whatsapp Template</title>
	 <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	 <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	 <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="css/main.css">
   <!-- Font Awesome File -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>

 <body>

   <div class="container app">
     <div class="row app-one">

       <div class="col-sm-4 side">
         <div class="side-one">
           <!-- Heading -->
           <div class="row heading">
             <div class="col-sm-3 col-xs-3 heading-avatar">
               <div class="heading-avatar-icon">
                 <img src="<?php echo $image; ?>">
               </div>
             </div>
             <div class="col-sm-1 col-xs-1  heading-dot  pull-right">
               <i class="fa fa-ellipsis-v fa-2x  pull-right" aria-hidden="true"></i>
             </div>
             <div class="col-sm-2 col-xs-2 heading-compose  pull-right">
               <i class="fa fa-comments fa-2x  pull-right" aria-hidden="true"></i>
             </div>
           </div>
           <!-- Heading End -->

           <!-- SearchBox -->
           <div class="row searchBox">
             <div class="col-sm-12 searchBox-inner">
               <div class="form-group has-feedback">
                 <input id="searchText" type="text" class="form-control" name="searchText" placeholder="Search">
                 <span class="glyphicon glyphicon-search form-control-feedback"></span>
               </div>
             </div>
           </div>

           <!-- Search Box End -->
           <!-- sideBar -->
           <div class="row sideBar">
             <div class="row sideBar-body">
               <div class="col-sm-3 col-xs-3 sideBar-avatar">
                 <div class="avatar-icon">
                   <img src="http://shurl.esy.es/y">
                 </div>
               </div>
               <div class="col-sm-9 col-xs-9 sideBar-main">
                 <div class="row">
                   <div class="col-sm-8 col-xs-8 sideBar-name">
                     <span class="name-meta">chat
                   </span>
                   </div>
                   <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                     <span class="time-meta pull-right">18:18
                   </span>
                   </div>
                 </div>
               </div>
             </div>


           </div>
           <!-- Sidebar End -->
         </div>
         <div class="side-two">

           <!-- Heading -->
           <div class="row newMessage-heading">
             <div class="row newMessage-main">
               <div class="col-sm-2 col-xs-2 newMessage-back">
                 <i class="fa fa-arrow-left" aria-hidden="true"></i>
               </div>
               <div class="col-sm-10 col-xs-10 newMessage-title">
                 New Chat
               </div>
             </div>
           </div>
           <!-- Heading End -->

           <!-- ComposeBox -->
           <div class="row composeBox">
             <div class="col-sm-12 composeBox-inner">
               <div class="form-group has-feedback">
                 <input id="composeText" type="text" class="form-control" name="searchText" placeholder="Search People">
                 <span class="glyphicon glyphicon-search form-control-feedback"></span>
               </div>
             </div>
           </div>
           <!-- ComposeBox End -->

           <!-- sideBar -->
           <div class="row compose-sideBar">
             <div class="row sideBar-body">
               <div class="col-sm-3 col-xs-3 sideBar-avatar">
                 <div class="avatar-icon">
                   <img src="http://shurl.esy.es/y">
                 </div>
               </div>
               <div class="col-sm-9 col-xs-9 sideBar-main">
                 <div class="row">
                   <div class="col-sm-8 col-xs-8 sideBar-name">
                     <span class="name-meta">Ankit Jain
                   </span>
                   </div>
                   <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                     <span class="time-meta pull-right">18:18
                   </span>
                   </div>
                 </div>
               </div>
             </div>
             <div class="row sideBar-body">
               <div class="col-sm-3 col-xs-3 sideBar-avatar">
                 <div class="avatar-icon">
                   <img src="http://shurl.esy.es/y">
                 </div>
               </div>
               <div class="col-sm-9 col-xs-9 sideBar-main">
                 <div class="row">
                   <div class="col-sm-8 col-xs-8 sideBar-name">
                     <span class="name-meta">Ankit Jain
                   </span>
                   </div>
                   <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                     <span class="time-meta pull-right">18:18
                   </span>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>
         <!-- Sidebar End -->
       </div>


       <!-- New Message Sidebar End -->

       <!-- Conversation Start -->
       <div class="col-sm-8 conversation">
         <!-- Heading -->
         <div class="row heading">
           <div class="col-sm-2 col-md-1 col-xs-3 heading-avatar">
             <div class="heading-avatar-icon">
               <img src="<?php echo $image; ?>">
             </div>
           </div>
           <div class="col-sm-6 col-xs-7 heading-name">
             <a class="heading-name-meta"><?php echo $name; ?>
             </a>
             <span class="heading-online">Online</span>
           </div>
           <div class="col-sm-2 col-xs-1  heading-dot pull-right">
            <button type="button" class="btn btn-primary" id="logout">Logout</button>
           </div>
					 <div class="col-sm-2 col-xs-1  heading-dot pull-right">
						<button type="button" class="btn btn-primary" id="settings">settings</button>
					 </div>
         </div>
         <!-- Heading End -->

         <!-- Message Box -->
         <div class="row message" id="conversation">

           <div class="row message-previous">
             <div class="col-sm-12 previous">
               <a onclick="previous(this)" id="ankitjain28" name="20">
               Show Previous Message!
               </a>
             </div>
           </div>



<?php
$cursorposts = $MySQLdb->prepare("SELECT * FROM posts");
$cursorposts->execute();


foreach ($cursorposts->fetchAll() as $obj) {
		if ($obj["user_id"] == $id) {
				echo "<div class='row message-body'>
				             <div class='col-sm-12 message-main-sender'>
				               <div class='sender'>
				                 <div class='message-text'>
												 <h5>{$obj["username"]}</h5>
				                 {$obj["post_data"]}
				                 </div>
				                 <span class='message-time pull-right'>
				                   {$obj["postdate"]}
				                 </span>
				               </div>
				             </div>
				           </div>
									 <br>";

		} else {
				echo "<div class='row message-body'>
				             <div class='col-sm-12 message-main-receiver'>
				               <div class='receiver'>
				                 <div class='message-text'>
												 <h5>{$obj["username"]}</h5>
												 {$obj["post_data"]}
				                 </div>
				                 <span class='message-time pull-right'>
				                   {$obj["postdate"]}
				                 </span>
				               </div>
				             </div>
				           </div>
									 <br>";

		}
}



 ?>



         </div>


         <!-- Message Box End -->

         <!-- Reply Box -->
         <div class="row reply">
					 <form class="" action="main.php" method="post">
		           <div class="col-sm-1 col-xs-1 reply-emojis">
		             <i class="fa fa-smile-o fa-2x"></i>
		           </div>
		           <div class="col-sm-9 col-xs-9 reply-main">
		             <!-- <textarea class="form-control" rows="1" id="comment"></textarea> -->
							<input type="text" class="form-control"  placeholder="message" name="message">
		           </div>
		           <div class="col-sm-1 col-xs-1 reply-recording">
		             <i class="fa fa-microphone fa-2x" aria-hidden="true"></i>
		           </div>
		           <div class="col-sm-1 col-xs-1 reply-send">
             <!-- <i class="fa fa-send fa-2x" aria-hidden="true"></i> -->

							 <input type="submit" name="send" value="Send">
						 </form>
           </div>
         </div>
         <!-- Reply Box End -->
       </div>
       <!-- Conversation End -->
     </div>
     <!-- App One End -->
   </div>

   <!-- App End -->
		 <script type="text/javascript">
		 $(".heading-compose").click(function() {
       $(".side-two").css({
         "left": "0"
       });
     });

     $(".newMessage-back").click(function() {
       $(".side-two").css({
         "left": "-100%"
       });
     });
		 </script>
		 <script type="text/javascript">
				 	$("#logout").click(function () {
				 			$.post("api.php",{"action":"logout"},function () {
				 					document.location="index.php";
				 			});
				 	});


					$("#settings").click(function(){
						document.location="settings.php";
					});
	 </script>
   </body>
 </html>
