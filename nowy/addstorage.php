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
if($page=='view'){
    $houses_id=$_SESSION['houses_id'];
    $id=$_SESSION['id'];
    $result = $mysqli->query("SELECT * FROM storage where house_id=$houses_id");

    while($row = $result->fetch_assoc()){
        ?>
        <tr>
		<td style="display:none;"><?php echo $row['id'] ?></td>

            <td ><?php echo $row['room_type'] ?></td>
            <td><?php echo $row['item_name'] ?></td>
			<td><?php echo $row['item_quantity'] ?></td>
			<td><?php echo $row['number_of_requests'] ?></td>


            <td><?php 
            if($row['item_weight']==0)
            echo 'Low';
            elseif ($row['item_weight']==1)
            echo 'Medium';
            elseif($row['item_weight']==2)
            echo 'High'
            ?></td>
            <td><?php echo $row['item_price'] ?></td>
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
    $result = $mysqli->query("SELECT * FROM storage house_id=$houses_id");
    $usersql="SELECT name FROM users where houses_id=$houses_id";
    $usertable=$mysqli->query($usersql);
    

    // if($input['user']==$clmNames[1])
    // $uszer=$id;
    // if($input['user']==$clmNames[0])
    // $uszer=$houses_id*-1;

    if ($input['action'] == 'edit') {
        $mysqli->query("UPDATE storage SET room_type='" . $input['room_type'] . "', item_name='" . $input['item_name'] . "', item_quantity='" . $input['item_quantity'] . "', number_of_requests='" . $input['number_of_requests'] . "', item_weight='" . $input['item_weight'] . "', item_price='" . $input['item_price'] . "' WHERE (id='" . $input['id'] . "' and house_id=$houses_id)");
    } else if ($input['action'] == 'delete') {
        $mysqli->query("UPDATE storage SET status=3 WHERE id='" . $input['id'] . "'");
    } else if ($input['action'] == 'restore') {
        $mysqli->query("UPDATE list_of_order SET status=0 WHERE id='" . $input['id'] . "'");
    }

    mysqli_close($mysqli);

    echo json_encode($input);
    
}
?>