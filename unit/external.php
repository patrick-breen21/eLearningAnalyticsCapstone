<?php
  
$params = array();
$params['user'] = $_SESSION['user']['username'];
$query = "SELECT *,
                (SELECT COUNT(*) FROM external_moderation WHERE resource_id = external.id AND status='upvote') AS upvotes,
                (SELECT COUNT(*) FROM external_moderation WHERE resource_id = external.id AND status='downvote') AS downvotes,
                (SELECT COUNT(*) FROM external_moderation WHERE resource_id = external.id AND status='flag') AS flags,
                (SELECT COUNT(*) FROM external_moderation WHERE resource_id = external.id AND status='endorse') AS endorsements,
                (SELECT status FROM external_moderation WHERE resource_id = external.id AND user=:user) AS myVote,
                (SELECT GROUP_CONCAT(tag) FROM external_tags WHERE resource_id = external.id GROUP BY resource_id) AS tags
            FROM external
            WHERE 1=1";

if ($unit['code'] != "") {
	$params['unit'] = $unit['code'];
	$query = $query . " AND unit = :unit";
}

$search = isset($_GET['search']) ? $_GET['search'] : "";

if ($search != "") {
	$params['search'] = '%'.$search.'%';
	$query = $query . " AND title LIKE :search";

	foreach (explode(' ', $search) as $index=>$term) {
    	$params['term_'.$index] = $term;
    	$query = $query . " OR :term_$index IN (SELECT tag FROM external_tags WHERE resource_id = external.id)";
	}
}

$query .= " ORDER BY upvotes DESC, downvotes";

$popular = pdoQuery($conn, $query, $params);

//pre_dump($popular);
?>
<h2 class="">External Recommended Resources</h2>
<input class='search' type='text' placeholder="search resources" name='search'/><button class='search btn'>Search</button>
<script>
  $('button.search.btn').click( function () {
      window.location.href = "unit/<?=$unit['code']?>/external/search="+$('input.search').val();
  });
</script>
<div class="column-container">
    <div class='elcontent'>                   
        <div class='popular external'>
            <div class='title'><?=strtoupper($unit['code'])?> - Popular External Resources</div>
          <?php foreach ($popular as $item): ?>
            <div class='item'>
              <div>
                <a href="<?= $item['link'] ?>"><?= $item['title'] ?></a>
                <span><i class='fa fa-arrow-up'></i><?= $item['upvotes'] ?></span>
                <span><i class='fa fa-arrow-down'></i><?= $item['downvotes'] ?></span>
                <?php if ($item['endorsements'] > 0): ?>
                  <span><i class='fa fa-star'></i>Academic Endorsed</span>
                <?php endif; ?>
              </div>
              <div>
                <a><?= $item['description'] ?></a>
                <span>Added <?= $item['timestamp'] ?></span>
                <?php $tags = $item['tags'] ? explode(",", $item['tags']) : []; ?>
                <?php foreach ($tags as $tag): ?>
                  <span><?= $tag ?></span>
                <?php endforeach; ?>
              </div>
              <div>
                <form method='post' action='mod_external.php'>
                    <input type='hidden' name="resource_id" value="<?=$item['id']?>" />
                    <input type='hidden' name="user" value="<?=$_SESSION['user']['username']?>" />
                    <?php if ($item['myVote']): ?>
                        <span><?=$item['myVote']?>d</span>
                    <?php endif; ?>
                    <?php if ($item['myVote'] !== 'upvote'): ?>
                        <button name='status' value='upvote'><i class='fa fa-arrow-up'></i>Upvote</button>
                    <?php endif; ?>
                    <?php if ($item['myVote'] !== 'downvote'): ?>
                        <button name='status' value='downvote'><i class='fa fa-arrow-down'></i>Downvote</button>
                    <?php endif; ?>
                    <?php if ($item['myVote'] !== 'downvote'): ?>
                        <button name='status' value='flag'><i class='fa fa-flag'></i>Flag</button>
                    <?php endif; ?>
                    <?php if ($_SESSION['user']['endorse'] && $item['myVote'] !== 'endorse'): ?>
                        <button name='status' value='endorse'><i class='fa fa-star'></i>Endorse</button>
                    <?php endif; ?>
                </form>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
    </div>
</div>