<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: gra.php');
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Polanka - Log in</title>
    <link rel="stylesheet" href="style.css">
</head>

<style>
.btn{
    font-family: "Roboto",sans-serif;
    text-transform: uppercase;
    outline: 0;
    background: #0070BA;
    border: 0;
    width:100%;
    padding: 15px;
    color: #ffffff;
    font-size: 14px;
    cursor: pointer;
}
.form{
     position: relative;
     z-index: 1;
     background: rgba(255,255,255,0.6);
     max-width: 360px;
     margin: 0 auto 100px;
     padding: 15px;
 }
.input{
    font-family: "Roboto", sans-serif;
    outline: 1;
    background: #f2f2f2;
    width: 100%;
    border: 0;
    margin: 0 0 15px;
    padding: 15px;
    box-sizing: border-box;
    font-size: 14px;
}
</style>

<body style="background:url(tlo.jpg) ;background-repeat:no-repeat;background-size:100% 100%;background-attachment: fixed">

    "Only the stupid need organization,the genius controls the chaos!" - Albert Einstein
    <br  /><br/>

    

    

    <form class="form" action="zaloguj.php" method="post">

        <br/><input type="text" class="input" placeholder="Mail" name="mail"><br/>
        <br/><input type="password" class="input" placeholder="Password" name="haslo"><br/><br/>
        <input type="submit" value="Log in" class="btn"/>    
    
    <a href="rejestracja.php">Don't Have an account? Register</a>
    <br/>

    <?php
   if (isset($_SESSION['blad']))
   {
		echo $_SESSION['blad'];
        unset($_SESSION['blad']);
    }
    ?>
    <br  /><br/>
  
    </form>

   

</body>

</html>