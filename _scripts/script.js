$(document).ready(init);

var statuses = [
    {'class': 'risk',     'txt': 'You are at risk.',    'color': 'firebrick'},
    {'class': 'warning',  'txt': 'You are borderline.', 'color': 'gold'},
    {'class': 'good',     'txt': 'You are doing well.', 'color': 'limegreen'}
];

function init(){
    var percent = getPercent(".signal-chart");
	console.log(percent);

	var dataset = [
		{ name: percent+'%', percent: percent, color: statuses[getStatus(percent)].color},
		{ name: '', percent: 100-percent, color: "#ddd"},
	];
    updateChart(".signal-chart", dataset);
    alert('here');
    $('#show-nav-menu').click(showMenu);
}

function showMenu() {
	alert('click');
	$('.wrapper-container').addClass('show-mob-nav');
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
function updateChart(chartClass, dataset) {
	$(chartClass).html("");

	dataset = cleanDataset(dataset);
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