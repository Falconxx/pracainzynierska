<?php
	session_start();

require_once "connect.php";

$mysqli = new mysqli($host,$db_user,$db_password,$db_name);
$mysqli->query("SET NAMES utf8");

if (mysqli_connect_errno()) {
  echo json_encode(array('mysqli' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
  exit;
}
$houses_id=$_SESSION['houses_id'];

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

$page = isset($_GET['p'])? $_GET['p'] : '' ;
if($page=='view'){
    $houses_id=$_SESSION['houses_id'];
    $id=$_SESSION['id'];
    $result = $mysqli->query("SELECT * FROM users where houses_id=$houses_id");

    while($row = $result->fetch_assoc()){
        ?>
        <tr>
		<td style="display:none;"><?php echo $row['id'] ?></td>
		<td ><?php echo $row['email'] ?></td>
		<td ><?php echo $row['user_password'] ?></td>
		<td ><?php echo $row['name'] ?></td>
		<td ><?php echo $row['surname'] ?></td>
		<td ><?php echo $row['birth_date'] ?></td>
		<td ><?php echo $row['phone_number'] ?></td>
		<td ><?php echo $row['number_of_completed_works'] ?></td>
        <td><?php 
            if($row['admin_status']==0)
            echo 'User';
            elseif ($row['admin_status']==1)
            echo 'Admin';
            elseif($row['admin_status']==2)
            echo 'Child';
            elseif($row['admin_status']==3)
            echo 'Deleted';
            ?></td>
		<td ><?php echo $row['purchases'] ?></td>

        </tr>
        <?php

        
    }
} else{

    // Basic example of PHP script to handle with jQuery-Tabledit plug-in.
    // Note that is just an example. Should take precautions such as filtering the input data.

    header('Content-Type: application/json');

    $input = filter_input_array(INPUT_POST);
    $houses_id=$_SESSION['houses_id'];
    $id=$_SESSION['id'];
    $result = $mysqli->query("SELECT * FROM users where house_id=$houses_id");
    $usersql="SELECT name FROM users where houses_id=$houses_id";
    $usertable=$mysqli->query($usersql);
    

    // if($input['user']==$clmNames[1])
    // $uszer=$id;
    // if($input['user']==$clmNames[0])
    // $uszer=$houses_id*-1;

    if ($input['action'] == 'edit') {
        $mysqli->query("UPDATE users SET email='" . $input['email'] . "', user_password='" . password_hash($input['user_password'],PASSWORD_DEFAULT) . "', houses_id='$houses_id', name='" . $input['name'] . "', surname='" . $input['surname'] . "', birth_date='" . $input['birth_date'] . "', phone_number='" . $input['phone_number'] . "', number_of_completed_works='" . $input['number_of_completed_works'] . "', admin_status='" . $input['admin_status'] . "', purchases='" . $input['purchases'] . "' WHERE (id='" . $input['id'] . "' and houses_id=$houses_id)");
    } else if ($input['action'] == 'delete') {
        $mysqli->query("UPDATE users SET admin_status=3 WHERE id='" . $input['id'] . "'");
    } else if ($input['action'] == 'restore') {
        $mysqli->query("UPDATE users SET status=0 WHERE id='" . $input['id'] . "'");
    }

    mysqli_close($mysqli);

    echo json_encode($input);
    
}
?>