<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
$mail2 = new PHPMailer(true);                              // Passing `true` enables exceptions
function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

    session_start();
    if(!isset($_POST['mail']))
    {
        header('Location: reminder.php');
        exit();
    }

    require_once "connect.php";

    $polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
    $polaczenie->query('set character_set_server=utf8');
    $polaczenie->query('set character_set_client=utf8');
    $polaczenie->query('set character_set_connection=utf8');
    $polaczenie->query('set character_set_results=utf8');
    $polaczenie->query('set character_set_server=utf8');
    if($polaczenie->connect_errno!=0)
    {
        echo "Error:".$polaczenie->connect_errno;
    }
    else
    {
        $mail = $_POST['mail'];
        $mail=htmlentities($mail);
        $mail = mysqli_real_escape_string($polaczenie, $mail);

        if($result = @$polaczenie->query(
            sprintf("SELECT * FROM users WHERE BINARY email='%s' ",
            mysqli_real_escape_string($polaczenie,$mail))))
        {
            echo 'coś';

            $amount_user=$result->num_rows;
            if($amount_user>0)
            {
                $row = $result->fetch_assoc();

                try {
                    //Server settings
                    // $mail2->SMTPDebug = 2;                                 // Enable verbose debug output
                    $mail2->IsSMTP();
                    $mail2->SMTPDebug = 0;
                    $mail2->SMTPAuth = true;  // Gmail requires authentication
                    $mail2->SMTPSecure = 'ssl'; // Gmail requires SSL connection
                    $mail2->Host = 'smtp.googlemail.com';
                    $mail2->Port = 465; 
                    $mail2->Username = "asaromaro@gmail.com"; // <-- Update this with your GMail username  
                    $mail2->Password = "Mniszek5900";

                    //Recipients
                    $mail2->setFrom('asaromaro@gmail.com', 'Polanka');
                    $mail2->addAddress($mail);     // Add a recipient
                    $password = randomPassword();
                    $pass_hash = password_hash($password,PASSWORD_DEFAULT);
                    $id=$row['id'];
                    $sql ="UPDATE users SET user_password = '$pass_hash' WHERE email='$mail'";
                    $polaczenie->query($sql);
                    $body='<p><strong>Hello</strong>Your Password is: '.$password.'</p';


                    //Content
                    $mail2->isHTML(true);                                  // Set email format to HTML
                    $mail2->Subject = 'Your Password has been reset';
                    $mail2->Body    = $body;
                    $mail2->AltBody = strip_tags($body);
                
                    $mail2->send();

                    echo "<script>
                    alert('The mail has been correctly reset check Your mail for new password');
                    window.location.href='index.php';
                    </script>";

                } catch (Exception $e) {
                    echo 'Message could not be sent. Mailer Error: ', $mail2->ErrorInfo;

                }
                
            }
            else {
				
				$_SESSION['blad'] = '<span style="color:red">Uncorrect email!</span>';
				header('Location: reminder.php');
				
			}
                

        }

        $polaczenie->close();
    }

    

    


?>

