<?php include('_includes/head.php') ?>

<body class=" controls-visible private-page ${intranet-demo} student Current Student en group-id-16731135 page-id-16787600 portlet-type " id="student-theme" data-gr-c-s-loaded="true" cz-shortcut-listen="true">
        <div id="wrapper-container">
            <?php include('_includes/header.php'); ?>            
            <div id="wrapper">
                <?php include('_includes/nav.php'); ?>
                <div class="columns-2-r" id="content-wrapper">
                    <div class="lfr-grid" id="layout-grid">
                        <div id="qut-homePage">
                            <h1 class="layout-heading sr-only">Learning Analytics - Echo Data</h1>
                            <div class="column-container">
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

<style>
    .axis path,
    .axis line {
        fill: none;
        stroke: #000;
        shape-rendering: crispEdges;
    }
    .x.axis path {
        display: none;
    }
    .line {
        fill: none;
        stroke: steelblue;
        stroke-width: 1px;
    }
</style>
<?php
////weekly average for students that week
//function AverageEchoTimes($AllEchoData){};

////weekly average for a single student
//function AverageEchoTimeUser($name, $AllEchoData){};
$AllEchoData = GetAllEchoData();
$FailGradeData = AverageEchoTimePerWeekByGrade(3);
$PassGradeData = AverageEchoTimePerWeekByGrade(4);
$CreditGradeData = AverageEchoTimePerWeekByGrade(5);
$DistGradeData = AverageEchoTimePerWeekByGrade(6);
$HDistGradeData = AverageEchoTimePerWeekByGrade(7);
$UnitAverage = AverageEchoTimes($AllEchoData);

$studentData = AverageEchoTimeUser($_SESSION['user']['hash'], $AllEchoData);
//pre_dump($studentData);
$studentData = [10, 13, 20, 11, 30, 40, 70, 90];
?>

<script src="http://d3js.org/d3.v3.js"></script>
<script>


    var studentArray = <?php echo json_encode($studentData)?>;
    var FailArr = <?php echo json_encode($FailGradeData)?>;
    var PassArr = <?php echo json_encode($PassGradeData)?>;
    var CredArr = <?php echo json_encode($CreditGradeData)?>;
    var DisArr = <?php echo json_encode($DistGradeData)?>;
    var HDisArr = <?php echo json_encode($HDistGradeData)?>;
    var averages = <?php echo json_encode($UnitAverage)?>;
    var data = [];

    var startDate = new Date('February 12, 2017 00:00:00 GMT+1000');
    for (index in studentArray) {
        var dummydata = {};
        //dummydata.date = '2011100'+index;
        dummydata.date = new Date(
            startDate.getFullYear(),
            startDate.getMonth(),
            startDate.getDate()+index*7,
            startDate.getHours(),
            startDate.getMinutes(),
            startDate.getSeconds());
        dummydata['Student'] = studentArray[index];
        dummydata['Fail'] = FailArr[index];
        dummydata['Pass'] = PassArr[index];
        dummydata['Credit'] = CredArr[index];
        dummydata['Distinction'] = DisArr[index];
        dummydata['High Distinction'] = HDisArr[index];
        dummydata['Avg. Unit Time'] = averages[index];
        data.push(dummydata);
    }

    //margins of graph
    var margin = {
            top: 20,
            right: 80,
            bottom: 30,
            left: 50
        },
        width = 900 - margin.left - margin.right,
        height = 500 - margin.top - margin.bottom;

    //parse data for later use
    //var parseDate = d3.time.format("%Y%m%d");

    //x Axis time scale range
    var x = d3.time.scale()
        .range([0, width]);

    //y Axis time scale range
    var y = d3.scale.linear()
        .range([height, 0]);

    //color of graph
    var color = d3.scale.category10();

    //xAxis orientation
    var xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom");

    //yAxis orientation
    var yAxis = d3.svg.axis()
        .scale(y)
        .orient("left");

    //building the line for the xAxis
    var line = d3.svg.line()
        .interpolate("basis")
        .x(function(d) {
            return x(d.date);
        })
        //building the line for the yAxis
        .y(function(d) {
            return y(d.time);
        });
    //making the graph scalable
    var svg = d3.select("#chart").append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    console.log(data);


    color.domain(d3.keys(data[0]).filter(function(key) {
        return key !== "date";
    }));

    var student = color.domain().map(function(name) {
        return {
            name: name,
            values: data.map(function(d) {
                return {
                    date: d.date,
                    time: +d[name]
                };
            })
        };
    });

    x.domain(d3.extent(data, function(d) {
        return d.date;
    }));

    y.domain([
        d3.min(student, function(c) {
            return d3.min(c.values, function(v) {
                return v.time;
            });
        }),
        d3.max(student, function(c) {
            return d3.max(c.values, function(v) {
                return v.time;
            });
        })
    ]);

    //create the legend
    var legend = svg.selectAll('g')
        .data(student)
        .enter()
        .append('g')
        .attr('class', 'legend');

    legend.append('rect')
        .attr('x', width - 20)
        .attr('y', function(d, i) {
            return i * 20;
        })
        .attr('width', 10)
        .attr('height', 10)
        .style('fill', function(d) {
            return color(d.name);
        });

    legend.append('text')
        .attr('x', width - 8)
        .attr('y', function(d, i) {
            return (i * 20) + 9;
        })
        .text(function(d) {
            return d.name;
        });

    svg.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + height + ")")
        .call(xAxis);

    svg.append("g")
        .attr("class", "y axis")
        .call(yAxis)
        .append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 6)
        .attr("dy", ".71em")
        .style("text-anchor", "end")
        .text("Minutes spent on unit");

    var studentName = svg.selectAll(".studentName")
        .data(student)
        .enter().append("g")
        .attr("class", "studentName");

    studentName.append("path")
        .attr("class", "line")
        .attr("d", function(d) {
            return line(d.values);
        })
        .style("stroke", function(d) {
            return color(d.name);
        });

    studentName.append("text")
        .datum(function(d) {
            return {
                name: d.name,
                value: d.values[d.values.length - 1]
            };
        })
        .attr("transform", function(d) {
            return "translate(" + x(d.value.date) + "," + y(d.value.time) + ")";
        })
        .attr("x", 3)
        .attr("dy", ".35em")
        .text(function(d) {
            return d.name;
        });

    //interactive mouse functionality
    var mouseG = svg.append("g")
        .attr("class", "mouse-over-effects");

    mouseG.append("path") // this is the black vertical line to follow mouse
        .attr("class", "mouse-line")
        .style("stroke", "black")
        .style("stroke-width", "1px")
        .style("opacity", "0");

    var lines = document.getElementsByClassName('line');

    var mousePerLine = mouseG.selectAll('.mouse-per-line')
        .data(student)
        .enter()
        .append("g")
        .attr("class", "mouse-per-line");

    mousePerLine.append("circle")
        .attr("r", 7)
        .style("stroke", function(d) {
            return color(d.name);
        })
        .style("fill", "none")
        .style("stroke-width", "1px")
        .style("opacity", "0");

    mousePerLine.append("text")
        .attr("transform", "translate(10,3)");

    mouseG.append('svg:rect') // append a rect to catch mouse movements on canvas
        .attr('width', width) // can't catch mouse events on a g element
        .attr('height', height)
        .attr('fill', 'none')
        .attr('pointer-events', 'all')
        .on('mouseout', function() { // on mouse out hide line, circles and text
            d3.select(".mouse-line")
                .style("opacity", "0");
            d3.selectAll(".mouse-per-line circle")
                .style("opacity", "0");
            d3.selectAll(".mouse-per-line text")
                .style("opacity", "0");
        })
        .on('mouseover', function() { // on mouse in show line, circles and text
            d3.select(".mouse-line")
                .style("opacity", "1");
            d3.selectAll(".mouse-per-line circle")
                .style("opacity", "1");
            d3.selectAll(".mouse-per-line text")
                .style("opacity", "1");
        })
        .on('mousemove', function() { // mouse moving over canvas
            var mouse = d3.mouse(this);
            d3.select(".mouse-line")
                .attr("d", function() {
                    var d = "M" + mouse[0] + "," + height;
                    d += " " + mouse[0] + "," + 0;
                    return d;
                });

            d3.selectAll(".mouse-per-line")
                .attr("transform", function(d, i) {
                    var xDate = x.invert(mouse[0]),
                        bisect = d3.bisector(function(d) { return d.date; }).right;
                    idx = bisect(d.values, xDate);

                    var beginning = 0,
                        end = lines[i].getTotalLength(),
                        target = null;

                    while (true){
                        target = Math.floor((beginning + end) / 2);
                        pos = lines[i].getPointAtLength(target);
                        if ((target === end || target === beginning) && pos.x !== mouse[0]) {
                            break;
                        }
                        if (pos.x > mouse[0])      end = target;
                        else if (pos.x < mouse[0]) beginning = target;
                        else break; //position found
                    }

                    d3.select(this).select('text')
                        .text(y.invert(pos.y).toFixed(2));

                    return "translate(" + mouse[0] + "," + pos.y +")";
                });
        });

</script>

</body>
</html>
