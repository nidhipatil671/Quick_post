<?php

include_once'connection.php';
include_once'signin_details.php';
$db=mysqli_connect($servername,$username,$password,$dbname);

$cnt = 0;


$query="SELECT id, title,discription,user_id,image FROM posts";

$result=mysqli_query($db,$query);
$cnt = mysqli_num_rows(mysqli_query($db,$query));

if(!empty($_SESSION['id'])){
	$loggedIn_user_id=$_SESSION['id'];
}

function isLoggedIn() {
	return !empty($_SESSION['logged_user_name']);
}

function isLoggedInUsersPosts($db, $user_id_from_post,$loggedIn_user_id) {
	$query="SELECT * FROM posts WHERE user_id='$loggedIn_user_id'";
	$result=mysqli_query($db,$query);
	if(mysqli_query($db,$query)){
		while($row=mysqli_fetch_array($result)){
			return $row['user_id'] = $loggedIn_user_id;
		}
		
	}
	return false;

}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Quick Post</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="index.css">
	
</head>
<body>
    <div class="container">
		<?php if(isLoggedIn()) {
			echo('
			<div class="nav">
				<div class=nav__links>
					<a href="#">Home</a>
					<a href="post.php">Make a post</a>
					<a href="edit_profile.php">Edit Profile</a>
					<a href="logout.php">Logout</a>
				</div>
				<div class="nav__img">
					<img src="./img/bg.jpeg" alt="avatar">
				</div>
			</div>
			');
		} else {
			echo ('
			<div class="nav_data">
				<div class="nav_link">
				      <div class="nava1">
			        	<h1>QUICK POST</h1>
			         </div>
					<button><a href="sign_in.php">Sign In</a></button>
		
					<button><a href="sign_up.php">Sign Up</a></button>
				</div>
				<br>	
				<div class="nav_data1" style="text-align:right;">
					<a href="forgetpass.php">Forget Password ?</a>
				</div>
			</div>
			
			');
		}
		?>
        <div class="main">
			<div class="welcome">
				<?php
					if(isLoggedIn()){?>
						<h2>Welcome <?php echo $_SESSION['logged_user_name'];?>, you have <?php echo $cnt;?> <?php if($cnt>1): echo 'publications'; else: echo 'publication'; endif;?> </h2>
					<?php }
					else{?>
						<h2>Welcome, with <?php echo $cnt;?> <?php if($cnt>1): echo 'publications'; else: echo 'publication'; endif;?> </h2>
				<?php	}
				?>
                </div>
            
			   <div class="row">
					<?php 
					 	if($result)
						{  
							while($row=mysqli_fetch_array($result)){
								if(isLoggedIn()) {
									echo('
										<div class="column"> 
											<img src="data:image/jpg;base64,'.base64_encode( $row['image'] ).'" class="imag1">

											<div class="first">
												<h3>'.$row["title"].'</h3>
											</div>

											<div class="cnt">
											'.$row["discription"].'
											</div>

											<div class="last">
												<a href="post.php?edit='.$row['id'].'">Edit</a>
												<a href="post_delete.php?id='.$row['id'].'">Delete</a>
												<a href="read_more.php?id='.$row['id'].'">read more</a>
											</div>

										</div>');
								} else {
									echo('
									<div class="column"> 
										<img src="data:image/jpg;base64,'.base64_encode( $row['image'] ).'" class="imag1">

										<div class="first">
											<h3>'.$row["title"].'</h3>
										</div>

										<div class="cnt">
										'.$row["discription"].'
										</div>

										<div class="last">
											<a href="read_more.php?id='.$row['id'].'">read more</a>
										</div>

									</div>');
								}
								
							}
							mysqli_free_result($result);
						}
						mysqli_close($db);
                    ?>

			    </div>       
        </div>
    </div>
</body>
</html>