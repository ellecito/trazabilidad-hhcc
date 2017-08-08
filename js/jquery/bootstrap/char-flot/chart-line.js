//Flot Line Chart with Tooltips
$(document).ready(function(){
	// console.log("document ready");
	var offset = 0;
	plot();
	function plot(){
		var sin = [], cos = [];
		for (var i = 0; i < 12; i += 0.2) {
			sin.push([i, Math.sin(i + offset)]);
			cos.push([i, Math.cos(i + offset)]);
		}
	
		var options = {
			series: {
				lines: { show: true },
				points: { show: true }
			},
			grid: {
				hoverable: true //IMPORTANT! this is needed for tooltip to work
			},
			yaxis: { min: -1.2, max: 1.2 },
			tooltip: true,
			tooltipOpts: {
				content: "'%s' of %x.1 is %y.4",
				shifts: {
					x: -60,
					y: 25
				}
			}
		};
	
		var plotObj = $.plot( $("#grafico-line-1"),
			[ { data: sin, label: "sin(x)"}, { data: cos, label: "cos(x)" } ],
			options );
	}

});




//Flot Line Chart with Tooltips
$(document).ready(function(){
	// console.log("document ready");
	var offset = 0;
	plot();
	function plot(){
		var ida = [], ton = []; ret = [];
		for (var i = 0; i < 12; i += 0.2) {
			ida.push([i, Math.sin(i + offset)]);
			ton.push([i, Math.cos(i + offset)]);
			ret.push([i, Math.cos(i + offset + i)]);
		}
	
		var options = {
			series: {
				lines: { show: true },
				points: { show: true }
			},
			grid: {
				hoverable: true //IMPORTANT! this is needed for tooltip to work
			},
			yaxis: { min: -1.2, max: 1.2 },
			// xaxis: { min: 0, max: 50 },
			tooltip: true,
			tooltipOpts: {
				content: "'%s' of %x.1 is %y.4",
				shifts: {
					x: -60,
					y: 25
				}
			}
		};
	
		var plotObj = $.plot( $("#grafico-line-2"),
			[ { data: ida, label: "Salida ida"}, { data: ton, label: "Toneladas reales" },  { data: ret, label: "Salida retorno" } ],
			options );
	}

});