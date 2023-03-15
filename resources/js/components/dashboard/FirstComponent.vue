<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <div class="card p-0">
                    <div class="card-body p-0">
                        <div id="barchart_values1" ></div>
                    </div>
                </div>
            </div>
        
            <div class="col-md-6">
                <div class="card p-0">
                    <div class="card-body p-0">
                        <div id="barchart_values2"></div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-6">
                <div class="card p-0">
                    <div class="card-body p-0">
                        <div id="barchart_values3"></div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-6">
                <div class="card p-0">
                    <div class="card-body p-0">
                        <div id="barchart_values4"></div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "FirstComponent",
    data() {
      return {
        message: "First component mounted"
      };
    },
    mounted(){
        google.charts.setOnLoadCallback(drawChart1);
        google.charts.setOnLoadCallback(drawChart2);
    },

    
  };

  google.charts.load("current", {packages:["corechart"]});
  google.charts.load('current', {packages:['gauge']});
  google.charts.load('current', {packages:['treemap']});
    
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
      var chart1 = new google.visualization.BarChart(document.getElementById("barchart_values1"));
      chart1.draw(view, options);

      var chart2 = new google.visualization.ColumnChart(document.getElementById("barchart_values2"));
      chart2.draw(view, options);

      var chart3 = new google.visualization.PieChart(document.getElementById("barchart_values3"));
      chart3.draw(view, options);


  }

  function drawChart2() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2004',  1000,      400],
          ['2005',  1170,      460],
          ['2006',  660,       1120],
          ['2007',  1030,      540]
        ]);

        var options = {
          title: 'Company Performance',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('barchart_values4'));

        chart.draw(data, options);
      }
  </script>
  