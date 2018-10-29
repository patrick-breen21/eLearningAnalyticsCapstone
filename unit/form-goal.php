<form method='post' action=''>
    <style>
        body{
            box-sizing: border-box;
        }
        .weeklygoaltime{
            padding: 16px;
            font-size: 13pt;
            background-color: lightgray;
        }
    </style>
    <div class="weeklygoaltime">
<!--        made the username and unit fields hidden-->
    <input type='hidden' name='username' value="<?=$_SESSION['user']['username']?>" size="4" maxlength="4"/>
    <input type="hidden" name='unit' value="<?=$unit['code']?>" />
    <label for "weekly-goal"><b>Weekly Hours Goal</b></label>
        <select name='week'>
            <option value="default">Default</option>
            <option value="week 1">week 1</option>
            <option value="week 2">week 2</option>
            <option value="week 3">week 3</option>
            <option value="week 4">week 4</option>
            <option value="week 5">week 5</option>
            <option value="week 6">week 6</option>
            <option value="week 7">week 7</option>
            <option value="week 8">week 8</option>
            <option value="week 9">week 9</option>
            <option value="week 10">week 10</option>
            <option value="week 11">week 11</option>
            <option value="week 12">week 12</option>
            <option value="week 13">week 13</option>
            <option value="exams">Exams</option>
        </select>
    <input type="text" id='weekly-goal' placeholder="10" name='gtime' />
    <input type='submit' class='button' value='Submit'/>
    </div>
</form>

<?php
	$params['user'] = posted_value('username');
	$params['unit'] = posted_value('unit');
	$params['week'] = posted_value('week');

  if ($params['user'] != NULL && $params['unit'] != NULL && $params['week'] != NULL) {
      $query = "SELECT * FROM `Goal Times` WHERE Users = :user AND Unit = :unit AND Week = :week";
    
      $currentgoal = pdoQuery($conn, $query, $params);
      
      $params['gtime'] = intval(posted_value('gtime'));
    
      if ($currentgoal) {
        $query = "UPDATE `Goal Times` SET `Goal Time` = :gtime WHERE Users = :user AND Unit = :unit AND Week = :week";
        $result = pdoQuery($conn, $query, $params);
    
        echo "Updated Goal";
      } else {
          $query = "INSERT INTO `Goal Times` (`id`, `Users`, `Unit`, `Week`, `Goal Time`) VALUES (NULL, :user, :unit, :week, :gtime);";
          
          $result = pdoQuery($conn, $query, $params);
    
          echo "Added new Goal";
      }
  }
?>