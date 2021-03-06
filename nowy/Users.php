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
$polaczenie->query("SET NAMES utf8");
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

</head>
<body  onload="viewData()"  >
    
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
<input type="button" name="back" id="back" class="btn btn-success" value="Add New User" onclick="location.href='AddNewUser.php';"/>
<br/>
<input id="btnshow0" onclick="demoHide0()" style="display:none;" class="btn btn-info" type="button" value="Show All"/>

            <figure>

        <table id="tabledit"  class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="display:none;">Id</th>
                    <input id="btnshow" onclick="demoHide()" style="display:none;" class="btn btn-info" type="button" value="Show Emails"/>
                    <th>Email <input id="btnHide" onclick="demoShow()" class="btn btn-success" type="button" value="Hide Emails"/></th>
                    <input id="btnshow1" onclick="demoHide1()" style="display:none;" class="btn btn-info" type="button" value="Show Passwords"/>
                    <th>Password <input id="btnHide1" onclick="demoShow1()" data-modal="modal" class="btn btn-success" type="button" value="Hide Passwords"/></th>
                    <input id="btnshow2" onclick="demoHide2()" style="display:none;" class="btn btn-info" type="button" value="Show Names"/>
                    <th>Name <input id="btnHide2" onclick="demoShow2()" class="btn btn-success" type="button" value="Hide Names"/></th>
                    <input id="btnshow3" onclick="demoHide3()" style="display:none;" class="btn btn-info" type="button" value="Show Surnames"/>
                    <th>Surname <input id="btnHide3" onclick="demoShow3()" class="btn btn-success" type="button" value="Hide Surnames"/></th>
                    <input id="btnshow4" onclick="demoHide4()" style="display:none;" class="btn btn-info" type="button" value="Show Birthdates"/>
                    <th>Birth Date <input id="btnHide4" onclick="demoShow4()" class="btn btn-success" type="button" value="Hide Birthdates"/></th>
                    <input id="btnshow5" onclick="demoHide5()" style="display:none;" class="btn btn-info" type="button" value="Show Phones"/>
                    <th>Phone Number <input id="btnHide5" onclick="demoShow5()" class="btn btn-success" type="button" value="Hide Phones"/></th>
                    <input id="btnshow6" onclick="demoHide6()" style="display:none;" class="btn btn-info" type="button" value="Show Works"/>
                    <th>Number of completed works <input id="btnHide6" onclick="demoShow6()" class="btn btn-success" type="button" value="Hide Works"/></th>
                    <input id="btnshow7" onclick="demoHide7()" style="display:none;" class="btn btn-info" type="button" value="Show Status"/>
                    <th>Status <input id="btnHide7" onclick="demoShow7()" class="btn btn-success" type="button" value="Hide Status"/></th>
                    <input id="btnshow8" onclick="demoHide8()" style="display:none;" class="btn btn-info" type="button" value="Show Purchases"/>
                    <th>Purchases <input id="btnHide8" onclick="demoShow8()" class="btn btn-success" type="button" value="Hide Purchases"/></th>

                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.tabledit.js"></script>
    <script type="text/javascript">
$(document).ready(function(){
    $("#btnHide1").trigger('click'); 
});
</script>
    <script>
        function demoShow() {document.getElementById("btnshow").style.display="inline-block";
                    document.getElementById("btnshow0").style.display="inline-block";}
                function demoShow1() {document.getElementById("btnshow1").style.display="inline-block";
                    document.getElementById("btnshow0").style.display="inline-block";}
                function demoShow2() {document.getElementById("btnshow2").style.display="inline-block";
                    document.getElementById("btnshow0").style.display="inline-block";}
                function demoShow3() {document.getElementById("btnshow3").style.display="inline-block";
                    document.getElementById("btnshow0").style.display="inline-block";}
                function demoShow4() {document.getElementById("btnshow4").style.display="inline-block";
                    document.getElementById("btnshow0").style.display="inline-block";}
                function demoShow5() {document.getElementById("btnshow5").style.display="inline-block";
                    document.getElementById("btnshow0").style.display="inline-block";}
                function demoShow6() {document.getElementById("btnshow6").style.display="inline-block";
                    document.getElementById("btnshow0").style.display="inline-block";}
                function demoShow7() {document.getElementById("btnshow7").style.display="inline-block";
                    document.getElementById("btnshow0").style.display="inline-block";}
                    function demoShow8() {document.getElementById("btnshow8").style.display="inline-block";
                    document.getElementById("btnshow0").style.display="inline-block";}
                function demoHide0() {document.getElementById("btnshow0").style.display="none";
                    document.getElementById("btnshow").style.display="none";
                    document.getElementById("btnshow1").style.display="none";
                    document.getElementById("btnshow2").style.display="none";
                    document.getElementById("btnshow3").style.display="none";
                    document.getElementById("btnshow4").style.display="none";
                    document.getElementById("btnshow5").style.display="none";
                    document.getElementById("btnshow6").style.display="none";
                    document.getElementById("btnshow7").style.display="none";
                    document.getElementById("btnshow8").style.display="none";}
                function demoHide() {document.getElementById("btnshow").style.display="none";}
                function demoHide1() {document.getElementById("btnshow1").style.display="none";}
                function demoHide2() {document.getElementById("btnshow2").style.display="none";}
                function demoHide3() {document.getElementById("btnshow3").style.display="none";}
                function demoHide4() {document.getElementById("btnshow4").style.display="none";}
                function demoHide5() {document.getElementById("btnshow5").style.display="none";}
                function demoHide6() {document.getElementById("btnshow6").style.display="none";}
                function demoHide7() {document.getElementById("btnshow7").style.display="none";}
                function demoHide7() {document.getElementById("btnshow8").style.display="none";}

        $(document).ready(function() {
            $('#btnshow0').click(function() {
                // if your table has header(th), use this
                $('td:nth-child(2),th:nth-child(2)').show();
                $('td:nth-child(3),th:nth-child(3)').show();
                $('td:nth-child(4),th:nth-child(4)').show();
                $('td:nth-child(5),th:nth-child(5)').show();
                $('td:nth-child(6),th:nth-child(6)').show();
                $('td:nth-child(7),th:nth-child(7)').show();
                $('td:nth-child(8),th:nth-child(8)').show();
                $('td:nth-child(9),th:nth-child(9)').show();
                $('td:nth-child(10),th:nth-child(10)').show();

            });
            $('#btnHide').click(function() {
                // if your table has header(th), use this
                $('td:nth-child(2),th:nth-child(2)').hide();
            });
            $('#btnshow').click(function() {
                // if your table has header(th), use this
                $('td:nth-child(2),th:nth-child(2)').show();
            });
            $('#btnHide1').click(function() {
                // if your table has header(th), use this
                $('td:nth-child(3),th:nth-child(3)').hide();
            });
            $('#btnshow1').click(function() {
                // if your table has header(th), use this
                $('td:nth-child(3),th:nth-child(3)').show();
            });
            $('#btnHide2').click(function() {
                // if your table has header(th), use this
                $('td:nth-child(4),th:nth-child(4)').hide();
            });
            $('#btnshow2').click(function() {
                // if your table has header(th), use this
                $('td:nth-child(4),th:nth-child(4)').show();
            });
            $('#btnHide3').click(function() {
                // if your table has header(th), use this
                $('td:nth-child(5),th:nth-child(5)').hide();
            });
            $('#btnshow3').click(function() {
                // if your table has header(th), use this
                $('td:nth-child(5),th:nth-child(5)').show();
            });
            $('#btnHide4').click(function() {
                // if your table has header(th), use this
                $('td:nth-child(6),th:nth-child(6)').hide();
            });
            $('#btnshow4').click(function() {
                // if your table has header(th), use this
                $('td:nth-child(6),th:nth-child(6)').show();
            });
            $('#btnHide5').click(function() {
                // if your table has header(th), use this
                $('td:nth-child(7),th:nth-child(7)').hide();
            });
            $('#btnshow5').click(function() {
                // if your table has header(th), use this
                $('td:nth-child(7),th:nth-child(7)').show();
            });
            $('#btnHide6').click(function() {
                // if your table has header(th), use this
                $('td:nth-child(7),th:nth-child(7)').hide();
            });
            $('#btnshow6').click(function() {
                // if your table has header(th), use this
                $('td:nth-child(7),th:nth-child(7)').show();
            });
            $('#btnHide7').click(function() {
                // if your table has header(th), use this
                $('td:nth-child(7),th:nth-child(7)').hide();
            });
            $('#btnshow7').click(function() {
                // if your table has header(th), use this
                $('td:nth-child(7),th:nth-child(7)').show();
            });
            $('#btnHide8').click(function() {
                // if your table has header(th), use this
                $('td:nth-child(7),th:nth-child(7)').hide();
            });
            $('#btnshow8').click(function() {
                // if your table has header(th), use this
                $('td:nth-child(7),th:nth-child(7)').show();
            });

        });
    function viewData(){
        $.ajax({
            url: 'editusers.php?p=view',
            method: 'GET'
        }).done(function(data){
            $('tbody').html(data);
            tableData();
            $('td:nth-child(3),th:nth-child(3)').hide();

        })
    }

    function tableData(){
        $('#tabledit').Tabledit({
            url: 'editusers.php',
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
                class: 'btn btn-sm columns',
                identifier: [0, 'id'],
                editable: [[1, 'email'],[2, 'user_password'],[3, 'name'],[4, 'surname'],[5, 'birth_date'],[6, 'phone_number'],[7, 'number_of_completed_works'], [8, 'admin_status', '{"1": "Admin", "0": "User", "2": "Child", "3": "Deleted"}'], [9, 'purchases']]
            },
            onSuccess: function(data, textStatus, jqXHR) {
                viewData();
            },
            onFail: function(jqXHR, textStatus, errorThrown) {
                console.log('onFail(jqXHR, textStatus, errorThrown)');
                alert(jqXHR.responseText);
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
