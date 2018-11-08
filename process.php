<?php
	session_start();

require_once "connect.php";

$mysqli = new mysqli($host,$db_user,$db_password,$db_name);

if (mysqli_connect_errno()) {
  echo json_encode(array('mysqli' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
  exit;
}

$page = isset($_GET['p'])? $_GET['p'] : '' ;
if($page=='view'){
    $houses_id=$_SESSION['houses_id'];
    $id=$_SESSION['id'];
    $result = $mysqli->query("SELECT * FROM list_of_order where user_id=$id or user_id=$houses_id*-1");
    $usersql="SELECT name FROM users where id=$houses_id*-1 or id=$id ";
    $usertable=$mysqli->query($usersql);
    while( $user=$usertable->fetch_assoc() ) {
        foreach( $user  AS $value ) {
            $clmNames[] = $value;
        }
    }
    while($row = $result->fetch_assoc()){
        ?>
        <tr>
            <td><?php echo $row['room'] ?></td>
            <td><?php echo $row['equipment'] ?></td>
            <td><?php echo $row['status'] ?></td>
            <td><?php 
                if($row['user_id']==$id)
                echo $clmNames[1];
                if($row['user_id']==($houses_id*-1))
                echo $clmNames[0]; 
            ?></td>
            <td><?php echo $row['priority'] ?></td>
            <td><?php echo $row['description'] ?></td>
        </tr>
        <?php
    }
} else{

    // Basic example of PHP script to handle with jQuery-Tabledit plug-in.
    // Note that is just an example. Should take precautions such as filtering the input data.

    header('Content-Type: application/json');

    $input = filter_input_array(INPUT_POST);



    if ($input['action'] == 'edit') {
        $mysqli->query("UPDATE tabledit SET name='" . $input['name'] . "', gender='" . $input['gender'] . "', email='" . $input['email'] . "', phone='" . $input['phone'] . "', address='" . $input['address'] . "' WHERE id='" . $input['id'] . "'");
    } else if ($input['action'] == 'delete') {
        $mysqli->query("UPDATE tabledit SET deleted=1 WHERE id='" . $input['id'] . "'");
    } else if ($input['action'] == 'restore') {
        $mysqli->query("UPDATE tabledit SET deleted=0 WHERE id='" . $input['id'] . "'");
    }

    mysqli_close($mysqli);

    echo json_encode($input);
    
}
?>