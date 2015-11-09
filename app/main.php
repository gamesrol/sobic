<?php 

$app->notFound(function () use ($app) {
	require '../public/partials/layout.html';
});

$app->get('/',function(){
	require '../public/partials/layout.html';
});

$app->group('/api', function () use ($app) {

	$app->post('/mail',function () use ($app){
 		$data = json_decode($app->request->getBody(), true);
		//print_s($data);
 		$results = [];
		$results["success"]= "false";

		
		if(isset($data)) {

			$email_to = "mail@example.com";
			$email_subject = "From contact of web page";
			
			// validation expected data exists
			
			if(!isset($data['name']) || !isset($data['email']) || !isset($data['msg'])) {
				$error_message .= 'We are sorry, but there appears to be a problem with the form you submitted.';
				$results["error"] = $error_message;
			}
		
			$name = $data['name']; // required
			$email_from = $data['email']; // required
			$comments = $data['msg']; // required
			
			$error_message = "";
			$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
			
			if(!preg_match($email_exp,$email_from)) {
				$error_message .= 'The Email Address you entered does not appear to be valid.<br />';
				$results["error"] = $error_message;
			}
			
			$string_exp = "/^[A-Za-z .'-]+$/";
			
			if(!preg_match($string_exp,$name)) {
				$error_message .= 'The Name you entered does not appear to be valid.<br />';
				$results["error"] = $error_message;
			}
			
			if(strlen($comments) < 2) {
				$error_message .= 'The Comments you entered do not appear to be valid.<br />';
				$results["error"] = $error_message;
			}
			
			if(strlen($error_message) > 0) {
				$results["error"] = $error_message;
			}
			
			$email_message = "Form details below.\n\n";
			
			$email_message .= "Name: ".$name."\n";
			$email_message .= "Email: ".$email_from."\n";
			if(isset($data['phone'])) {
				$phone = $data['phone'];
				$email_message .= "Phone: ".$phone."\n";
			}
			
			$email_message .= "Text: ".$comments."\n";
			
			// create email headers
			
			$headers = 'From: '.$email_from."\r\n".'Reply-To: '.$email_from."\r\n" .'X-Mailer: PHP/' . phpversion();
			
			if(mail($email_to, $email_subject, $email_message, $headers)) {
				$results["success"]= "true";
			}
		}
		
		echo json_encode($results);
	});

	include ('controllers/user.php');
	include ('controllers/profile.php');

	/* It is important to respect these comments to generate smooth scaffold. */
	/** Scaffold PHP Controller **/

});