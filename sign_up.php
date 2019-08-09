<?php 
    session_start();
    include_once'connection.php';
    $db=mysqli_connect($servername,$username,$password,$dbname);
    if($db->connect_error){
        die("connection failed:".$db);
    }
    
    if(isset($_POST['submit'])&&($_POST['password']===$_POST['confirm_pass'])){
        
        $user_name=$_POST['user_name'];
        $user_mail_id=$_POST['user_mail_id'];
        $confirm_pass=$_POST['confirm_pass'];
        $hash_pass = password_hash($confirm_pass,PASSWORD_DEFAULT);//encrypt the password
        $first_name=$_POST['first_name'];
        $last_name=$_POST['last_name'];

        $query="INSERT INTO users(user_name,user_mail_id,confirm_pass,first_name,last_name) VALUES('$user_name','$user_mail_id','$hash_pass','$first_name','$last_name')";
        mysqli_query($db,$query);
        header('location:sign_in.php');

    }
    if(isset($_POST['submit'])&&($_POST['password']!=$_POST['confirm_pass'])){
        header('location:sign_up.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>sign_up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="sign_in.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="signup__box">
        <div class="header">
                <h2>Sign up</h2>
        </div>
        <form  method="post" action="signup_details.php">
            <div class="input-group">
                <p class="fa fa-user-o">   First Name</p>
                <input type="text" name="first_name" placeholder="First Name">
            </div>  
            <div class="input-group">          
                    <p class="fa fa-user-o">   Last Name</p>
                    <input type="text" name="last_name" placeholder="Last Name">
            </div>
            <div class="input-group">
                <p class="fa fa-user-o">  User Name</p>
                <input type="text" name="user_name" placeholder="User name">
            </div>

            <div class="input-group">
			    <p class="fa fa-envelope-open-o"> Email</p>
                <input type="email" name="user_mail_id" placeholder="Email Id">
            </div>

            <div class="input-group">
                <p class="fa fa-key"> Password</p>
                <input type="password" name="password" placeholder="password" id="pass" >
            </div>
            <div class="input-group">
			    <p class="fa fa-thumbs-o-up">  Confirm Password</p>
                <input type="password" name="confirm_pass" placeholder="Password" id="cnfirm_pass">
            </div>
            
            <div class="input-group">
                <input  type="checkbox" required>I agree with all terms and condition.
            </div> 
            

            <div class="input-group">
                <input  type="submit" name="submit" value="Submit" onclick="validate()">
            </div>

            
		</form>
    </div>
    
	<script>
        function validate(){

            var a = document.getElementById("pass").value;
            var b = document.getElementById("cnfirm_pass").value;
            if (a!=b){
               alert("Passwords do no match");
               return false;
            }
        }
     </script>
</body>


</html>