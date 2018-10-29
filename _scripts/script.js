$(document).ready(init);

var statuses = [
    {'class': 'risk',     'txt': 'You are at risk.',    'color': 'firebrick'},
    {'class': 'warning',  'txt': 'You are borderline.', 'color': 'gold'},
    {'class': 'good',     'txt': 'You are doing well.', 'color': 'limegreen'}
];

function init(){
	//$('#show-nav-menu').click(mobileMenu);
    updateChart(".signal-chart");
}

function mobileMenu() {
	//alert('click');
	$('#wrapper-container').toggleClass('show-menu');
}

function getPercent(wrapperClass) {
    return $(wrapperClass).text();
}

function getStatus(percent) {
    if (percent > 66) return 2;
    else if (percent > 33) return 1;
    else return 0;
}

function cleanDataset(actual) {
  var newArray = new Array();
  colorArray = [];
  for (var i = 0; i < actual.length; i++) {
    if (actual[i].percent > 0) {
      newArray.push(actual[i]);
      colorArray.push(actual[i].color);
    }
  }
  return newArray;
}

function getColors(data) {
  var colorArray = [];
  for (var i = 0; i < data.length; i++) {
      colorArray.push(data[i].color);
  }
  return colorArray;
}

// D3 chart
function updateChart(chartClass) {
	var percent = getPercent(chartClass);
	$(chartClass).html("");

	var color = statuses[getStatus(percent)].color;

	colors = [color, "#F5F5F5"];
	halfDonut(chartClass, percent, colors);
}

function halfDonut(chartClass, percent) {
    var value = percent/100
    var text = Math.round(value * 100) + '%'
    var data = [value, 1 - value]
    
    // Settings
	var width = 200
    var height = 100
    var anglesRange = 0.5 * Math.PI
    var radis = Math.min(width, 2 * height) / 2
    var thickness = height/3
    // Utility 
//     var colors = d3.scale.category10();
    
    var pies = d3.layout.pie()
    	.value( d => d)
    	.sort(null)
    	.startAngle( anglesRange * -1)
    	.endAngle( anglesRange)
    
		var arc = d3.svg.arc()
    	.outerRadius(radis)
    	.innerRadius(radis - thickness)
    
    var translation = (x, y) => `translate(${x}, ${y})`
    
    // Feel free to change or delete any of the code you see in this editor!
    var svg = d3.select(chartClass).append("svg")
      .attr("width", width)
      .attr("height", height)
    	.attr("class", "half-donut")
			.append("g")
    	.attr("transform", translation(width / 2, height))
    
    
    var path = svg.selectAll("path")
    	.data(pies(data))
    	.enter()
    	.append("path")
    	.attr("fill", (d, i) => colors[i])
    	.attr("d", arc);

	path.transition()
	  .duration(1000)
	  .attrTween('d', function(d) {
	      var interpolate = d3.interpolate({startAngle: anglesRange * -1, endAngle: anglesRange}, d);
	      return function(t) {
	          return arc(interpolate(t));
	      };
	  });

	svg.append("text")
    	.text( d => text)
    	.attr("dy", "0")
    	.attr("class", "label")
    	.attr("text-anchor", "middle");
}

function fancyDonut(chartClass, dataset) {
	if (dataset.length == 0) return;
	var pie=d3.layout.pie()
	        .value(function(d){return d.percent})
	        .sort(null)
	        .padAngle(.03);
	 
	var w = h = 250;
	 
	var outerRadius=w/2;
	var innerRadius=w/3;
	console.log(getColors(dataset));
	var color = d3.scale.ordinal().range(getColors(dataset));
	 
	var arc=d3.svg.arc()
	  .outerRadius(outerRadius)
	  .innerRadius(innerRadius);
	 
	var svg=d3.select(chartClass)
	  .append("svg")
	  .attr({
	      width:w,
	      height:h,
	      class:'shadow'
	  }).append('g')
	  .attr({
	      transform:'translate('+w/2+','+h/2+')'
	  });
	  
	var path=svg.selectAll('path')
	  .data(pie(dataset))
	  .enter()
	  .append('path')
	  .attr({
	      d:arc,
	      fill:function(d,i){
	          return color(d.data.name);
	      }
	  });
	 
	path.transition()
	  .duration(1000)
	  .attrTween('d', function(d) {
	      var interpolate = d3.interpolate({startAngle: 0, endAngle: 0}, d);
	      return function(t) {
	          return arc(interpolate(t));
	      };
	  });
	 
	addText(dataset, pie, color, arc, svg);
}

function addText(dataset, pie, color, arc, svg) {
	var restOfTheData=function(){
    	/*
	    var text=svg.selectAll('text')
	        .data(pie(dataset))
	        .enter()
	        .append("text")
	        .transition()
	        .duration(200)
	        .attr("transform", function (d) {
	            return "translate(" + arc.centroid(d) + ")";
	        })
	        .attr("dy", ".4em")
	        .attr("text-anchor", "middle")
	        .text(function(d){
	            return d.data.percent+"%";
	        })
	        .style({
	            fill:'#ddd',
	            'font-size':'18px'
	        });
	 */
	    var legendRectSize=20;
	    var legendSpacing=7;
	    var legendHeight=legendRectSize+legendSpacing;
	 
        
	    var legend=svg.selectAll('.legend')
	        .data(color.domain())
	        .enter()
	        .append('g')
	        .attr({
	            class:'legend',
	            transform:function(d,i){
	                //Just a calculation for x & y position
	                return 'translate(-40,' + ((i*legendHeight)-40) + ')';
	            }
	        });
	    /*legend.append('rect')
	        .attr({
	            width:legendRectSize,
	            height:legendRectSize,
	            rx:20,
	            ry:20
	        })
	        .style({
	            fill:color,
	            stroke:color
	        });
	        */
	 
	    legend.append('text')
	        .attr({
	            x:15,
	            y:15
	        })
	        .text(function(d){
	            return d;
	        }).style({
	            fill:'#ddd',
	            'font-size':'30px'
	        });
	        
	};

	setTimeout(restOfTheData,1000);
}

function pie(data, selector) {
    var width = 760,
        height = 300,
        radius = Math.min(width, height) / 2 - 10;

    var color = d3.scale.category20();

    var arc = d3.svg.arc()
        .outerRadius(radius);

    var pie = d3.layout.pie();

    var svg = d3.select(selector).append("svg")
        .datum(data)
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

    var arcs = svg.selectAll("g.arc")
        .data(pie)
        .enter().append("g")
        .attr("class", "arc");

    arcs.append("path")
        .attr("fill", function(d, i) { return color(i); })
        .transition()
        .ease("bounce")
        .duration(2000)
        .attrTween("d", tweenPie)
        .transition()
        .ease("elastic")
        .delay(function(d, i) { return 2000 + i * 50; })
        .duration(750)
        .attrTween("d", tweenDonut);

    function tweenPie(b) {
        b.innerRadius = 0;
        var i = d3.interpolate({startAngle: 0, endAngle: 0}, b);
        return function(t) { return arc(i(t)); };
    }

    function tweenDonut(b) {
        b.innerRadius = radius * .6;
        var i = d3.interpolate({innerRadius: 0}, b);
        return function(t) { return arc(i(t)); };
    }

}


function optionalLines(data, selector) {
  var margin = {top: 20, right: 200, bottom: 100, left: 50},
      margin2 = { top: 430, right: 10, bottom: 20, left: 40 },
      width = 960 - margin.left - margin.right,
      height = 500 - margin.top - margin.bottom,
      height2 = 500 - margin2.top - margin2.bottom;
  var bisectDate = d3.bisector(function(d) { return d.date; }).left;
  var xScale = d3.time.scale()
      .range([0, width]),
      xScale2 = d3.time.scale()
      .range([0, width]); // Duplicate xScale for brushing ref later
  var yScale = d3.scale.linear()
      .range([height, 0]);
  var color = d3.scale.category10();
  var xAxis = d3.svg.axis()
      .scale(xScale)
      .orient("bottom"),
      xAxis2 = d3.svg.axis() // xAxis for brush slider
      .scale(xScale2)
      .orient("bottom");
  var yAxis = d3.svg.axis()
      .scale(yScale)
      .orient("left");
  var line = d3.svg.line()
      .interpolate("basis")
      .x(function(d) { return xScale(d.date); })
      .y(function(d) { return yScale(d.rating); })
      .defined(function(d) { return d.rating; });  // Hiding line value defaults of 0 for missing data
  var maxY; // Defined later to update yAxis
  var svg = d3.select(selector).append("svg")
      .attr("width", width + margin.left + margin.right)
      .attr("height", height + margin.top + margin.bottom) //height + margin.top + margin.bottom
    .append("g")
      .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
  // Create invisible rect for mouse tracking
  svg.append("rect")
      .attr("width", width)
      .attr("height", height)                                    
      .attr("x", 0) 
      .attr("y", 0)
      .attr("id", "mouse-tracker")
      .style("fill", "white");
  //for slider part-----------------------------------------------------------------------------------
  var context = svg.append("g") // Brushing context box container
      .attr("transform", "translate(" + 0 + "," + 410 + ")")
      .attr("class", "context");
  //append clip path for lines plotted, hiding those part out of bounds
  svg.append("defs")
    .append("clipPath") 
      .attr("id", "clip")
      .append("rect")
      .attr("width", width)
      .attr("height", height);
  //end slider part-----------------------------------------------------------------------------------
    color.domain(d3.keys(data[0]).filter(function(key) { // Set the domain of the color ordinal scale to be all the csv headers except "date", matching a color to an issue
      return key !== "date"; 
    }));
    var categories = color.domain().map(function(name) { // Nest the data into an array of objects with new keys
      return {
        name: name, // "name": the csv headers except date
        values: data.map(function(d) { // "values": which has an array of the dates and ratings
          return {
            date: d.date, 
            rating: +(d[name]),
            };
        }),
        visible: ((name === "My Time" || name==='High Distinction' || name==='Distinction') ? true : false) // "visible": all false except for economy which is true.
      };
    });
  
    xScale.domain(d3.extent(data, function(d) { return d.date; })); // extent = highest and lowest points, domain is data, range is bouding box
    yScale.domain([0, 100
      //d3.max(categories, function(c) { return d3.max(c.values, function(v) { return v.rating; }); })
    ]);
    xScale2.domain(xScale.domain()); // Setting a duplicate xdomain for brushing reference later
   //for slider part-----------------------------------------------------------------------------------
   var brush = d3.svg.brush()//for slider bar at the bottom
      .x(xScale2) 
      .on("brush", brushed);
    context.append("g") // Create brushing xAxis
        .attr("class", "x axis1")
        .attr("transform", "translate(0," + height2 + ")")
        .call(xAxis2);
    var contextArea = d3.svg.area() // Set attributes for area chart in brushing context graph
      .interpolate("monotone")
      .x(function(d) { return xScale2(d.date); }) // x is scaled to xScale2
      .y0(height2) // Bottom line begins at height2 (area chart not inverted) 
      .y1(0); // Top line of area, 0 (area chart not inverted)
    //plot the rect as the bar at the bottom
    context.append("path") // Path is created using svg.area details
      .attr("class", "area")
      .attr("d", contextArea(categories[0].values)) // pass first categories data .values to area path generator 
      .attr("fill", "#F1F1F2");
    //append the brush for the selection of subsection  
    context.append("g")
      .attr("class", "x brush")
      .call(brush)
      .selectAll("rect")
      .attr("height", height2) // Make brush rects same height 
        .attr("fill", "#E6E7E8");  
    //end slider part-----------------------------------------------------------------------------------
    // draw line graph
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
        .attr("x", -10)
        .attr("dy", ".71em")
        .style("text-anchor", "end")
        .text("Minutes spent on unit");
  
    var issue = svg.selectAll(".issue")
        .data(categories) // Select nested data and append to new svg group elements
      .enter().append("g")
        .attr("class", "issue");   
  
    issue.append("path")
        .attr("class", "line")
        .style("pointer-events", "none") // Stop line interferring with cursor
        .attr("id", function(d) {
          return "line-" + d.name.replace(" ", "").replace("/", ""); // Give line id of line-(insert issue name, with any spaces replaced with no spaces)
        })
        .attr("d", function(d) { 
          return d.visible ? line(d.values) : null; // If array key "visible" = true then draw line, if not then don't 
        })
        .attr("clip-path", "url(#clip)")//use clip path to make irrelevant part invisible
        .style("stroke", function(d) { return color(d.name); });
  
    // draw legend
    var legendSpace = 450 / categories.length; // 450/number of issues (ex. 40)
    function drawlines(d){ // On click make d.visible 
    	console.log(d);
          d.visible = !d.visible; // If array key for this data selection is "visible" = true then make it false, if false then make it true
  
          maxY = findMaxY(categories); // Find max Y rating value categories data with "visible"; true
          yScale.domain([0,maxY]); // Redefine yAxis domain based on highest y value of categories data with "visible"; true
          svg.select(".y.axis")
            .transition()
            .call(yAxis);   
  
          issue.select("path")
            .transition()
            .attr("d", function(d){
              return d.visible ? line(d.values) : null; // If d.visible is true then draw line for this d selection
            })
  
          issue.select("rect")
            .transition()
            .attr("fill", function(d) {
            return d.visible ? color(d.name) : "#F1F1F2";
          });
        }
    issue.append("rect")
        .attr("width", 10)
        .attr("height", 10)                                    
        .attr("x", width + (margin.right/3) - 15) 
        .attr("y", function (d, i) { return (legendSpace)+i*(legendSpace) - 8; })  // spacing
        .attr("fill",function(d) {
          return d.visible ? color(d.name) : "#F1F1F2"; // If array key "visible" = true then color rect, if not then make it grey 
        })
        .attr("class", "legend-box")
        .on("click", drawlines)
        .on("mouseover", function(d){
          d3.select(this)
            .transition()
            .attr("fill", function(d) { return color(d.name); });
  
          d3.select("#line-" + d.name.replace(" ", "").replace("/", ""))
            .transition()
            .style("stroke-width", 2.5);  
        })
        .on("mouseout", function(d){
  
          d3.select(this)
            .transition()
            .attr("fill", function(d) {
            return d.visible ? color(d.name) : "#F1F1F2";});
          d3.select("#line-" + d.name.replace(" ", "").replace("/", ""))
            .transition()
            .style("stroke-width", 1.5);
        })
    issue.append("text")
        .attr("x", width + (margin.right/3)) 
        .attr("y", function (d, i) { return (legendSpace)+i*(legendSpace); })  // (return (11.25/2 =) 5.625) + i * (5.625) 
        .text(function(d) { return d.name; });
    // Hover line 
    var hoverLineGroup = svg.append("g") 
              .attr("class", "hover-line");
    var hoverLine = hoverLineGroup // Create line with basic attributes
          .append("line")
              .attr("id", "hover-line")
              .attr("x1", 10).attr("x2", 10) 
              .attr("y1", 0).attr("y2", height + 10)
              .style("pointer-events", "none") // Stop line interferring with cursor
              .style("opacity", 1e-6); // Set opacity to zero
    var hoverDate = hoverLineGroup
          .append('text')
              .attr("class", "hover-text")
              .attr("y", height - (height-40)) // hover date text position
              .attr("x", width - 150) // hover date text position
              .style("fill", "#E6E7E8");
    var columnNames = d3.keys(data[0]) //grab the key values from your first data row
                                       //these are the same as your column names
                    .slice(1); //remove the first column name (`date`);
    var focus = issue.select("g") // create group elements to house tooltip text
        .data(columnNames) // bind each column name date to each g element
      .enter().append("g") //create one <g> for each columnName
        .attr("class", "focus"); 
  
    focus.append("text") // http://stackoverflow.com/questions/22064083/d3-js-multi-series-chart-with-y-value-tracking
          .attr("class", "tooltip")
          .attr("x", width + 20) // position tooltips  
          .attr("y", function (d, i) { return (legendSpace)+i*(legendSpace); }); // (return (11.25/2 =) 5.625) + i * (5.625) // position tooltips       
  
    // Add mouseover events for hover line.
    d3.select("#mouse-tracker") // select chart plot background rect #mouse-tracker
    .on("mousemove", mousemove) // on mousemove activate mousemove function defined below
    .on("mouseout", function() {
        hoverDate
            .text(null) // on mouseout remove text for hover date
  
        d3.select("#hover-line")
            .style("opacity", 1e-6); // On mouse out making line invisible
    });
    function mousemove() { 
        var mouse_x = d3.mouse(this)[0]; // Finding mouse x position on rect
        var graph_x = xScale.invert(mouse_x); //
        //var mouse_y = d3.mouse(this)[1]; // Finding mouse y position on rect
        //var graph_y = yScale.invert(mouse_y);
        //console.log(graph_x);
        var format = d3.time.format('%b %Y'); // Format hover date text to show three letter month and full year
        hoverDate.text(format(graph_x)); // scale mouse position to xScale date and format it to show month and year
        d3.select("#hover-line") // select hover-line and changing attributes to mouse position
            .attr("x1", mouse_x) 
            .attr("x2", mouse_x)
            .style("opacity", 1); // Making line visible
        // Legend tooltips // http://www.d3noob.org/2014/07/my-favourite-tooltip-method-for-line.html
        var x0 = xScale.invert(d3.mouse(this)[0]), /* d3.mouse(this)[0] returns the x position on the screen of the mouse. xScale.invert function is reversing the process that we use to map the domain (date) to range (position on screen). So it takes the position on the screen and converts it into an equivalent date! */
        i = bisectDate(data, x0, 1), // use our bisectDate function that we declared earlier to find the index of our data array that is close to the mouse cursor
        /*It takes our data array and the date corresponding to the position of or mouse cursor and returns the index number of the data array which has a date that is higher than the cursor position.*/
        d0 = data[i - 1],
        d1 = data[i],
        /*d0 is the combination of date and rating that is in the data array at the index to the left of the cursor and d1 is the combination of date and close that is in the data array at the index to the right of the cursor. In other words we now have two variables that know the value and date above and below the date that corresponds to the position of the cursor.*/
        d = x0 - d0.date > d1.date - x0 ? d1 : d0;
        /*The final line in this segment declares a new array d that is represents the date and close combination that is closest to the cursor. It is using the magic JavaScript short hand for an if statement that is essentially saying if the distance between the mouse cursor and the date and close combination on the left is greater than the distance between the mouse cursor and the date and close combination on the right then d is an array of the date and close on the right of the cursor (d1). Otherwise d is an array of the date and close on the left of the cursor (d0).*/
  
        //d is now the data row for the date closest to the mouse position
        focus.select("text").text(function(columnName){
           //because you didn't explictly set any data on the <text>
           //elements, each one inherits the data from the focus <g>
  
           return (d[columnName]);
        });
    };
    //for brusher of the slider bar at the bottom
    function brushed() {
      xScale.domain(brush.empty() ? xScale2.domain() : brush.extent()); // If brush is empty then reset the Xscale domain to default, if not then make it the brush extent
      svg.select(".x.axis") // replot xAxis with transition when brush used
            .transition()
            .call(xAxis);
      maxY = findMaxY(categories); // Find max Y rating value categories data with "visible"; true
      yScale.domain([0,maxY]); // Redefine yAxis domain based on highest y value of categories data with "visible"; true
      svg.select(".y.axis") // Redraw yAxis
        .transition()
        .call(yAxis);
      issue.select("path") // Redraw lines based on brush xAxis scale and domain
        .transition()
        .attr("d", function(d){
            return d.visible ? line(d.values) : null; // If d.visible is true then draw line for this d selection
        });
      
    };
    function findMaxY(data){  // Define function "findMaxY"
      var maxYValues = data.map(function(d) { 
        if (d.visible){
          return d3.max(d.values, function(value) { // Return max rating value
            return value.rating; })
        }
      });
      return d3.max(maxYValues);
    }
}
