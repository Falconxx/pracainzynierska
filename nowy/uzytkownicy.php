<?php

session_start();
unset($_SESSION['blad']);
require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);
$houses_id=$_SESSION['houses_id'];
$id=$_SESSION['id'];
$sql="SELECT * FROM list_of_order where user_id=$id or user_id=$houses_id*-1";
$polaczenie = new mysqli($host,$db_user,$db_password,$db_name);
$records=$polaczenie->query($sql);
$usersql="SELECT name FROM users where id=$houses_id*-1 or id=$id ";
$usertable=$polaczenie->query($usersql);
while( $user=$usertable->fetch_assoc() ) {
    foreach( $user  AS $value ) {
        $clmNames[] = $value;
    }
}
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

if (!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}

?>
<!DOCTYPE html>

<html lang="en">
<?php

echo "<p>Witaj w domu ".$house_name['name']." jesteś zalogowany jako ".$_SESSION['email'].'! [<a href="logout.php">Wyloguj się!</a>]</p>';

?>
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Opis strony"/>
    <link href="css/bootstrap.css" rel="stylesheet"/>
    <link href="css/font-awesome.css" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css">

   <style>
@import url('https://fonts.googleapis.com/css?family=Slabo+27px&subset=latin-ext');

.ListaZlecen {
background: rgba(000,187,045,0.3);
}
.MojeZlecenia{
background: rgba(034,113,179,0.3);
}
.HistoriaZlecen{
background: rgba(255,255,0,0.3);
}
.Schowek{
background: rgba(11, 230, 223, 0.3);
}
.Grafik{
background:  rgba(255,0,0,0.3);

}
.Uzytkownicy{
background: rgba(245, 23, 234, 0.3);
width: 150px;
height: 50px;
}
</style >
    <title>Polanka - Zarządzaj swoim domem jak nigdy dotąd</title>
    <link rel="stylesheet" href="style.css">

</head>
<body  onload="viewData()" style="background:url(tlo.jpg) ;background-repeat:no-repeat;background-size:100% 100%;background-attachment: fixed">
    
    <div class="container" id="container">
    <header>  
        
        <div class="title" >      
       <h1>Polanka</h1>
            </div>
        <nav>
            <div class="cos">
        <ul>
            
        <li class="ListaZlecen"><a href="ListaZlecen.html"><span>Lista Zleceń</span></a></li>
        <li class="MojeZlecenia"><a href="MojeZlecenia.html"><span>Moje Zlecenia</span></a></li>
        <li class="HistoriaZlecen"><a href="HistoriaZlecen.html"><span>Historia Zleceń</span></a></li>
        <li class="Schowek"><a href="Schowek.html"><span>Schowek</span></a></li>
        <li class="Grafik"><a href="Grafik.html"><span>Grafik</span></a></li>
       <li class="Uzytkownicy"><a href="uzytkownicy.php"><span>Zarzadzaj Użytkownikami</span></a></li>
                       

             </ul>
                 </div>
        </nav>
    </header>
        <div class="content">
            <div class="main-content">
    <section>
        <article  id="html">
<p>    Polanka - Zarządzaj swoim domem jak nigdy dotąd</p>
            <figure>

        <table id="tabledit"  class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Room</th>
                    <th>Equipment</th>
                    <th>Status</th>
                    <th>User</th>
                    <th>Priority</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.tabledit.js"></script>
    <script>
    function viewData(){
        $.ajax({
            url: 'process.php?p=view',
            method: 'GET'
        }).done(function(data){
            $('tbody').html(data);
            tableData();
        })
    }

    function tableData(){
        $('#tabledit').Tabledit({
            url: 'process.php',
            eventType: 'dblclick',
            editButton: true,
            deleteButton: true,
            hideIdentifier: false,
            buttons: {
                edit: {
                    class: 'btn btn-sm btn-warning',
                    html: '<span class="glyphicon glyphicon-pencil"></span> Edit',
                    action: 'edit'
                },
                delete: {
                    class: 'btn btn-sm btn-danger',
                    html: '<span class="glyphicon glyphicon-trash"></span> Trash',
                    action: 'delete'
                },
                save: {
                    class: 'btn btn-sm btn-success',
                    html: 'Save'
                },
                restore: {
                    class: 'btn btn-sm btn-warning',
                    html: 'Restore',
                    action: 'restore'
                },
                confirm: {
                    class: 'btn btn-sm btn-default',
                    html: 'Confirm'
                }
            },
            columns: {
                identifier: [0, 'id'],
                editable: [[1, 'room'],[2, 'equipment'],[3, 'status', '{"0": "To do", "1": "Doing", "2": "Done"}'],[4, 'user'], [5, 'priority', '{"0": "Low", "1": "Medium", "2": "High"}'], [6, 'description']]
            },
            onSuccess: function(data, textStatus, jqXHR) {
                viewData();
            },
            onFail: function(jqXHR, textStatus, errorThrown) {
                console.log('onFail(jqXHR, textStatus, errorThrown)');
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            },
            onAjax: function(action, serialize) {
                console.log('onAjax(action, serialize)');
                console.log(action);
                console.log(serialize);
            }
        });
    }
        </script>


            </figure>
    </article>
  

    <p>
    </p>
        </div>
       



        </section>
            </div>
    <footer>Wszelkie prawa zastrzeżone &copy</footer>
        </div>
</body>
</html>
