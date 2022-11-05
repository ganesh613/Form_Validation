<?php 
session_start();
//------ PHP code for User registration form---
$error = "";
$error2="";
if (array_key_exists("signUp", $_POST)) {
 
     // Database Link
    include('config.php');  
 
    //Taking HTML Form Data from User
    $name = mysqli_real_escape_string($linkDB, $_POST['name']);
    $email = mysqli_real_escape_string($linkDB, $_POST['email']);
    $password = mysqli_real_escape_string($linkDB,  $_POST['password']); 
    $repeatPassword = mysqli_real_escape_string($linkDB,  $_POST['repeatPassword']); 
     
    // PHP form validation PHP code
    // here name is id number field
    if (!$name ) {
      $error .= "Name is required <br>";
     }
    if(!str_starts_with($name, "S")){
      $error .= "ID must starts with 'S' <br>";  
    }
    if (!$email) {
        $error .= "Email is required <br>";
     }
     if (!str_ends_with($email, "rguktsklm.ac.in")) {
        $error .= "only rguktsklm.ac.in domain is allowed<br>";
     }
    if (!$password) {
        $error .= "Password is required <br>";
        
     }

     if ($password !== $repeatPassword) {
        $error .= "Password does not match <br>";
     }
     if ($error) {
        $error = "<b>There were error(s) in your form!</b> <br>".$error;
     }  else {
       
        //Check if email is already exist in the Database
 
        $query = "SELECT id FROM details WHERE email = '$email'";
        $result = mysqli_query($linkDB, $query);
        if (mysqli_num_rows($result) > 0) {
            $error .="<p>Your email has taken already!</p>";
        } else {

            //Password encryption or Password Hashing
            // $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
            $hashedPassword=md5($password);

            $query = "INSERT INTO details (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";
             
            if (!mysqli_query($linkDB, $query)){
                $error ="<p>Could not sign you up - please try again.</p>";
                } else {
 
                    //session variables to keep user logged in
                $_SESSION['id'] = mysqli_insert_id($linkDB);  
                $_SESSION['name'] = $name;
 
                //Setcookie function to keep user logged in for long time
                if ($_POST['stayLoggedIn'] == '1') {
                setcookie('id', mysqli_insert_id($linkDB), time() + 60*60*365);
                //echo "<p>The cookie id is :". $_COOKIE['id']."</P>";
                }
                  
                //Redirecting user to home page after successfully logged in 
                header("Location: login.php");  
             
                }
             
            }
 
        }  
    }
 
      //-------User Login PHP Code ------------
 
if (array_key_exists("logIn", $_POST)) {
     
    // Database Link
    include('config.php'); 
 
      //Taking form Data From User
      $email = mysqli_real_escape_string($linkDB, $_POST['email']);
      $password = mysqli_real_escape_string($linkDB,  $_POST['password']); 
      $hashedPassword = md5($password);
      //Check if input Field are empty
      if (!$email) {
          $error2 .= "Email is required <br>";
       }
      if (!$password) {
          $error2 .= "Password is required <br>";
       } 
       if ($error2) {
          $error2 = "<b>There were error(s) in your form!</b><br>".$error2;
       }
        
      else {        
          //matching email and password
 
            $query = "SELECT * FROM details WHERE email='$email'";
            $result = mysqli_query($linkDB, $query);
            $row = mysqli_fetch_array($result);
            // echo $hashedPassword."<br/>";
            // echo $row['password']."<br/>";
            if (isset($row)) {
                 
                if (($hashedPassword ==$row['password'])) {
 
                        //session variables to keep user logged in
                    // $_SESSION['id'] = $row['id'];  
 
                    //   //Logged in for long time untill user didn't log out
                    // if ($_POST['stayLoggedIn'] == '1') {
                    // setcookie('id', $row['id'], time() + 60*60*24); //Logged in permanently
                    // }
                    
                    header("Location: LoggedInPage.php");
 
                } else {
                    $error2 = "Combination of email/password does not match!";
                     }
   
            }  else {
                $error2 = "Combination of email/password does not match!";
                 }
        }
}

//PHP code to logout user from website
 
  // if (isset($_GET["logout"])) {
  //   unset($_SESSION['id']);
  //   setcookie("id", "", time() - 3600);
  //   $_COOKIE['id'] = "";
  // } 

?>
