<?php include('_includes/head.php') ?>

<?php
    $data = null;
	
?>
<body class=" controls-visible private-page student Current Student en group-id-16731135 page-id-16787600 portlet-type " id="student-theme" data-gr-c-s-loaded="true" cz-shortcut-listen="true">
        <div id="wrapper-container">
            <?php include('_includes/header.php'); ?>            
            <div id="wrapper">
                <?php include('_includes/nav.php'); ?>
                <div class="columns-2-r" id="content-wrapper">
                    <div class="lfr-grid" id="layout-grid">
                        <div id="qut-homePage">
                            <h1 class="layout-heading sr-only">Add Data</h1>
                            <div class="column-container">
                                <div class='elcontent grid'>
                                    <div class="cell">
                                      <form method="post" action=''>
                                        <h2>Add a Resource</h2>
                                        <input type='hidden' name='user' value="<?=$_SESSION['user']['username']?>" />
                                        <div><p><label>Unit Code</label><br><input type='text' name='subject' placeholder="e.g. CAB202"/></p></div>
                                        <div><p><label>Resource URL</label><br><input type='text' name='link' placeholder="e.g. http://stackoverflow.com/.../some-resource"/></p></div>
                                        <div><p><label>Resource Title</label><br><input type='text' name='title' placeholder="e.g. Programming in C"/></p></div>
                                        <div><p><label>Image URL</label><br><input type='text' name='image' placeholder="e.g. http://somesite.com/.../someimage.jpg"/></p></div>
                                        <div><p><label>Resource Description</label><br>
                                        <textarea name='description'></textarea></p></div>
                                        <!--div><label>Feedback</label>
                                        <textarea></textarea></div>
                                        <div><fieldset class="rating">
                                            <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                            <input type="radio" id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                            <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                            <input type="radio" id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                            <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                            <input type="radio" id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                            <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                            <input type="radio" id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                            <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                            <input type="radio" id="starhalf" name="rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                        </fieldset></div-->

                                        <div><button>Submit</button></div>
                                      </form>
                                      <?php
                                        if (posted_value('user') && posted_value('subject') && posted_value('link') && posted_value('title')) {
                                            include 'new_external.php';
                                        }
                                      ?>
                                    </div>
                                    
                                    <div class='cell'><?php csv_import_form(); ?></div>
                                </div>
                                <div class='upload-msg'>
                                <?php
                                    if ($_FILES[csv]) {
                                        $data = parseCSV($_FILES[csv]);
                                        if ($data[0]['Echo Date']) {
                                            $hashes = array_unique(array_column($data, 'hash'));

                                            echo $_SESSION['user']['hash'].'<br>';
                                            loadData($data, $portal='LL');
                                        }
                                    }
                                ?>
                                </div>
                                <div>
                                    <?php displayData($data); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        <?php include('_includes/footer.php'); ?> 
        </div>
</body></html>
