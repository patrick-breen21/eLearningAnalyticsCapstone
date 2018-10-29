<style>
.container {
  margin-top:30px;
}

h1, h2, h3, h4, h5, h6 {
  font-weight:700;
}

.fancyTab {
	text-align: center;
  padding:15px 0;
  background-color: #eee;
	box-shadow: 0 0 0 1px #ddd;
	top:15px;	
  transition: top .2s;
  width: calc(100%/4);
}

.fancyTabs > li {
    float: left;
    margin-bottom: -1px;
}

.nav > li {
    position: relative;
    display: block;
}

.fancyTab.active {
  top:0;
  transition:top .2s;
}

.whiteBlock {
  display:none;
}

.fancyTab.active .whiteBlock {
  display:block;
  height:2px;
  bottom:-2px;
  background-color:#fff;
  width:99%;
  position:absolute;
  z-index:1;
}

.fancyTab a {
	font-size:1.65em;
	font-weight:300;
  transition:.2s;
  color:#333;
}

/*.fancyTab .hidden-xs {
  white-space:nowrap;
}*/

.fancyTabs {
	border-bottom:2px solid #ddd;
  margin: 15px 0 0;
}

li.fancyTab a {
  padding-top: 15px;
  top:-15px;
  padding-bottom:0;
}

li.fancyTab.active a {
  padding-top: inherit;
}

.fancyTab .fa {
  font-size: 40px;
	width:100%;
	padding: 15px 0 5px;
  color: #707070;
}

.fancyTab.active .fa {
  color: #fff;
}

.nav-tabs li a {
  background-color: #eee !important;
  color: #707070 !important;
}

.fancyTab a:focus {
	outline:none;
}

.fancyTabContent {
  border-color: transparent;
  box-shadow: 0 -2px 0 -1px #fff, 0 0 0 1px #ddd;
  padding: 30px 15px 15px;
  position:relative;
  background-color:#fff;
}

.fancyTabs > li.fancyTab.active > a, 
.fancyTabs > li.fancyTab.active > a:focus,
.fancyTabs > li.fancyTab.active > a:hover {
	border-width:0;
}

.fancyTabs > li.fancyTab:hover {
	background-color:#f9f9f9;
	box-shadow: 0 0 0 1px #ddd;
}

.fancyTabs > li.fancyTab.active:hover {
  background-color:#fff;
  box-shadow: 1px 1px 0 1px #fff, 0 0px 0 1px #ddd, -1px 1px 0 0px #ddd inset;
}

.fancyTabs > li.fancyTab:hover a {
	border-color:transparent;
}

.nav.fancyTabs .fancyTab a[data-toggle="tab"] {
  background-color:transparent;
  border-bottom:0;
}

.fancyTabs > li.fancyTab:hover a {
  border-right: 1px solid transparent;
}

.fancyTabs > li.fancyTab > a {
	margin-right:0;
	border-top:0;
  padding-bottom: 30px;
  margin-bottom: -30px;
}

.fancyTabs > li.fancyTab {
	margin-right:0;
	margin-bottom:0;
}

.fancyTabs > li.fancyTab:last-child a {
  border-right: 1px solid transparent;
}

.fancyTabs > li.fancyTab.active:last-child {
  border-right: 0px solid #ddd;
	box-shadow: 0px 2px 0 0px #fff, 0px 0px 0 1px #ddd;
}

.fancyTab:last-child {
  box-shadow: 0 0 0 1px #ddd;
}

.tabs .fancyTabs li.fancyTab.active a {
	box-shadow:none;
  top:0;
}


.fancyTab.active {
  background: #fff;
	box-shadow: 1px 1px 0 1px #fff, 0 0px 0 1px #ddd, -1px 1px 0 0px #ddd inset;
  padding-bottom:30px;
}

.arrow-down {
	display:none;
  width: 0;
  height: 0;
  border-left: 20px solid transparent;
  border-right: 20px solid transparent;
  border-top: 22px solid #ddd;
  position: absolute;
  top: -1px;
  left: calc(50% - 20px);
}

.arrow-down-inner {
  width: 0;
  height: 0;
  border-left: 18px solid transparent;
  border-right: 18px solid transparent;
  border-top: 12px solid #fff;
  position: absolute;
  top: -22px;
  left: -18px;
}

.fancyTab.active .arrow-down {
  display: block;
}

@media (max-width: 1200px) {
  
  .fancyTab .fa {
  	font-size: 36px;
  }
  
  .fancyTab .hidden-xs {
    font-size:22px;
	}
		
}
	
	
@media (max-width: 992px) {
    
  .fancyTab .fa {
  	font-size: 33px;
  }
    
  .fancyTab .hidden-xs {
  	font-size:18px;
    font-weight:normal;
  }
		
}
	
	
@media (max-width: 768px) {
    
  .fancyTab > a {
    font-size:18px;
  }
    
  .nav > li.fancyTab > a {
    padding:15px 0;
    margin-bottom:inherit;
  }
    
  .fancyTab .fa {
    font-size:30px;
  }
    
  .fancyTabs > li.fancyTab > a {
    border-right:1px solid transparent;
    padding-bottom:0;
  }
    
  .fancyTab.active .fa {
    color: #333;
	}
		
}
</style>

        <ul class="nav nav-tabs fancyTabs" role="tablist">
            <?php // chart-area, chart-bar, chart-line, chart-pie ?>
            <li class="tab fancyTab <?= $view == 'metrics' ? 'active' : ''?> ">
            <div class="arrow-down"><div class="arrow-down-inner"></div></div>	
                <a id="tab0" href="unit/<?=$unit['code']?>/metrics"><span class="fa fa-chart-bar"></span><span class="hidden-xs">Metrics</span></a>
            	<div class="whiteBlock"></div>
            </li>
                                                    
            <li class="tab fancyTab <?= $view == 'internal' ? 'active' : ''?> ">
            <div class="arrow-down"><div class="arrow-down-inner"></div></div>
                <a id="tab3" href="unit/<?=$unit['code']?>/internal"><span class="fa fa-mortar-board"></span><span class="hidden-xs">Internal</span></a>
                <div class="whiteBlock"></div>
            </li> 
                 
            <li class="tab fancyTab <?= $view == 'external' ? 'active' : ''?> ">
            <div class="arrow-down"><div class="arrow-down-inner"></div></div>
                <a id="tab4" href="unit/<?=$unit['code']?>/external"><span class="fa fa-stack-overflow"></span><span class="hidden-xs">External</span></a>
                <div class="whiteBlock"></div>
            </li>
            
            <li class="tab fancyTab <?= $view == 'help' ? 'active' : ''?> ">
            <div class="arrow-down"><div class="arrow-down-inner"></div></div>
                <a id="tab5" href="unit/<?=$unit['code']?>/help"><span class="fa fa-question-circle"></span><span class="hidden-xs">Help</span></a>
                <div class="whiteBlock"></div>
            </li>
        </ul>