<?php
	session_start();

require_once "connect.php";

$mysqli = new mysqli($host,$db_user,$db_password,$db_name);
$mysqli->query("SET NAMES utf8");

if (mysqli_connect_errno()) {
  echo json_encode(array('mysqli' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
  exit;
}

$page = isset($_GET['p'])? $_GET['p'] : '' ;
$uszer='';
if($page=='view'){
    $houses_id=$_SESSION['houses_id'];
    $id=$_SESSION['id'];
    $result = $mysqli->query("SELECT * FROM list_of_order where (status!='2' AND status!='3') AND house_id=$houses_id");
    $usersql="SELECT name FROM users where houses_id=$houses_id";
    $usertable=$mysqli->query($usersql);
    while( $user=$usertable->fetch_assoc() ) {
        foreach( $user  AS $value ) {
            $clmNames[] = $value;
        }
    }
    while($row = $result->fetch_assoc()){
        ?>
        <tr>
            <td style="display:none;"><?php echo $row['id'] ?></td>
            <td ><?php echo $row['room'] ?></td>
            <td><?php echo $row['equipment'] ?></td>
            <td><?php 
            if($row['status']==2)
            echo 'Done';
            elseif ($row['status']==1)
            echo 'Doing';
            elseif($row['status']==0)
            echo 'To do'
            ?></td>
            <td><?php 
                $idforname=$row['user_id'];
                $usernamesql="SELECT name FROM users where id=$idforname";
                $usernamequery=$mysqli->query($usernamesql);
                $username=$usernamequery->fetch_assoc();
                echo $username['name'];
            ?></td>
            <td><?php 
            if($row['priority']==0)
            echo 'Low';
            elseif ($row['priority']==1)
            echo 'Medium';
            elseif($row['priority']==2)
            echo 'High'
            ?></td>
            <td><?php echo $row['description'] ?></td>
            <td><?php echo $row['price'] ?></td>
            
            <td><?php echo $row['effort_hours'] ?></td>
        </tr>
        <?php

        
    }
} else{

    // Basic example of PHP script to handle with jQuery-Tabledit plug-in.
    // Note that is just an example. Should take precautions such as filtering the input data.
do{
    header('Content-Type: application/json');

    $input = filter_input_array(INPUT_POST);
    $houses_id=$_SESSION['houses_id'];
    $id=$_SESSION['id'];
    $result = $mysqli->query("SELECT * FROM list_of_order where (status!='2' AND status!='3') AND house_id=$houses_id");
    $usersql="SELECT name FROM users where houses_id=$houses_id";
    $usertable=$mysqli->query($usersql);
    if(!is_numeric($_POST['price']))
    {
    echo "price must be number";
    break;
}
if(!is_numeric($_POST['effort_hours']))
    {
    echo "effort hours must be number";
    break;
}
    while( $user=$usertable->fetch_assoc() ) {
        foreach( $user  AS $value ) {
            $clmNames[] = $value;
        }
    }
    for($q=0;$q<sizeof($clmNames);$q++)
    {
        if(isset($_POST['user']))
        {
        $inputname=strtolower($input['user']);
        if($inputname==strtolower($clmNames[$q]))
        {
            $nameofuser=strtolower($clmNames[$q]);
            $usersql="SELECT DISTINCT id FROM users WHERE LOWER(name) LIKE '$nameofuser' and houses_id=$houses_id";
            $usertable=$mysqli->query($usersql);
            $user=$usertable->fetch_assoc();
            $uszer=$user['id'];

        }
    }
    }

    // if($input['user']==$clmNames[1])
    // $uszer=$id;
    // if($input['user']==$clmNames[0])
    // $uszer=$houses_id*-1;

    if ($input['action'] == 'edit') {
        if($uszer!='')
        $mysqli->query("UPDATE list_of_order SET room='" . $input['room'] . "', equipment='" . $input['equipment'] . "', status='" . $input['status'] . "', user_id='" . $uszer . "', priority='" . $input['priority'] . "', description='" . $input['description'] . "', price='" . $input['price'] . "', effort_hours='" . $input['effort_hours'] . "' WHERE id='" . $input['id'] . "'");
        else{
            echo "wprowadz nazwe uzytkownika ktory istnieje";
            break;
        }    } else if ($input['action'] == 'delete') {
        $mysqli->query("UPDATE list_of_order SET status=3 WHERE id='" . $input['id'] . "'");
    } else if ($input['action'] == 'restore') {
        $mysqli->query("UPDATE list_of_order SET status=0 WHERE id='" . $input['id'] . "'");
    }

    mysqli_close($mysqli);

    echo json_encode($input);
}while(false);
}
?>