<?php
include('../_includes/head.php');

$default = 'metrics';

?>

<?php
   
if (isset($_GET['id']) && in_array( strtolower($_GET['id']), array_keys($units) )):
    $unit = $units[strtolower($_GET['id'])];
    ?>

<?php
if (isset($_GET['view']) && in_array($_GET['view'], ['internal', 'external', 'metrics', 'help'])):
    $view = $_GET['view'];
else:
    $view = $default;
endif;
?>
    
<body class=" controls-visible private-page ${intranet-demo} student Current Student en group-id-16731135 page-id-16787600 portlet-type " id="student-theme" data-gr-c-s-loaded="true" cz-shortcut-listen="true">
  <div id="wrapper-container">
    <?php include('../_includes/header.php'); ?>            
    <div id="wrapper">
      <?php include('../_includes/nav.php'); ?>
      <div class="columns-2-r" id="content-wrapper">
        <div class="lfr-grid" id="layout-grid">
          <div id="qut-homePage">
            <h3 class="layout-heading portlet-title"><?=strtoupper($unit['code'])?> - <?=$unit['title']?></h3>
            <div class="container"> 
                <section id="fancyTabWidget" class="tabs t-tabs">
                    <?php include('nav.php'); ?>
                    <div id="myTabContent" class="tab-content fancyTabContent" aria-live="polite">
                        
                        <?php
                        include("{$view}.php");
                        ?>
                    </div>
            
                </section>
            </div>
          </div>
        </div>
      </div>
        
    </div>
  <?php include('../_includes/footer.php'); ?> 
  </div>

</body>
</html>
    
    
    
    
    
<?php 
else:
    print '404 unit code unknown';
endif;

?>