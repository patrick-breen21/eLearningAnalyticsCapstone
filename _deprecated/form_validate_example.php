<!DOCTYPE html>
<html>
	<?php
		$title = 'Form | QUT Learning Analytics';

		include_once "_database/connect.php";
		include_once "_includes/head.php";
	?>

	<body><div class='page login'>

		<div class='content'>

			<section class='main-content login-section'>
        <?php
					$errors = array();
					$field_list = $_POST;
					$required_fields = ['username', 'email', 'password', 'confirmPass'];
					$match_fields = ['firstname' => '/^[A-Za-z\s]+$/', 'lastname' => '/^[A-Za-z\s]+$/', 'email' => '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/',
							'dob' => '/^\d{4}-\d{2}-\d{2}$/',
							'phone' => '/^(0[237]\d{8})|(04\d{8})|(13[\d]{4})|(1300[\d]{6})|(1800[\d]{6})$/'
					];
					if (isset($field_list['password'])) $match_fields['confirmPass'] = "/^{$field_list['password']}$/";

					if (isset($field_list['username'])) {
					    require "validate.php";
					    foreach ($required_fields as $name) {
					    	validateRequired($errors, $field_list, $name);
					    }

					    foreach ($match_fields as $name => $pattern) {
					    	validateMatch($errors, $field_list, $name, $pattern);
					    }
					  
					    if ($errors) {
					        include "_includes/signup_form.php";
					    } else {
					        echo 'form submitted successfully with no errors';
					        include "login/new_user.php";
					    }
					} else {
					    include "_includes/signup_form.php";
					}
				?>

			</section>
		</div>
	</div>
	</body>
	<?php $conn = null; ?>

</html>
