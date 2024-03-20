<?php

$firstname = $_POST['firstname'];
$email  = $_POST['email'];
$password = $_POST['password'];
$mobile = $_POST['mobile'];




if (!empty($firstname) || !empty($email) || !empty($password) || !empty($password) )
{

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "skillstream";



// Create connection
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()){
  die('Connect Error ('. mysqli_connect_errno() .') '
    . mysqli_connect_error());
}
else{
  $SELECT = "SELECT email From register Where email = ? Limit 1";
  $INSERT = "INSERT Into register (firstname , email , password , mobile )values(?,?,?,?)";

//Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $stmt->bind_result($email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;

     //checking username
      if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("sssi", $firstname,$email,$password,$mobile);
      $stmt->execute();
      echo "Your Account is Created Successully";
     } else {
      echo "Someone already registered using this email";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All field are required";
 die();
}
?>