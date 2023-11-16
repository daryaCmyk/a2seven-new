<?php

$validation = [];

$uploadfile = tempnam(sys_get_temp_dir(), sha1($_FILES['file']['name']));
$filename = $_FILES['file']['name'];
if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
    $mail->addAttachment($uploadfile, $filename);
}

if( $_POST['vacancy'] ) {
	$title = 'Отклик на вакансию: '.$_POST['vacancy'];
} elseif ($_POST['title']) {
	$title = $_POST['title'];
} else {
	$title = 'Заказать звонок';
}

$mail->Subject = $title;

$message = '';
if( $_POST['name'] ) $message .= '<p><b>Имя: </b><span>'.$_POST['name'].'</span></p>';
if( $_POST['phone'] ) $message .= '<p><b>Телефон: </b><span>'.$_POST['phone'].'</span></p>';
if( $_POST['email'] ) $message .= '<p><b>Email: </b><span>'.$_POST['email'].'</span></p>';
if( $_POST['message'] ) $message .= '<p><b>Сообщение: </b><span>'.$_POST['message'].'</span></p>';


$link = $_POST['link'];


$mail->Body = "
	<div id='margin: 20px 30px;font-size:14px;'>
		<h2>$title</h2>
		$message
		<h3>Доп информация</h3>
		<p><b>IP-адрес:</b> ".$_SERVER['REMOTE_ADDR']."</p>
		
		<p><b>Инфо о компе:</b>".$_SERVER['HTTP_USER_AGENT']." </p>
		
		<p><b>Адрес страницы с которой отправили форму:</b>".$link."</p>
		
		<p><b>Дата:</b> ".date('d.m.Y')."</p>
		
		<p><b>Время:</b> ".date('G:i')."</p>
		<br /><br /><br />
		<p>----------------</p>
		<br />
		<p>Не отвечайте на это сообщение, оно отправлено автоматически. Связаться с отправителем можно по его контактным данным в теле сообщения. Если сообщение отображается некорректно или у Вас возникли вопросы свяжитесь со службой поддержки компании Place-start по e-mail <a href='mailto:support@place-start.ru'>support@place-start.ru</a> или по телефону  <a href='tel:+78172264100'>+7 (8172) 26-41-00</a></p>
	</div>
";


if(!$mail->send()) {
	$validation['valid'] = 'not-valid';
	$validation['text'] = 'Ошибка: ' . $mail->ErrorInfo;
} else {
	$validation['valid'] = 'yes-valid';
}
echo json_encode($validation);
die;