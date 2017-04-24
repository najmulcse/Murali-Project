<?php 
include "php/dbConnection.php";
	
	function signin_checking(){

	global $connection;
		      $error=false;
          $msg="";
		     $email = $_POST['email'];
         $password = $_POST['password'];
         $email = mysqli_real_escape_string($connection,$email);
         $password = mysqli_real_escape_string($connection,$password);

         if(empty($email)){
                $error=true;
                $msg = "Please enter your  username.";

            }


            if (empty($password)){
                $error = true;
                $msg = "Please enter password.";
            }

            if(!$error)
            {
            	$hashFormat = "$2y$10$";
                $salt = "iusesomecrazystrings22";
                $hashF_and_salt = $hashFormat . $salt;
                $password = crypt($password, $hashF_and_salt);
                $query = "SELECT email,password from users where email='$email'";
                $query_email_result = mysqli_query($connection,$query);
                $row=mysqli_fetch_array($query_email_result);
                $count_user =mysqli_num_rows($query_email_result);
                   if($count_user ==1 && $row['password']==$password){
                     echo  $_SESSION['email']=$row['email'];
                       header("Location: index.php");
                      }
                   else
                       {
                       $msg = "Wrong username or password, Try again...";
                       }

                       return $msg;

            }
		

	}



	function registration()
	{
		// Signup form action is here
    global $connection;
        $error=false;
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        
        $email = mysqli_real_escape_string($connection,$email);
        $password = mysqli_real_escape_string($connection,$password);
		$confirm_password = mysqli_real_escape_string($connection,$confirm_password);
          // check username exist or not

            if(empty($email)){
                $error=true;
                $emailError = "Please enter your  email.";

            }
            else {

                $query = "SELECT email from users where email='$email'";
                $query_email_result = mysqli_query($connection,$query);
                $check_email =mysqli_num_rows($query_email_result);
                if($check_email!=0){
                    $error = true;
                    $emailError = "Provided Username is already in use.";
                }

            }

      // password validation
          if (empty($password)){
              $error = true;
              $passError = "Please enter password.";
          } else if(strlen($password) < 6) {
              $error = true;
              $passError = "Password must have atleast 6 characters.";
          }
        if (empty($confirm_password)){
            $error = true;
            $passError = "Please enter password.";
        } else if($password != $confirm_password) {
            $error = true;
            $conf_passError = "Password does not match";
        }

            if(!$error){



                        $hashFormat = "$2y$10$";
                        $salt = "iusesomecrazystrings22";
                        $hashF_and_salt = $hashFormat . $salt;
                        $password = crypt($password, $hashF_and_salt);
                        $query="INSERT INTO users(email,password)";
                        $query.="values('$email','$password')";
                        $query_insert_result = mysqli_query($connection,$query);
                        if($query_insert_result)
                        {
                            $errorType = "Success";
                            $errorMSG = "Successfully registered, you may login now";                            
                            header("Location: AdminPage.php");

                        }
                        else
                        {
                            $errorType = "Danger";
                            $errorMSG = "Something went wrong, try again later...";
                        }

                    }










	}


?>