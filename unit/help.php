<?php
    /*
    // GET: /api/guest/timetable/<campus>/<stream>/<week>
    [HttpGet]
    [Route("timetable/{campus}/{stream}/{week}")]
    public async Task<object> GetTimetable(Campus campus, Stream stream, int week,
        
    For the campus/stream, you can use the enum names or values. They are:
    public enum Stream
    {
        [Display(Name = "Maths")]
        Maths,

        [Display(Name = "Science")]
        Science,

        [Display(Name = "IT")]
        IT,

        [Display(Name = "Duty Host")]
        [RestrictedStream()]
        DutyHost
    }

    public enum Campus
    {
        [Display(Name = "Gardens Point")]
        [CampusLocation("Level 2, V Block (Library)")]
        GardensPoint,

        [Display(Name = "Kelvin Grove")]
        [CampusLocation("Level 3, R Block (Library)")]
        KelvinGrove
    }
    
    Starting at 0, so IT would GP/IT would be /api/guest/timetable/GardensPoint/IT/10, or /api/guest/timetable/0/2/10

    */

function getSkill($skillid, $skills) {
    $skill = [];
    
    foreach ($skills as $skill) {
        if ($skill->id == $skillid) {
            return $skill; 
        }
    }
    
    return null;
}

function cmpTime($a, $b) {
    //echo "<br>A - {$a->dayName} {$a->startTime}<br>";
    //echo "B - {$b->dayName} {$b->startTime}<br>";
    if ($a->day < $b->day) {
      //echo 'A - Earlier day<br>';
      return -1;
    } elseif ( $a->day == $b->day) {
      //echo 'Same day<br>';
      $aStart = new DateTime($a->startTime);
      if ($a->startTime == $b->startTime) {
        //echo 'Same time<br>';
        return 0;
      } else if ($aStart->diff(new DateTime($b->startTime))->format('%R') == '+') { // same time executes here
        //echo 'A - Earlier time<br>';
        return -1;
      } else {
        //echo 'A - Later time<br>';
        return 1;
      }
      
      
    } else {
      //echo 'A - Later day<br>';
      return 1;
    }
}
  
    
  $json_response = file_get_contents('../_data/it-plfs.json');
  $response = json_decode($json_response);
  
  usort($response->shifts, 'cmpTime');
  ?>
  <script>console.log(<?=json_encode($response->shifts)?>);</script>
  <?php
  date_default_timezone_set("Australia/Brisbane");
  
  $day = date('w');
  
  $now = new DateTime();
  
  // If no remaining times for the day, show times for tomorrow
  if ($now->diff(new DateTime("5:00 PM"))->format('%R') == '-') {
    $day += 1;
    $now->modify('+1 day')->setTime(0, 0);
  }
  
  if ($day > 5 || $day == 0) {
    $day = 1;
    $now->modify('next monday')->setTime(0, 0);
  }
  
?>
<p><a href='https://blackboard.qut.edu.au/webapps/blackboard/content/listContentEditable.jsp?content_id=_6310862_1&course_id=_106041_1&target=blank'>Group Support Sessions</a></p>
<h2><?=$now->format('l');?> Help Sessions</h2>
<div class="shifts course-listing">  
<?php foreach ($response->shifts as $index=>$shift): ?>
  
  <?php //if ($index != 0) pre_dump(cmpTime($response->shifts[$index-1], $response->shifts[$index])); ?>
  <?php if ($shift->day == $day && $shift->absent == false): ?>
      <?php
        $startTime = new DateTime($now->format('Y-m-d') . ' ' . $shift->startTime);
        $endTime = new DateTime($now->format('Y-m-d') . ' ' . $shift->endTime);
      ?>
      
      <?php $plfRelSkills = array_intersect($unit['skills'],$shift->plfSkills); ?>
      
      <?php if ($plfRelSkills == []) continue; ?>
      
      <?php if ($now->diff($startTime)->format('%R') == '+'): ?>
          <h3>UPCOMING</h3>
      <?php elseif ($now->diff($endTime)->format('%R') == '+'): ?>
          <h3>IN PROGRESS</h3>
      <?php else: continue; ?>
      <?php endif; ?>
      
      <?php
        foreach ($plfRelSkills as $index=>$skillid) {
          $plfRelSkills[$index] = getSkill($skillid, $response->skills)->title;
        }
      ?>
      
          <div class="course-item" >
              <div badge="course" class="badge"></div>
              <h2 class="course-code"><?= $shift->plfPublicName ?></h2>
              <div class="course-title"><?= $shift->startTime ?> - <?= $shift->endTime ?></div>
              <div class="course-discipline"><?php echo implode(", ", $plfRelSkills); ?></div>
          </div>
  <?php endif; ?>
<?php endforeach; ?>
</div>


<script>
  let response = JSON.parse(<?= json_encode($json_response) ?>);
  console.log(response);
</script>