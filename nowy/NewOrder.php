<?php

session_start();
unset($_SESSION['blad']);
require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);
$mysqli = new mysqli($host,$db_user,$db_password,$db_name);
$mysqli->query('set character_set_server=utf8');
$mysqli->query('set character_set_client=utf8');
$mysqli->query('set character_set_connection=utf8');
$mysqli->query('set character_set_results=utf8');
$mysqli->query('set character_set_server=utf8');

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
$id=$_SESSION['id'];

$sql="SELECT * FROM list_of_order where user_id=$houses_id or user_id=$houses_id*-1";
$polaczenie->query('set character_set_server=utf8');
$polaczenie->query('set character_set_client=utf8');
$polaczenie->query('set character_set_connection=utf8');
$polaczenie->query('set character_set_results=utf8');
$polaczenie->query('set character_set_server=utf8');
$records=$polaczenie->query($sql);
$usersql="SELECT name FROM users where houses_id=$houses_id ";
$usertable=$polaczenie->query($usersql);
while( $user=$usertable->fetch_assoc() ) {
    foreach( $user  AS $value ) {
        $clmNames[] = $value;
    }
}
$numberofusers = count($clmNames);
?>
<!DOCTYPE html>

<html>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>
<meta  name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#317EFB"/>

<meta charset="utf-8">

	<head>
		<meta charset="utf-8">
		<title>Add New Order To <?php echo $house_name['name']?></title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="style3.css">
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
	</head>
	<body>
		<div class="container">
			<br />
			<br />
			<h1 align="center"  style="
 !important;
    color: green !important;"><a
			 title="Add New Order To House: pierwszy" color="green">Add New Order To House: <?php echo $house_name['name']?></a></h1><br />
			<div class="form-group">
				<form accept-charset="utf-8" name="add_order" id="add_order">
					<div class="table-responsive">
						<table border="0" cellpadding="0" cellspacing="0" style="background: rgba(255,255,255,0.6); " class="mobilewrapper" id="dynamic_field">
							<tr>
								<td class="colsplit" width="5%"><input type="text"  name="id[]" value="Id: 1"class="form-control house_list" readonly/></td>
                                <td class="colsplit" width="13%"><input type="text"  name="name[]" value='<?php echo 'house: '.$house_name['name']?>'class="form-control house_list" readonly/></td>
                                <td class="colsplit" width="12.5%"><input type="text"  name="room[]" placeholder="Room" class="form-control room_list" /></td>
                                <td class="colsplit" width="10%"><input type="text"  name="equipment[]" placeholder="Equipment" class="form-control equipment_list" /></td>
								<td class="colsplit" width="7%">
								<meta charset="UTF-8">

								<select class="form-control" name="status[]">
								<option value="0">To Do</option>
								<option value="1">Doing</option>
								<option value="2">Done</option>
								<option value="3">Deleted</option>
								</select>
								</td>
								<td class="colsplit" width="7.5%">
								<select class="form-control" name="user[]" style="width:100%">
								<?php
								foreach($clmNames as $usernames) {
								?>
								<option 
								<?php
								    for($q=0;$q<sizeof($clmNames);$q++)
									{
										if($usernames==$clmNames[$q])
										{
											$nameofuser=$clmNames[$q];
											$usersql="SELECT id FROM users WHERE name LIKE '$usernames' and houses_id='$houses_id'";
											$usertable=$mysqli->query($usersql);
											$user=$usertable->fetch_assoc();
											$uszer=$user['id'];
								
										}
									}
								?>value=<?php echo $uszer; ?>>
								<?php $rezult = $usernames;
 echo $rezult; ?> </option>
								<?php } ?>
								</select>
								</td>
                                <td class="colsplit" width="6%">
								<select class="form-control" name="priority[]" class="col1">
								<option value="0">Low</option>
								<option value="1">Medium</option>
								<option value="2">High</option>
								</select>
								</td>
                                <td class="colsplit" width="13%"><input type="text"  name="description[]" placeholder="Description" class="form-control description_list" /></td>
                                <td class="colsplit" width="8%"><input type="number"  name="price[]" placeholder="Price" class="form-control price_list" /></td>
                                <td class="colsplit" width="10%"><input type="number"  name="effort_hours[]" placeholder="Effort hours" class="form-control effort_hours_list" /></td>

								<td class="colsplit" width="13%"><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
							</tr>
						</table>
						<input type="button" name="submit" id="submit" class="btn btn-info" value="Submit" />
						<input type="button" name="back" id="back" class="btn btn-info" value="Back" onclick="history.back();"/>

					</div>
				</form>
			</div>
		</div>
	</body>
</html>

<script>
$(document).ready(function(){
	var i=1;
	$('#add').click(function(){
		i++;
		$('#dynamic_field').append('<tr id="row'+i+'"><td class="colsplit" width="5%"><input type="text"  name="id[]" value="Id: '+i+'"class="form-control house_list" readonly/></td><td class="colsplit" width="13%"><input type="text" name="name[]" placeholder="<?php echo 'house: '.$house_name['name']?>" class="form-control name_list" readonly/></td><td class="colsplit" width="15.5%"><input type="text" name="room[]" placeholder="Room" class="form-control room_list" /></td><td class="colsplit" width="17%"><input type="text" name="equipment[]" placeholder="Equipment" class="form-control equipment_list" /></td><td class="colsplit" width="7%"><select class="form-control" name="status[]"> <option value="0">To Do</option><option value="1">Doing</option><option value="2">Done</option><option value="3">Deleted</option> </select></td><td class="colsplit" width="10%"><select class="form-control" name="user[]" style="width:100%"><?php foreach($clmNames as $usernames) { ?> <option <?php for($q=0;$q<sizeof($clmNames);$q++){if($usernames==$clmNames[$q]){$nameofuser=$clmNames[$q];$usersql="SELECT id FROM users WHERE name ='". $usernames. "' and houses_id='".$houses_id."'";$usertable=$mysqli->query($usersql);$user=$usertable->fetch_assoc();$uszer=$user['id'];}}?>value=<?php echo $uszer; ?>><?php echo $usernames; ?> </option><?php } ?></select> </td><td class="colsplit" width="5.5%"><select class="form-control" name="priority[]" class="col1"><option value="0">Low</option><option value="1">Medium</option><option value="2">High</option></select></td><td class="colsplit" width="20%"><input type="text" name="description[]" placeholder="Description" class="form-control description_list" /></td ><td class="colsplit" width="20%"><input type="text" name="price[]" placeholder="Price" class="form-control price_list" /></td ><td class="colsplit" width="20%"><input type="text" name="effort_hours[]" placeholder="Effort Hours" class="form-control effort_hours_list" /></td ><td class="colsplit" width="13%"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
	});
	
	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
		i--;
		
	});
	
	$('#submit').click(function(){		
		$.ajax({
			url:"order.php",
			method:"POST",
			data:$('#add_order').serialize(),
			contentType: "application/x-www-form-urlencoded;charset=utf-8",
			success:function(data)
			{
				alert(data);
				$('#add_order')[0].reset();
				
			}
		});
	});
	
});
</script>




