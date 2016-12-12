<?php
require_once ('mail/class.phpmailer.php');
require_once ('mail/class.smtp.php');

//$ini_array = parse_ini_file("../conf.ini",true);

$host = "localhost";
$username = "amsuser";
$password = "nXQNpEmxvb6bc5Va";
$db_name = "ams";
error_reporting(E_ALL ^ E_DEPRECATED);
mysql_connect("$host", "$username", "$password") or die("cannot connect");
mysql_select_db ("$db_name") or die("cannot select DB");

function send_mail($to, $to_name, $subject, $message, $seconds){
	set_time_limit($seconds);
	$current_date = date('U');
	$sql = mysql_query("select * from configmail where status = 'Active'");
	$num_row = mysql_num_rows($sql);
	if($num_row >=1){
		while($row = mysql_fetch_array($sql)){
			$host = $row['host'];
			$fromID = $row['fromid'];
			$fromName = $row['fromname'];
			$login = $row['login'];
			$password = $row['password'];
			$port = $row['port'];
			$smtpAuth = $row['smtpAuth'];
			$smtpSecure = $row['smtpSecure'];
			$smtpDebug = $row['smtpDebug'];
		}
			
			$mail = new PHPMailer();
			$mail->IsSMTP();							// set mailer to use SMTP
			$mail->IsHTML(true);						// set HTML Is true to Execute HTML
			$mail->Host = $host;						// specify main and backup server
			$mail->SMTPAuth = $smtpAuth;				// turn on SMTP authentication
			$mail->Username = $login;					// SMTP username
			$mail->Password = $password;				// SMTP password
			$mail->Port = $port;
			$mail->SMTPSecure = $smtpSecure;			// SMTP Secure
			$mail->SetFrom($fromID, $fromName);			// SMTP From
			//$count = count($to);
				
							
				if($to != ''){
									
					$mail->AddAddress($to, $to_name);		// To Whom Mail Will be Send
					$mail->Subject = $subject;					// Subject of the Mail
					$mail->Body  = $message;					// Body of the Mail Content
														
					if(!$mail->Send()){
						echo "<br>Mailer Error: " . $mail->ErrorInfo;
						return false;
						exit;					
					}					
					else{
						echo "<br>Notification Mail Sent<br>";
						
						return true;
					//	$mail->ClearAllRecipients();						
					}
				}		
				

		
	}
	else{
		echo "Error : No Active Config Mail";
	}
}
?>
