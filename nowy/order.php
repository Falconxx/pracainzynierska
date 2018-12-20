<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
$mail2 = new PHPMailer(true);  
$mail2->CharSet = 'UTF-8';
$mail2->Encoding = 'base64';

session_start();
unset($_SESSION['blad']);
require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);
$houses_id=$_SESSION['houses_id'];
$polaczenie = new mysqli($host,$db_user,$db_password,$db_name);
$mysqli = new mysqli($host,$db_user,$db_password,$db_name);
$polaczenie->query('set character_set_server=utf8');
$polaczenie->query('set character_set_client=utf8');
$polaczenie->query('set character_set_connection=utf8');
$polaczenie->query('set character_set_results=utf8');
$polaczenie->query('set character_set_server=utf8');
$mysqli->query('set character_set_server=utf8');
$mysqli->query('set character_set_client=utf8');
$mysqli->query('set character_set_connection=utf8');
$mysqli->query('set character_set_results=utf8');
$mysqli->query('set character_set_server=utf8');
$number1 = count($_POST["room"]);
$number2 = count($_POST["equipment"]);
$number3 = count($_POST["description"]);
$number4 = count($_POST["price"]);
$number5 = count($_POST["effort_hours"]);

$value1 = $_POST["room"];
$value2 = $_POST["equipment"];
$value3 = $_POST["status"];
$value4 = $_POST["user"];
$value5 = $_POST["priority"];
$value6 = $_POST["description"];
$value7 = $_POST["price"];
$value8 = $_POST["effort_hours"];

$val;
$sql = '';
if(( $number1 >= 1 && $number2 >= 1 && $number3>=1&& $number4>=1&& $number5>=1 )&&($number1==$number2 && $number2==$number3&& $number3==$number4&& $number4==$number5))
{
	for($i=0; $i<$number1; $i++)
	{
		$value1_clean = $value1[$i];
		$value2_clean = $value2[$i];
		$value3_clean = $value3[$i];
		$value4_clean = $value4[$i];
		$value5_clean = $value5[$i];
		$value6_clean = $value6[$i];
		$value7_clean = $value7[$i];
		$value8_clean = $value8[$i];

		if($value1_clean != '' && $value2_clean != '' && $value3_clean != '' && $value4_clean != '' && $value5_clean != '' && $value6_clean != ''&& $value7_clean != ''&& $value8_clean != '')

		{
			$sql = 'INSERT INTO list_of_order(house_id,room,equipment,status,user_id,priority,description,price,effort_hours) VALUES("'.$houses_id.'", "'.$value1_clean.'", "'.$value2_clean.'", "'.$value3_clean.'", "'.$value4_clean.'", "'.$value5_clean.'", "'.$value6_clean.'", "'.$value7_clean.'", "'.$value8_clean.'");';
			
			$mailsql= "SELECT email FROM `users` WHERE id='$value4_clean' and houses_id=$houses_id";
			$res=$polaczenie->query($mailsql);
			$result=$res->fetch_assoc();
			$mails=$result['email'];

			// "INSERT INTO list_of_order(name) VALUES('".mysqli_real_escape_string($connect, $_POST["name"][$i])."')";
			$polaczenie->query($sql);
			// mysqli_query($polaczenie, $sql);
			echo "order ".$i." was insterter properly";
			
			echo $value4_clean;
			$statusz='';
			$prioriyy='';
			if($status=0)
			$statusz='To Do';
			if($status=1)
			$statusz='Doing';
			if($status=2)
			$statusz='Done';
			if($status=3)
			$statusz='Deleted';
			if($prioriy=0)
			$prioriyy='Low';
			if($prioriy=1)
			$prioriyy='Medium';
			if($prioriy=2)
			$prioriyy='High';
			try {
 //Server settings
                    // $mail2->SMTPDebug = 2;                                 // Enable verbose debug output
                    $mail2->IsSMTP();
                    $mail2->SMTPDebug = 0;
                    $mail2->SMTPAuth = true;  // Gmail requires authentication
                    $mail2->SMTPSecure = 'ssl'; // Gmail requires SSL connection
                    $mail2->Host = 'smtp.googlemail.com';
                    $mail2->Port = 465; 
                    $mail2->Username = "asaromaro@gmail.com"; // <-- Update this with your GMail username  
                    $mail2->Password = "Mniszek5900";

                    //Recipients
                    $mail2->setFrom('asaromaro@gmail.com', 'Polanka');
                    $mail2->addAddress($mails);     // Add a recipient
                   
                    $body='<p><strong>New Order assigned to You</strong> is:'.'room: '.$value1_clean.' equipment: '.$value2_clean.' status: '.$statusz.' assigned to: '.$value4_clean.' priority: '.$prioriyy.' description: '.$value6_clean.' price: '.$value7_clean.'</p';


                    //Content
                    $mail2->isHTML(true);                                  // Set email format to HTML
                    $mail2->Subject = 'New Order assigned to You';
                    $mail2->Body    = $body;
                    $mail2->AltBody = strip_tags($body);
                
                    $mail2->send();

                } catch (Exception $e) {
                    echo 'Message could not be sent. Mailer Error: ', $mail2->ErrorInfo;

                }


		}
		else{
			// echo "ERROR order ".$i." was not insterter properly";
			
			echo $sql;
			echo $value4_clean[$i];


		}

	}
}
else
{
    echo "Please, insert all data";

}