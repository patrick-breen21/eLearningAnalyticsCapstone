<?php
	$params['user'] = strtolower(posted_value('user'));
	$params['unit'] = strtolower(posted_value('subject'));
	$params['link'] = posted_value('link');
	$params['title'] = posted_value('title');
	$params['image'] = posted_value('image');
	$params['description'] = posted_value('description');
    //pre_dump($params);
    
	$query = "INSERT INTO external(user, unit, link, title, image, description, status) VALUES(:user, :unit, :link, :title, :image, :description, 'published')";

try {
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // use exec() because no results are returned
    $statement = $conn->prepare($query);
    
    $statement->execute($params);
    echo "New record created successfully";
} catch(PDOException $e) {
    echo 'ERROR: '.$e->getMessage();
}

$conn = null;
?>