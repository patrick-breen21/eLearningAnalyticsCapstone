<?php
    
$unit = $units[strtolower($_GET['id'])];

$params = [];
$params['name'] = $_SESSION['user']['username'];

$params['unit'] = $unit['code'];

if ($params['name'] && $params['unit']) {
  $query = "SELECT `Week`,`Goal Time` FROM `Goal Times` WHERE `Users` LIKE :name AND `Unit` LIKE :unit";
  
  $result = pdoQuery($conn, $query, $params);
} else {
  echo "Missing parameters";
}

/*
$LLdata = GetEchoDataUser($params['name']);

$loggedtimedata = array();
$temp = array();
//LL result array order $name . "," . $duration . "," . $timestamp . ", " . $date . ", " .$unit. ", " . $verb . ";";


foreach ($LLdata as $entry){
    if ($entry[5] == "logged"){
        array_push($temp, $entry[3], $entry[5]); //create array of week and time
        array_push($loggedtimedata, $temp); //append week and time array to data array.
    }
}

var_dump($loggedtimedata);

//insert the $loggedtimedata into js array....
*/
?>
<section>
<h3>Logged Time vs My Goals</h3>
<div class='goal-chart chart'></div>
  <script>
  let goaltimes = <?= json_encode($result) ?>;
  
  var dataset = [
      ['Week 1',10, 4],
      ['Week 2',10,4],
      ['Week 3',10,3],
      ['Week 4',10,5],
      ['Week 5',10,5],
      ['Week 6',10,3],
      ['Week 7',10, 4],
      ['Week 8',10, 4],
      ['Week 9',10, 4],
      ['Break',10, 4],
      ['Week 10',10, 4],
      ['Week 11',10, 4],
      ['Week 12',10, 4],
      ['Week 13',10, 10],
      ['Swotvac',10, 4],
      ['Exams',10, 15],
  ];
  
  for (week of dataset) {
      for (goal of goaltimes) {
        if (week[0].toLowerCase() == goal.Week.toLowerCase()) {
            week[1] = goal['Goal Time'];
            console.log('goal is '+goal['Goal Time']);
        }
      }
  }

  var margin = {top: 20, right: 20, bottom: 30, left: 40},
      width = 960,
      height = 400;

  var xScale = d3.scaleBand()
                .rangeRound([0, width])
                .padding(0.1)
                .domain(dataset.map(function(d) {
                  return d[0];
                }));
      yScale = d3.scaleLinear()
                .rangeRound([height, 0])
                .domain([0, d3.max(dataset, (function (d) {
                  return d[2];
                }))]);

  var svg = d3.select(".goal-chart").append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom);

  var g = svg.append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

//  var g = svg.selectAll("g")
//    .data(dataset.nodes).enter()
//    .append("g")
//    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
  
  // axis-x
  g.append("g")
      .attr("class", "axis axis--x")
      .attr("transform", "translate(0," + height + ")")
      .call(d3.axisBottom(xScale));

  // axis-y
  g.append("g")
      .attr("class", "axis axis--y")
      .call(d3.axisLeft(yScale));

  var bar = g.selectAll("rect")
    .data(dataset)
    .enter().append("g");

  // bar chart
  bar.append("rect")
    .attr("x", function(d) { return xScale(d[0]); })
    .attr("y", function(d) { return yScale(d[2]); })
    //.attr("data-legend",function(d) { return d.name})
    .attr("width", xScale.bandwidth())
    .attr("height", function(d) { return height - yScale(d[2]); })
    .attr("class", function(d) {
      var s = "bar ";
      if (d[1] < 400) {
        return s + "bar1";
      } else if (d[1] < 800) {
        return s + "bar2";
      } else {
        return s + "bar3";
      }
    });

  // labels on the bar chart
  bar.append("text")
    .attr("dy", "1.3em")
    .attr("x", function(d) { return xScale(d[0]) + xScale.bandwidth() / 2; })
    .attr("y", function(d) { return yScale(d[2]); })
    .attr("text-anchor", "middle")
    .attr("font-family", "sans-serif")
    .attr("font-size", "11px")
    .attr("fill", "black")
    .text(function(d) {
      return d[2];
    });

  // line chart
  var line = d3.line()
      .x(function(d, i) { return xScale(d[0]) + xScale.bandwidth() / 2; })
      .y(function(d) { return yScale(d[1]); })
      .curve(d3.curveMonotoneX);

  bar.append("path")
    .attr("class", "line") // Assign a class for styling
    .attr("data-legend",function(d) { return d.name})
    .attr("d", line(dataset)); // 11. Calls the line generator

  bar.append("circle") // Uses the enter().append() method
      .attr("class", "dot") // Assign a class for styling
      .attr("cx", function(d, i) { return xScale(d[0]) + xScale.bandwidth() / 2; })
      .attr("cy", function(d) { return yScale(d[1]); })
      .attr("r", 5);


  </script>
  
  <img src="_images/legend.png" alt="graph legend" height="90" width="100">
  </section>