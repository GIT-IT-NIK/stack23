<?php

session_start();

$email = $_POST["r_email"];
$name = $_POST["name"];
$phone = $_POST["phone"];
$gender = $_POST["gender"];
$ogname = $_POST["ogname"];
$ieee_no = $_POST["ieee_no"];
$member_type = $_POST["member_type"];
$wie_no = $_POST["wie_no"];
$location = $_POST["location"];


echo $email."</br>";
echo $name."</br>";
echo $phone."</br>";
echo $gender."</br>";
echo $ogname."</br>";
echo $ieee_no."</br>";
echo $member_type."</br>";
echo $wie_no."</br>";
echo $location."</br>";

$_SESSION['NAME']=$name;
$_SESSION['EMAIL']=$email;
$_SESSION['PHONE']=$phone;

function Redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);

    exit();
}

 $conn = mysqli_connect("us-cdbr-east-03.cleardb.com", "bb43ac196f9c5b", "e2c1f8bd", "users");
          
        if($conn === false){
            die("ERROR: Could not connect. " 
                . mysqli_connect_error());
        }

        $sql = "INSERT INTO users  VALUES ('$email', 
            '$name','$phone','$gender','$ogname','$ieee_no','$member_type', '$wie_no', '$location')";
          
        if(mysqli_query($conn, $sql)){
              redirect('checkout.php', false);
            

        } else{
            echo "ERROR: Hush! Sorry $sql. " 
                . mysqli_error($conn);
        }
          

        mysqli_close($conn);

?>
