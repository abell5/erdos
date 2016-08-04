<?php
function redirect($new_location) {
	header("Location: " . $new_location);
	exit;
}

function password_encrypt($password) {
	$hash_format = "$2y$10$";
	$salt = generate_salt();
	$format_and_salt = $hash_format . $salt;
	$hash = crypt($password, $format_and_salt);
	return $hash;
}

function generate_salt() {
	$unique_random_string = md5(uniqid(mt_rand(), true));
	$base64_string = base64_encode($unique_random_string);
	$modified_base64_string = str_replace('+','.',$base64_string);
	$salt = substr($modified_base64_string, 0, 22);
	return $salt;
}



?>