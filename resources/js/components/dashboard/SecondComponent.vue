<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <div class="card p-0">
                    <div class="card-body p-0 text-center">
                        <div id="barchart_values3"></div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-4">
                <div class="card p-0">
                    <div class="card-body p-0 text-center">
                        <div id="barchart_values4"></div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-4">
                <div class="card p-0">
                    <div class="card-body p-0 text-center">
                        <div id="barchart_values5"></div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-6">
                <div class="card p-0">
                    <div class="card-body p-0 text-center">
                        <div id="barchart_values1" ></div>
                    </div>
                </div>
            </div>
        
            <div class="col-md-6">
                <div class="card p-0">
                    <div class="card-body p-0 text-center">
                        <div id="barchart_values2"></div>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "SecondComponent",
    data() {
      return {
        message: "Second component mounted"
      };
    },
    mounted(){
        google.charts.setOnLoadCallback(drawChart1);
        google.charts.setOnLoadCallback(drawChart2);
        google.charts.setOnLoadCallback(drawChart3);
        google.charts.setOnLoadCallback(drawChart4);
        google.charts.setOnLoadCallback(drawChart5);
    },

    
  };

  google.charts.load("current", {packages:["corechart"]});
  google.charts.load('current', {packages:['gauge']});
//   google.charts.load('current', {packages:['treemap']});
  google.charts.load('current', {'packages':['treemap']});
    
    function drawChart1() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
        ["Copper", 8.94, "#b87333"],
        ["Silver", 10.49, "silver"],
        ["Gold", 19.30, "gold"],
        ["Platinum", 21.45, "color: #e5e4e2"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Density of Precious Metals, in g/cm^3",
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };

      var chart2 = new google.visualization.ColumnChart(document.getElementById("barchart_values2"));
      chart2.draw(view, options);

    }
    function drawChart2() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('barchart_values3'));
        chart.draw(data, options);
    }

    function drawChart3() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('barchart_values4'));
        chart.draw(data, options);
    }

    function drawChart4() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Pizza');
        data.addColumn('number', 'Populartiy');
        data.addRows([
        ['Pepperoni', 33],
        ['Hawaiian', 26],
        ['Mushroom', 22],
        ['Sausage', 10], // Below limit.
        ['Anchovies', 9] // Below limit.
        ]);

        var options = {
        title: 'Popularity of Types of Pizza',
        sliceVisibilityThreshold: .2
        };

        var chart = new google.visualization.PieChart(document.getElementById('barchart_values5'));
        chart.draw(data, options);
    }

    function drawChart5() {
        var data = google.visualization.arrayToDataTable([
          ['Location', 'Parent', 'Market trade volume (size)', 'Market increase/decrease (color)'],
          ['Global',    null,                 0,                               0],
          ['America',   'Global',             0,                               0],
          ['Europe',    'Global',             0,                               0],
          ['Asia',      'Global',             0,                               0],
          ['Australia', 'Global',             0,                               0],
          ['Africa',    'Global',             0,                               0],
          ['Brazil',    'America',            11,                              10],
          ['USA',       'America',            52,                              31],
          ['Mexico',    'America',            24,                              12],
          ['Canada',    'America',            16,                              -23],
          ['France',    'Europe',             42,                              -11],
          ['Germany',   'Europe',             31,                              -2],
          ['Sweden',    'Europe',             22,                              -13],
          ['Italy',     'Europe',             17,                              4],
          ['UK',        'Europe',             21,                              -5],
          ['China',     'Asia',               36,                              4],
          ['Japan',     'Asia',               20,                              -12],
          ['India',     'Asia',               40,                              63],
          ['Laos',      'Asia',               4,                               34],
          ['Mongolia',  'Asia',               1,                               -5],
          ['Israel',    'Asia',               12,                              24],
          ['Iran',      'Asia',               18,                              13],
          ['Pakistan',  'Asia',               11,                              -52],
          ['Egypt',     'Africa',             21,                              0],
          ['S. Africa', 'Africa',             30,                              43],
          ['Sudan',     'Africa',             12,                              2],
          ['Congo',     'Africa',             10,                              12],
          ['Zaire',     'Africa',             8,                               10]
        ]);

        var tree = new google.visualization.TreeMap(document.getElementById('barchart_values1'));

        tree.draw(data, {
          minColor: '#f00',
          midColor: '#ddd',
          maxColor: '#0d0',
          headerHeight: 15,
          fontColor: 'black',
          showScale: true
        });

      }
  </script>
  