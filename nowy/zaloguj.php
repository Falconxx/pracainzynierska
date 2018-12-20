<?php

    session_start();
    if(!isset($_POST['mail'])&&!isset($_POST['haslo']))
    {
        header('Location: index.php');
        exit();
    }

    require_once "connect.php";

    $polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);

    if($polaczenie->connect_errno!=0)
    {
        echo "Error:".$polaczenie->connect_errno;
    }
    else
    {
        $mail = $_POST['mail'];
        $haslo = $_POST['haslo'];
        $mail=htmlentities($mail,ENT_QUOTES,UTF-8);

        
        if($result = @$polaczenie->query(
        sprintf("SELECT * FROM users WHERE BINARY email='%s' ",
        mysqli_real_escape_string($polaczenie,$mail))))
        {
            $amount_user=$result->num_rows;
            if($amount_user>0)
            {

                $row = $result->fetch_assoc();

                if(password_verify($haslo,$row['user_password']))
                {

                $_SESSION['zalogowany'] = true;
                $_SESSION['id']=$row['id'];
                $_SESSION['mail'] = $row['email'];
                $_SESSION['houses_id'] = $row['houses_id'];

                unset($_SESSION['blad']);
                $result->close();

                header('Location: gra.php');
                }
                else{

                    $_SESSION['blad'] = '<span style="color:red">Uncorrect email or password!</span>';
				    header('Location: index.php');
               
                }
                
            }
            else {
				
				$_SESSION['blad'] = '<span style="color:red">Uncorrect email or password!</span>';
				header('Location: index.php');
				
			}
                

        }

        $polaczenie->close();
    }

    

    


?>

