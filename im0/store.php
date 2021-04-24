<?php
if(isset($_POST['submitX'])){
        session_start();

        $email = $_POST["r_email"];
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $gender = $_POST["gender"];
        $ogname = $_POST["ogname"];
        $ieee_no = null;
	$member_type = null;
	$wie_no = null;
	$location = null;

        $_SESSION['NAME']=$name;
        $_SESSION['EMAIL']=$email;
        $_SESSION['PHONE']=$phone;
	
	date_default_timezone_set('Asia/Kolkata');
	$date = date('Y/m/d H:i:s');

        function Redirect($url, $permanent = false)
        {
            header('Location: ' . $url, true, $permanent ? 301 : 302);

            exit();
        }

         $conn = mysqli_connect("us-cdbr-east-03.cleardb.com", "bb43ac196f9c5b", "e2c1f8bd", "heroku_b860fd6b42d3963");

                if($conn === false){
                    die("ERROR: Could not connect. " 
                        . mysqli_connect_error());
                }

                $sql = "INSERT INTO users  VALUES ('$email', 
                    '$name','$phone','$gender','$ogname','$ieee_no','$member_type', '$wie_no', '$location', '$date')";

                if(mysqli_query($conn, $sql)){
                      redirect('checkout.php', false);


                } else{
                    echo "ERROR: Hush! Sorry $sql. " 
                        . mysqli_error($conn);
                }


                mysqli_close($conn);
        }
    else{
        echo "Invalid Request";
    }
?>
