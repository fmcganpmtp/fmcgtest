@extends('layouts.template')
@section('title', 'MAP')
@section('content')
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>


<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
 /* height: 500px;*/
}
</style>

<!-- Resources -->


<!-- Chart code -->
<script>
am5.ready(function() {

// Data
var groupData = [
  {
    "name": "Regions we are ative in",
    "data": [
      { "id": "AF", "status": "Expand To"},
      { "id": "AL", "status": "Expand To"},
      { "id": "DZ", "status": "Expand To"},
      { "id": "AS", "status": "Expand To"},
      { "id": "AD", "status": "Expand To"},
      { "id": "AO", "status": "Expand To"},
      { "id": "AI", "status": "Expand To"},
      { "id": "AQ", "status": "Expand To"},
      { "id": "AG", "status": "Expand To"},
      { "id": "AR", "status": "Expand To"},
      { "id": "AM", "status": "Expand To"},
      { "id": "AW", "status": "Expand To"},
      { "id": "AU", "status": "Expand To"},
      { "id": "IN", "status": "Expand To"},
      { "id": "AZ", "status": "Expand To"}
   ]
  }, {
    "name": "Regions we would like to expand to",
    "data": [
      { "id": "BS", "status": "Active" },
      { "id": "BH", "status": "Active" },
      { "id": "BD", "status": "Active" },
      { "id": "BB", "status": "Active" },
      { "id": "BY", "status": "Active" },
      { "id": "BE", "status": "Active" },
      { "id": "BZ", "status": "Active" },
      { "id": "BJ", "status": "Active" },
      { "id": "BM", "status": "Active" },
      { "id": "RU", "status": "Active" }
    ]
  }
];


// Create root and chart
var root = am5.Root.new("chartdiv");


// Set themes
root.setThemes([
  am5themes_Animated.new(root)
]);


// Create chart
var chart = root.container.children.push(am5map.MapChart.new(root, {
  homeZoomLevel: 3.5,
  homeGeoPoint: { longitude: 10, latitude: 52 }
}));


// Create world polygon series
var worldSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {
  geoJSON: am5geodata_worldLow,
  exclude: ["AQ"]
}));

worldSeries.mapPolygons.template.setAll({
  fill: am5.color(0xaaaaaa)
});

worldSeries.events.on("datavalidated", () => {
  chart.goHome();
});


// Add legend
var legend = chart.children.push(am5.Legend.new(root, {
  useDefaultMarker: true,
  centerX: am5.p50,
  x: am5.p50,
  centerY: am5.p100,
  y: am5.p100,
  dy: -20,
  background: am5.RoundedRectangle.new(root, {
    fill: am5.color(0xffffff),
    fillOpacity: 0.2
  })
}));

legend.valueLabels.template.set("forceHidden", true)


// Create series for each group
var colors = am5.ColorSet.new(root, {
  step: 2
});
colors.next();

am5.array.each(groupData, function(group) {
  var countries = [];
  var color = colors.next();

  am5.array.each(group.data, function(country) {
    countries.push(country.id)
  });

  var polygonSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {
    geoJSON: am5geodata_worldLow,
    include: countries,
    name: group.name,
    fill: color
  }));


  polygonSeries.mapPolygons.template.setAll({
    tooltipText: "[bold]{name}[/]\n{status} Region ",
    interactive: true,
    fill: color,
    strokeWidth: 2
  });

  polygonSeries.mapPolygons.template.states.create("hover", {
    fill: am5.Color.brighten(color, -0.3)
  });

  polygonSeries.mapPolygons.template.events.on("pointerover", function(ev) {
    ev.target.series.mapPolygons.each(function(polygon) {
      polygon.states.applyAnimate("hover");
    });
  });

  polygonSeries.mapPolygons.template.events.on("pointerout", function(ev) {
    ev.target.series.mapPolygons.each(function(polygon) {
      polygon.states.applyAnimate("default");
    });
  });
  polygonSeries.data.setAll(group.data);

  legend.data.push(polygonSeries);
});

}); // end am5.ready()
</script>

<!-- HTML -->
<div id="chartdiv"></div>
            

@endsection
