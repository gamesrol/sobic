<?php

$app->group('/user', function () use ($app) {

	$app->get('/', function () use ($app) {
		$data = json_decode($app->request->getBody(), true);

		$results = [];
		$results["user"] = [];
		$results["success"]= "false";

		if (validatedKey($data["user"]["id"], $data["user"]["key"])) {
			$user = user::where('id', '=', $data["user"]["id"])->first();
			$results["user"] = $user;

			$results["success"]= "true";
		} else {
			$results["success"]= "false";
			$results["error"]= "No auth";
		}
		echo json_encode($results);
	});
	
	$app->post('/photo', function () use ($app) {
		$data = json_decode($_POST['data'], true);
		$results = [];
		$results["success"]= "false";
		if (validatedKey($data['user'])) {
			if($_FILES['file']['name'] != ""){ // El campo foto contiene una imagen...
		
				// Primero, hay que validar que se trata de un JPG/GIF/PNG
				$allowedExts = array("jpg", "jpeg", "gif", "png", "JPG", "GIF", "PNG");
				$ext = end(explode(".", $_FILES["file"]["name"]));
				if ((($_FILES["file"]["type"] == "image/gif")
					|| ($_FILES["file"]["type"] == "image/jpeg")
					|| ($_FILES["file"]["type"] == "image/png")
					|| ($_FILES["file"]["type"] == "image/pjpeg"))
					&& in_array($ext, $allowedExts)) {
				
					$ext = end(explode('.', $_FILES['file']['name']));
					$photo = substr(md5(uniqid(rand())),0,10).".".$ext;
					$dir = dirname(__FILE__).'/../../public/img/users'; // directorio de tu elección
					if(move_uploaded_file($_FILES['file']['tmp_name'], $dir.'/'.$photo)){
						$user = User::find($data['user']['id']);
						$user->img = "img/users/".$photo;
						$user->save();
						$img = new Imagick($dir.'/'.$photo);
						$img->cropThumbnailImage(50, 50);
						$img->writeImage ($dir.'/'.$photo);
						$results['img'] = "img/users/".$photo;
						$results["success"]= "true";
					}

				} else { 
					$results["error"]= "Invalid format";
				}
			} else {
				$results["error"]= "Not exist file";
			}
		} else {
			$results["success"]= "false";
			$results["error"]= "No auth";
		}
		echo json_encode($results);
	});

	$app->post('/new', function () use ($app) {
		$data = json_decode($app->request->getBody(), true);

		$results = [];
		$results["success"]= "false";

		if(!User::where('email', '=', $data["user"]["email"])->exists()){
			$user = new User();
			$user->email = $data["user"]["email"];
			$user->password = hash('sha512',$data["user"]["password"]);
			$user->save();
			$encriptedKey = hash('sha512', $user->id.$user->email.$user->created_at);
			$results["id"] = $user->id;
			$results["email"] = $user->email;
			$results["isAdmin"] = $user->isAdmin;
			$results["key"] = $encriptedKey;
			$results["success"]= "true";
		}
		echo json_encode($results);
	});

	$app->post('/login', function () use ($app) {
		$data = json_decode($app->request->getBody(), true);

		$results = [];
		$results["success"]= "false";
	
		$veri = User::where('email', '=', $data['user']['email'])->where('email', '=', $data['user']['email'])->where('password', '=', hash('sha512', $data['user']['password']))->first();
		if(User::where('email', '=', $data['user']['email'])->where('password', '=', hash('sha512', $data['user']['password']))->exists()){
			$results["id"] = $veri->id;
			$results["email"] = $veri->email;
			$results["isAdmin"] = $veri->isAdmin;
			$results["img"] = $veri->img;
			$results["key"] = hash('sha512', $veri->id.$veri->email.$veri->created_at);
			$results["created_at"] = $veri->created_at;
			$results["success"]= "true";
		}
	
		echo json_encode($results);
	});

	$app->get('/list', function () use ($app) {
		$users = User::all();
		$results["users"] = $users;
		echo json_encode($results);
	});

	$app->post('/recover', function () use ($app) {
		$data = json_decode($app->request->getBody(), true);

		$results = [];
		$results["success"]= "false";
		if(isset($data['email'])) {
			$user = User::where('email', '=', $data['email'])->first();

			$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
			$longitudCadena=strlen($cadena);
			$pass = "";
			$longitudPass=15;

			for($i=1 ; $i<=$longitudPass ; $i++){
				$pos=rand(0,$longitudCadena-1);
				$pass .= substr($cadena,$pos,1);
			}
			if($user) {
				$userEn = new UsersRec();
				$userEn->user_id = $user->id;
				$userEn->email = $user->email;
				$userEn->key_token = $pass;
				$userEn->save();
			
				$email = $userEn->email;
				$message = "Dear User of Sobic Framework,<br/ >";
				$message .= "Please visit the url to log in the app, you may change the password after<br/ >";
				$message .= "-----------------------<br/ >";
				$message .= "'https://yourURL/recovery/".$pass;
				$message .= "<br/ >-----------------------<br/ >";
				$message .= "Please be sure to copy the entire key into your url. The key will expire after 3 days for security reasons.<br/ >";
				$message .= "If you did not request this forgotten password email, no action is needed, your password will not be reset as long as the link above is not visited. However, you may want to log into your account and change your security password and answer, as someone may have guessed it.<br/ >";
				$message .= "Thanks,<br/ >";
				$message .= "-- Sobic Framework team";
				$headers = "From: contact@sobic.sobic \n";
				$headers .= "To-Sender: \n";
				$headers .= "X-Mailer: PHP\n"; // mailer
				$headers .= "Reply-To: contact@sobic.sobic\n"; // Reply address
				$headers .= "Return-Path: contact@sobic.sobic\n"; //Return Path for errors
				$headers .= "Content-Type: text/html; charset=iso-8859-1"; //Enc-type
				$subject = "Your Lost Password";
				@mail($email,$subject,$message,$headers);

				$results["success"] = "true";
				$results["value"]= "Password changed";
			}
		}
		echo json_encode($results);
	});
	$app->post('/recovery/:key_token', function ($key_token) use ($app) {
		$data = json_decode($app->request->getBody(), true);

		$results = [];
		$results["success"] = "false";
		$query = UsersRec::where('key_token', '=', $key_token)->first();
		if($query->exists()) {
			$userId = $query->user_id;
			$query1 = User::where('id', '=', $userId)->first();
			if($query1->exists()) {
				$user = $query1;
				$user->password = hash('sha512',$data["pass"]["password1"]);
				$user->update();

				$results["user"] = $user;
				$results["value"] = "New password";
				$results["success"] = "true";
			} else {
				$results["value"] = "No user to change password";
			}
		} else {
			$results["value"] = "Key don't valid'";
		}
			echo json_encode($results);
	});
	
	$app->post('/pass', function () use ($app) {
		$data = json_decode($app->request->getBody(), true);

		$results = [];
		$results["success"]= "false";
		$query = User::where('email', '=', $data["user"]["email"])->where('password', '=', hash('sha512',$data["pass"]["password"]));

		if($data['user']['social'] == ""){
			if($query->exists()){
				$user = $query->first();
				
				$user->password = hash('sha512',$data["pass"]["password1"]);
				$user->update();
				$results["user"] = $user;
				$results["value"] = "New";
				$results["success"] = "true";
			}
		}	
		echo json_encode($results);
	});
});
