<?php
// Файлы phpmailer
require 'class.phpmailer.php';
require 'class.smtp.php';
require '../wp-config.php';

// Настройки
$mail = new PHPMailer;

$mail->isSMTP();

$mail->Host = MAIL_HOST;
$mail->Username = MAIL_USERNAME; 
$mail->Password = MAIL_PASSWORD;

$mail->SMTPOptions = array(
	'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
	)
);
$mail->SMTPAutoTLS = false;
$mail->Port = MAIL_PORT;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->CharSet = 'UTF-8';
$mail->Encoding = 'base64';

$mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);

date_default_timezone_set('Europe/Moscow');

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_set_charset($connection, 'utf8');

if($connection)
{
	$resultEmailInfo="SELECT * FROM wp_options WHERE option_name='options_forms-emails'";
	$emailInfo = getData($connection, $resultEmailInfo);

	$resultEmailVacancy="SELECT * FROM wp_options WHERE option_name='options_forms-email-vacancy'"; 
	$emailVacancy = getData($connection, $resultEmailVacancy);
}

$mail->isHTML(true);

if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'])) {
	if( $_POST['action'] == 'callback') {
		$emails = explode(',', $emailInfo);
		foreach($emails as &$value){
			$mail->addAddress($value);
		}
		require 'includes/callback.php';
	} elseif ($_POST['action'] == 'vacancy') {
		$emails = explode(',', $emailVacancy);
		foreach($emails as &$value){
			$mail->addAddress($value);
		}
		require 'includes/callback.php';
	}
} else {
	$validation['valid'] = 'not-valid';
	echo json_encode($validation);
	header("HTTP/1.0 403 Forbidden");
}

?>