<?php

echo '


<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <style>
    .bar1 { fill: aqua; }
    .bar2 { fill: deepskyblue; }
    .bar3 { fill: steelblue; }
    .bar:hover {fill: orange; }
    .axis--x path { display: none; }
    .line {
        fill: none;
        stroke: royalblue;
        stroke-width: 3;
    }
    .dot {
        fill: royalblue;
        stroke: royalblue;
    }
    
    .legend rect {
      fill:white;
      stroke:black;
      opacity:0.8;}
      
    .legends5 {
    float:left;
    margin-right: 1em;
}
      
  </style>
  <script src="https://d3js.org/d3.v4.min.js"></script>
</head>
<span><h1> Logged Time And Goal Time Per Week</h1>
</span>

<body>



  <script>
  var dataset = [
    [\'Week 1\',1000, 102],
    [\'Week 2\',1000,341],
    [\'Week 3\',1000,935],
    [\'Week 4\',1000,800],
    [\'week 5\',1000,743],
    [\'week 6\',1000,1200],
    [\'week 7\',1000, 626],
    [\'week 8\',1000, 1064],
    [\'week 9\',1000, 1443],
    [\'Week 10\',1000, 630],
    [\'Week 11\',1000, 556],
    [\'Week 12\',1200, 880],
    [\'Week 13\',1200, 1589],
    [\'Week 14\',1200, 1497],
    [\'Week 15\',1200, 749],
    [\'Week 16\',1200, 720]
  ];

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

  var svg = d3.select("body").append("svg")
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
//  
//  legend = svg.append("g")
//  .attr("class","legend")
//  .attr("transform","translate(50,30)")
//  .style("font-size","12px")
//  .call(d3.legend)
//  
 // add the legend
//  var legend = svg.append("g")
//  .attr("class","legend")
//  .attr("transform","translate(50,30)")
//  .style("font-size","12px")
//  .call(d3.legend)
  

// svg.append("text")
//      .attr("transform", "translate("+(width+3)+","+yScale(dataset[0,1].open)+")")
//      .attr("dy", ".35em")
//      .attr("text-anchor", "start")
//      .style("fill", "blue")
//      .text("Goal Time");

  </script>
  
  <img src="legend.png" alt="graph legend" height="90" width="100">

</body>
</html>';

?>