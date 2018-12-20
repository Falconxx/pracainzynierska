<?php

	session_start();
	


?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no"/>
    <title>Polanka - Log in</title>
    <link rel="stylesheet" href="style.css">
</head>

<style>
*{
      margin: 0;
      padding: 0;
    }
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

<body >
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>
<script>
window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#efefef",
      "text": "#5c7291"
    },
    "button": {
      "background": "#56cbdb",
      "text": "#ffffff"
    }
  },
  "theme": "classic",
  "position": "top",
  "static": true,
    "content": {
    "href": "https://pl.wikipedia.org/wiki/HTTP_cookie"
  }
})});
</script> 
        <p>    Polanka <br/>
            Zarządzaj swoim domem jak nigdy dotąd</p>
    <br  /><br/>

    

    

    <form class="form" action="remind.php" method="post">

        <br/><input type="text" class="input" placeholder="Mail" name="mail"><br/>
        <input type="submit" value="Remind Me" class="btn"/>  
        <?php
        echo ' [<a style="text-align:right" href="index.php">Back</a>]';
        ?>
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