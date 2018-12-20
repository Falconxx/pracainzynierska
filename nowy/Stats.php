<?php


session_start();
if (!(isset($_SESSION['zalogowany'])) && !($_SESSION['zalogowany']==true))
{
    header('Location: index.php');
}
unset($_SESSION['blad']);
require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);
$houses_id=$_SESSION['houses_id'];
$id=$_SESSION['id'];
$sql="SELECT * FROM users where house_id=$houses_id";
$polaczenie = new mysqli($host,$db_user,$db_password,$db_name);
// $polaczenie->query("SET NAMES utf8");

$polaczenie->query('set character_set_server=utf8');
$polaczenie->query('set character_set_client=utf8');
$polaczenie->query('set character_set_connection=utf8');
$polaczenie->query('set character_set_results=utf8');
$polaczenie->query('set character_set_server=utf8');
$records=$polaczenie->query($sql);
$usersql="SELECT name FROM users where id=$houses_id*-1 or id=$id ";
$usertable=$polaczenie->query($usersql);
while( $user=$usertable->fetch_assoc() ) {
    foreach( $user  AS $value ) {
        $clmNames[] = $value;
    }
}
$numberofusers = count($clmNames);
try{

    $polaczenie = new mysqli($host,$db_user,$db_password,$db_name);
    if($polaczenie->connect_errno!=0)
    {
      throw new Exception(mysqli_connect_errno());
    }
    else{
        //mail w bazie?
        $result=$polaczenie->query("SELECT name From houses WHERE id='$houses_id'");
        
    }
}
    catch(Exception $e)
    {
        echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestracje w innym terminie!</span>';
        echo '<br/> Informacja developreska: '.$e;
    }
$house_name=$result->fetch_assoc();



?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no"/>
    <meta name="description" content="Opis strony"/>
    <link href="css/bootstrap.css" rel="stylesheet"/>
    <link href="css/font-awesome.css" rel="stylesheet"/>
    <link rel="stylesheet" href="style2.css">

   <style>
@import url('https://fonts.googleapis.com/css?family=Slabo+27px&subset=latin-ext');

</style >
    <title>Polanka - Zarządzaj swoim domem jak nigdy dotąd </title>
    <!-- <link rel="stylesheet" href="style2.css"> -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

          <?php
$prices="SELECT user_id, SUM(price) as sum_of_price FROM list_of_order WHERE user_id!=$houses_id*-1 and house_id=$houses_id GROUP BY user_id";
$query = $polaczenie->query($prices); 

while ($row = $query->fetch_object()) { 
    $me2[$row->user_id]['user_id'] = $row->sum_of_price;
    // $me2[$row->user_id]['sum_of_price'] = $row->member_id;
} 
foreach($me2 as $key => $value) {
    // echo "klucz";
    // echo $key;
    // echo "wartość";
    // echo $value['user_id'];

    // echo $value['sum_of_price'];
}
          ?>


        var data = google.visualization.arrayToDataTable([
            ['User', 'Money'],

            <?php
            $polaczenie->query('set character_set_server=utf8');
            $polaczenie->query('set character_set_client=utf8');
            $polaczenie->query('set character_set_connection=utf8');
            $polaczenie->query('set character_set_results=utf8');
            $polaczenie->query('set character_set_server=utf8');
            foreach($me2 as $key => $value) {
                $quera="SELECT name FROM users where id=$key";
                $usn=$polaczenie->query($quera);
                $username=$usn->fetch_assoc();

                ?>
           
           ['<?php echo $username['name'] ?>',     <?php echo $value['user_id']; ?>],
          <?php
            }
                ?>
        ]);
  <?php
$prices="SELECT user_id, SUM(effort_hours) as sum_effort_hours FROM list_of_order WHERE user_id!=$houses_id*-1 and house_id=$houses_id GROUP BY user_id";
$query = $polaczenie->query($prices); 

while ($row = $query->fetch_object()) { 
    $me2[$row->user_id]['user_id'] = $row->sum_effort_hours;
    // $me2[$row->user_id]['sum_of_price'] = $row->member_id;
} 
foreach($me2 as $key => $value) {
    // echo "klucz";
    // echo $key;
    // echo "wartość";
    // echo $value['user_id'];

    // echo $value['sum_of_price'];
}
          ?>
         var data2 = google.visualization.arrayToDataTable([
            ['User', 'Effort Hours'],

            <?php
            $polaczenie->query('set character_set_server=utf8');
            $polaczenie->query('set character_set_client=utf8');
            $polaczenie->query('set character_set_connection=utf8');
            $polaczenie->query('set character_set_results=utf8');
            $polaczenie->query('set character_set_server=utf8');
            foreach($me2 as $key => $value) {
                $quera="SELECT name FROM users where id=$key";
                $usn=$polaczenie->query($quera);
                $username=$usn->fetch_assoc();

                ?>
            
          ['<?php echo $username['name'] ?>',     <?php echo $value['user_id']; ?>],
          <?php
            }
                ?>
        ]);


        var options = {
            backgroundColor: 'transparent',
          title: 'My Daily Activities'
        };

        var options2 = {
            backgroundColor: 'transparent',
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart')).
      draw(data, {title:"Money Spend on House",
        backgroundColor: 'transparent',
                 sliceVisibilityThreshold:0,
                 pieSliceText: 'value'
                 });;
        var chart2 = new google.visualization.PieChart(document.getElementById('piechart2')).
      draw(data2, {title:"Hours Spend on House",
        backgroundColor: 'transparent',
                 sliceVisibilityThreshold:0,
                 pieSliceText: 'value'
                 });;         

        chart.draw(data, options);
        chart.draw(data2, options2);

      }
    </script>

</head>
<body>
    
    <div class="container" id="container">
    <p>
    <?php
            // echo '<span style="color: white; font-size: 20px;">Welcome ' . $_SESSION['something'] .  ', <a href="something.php">something</a></span>';

echo "<p style='text-align:right'>".' [<a href="logout.php">Wyloguj się!</a>]</p>';

?>
<br/>

</p>
    <header>  
        
        <div class="title" >      
       <h1>Polanka</h1>
            </div>
        <nav>
            <div class="cos">
        <ul>

        <li class="NewOrder"><a href="NewOrder.php"><span>New Order</span></a></li>
        <li class="MyOrders"><a href="MyOrders.php"><span>My Orders</span></a></li>    
        <li class="ListOfOrder"><a href="ListOfOrders.php"><span>List Of Orders</span></a></li>
        <li class="HistoryOfOrders"><a href="HistoryOfOrders.php"><span>History Of Orders</span></a></li>
        <li class="Storage"><a href="Storage.php"><span>Storage</span></a></li>
        <li class="Graphic"><a href="Stats.php"><span>Summary</span></a></li>
        <li class="Users"><a href="Users.php"><span>Users</span></a></li>
        </ul>       
        </div>
        <div class="select-field">

        
        <select name="sectional_nav" id="sectional_nav" class="form-control hidden-md-up" onchange="window.location.href=this.value">
        <option value="NewOrder.php">New Order</option>
        <option value="MyOrders.php">My Orders</option>    
        <option value="ListOfOrders.php">List Of Orders</option>
        <option value="HistoryOfOrders.php">History Of Orders</option>
        <option value="Storage.php">Storage</option>
        <option value="Stats.php">Summary</option>
        <option selected="selected" value="Users.php">Users</option>
        </select>
        </div>
        </nav>
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
    </header>
        <div class="content">
            <div class="main-content">
    <section>
        <article  id="html">
<!-- <p>    Polanka - Zarządzaj swoim domem jak nigdy dotąd </p> -->
<div id="piechart"  style=" width: 50%; height: 500px;float: left;"></div>
<div id="piechart2"  style="width: 50%; height: 500px;float: right;"></div>


</body>
</html>
