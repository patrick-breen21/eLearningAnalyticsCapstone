<?php

function validateMatch(&$errors, $field_list, $field_name, $pattern) {
	if (!isset($field_list[$field_name]) || empty($field_list[$field_name])) return;
    if (!preg_match($pattern, $field_list[$field_name])) {
        $errors[$field_name] = 'invalid';
        return false;
    }
    return true;
}

function validateRequired(&$errors, $field_list, $field_name) {
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name])) {
        $errors[$field_name] = 'required';
        return false;
    }
    return true;
}

?>