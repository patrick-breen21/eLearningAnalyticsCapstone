<?php include('_includes/head.php') ?>

<body class=" controls-visible private-page ${intranet-demo} student Current Student en group-id-16731135 page-id-16787600 portlet-type " id="student-theme" data-gr-c-s-loaded="true" cz-shortcut-listen="true">
        <div id="wrapper-container">
            <?php include('_includes/header.php'); ?>            
            <div id="wrapper">
                <?php include('_includes/nav.php'); ?>
                <?php include('_includes/status.php'); ?>                
                <div class="columns-2-r" id="content-wrapper">
                    <div class="lfr-grid" id="layout-grid">
                        <div id="qut-homePage">
                            <h1 class="layout-heading sr-only">LL Echo Data</h1>
                            <div class="column-container">
                                <?
                                    $hash = $_SESSION['user']['hash'];
                                    $data = GetEchoTimeUser($hash);
                                ?>
                                <pre><?php echo $hash . ' - ' . json_encode($data); ?></pre>
                                <div class='elcontent'>
                                    <div id='chart'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        <?php include('_includes/footer.php'); ?> 
        </div>

<script>

var user = <?php echo json_encode($_SESSION['user']) ?>;
var myData = <?php echo json_encode($data) ?>;

var margin = {
    top: 30,
    right: 30,
    bottom: 40,
    left: 50
}

//defining container
var height = 500 - margin.top - margin.bottom;
var width = 500 - margin.right - margin.left;
//creating animation
var animateDuration = 700;
var animateDelay = 30;

var tooltip = d3.select('body').append('div')
    .style('position', 'absolute')
    .style('background', '#f4f4f4')
    .style('padding', '5 15 px')
    .style('border', '1px #333 solid')
    .style('border-radius', '5px')
    .style('opacity', '0');
//yAxis creation
var yScale = d3.scale.linear()
    .domain([0, d3.max(myData)])
    .range([0, height]);
//yAxis creation
var xScale = d3.scale.ordinal()
    .domain(d3.range(0, myData.length))
    .rangeBands([0, width]);
var colours = d3.scale.linear()
    .domain([0, myData.length])
    .range(['#90ee90', '#30c230']);


//chart container
var myChart = d3.select("#chart").append('svg')
    .attr('width', width + margin.right + margin.left)
    .attr('height', height + margin.top + margin.bottom)
    .append('g')
    .attr('transform', 'translate('+margin.left+','+ margin.top+')')
    .style('background', '#f4f4f4')
    .selectAll('rect')
    .data(myData).enter()
    .append('rect').style('fill', function (d, i) {
        return colours(i);
    })
    .attr('width', xScale.rangeBand())
    .attr('height', 0)
    .attr('x', function(d, i) {
        return xScale(i);
    })
    .attr('y', height)
    //creation of interactive display - errors
    .on('mouseOver', function(d){
        tooltip.transition()
            .style('opacity', 1)

        tooltip.html(d)
            .style('left', (d3.event.pageX)+'px')
            .style('top', (d3.event.pageY)+ 'px')
        d3.select(this).style('opacity', 0.5)
    })
    .on('mouseOut', function(d){
        tooltip.transition()
            .style('opacity', 0)
        d3.select(this).style('opacity', 1)
        })
    //animation of chart while loading
    myChart.transition()
        .attr('height', function(d){
            return yScale(d);
        })
        .attr('y', function(d){
            return height - yScale(d);
        })
        .duration(animateDuration)
        .delay(function (d, i) {
            return i * animateDelay
        })
        .ease('elastic')
    //vertical Scale
    var vScale = d3.scale.linear()
        .domain([0, d3.max(myData)])
        .range([height, 0])
    //height Scale
    var heightScale = d3.scale.ordinal()
        .domain(d3.range(0, myData.length))
        .rangeBands([0, width])
    //v Axis
    var vAxis = d3.svg.axis()
        .scale(vScale)
        .orient('left')
        .ticks(5)
        .tickPadding(5)

    var vGuide = d3.select('svg')
        .append('g')
            vAxis(vGuide)
            vGuide.attr('transform', 'translate('+margin.left+',' +margin.top+')')
            vGuide.selectAll('path')
                .style('fill', 'none')
                .style('stroke', '#000')
            vGuide.selectAll('line')
                .style('stroke', '#000')

    var hAxis = d3.svg.axis()
    .scale(heightScale)
    .orient('bottom')
    .ticks(5)
    .tickValues(heightScale.domain().filter(function(d, i){
        return !(i % (myData.length/7));

    }));

    var hGuide = d3.select('svg')
    .append('g')
    hAxis(hGuide)
    hGuide.attr('transform', 'translate('+('+margin.left+',' +margin.top+'))
    hGuide.selectAll('path')
        .style('fill', 'none')
        .style('stroke', '#000')
    hGuide.selectAll('line')
        .style('stroke', '#000')


</script>

</body>
</html>
