<?php
	include_once "_database/connect.php";
	include_once "_includes/head.php";

	$params['resource_id'] = intval(posted_value('resource_id'));
	$params['user'] = posted_value('user');
  
  pre_dump($params);
  
  $query = "SELECT resource_id, user, status FROM external_moderation WHERE resource_id = :resource_id AND user = :user";

  $existingvote = pdoQuery($conn, $query, $params);
  
  $params['status'] = posted_value('status');
  
  pre_dump($existingvote);
  
  if ($existingvote) {
    $query = "UPDATE external_moderation SET status = :status, timestamp = NOW() WHERE resource_id = :resource_id AND user = :user";
    $result = pdoQuery($conn, $query, $params);
    pre_dump($result);
    echo "Updated vote";
  } else {
    $query = "INSERT INTO external_moderation(resource_id, user, status) VALUES(:resource_id, :user, :status)";
    $result = pdoQuery($conn, $query, $params);
    pre_dump($result);
    echo "Added vote";
  }
?>