<?php

	session_start();
    unset($_SESSION['blad']);
    unset($_SESSION['e_Imie']);
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
    if(isset($_POST['mail']))
    {
        //udana walidacja
        $OK=true;

        //nazwa Domu
        $name = $_POST['name'];

        //length of nick
        if ((strlen($name)<3) || (strlen($name)>20))
        {
            $OK=false;
            $_SESSION['e_nick']="Name of house must have from 3 to 20 signs!";
        }

        if(ctype_alnum($name)==false)
        {
            $OK=false;
            $_SESSION['e_nick']="Name of house should contain only letters and numbers without Polish signs!";
        }

        

        // check Addresss 

        $address = $_POST['address'];

        if ((strlen($address)<3) || (strlen($address)>1000))
        {
            $OK=false;
            $_SESSION['e_address']="Address must have from 3 to 1000 signs!";
        }

        //check number phone
        $phone = $_POST['phone_number'];


        if (strlen($phone)!=9) 
        {
            $OK=false;
            $_SESSION['e_phone']="Phone number must have 9 numbers";
        }

        if(ctype_alnum($phone)==false)
        {
            $OK=false;
            $_SESSION['e_phone']="Phone number must contain only numbers";
        }

        if(is_numeric($phone)==false)
        {
            $OK=false;
            $_SESSION['e_phone']="Phone number must contain only numbers";
        }
        //check number phone
        $phone2 = $_POST['phone_number2'];


        if (strlen($phone2)!=9) 
        {
            $OK=false;
            $_SESSION['e_phone2']="Phone number must have 9 numbers";
        }

        if(ctype_alnum($phone2)==false)
        {
            $OK=false;
            $_SESSION['e_phone2']="Phone number must contain only numbers!)";
        }

        if(is_numeric($phone2)==false)
        {
            $OK=false;
            $_SESSION['e_phone2']="Phone number must contain only numbers!)";
        }


        //Imie
        $Imie = $_POST['Imie'];

        //length of nick
        if ((strlen($Imie)<3) || (strlen($Imie)>20))
        {
            $OK=false;
            $_SESSION['e_Imie']="Name must have from 3 to 20 signs!";
        }

        if(ctype_alpha($Imie)==false)
        {
            $OK=false;
            $_SESSION['e_Imie']="Name must contain only letters";
        }


        //Imie
        $nazwisko = $_POST['nazwisko'];

        //length of nazwisko
        if ((strlen($nazwisko)<3) || (strlen($nazwisko)>30))
        {
            $OK=false;
            $_SESSION['e_nazwisko']="Surname must have from 3 to 20 signs!";
        }

        if(ctype_alpha($nazwisko)==false)
        {
            $OK=false;
            $_SESSION['e_nazwisko']="Surname must contain only letters";
            
        }

        //miesiac dzien
        $Year = $_POST['Year'];
        $Month = $_POST['Month'];
        $Days = $_POST['Days'];
 

        if ((($Month!='Styczen')||($Month!='Marzec')||($Month!='Maj')||($Month!='Lipiec')||($Month!='Sierpien')||($Month!='Pazdziernik')||($Month!='Grudzien'))&&($Days==31))
        {
            $OK=false;
            $_SESSION['e_Days']=$Month." Doesn't have ".$Days." Days";
        }

        
        if(is_numeric($Year)&&((!($Year % 4 == 0 && $Year % 100 != 0 || $Year % 400 == 0))&&$Days==29))
        {
            $OK=false;
            $_SESSION['e_Days']="If Year is leap ".$Month." Doesn't have ".$Days." Days";

        }


     

        $Month_sql;
        switch ($Month) {
            case "Month":
                $_SESSION['e_Days']="Fill month of birth";
                $Month_sql='00';
                $OK=false;
                break;
            case "Styczen":
                $Month_sql='01';
                break;
            case "Luty":
                $Month_sql='02';
                break;
            case "Marzec":
                $Month_sql='03';
                break;
            case "Kwiecien":
                $Month_sql='04';
                break;
            case "Maj":
                $Month_sql='05';
                break;
            case "Czerwiec":
                $Month_sql='06';
                break;
            case "Lipiec":
                $Month_sql='07';
                break;
            case "Sierpien":
                $Month_sql='08';
                break;
            case "Wrzesien":
                $Month_sql='09';
                break;
            case "Pazdziernik":
                $Month_sql='10';
                break;
            case "Listopad":
                $Month_sql='11';
                break;
            case "Grudzien":
                $Month_sql='12';
                break;
            }

        if(!is_numeric($Year))
        {
            $OK=false;
            $_SESSION['e_Days']="Fill Year of birth";
        }
        if ((($Month!='Styczen')&&($Month!='Luty')&&($Month!='Marzec')&&($Month!='Kwiecien')&&($Month!='Maj')&&($Month!='Czerwiec')&&($Month!='Lipiec')&&($Month!='Sierpien')&&($Month!='Wrzesien')&&($Month!='Pazdziernik')&&($Month!='Listopad')&&($Month!='Grudzien')))
        {
            $OK=false;
            $_SESSION['e_Days']="Fill Month of birth";
        }
        if(!is_numeric($Days))
        {
            $OK=false;
            $_SESSION['e_Days']="Fill day of birth";
        }

        $birthdate="{$Year}-{$Month_sql}-{$Days}";
        $inputdob=date("Y-m-d",strtotime($birthdate));
        
        



        $mail = $_POST['mail'];
        $mailB = filter_var($mail,FILTER_SANITIZE_EMAIL);

        if ((filter_var($mailB,FILTER_VALIDATE_EMAIL)==false) || ($mailB!=$mail))
        {
            $OK=false;
            $_SESSION['e_mail']="Enter correct address E-mail";
        }



        
        $login = $_POST['Login'];
        $loginB = filter_var($login,FILTER_SANITIZE_EMAIL);


        //length of nick
        if ((filter_var($loginB,FILTER_VALIDATE_EMAIL)==false) || ($loginB!=$login))
        {
            $OK=false;
            $_SESSION['e_login']="Enter correct address E-mail";
        }

        //Password

        $haslo1=$_POST['haslo1'];
        $haslo2=$_POST['haslo2'];

        //length of nick
        if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
        {
            $OK=false;
            $_SESSION['e_haslo']="Password must have from 8 to 20 signs!";
        }
        
        if($haslo1!=$haslo2)
        {
            $OK=false;
            $_SESSION['e_haslo']="Passwords do not equals!";
        }

        $haslo_hash = password_hash($haslo1,PASSWORD_DEFAULT);

        if(!isset($_POST['regulamin']))
        {
            $OK=false;
            $_SESSION['e_regulamin']="Accept terms of usage!";
        }

        $secret="6LeQ4XMUAAAAAN1jJX7wNmKYIG-pFQpGY-D1K6wj";

        $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);

        $response = json_decode($check);


        if($response->success==false)
        {
            $OK=false;
            $_SESSION['e_captcha']="Proove, You're not a robot!";
        }


        //pamietanie danych
        $_SESSION['fr_nick'] = $name ;
        $_SESSION['fr_address'] = $address ;
        $_SESSION['fr_phone'] = $phone ;
        $_SESSION['fr_phone2'] = $phone2 ;
        $_SESSION['fr_Imie'] = $Imie ;
        $_SESSION['fr_nazwisko'] = $nazwisko ;
        $_SESSION['fr_mail'] = $mail ;
        $_SESSION['fr_login'] = $login ;
        $_SESSION['fr_haslo'] = $haslo1 ;
        $_SESSION['fr_haslo2'] = $haslo2 ;

        if(isset($_POST['regulamin'])) $_SESSION['fr_regulamin']=true;



        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        try{

            $polaczenie = new mysqli($host,$db_user,$db_password,$db_name);
            if($polaczenie->connect_errno!=0)
            {
              throw new Exception(mysqli_connect_errno());
            }
            else{
                //mail w bazie?
                $result=$polaczenie->query("SELECT id From houses WHERE mail='$mail'");

                if(!$result) throw new Exception($polaczenie->error);
                $amount_mails = $result->num_rows;
                if($amount_mails>0)
                {
                    $OK=false;
                    $_SESSION['e_mail']="House with this address e-mail already exists!";
                }
                //login w bazie?
                $result=$polaczenie->query("SELECT id From users WHERE email='$login'");

                if(!$result) throw new Exception($polaczenie->error);
                $amount_mailsnick = $result->num_rows;
                if($amount_mailsnick>0)
                {
                    $OK=false;
                    $_SESSION['e_login']="Account with this address e-mail already exists!";
                }

                
                
                if($OK==true)
                {
                    //add house to data base


                    if($polaczenie->query("INSERT INTO houses VALUES (NULL, '$name','$address','$phone','$mail')"))
                    {
                        $houses_id=mysqli_query($polaczenie,"SELECT id FROM `houses` WHERE name='$name'");
                        $row = $houses_id->fetch_assoc();
        
                    }
                    else{

                        throw new Exception($polaczenie->error);

                        }
                    if($polaczenie->query("INSERT INTO users VALUES (NULL,'$login','$haslo_hash','$row[id]','$Imie','$nazwisko','$birthdate','$phone2',0,1,0)"))
                    {
                        $noneid=$row['id']*-1;
                        $password = randomPassword();
                        $pass_hash = password_hash($password,PASSWORD_DEFAULT);
                        $nonesql="INSERT INTO users VALUES ('$noneid','none$row[id]','$pass_hash','$row[id]','none','$nazwisko','$birthdate','$noneid',0,1,0)";
                        $polaczenie->query($nonesql);
                        $_SESSION['udanarejestracja']=true;
                        

                         header('Location: witamy.php');
                    }
                    else{
                        echo("$login,$haslo_hash,$count,$Imie,$nazwisko,$birthdate,$phone2");
                        throw new Exception($polaczenie->error);
    
                            }

                }


                $polaczenie->close();
            }

        }
        catch(Exception $e)
        {
            echo '<span style="color:red;">Internal server error, sorry something went wrong!</span>';
            echo '<br/> Informacja developreska: '.$e;
        }

      

    }

?>

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
     background: url(background.jpg) ;
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

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polanka - Create free account!</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <style>

        .error
        {
            color:red;
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>

</head>




<body style="background:url(tlo.jpg) ; width=100%; background-repeat:no-repeat;background-size:100% 100%;background-attachment: fixed">
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
    <form class="form" method="post">
    

        <input type="text" class="input" placeholder="House name" value="<?php
        if(isset($_SESSION['fr_nick']))
        {
            echo($_SESSION['fr_nick']);
            unset($_SESSION['fr_nick']);
        }
        ?>" name="name"/> <br/>

        <?php

            if(isset($_SESSION['e_nick']))
            {
                echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                unset($_SESSION['e_nick']);
            }
            

        ?>

        <input type="text" class="input" placeholder="Address"
        value="<?php
        if(isset($_SESSION['fr_address']))
        {
            echo($_SESSION['fr_address']);
            unset($_SESSION['fr_address']);
        }
        ?>" name="address"/> 

        <?php

            if(isset($_SESSION['e_address']))
            {
                echo '<div class="error">'.$_SESSION['e_address'].'</div>';
                unset($_SESSION['e_address']);
            }
            

        ?>
        <br/> <input type="text" class="input" placeholder="Landline number" value="<?php
        if(isset($_SESSION['fr_phone']))
        {
            echo($_SESSION['fr_phone']);
            unset($_SESSION['fr_phone']);
        }
        ?>"name="phone_number"/> <br/>
        <?php

            if(isset($_SESSION['e_phone']))
            {
                echo '<div class="error">'.$_SESSION['e_phone'].'</div>';
                unset($_SESSION['e_phone']);
            }
            

        ?>

        <input type="text" class="input" placeholder="Phone number" value="<?php
        if(isset($_SESSION['fr_phone2']))
        {
            echo($_SESSION['fr_phone2']);
            unset($_SESSION['fr_phone2']);
        }
        ?>"name="phone_number2"/> <br/>
        <?php

            if(isset($_SESSION['e_phone2']))
            {
                echo '<div class="error">'.$_SESSION['e_phone2'].'</div>';
                unset($_SESSION['e_phone2']);
            }
            

        ?>

        <input type="text" class="input" placeholder="Name" value="<?php
        if(isset($_SESSION['fr_Imie']))
        {
            echo($_SESSION['fr_Imie']);
            unset($_SESSION['fr_Imie']);
        }
        ?>" name="Imie"/> <br/>

        <?php

            if(isset($_SESSION['e_Imie']))
            {
                echo '<div class="error">'.$_SESSION['e_Imie'].'</div>';
                unset($_SESSION['e_imie']);
            }
            

        ?>

        <input type="text" class="input" placeholder="Surname" value="<?php
        if(isset($_SESSION['fr_nazwisko']))
        {
            echo($_SESSION['fr_nazwisko']);
            unset($_SESSION['fr_nazwisko']);
        }
        ?>" name="nazwisko"/> <br/>

        <?php

            if(isset($_SESSION['e_nazwisko']))
            {
                echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
                unset($_SESSION['e_nazwisko']);
            }
            

        ?>
        

        Date of Birth: 
        
        <select name = "Year" size="1">
        <option value="Year"> Year </option>
        <option value="2018">2018</option>
        <option value="2017">2017</option>
        <option value="2016">2016</option>
        <option value="2015">2015</option>
        <option value="2014">2014</option>
        <option value="2013">2013</option>
        <option value="2012">2012</option>
        <option value="2011">2011</option>
        <option value="2010">2010</option>
        <option value="2009">2009</option>
        <option value="2008">2008</option>
        <option value="2007">2007</option>
        <option value="2006">2006</option>
        <option value="2005">2005</option>
        <option value="2004">2004</option>
        <option value="2003">2003</option>
        <option value="2002">2002</option>
        <option value="2001">2001</option>
        <option value="2000">2000</option>
        <option value="1999">1999</option>
        <option value="1998">1998</option>
        <option value="1997">1997</option>
        <option value="1996">1996</option>
        <option value="1995">1995</option>
        <option value="1994">1994</option>
        <option value="1993">1993</option>
        <option value="1992">1992</option>
        <option value="1991">1991</option>
        <option value="1990">1990</option>
        <option value="1989">1989</option>
        <option value="1988">1988</option>
        <option value="1987">1987</option>
        <option value="1986">1986</option>
        <option value="1985">1985</option>
        <option value="1984">1984</option>
        <option value="1983">1983</option>
        <option value="1982">1982</option>
        <option value="1981">1981</option>
        <option value="1980">1980</option>
        <option value="1979">1979</option>
        <option value="1978">1978</option>
        <option value="1977">1977</option>
        <option value="1976">1976</option>
        <option value="1975">1975</option>
        <option value="1974">1974</option>
        <option value="1973">1973</option>
        <option value="1972">1972</option>
        <option value="1971">1971</option>
        <option value="1970">1970</option>
        <option value="1969">1969</option>
        <option value="1968">1968</option>
        <option value="1967">1967</option>
        <option value="1966">1966</option>
        <option value="1965">1965</option>
        <option value="1964">1964</option>
        <option value="1963">1963</option>
        <option value="1962">1962</option>
        <option value="1961">1961</option>
        <option value="1960">1960</option>
        <option value="1959">1959</option>
        <option value="1958">1958</option>
        <option value="1957">1957</option>
        <option value="1956">1956</option>
        <option value="1955">1955</option>
        <option value="1954">1954</option>
        <option value="1953">1953</option>
        <option value="1952">1952</option>
        <option value="1951">1951</option>
        <option value="1950">1950</option>
        <option value="1949">1949</option>
        <option value="1948">1948</option>
        <option value="1947">1947</option>
        <option value="1946">1946</option>
        <option value="1945">1945</option>
        <option value="1944">1944</option>
        <option value="1943">1943</option>
        <option value="1942">1942</option>
        <option value="1941">1941</option>
        <option value="1940">1940</option>
        <option value="1939">1939</option>
        <option value="1938">1938</option>
        <option value="1937">1937</option>
        <option value="1936">1936</option>
        <option value="1935">1935</option>
        <option value="1934">1934</option>
        <option value="1933">1933</option>
        <option value="1932">1932</option>
        <option value="1931">1931</option>
        <option value="1930">1930</option>
        <option value="1929">1929</option>
        <option value="1928">1928</option>
        <option value="1927">1927</option>
        <option value="1926">1926</option>
        <option value="1925">1925</option>
        <option value="1924">1924</option>
        <option value="1923">1923</option>
        <option value="1922">1922</option>
        <option value="1921">1921</option>
        <option value="1920">1920</option>
        </select>

        <select name = "Month">
        <option value="Month">Month</option>
        <option value="Styczen">January</option>
        <option value="Luty">February</option>
        <option value="Marzec">March</option>
        <option value="Kwiecien">April</option>
        <option value="Maj">May</option>
        <option value="Czerwiec">June</option>
        <option value="Lipiec">July</option>
        <option value="Sierpien">August</option>
        <option value="Wrzesien">September</option>
        <option value="Pazdziernik">October</option>
        <option value="Listopad">November</option>
        <option value="Grudzien">December</option>
        </select>
        
        <select name = "Days">
        <option value="Days"> Day </option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
        <option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>
        <option value="31">31</option>
        </select>  <br/>

        <?php

            if(isset($_SESSION['e_Days']))
            {
                echo '<div class="error">'.$_SESSION['e_Days'].'</div>';
                unset($_SESSION['e_Days']);
            }
            

        ?>
        

        

        <br/><input type="text" class="input" placeholder="House E-Mail" value="<?php
        if(isset($_SESSION['fr_mail']))
        {
            echo($_SESSION['fr_mail']);
            unset($_SESSION['fr_mail']);
        }
        ?>" name="mail"/> <br/>

              <?php

            if(isset($_SESSION['e_mail']))
            {
                echo '<div class="error">'.$_SESSION['e_mail'].'</div>';
                unset($_SESSION['e_mail']);
            }
            

        ?>
        <input type="text" class="input" placeholder="Admin Mail" value="<?php
        if(isset($_SESSION['fr_login']))
        {
            echo($_SESSION['fr_login']);
            unset($_SESSION['fr_login']);
        }
        ?>"name="Login"/> <br/>

        <?php

            if(isset($_SESSION['e_login']))
            {
                echo '<div class="error">'.$_SESSION['e_login'].'</div>';
                unset($_SESSION['e_login']);
            }
            

        ?>

        <input type="password"class="input" placeholder="Password" value="<?php
        if(isset($_SESSION['fr_haslo']))
        {
            echo($_SESSION['fr_haslo']);
            unset($_SESSION['fr_haslo']);
        }
        ?>"name="haslo1"/> <br/>
        <?php

            if(isset($_SESSION['e_haslo']))
            {
                echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
                unset($_SESSION['e_haslo']);
            }
            

        ?>
        <input type="password" class="input" placeholder="Repeat Password" value="<?php
        if(isset($_SESSION['fr_haslo2']))
        {
            echo($_SESSION['fr_haslo2']);
            unset($_SESSION['fr_haslo2']);
        }
        ?>"name="haslo2"/> <br/>

        
        <label>
        <input type="checkbox" name="regulamin" <?php 
        if(isset($_SESSION['fr_regulamin'])){
            echo "checked";
            unset($_SESSION['fr_regulamin']);
        }
        
        ?>/>Accept terms of usage <a href="https://www.gov.pl/web/cyfryzacja/rodo-informacje">More info here</a>
        </label>
        <?php

            if(isset($_SESSION['e_regulamin']))
            {
                echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                unset($_SESSION['e_regulamin']);
            }
            

        ?>
        <div class="g-recaptcha" data-sitekey="6LeQ4XMUAAAAAP7udKHb6k0X4dOa3I6c3sIVanNB"></div>
        <?php

            if(isset($_SESSION['e_captcha']))
            {
                echo '<div class="error">'.$_SESSION['e_captcha'].'</div>';
                unset($_SESSION['e_captcha']);
            }
            

        ?>
        <br/>

        <input type="submit" class="btn" value="Zarejestruj się"/> 
        <a href="index.php">Cofnij</a>
        <br  /><br/>



    </form>

</body>

</html>