<template>
    <div>

      <div class="row d-flex justify-content-center pb-4">
       <div class="col-md-2">
          <select style="width:100%">
            <option value="0">All Centre</option>
            <option value="1">Dhaka</option>
            <option value="2">Cittagong</option>
          </select>
        </div> 
        <div class="col-md-2">
          <select style="width:100%">
            <option value="0">All Centre</option>
            <option value="1">Dhaka</option>
            <option value="2">Cittagong</option>
          </select>
        </div>
        
      </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card p-0 pb-2" style="overflow:hidden">
                  <!-- <div class="card-header"></div> -->
                    <div class="card-body border-primary p-0">
                        <div class="p-0" id="barchart_values1" ></div>
                    </div>
                </div>
            </div>
        
            <!-- <div class="col-md-6">
                <div class="card p-0">
                    <div class="card-body p-0">
                        <div id="barchart_values2"></div>
                    </div>
                </div>
                
            </div> -->
            <div class="col-md-6">
                <div class="card p-0">
                    <div class="card-body p-0">
                        <div class="p-0" id="barchart_values3"></div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-6">
                <div class="card p-0">
                    <div class="card-body p-0">
                        <div class="p-0" id="barchart_values4"></div>
                    </div>
                </div>
                
            </div>

            <div class="col-md-4">
                <div class="card p-0">
                    <div class="card-body p-0">
                        <div class="p-0" id="barchart_values5"></div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-4">
                <div class="card p-0">
                    <div class="card-body p-0">
                        <div class="p-0" id="barchart_values6"></div>
                    </div>
                </div>
                
            </div><div class="col-md-4">
                <div class="card p-0">
                    <div class="card-body p-0">
                        <div class="p-0" id="barchart_values7"></div>
                    </div>
                </div>
                
            </div>



            <div class="col-md-6">
                <div class="card p-0">
                    <div class="card-body p-0">
                        <div class="p-0" id="barchart_values8"></div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-6">
                <div class="card p-0">
                    <div class="card-body p-0">
                        <div class="p-0" id="barchart_values9"></div>
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
    
    props:['project_id'],

    mounted(){
        google.charts.setOnLoadCallback(drawChart1);

        google.charts.setOnLoadCallback(drawChart2);
        google.charts.setOnLoadCallback(drawChart3);

        google.charts.setOnLoadCallback(drawChart4);
        google.charts.setOnLoadCallback(drawChart5);
        google.charts.setOnLoadCallback(drawChart6);
        
        google.charts.setOnLoadCallback(drawChart7);
        google.charts.setOnLoadCallback(drawChart8);
    },

    
  };

  google.charts.load("current", {packages:["corechart"]});
  google.charts.load('current', {packages:['gauge']});
  google.charts.load('current', {packages:['treemap']});
  google.charts.load('current', {'packages':['bar']});
  google.charts.load('current', {'packages':['table']});
    
    function drawChart1() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Bolivia', 'Ecuador', 'Madagascar', 'Papua New Guinea', 'Rwanda', 'Average'],
          ['2004/05',  165,      938,         522,             998,           450,      614.6],
          ['2005/06',  135,      1120,        599,             1268,          288,      682],
          ['2006/07',  157,      1167,        587,             807,           397,      623],
          ['2007/08',  139,      1110,        615,             968,           215,      609.4],
          ['2008/09',  136,      691,         629,             1026,          366,      569.6]
        ]);

        var options = {
          // chartArea:{bottom:'5%'},
          title : 'Monthly Coffee Production by Country',
          vAxis: {title: 'Cups'},
          hAxis: {title: 'Month'},
            
          seriesType: 'bars',
          series: {5: {type: 'line'}},
          legend:{
            position:'bottom',
            textStyle:{fontSize:12},
          }
        };

        var chart = new google.visualization.ComboChart(document.getElementById('barchart_values1'));
        chart.draw(data, options);
        


  }

  function drawChart2() {
    var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses', 'Profit'],
          ['2014', 1000, 400, 200],
          ['2015', 1170, 460, 250],
          ['2016', 660, 1120, 300],
          ['2017', 1030, 540, 350]
        ]);

        var options = {
          chart: {
            title: 'Company Performance',
            subtitle: 'Sales, Expenses, and Profit: 2014-2017',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_values3'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }

      function drawChart3() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses', 'Profit'],
          ['2014', 1000, 400, 200],
          ['2015', 1170, 460, 250],
          ['2016', 660, 1120, 300],
          ['2017', 1030, 540, 350]
        ]);

        var options = {
          chart: {
            title: 'Company Performance',
            subtitle: 'Sales, Expenses, and Profit: 2014-2017',
          },
          bars: 'horizontal' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_values4'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }

      function drawChart4() {
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

      var chart = new google.visualization.PieChart(document.getElementById('barchart_values5'));
      chart.draw(data, options);
  }

  function drawChart5() {

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

      var chart = new google.visualization.PieChart(document.getElementById('barchart_values6'));
      chart.draw(data, options);
  }

  function drawChart6() {

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

        var chart = new google.visualization.PieChart(document.getElementById('barchart_values7'));
        chart.draw(data, options);
    }

    function drawChart7() {
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

        var chart = new google.visualization.LineChart(document.getElementById('barchart_values8'));

        chart.draw(data, options);

    }

    function drawChart8() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('number', 'Salary');
        data.addColumn('boolean', 'Full Time Employee');
        data.addRows([
          ['Mike',  {v: 10000, f: '$10,000'}, true],
          ['Jim',   {v:8000,   f: '$8,000'},  false],
          ['Alice', {v: 12500, f: '$12,500'}, true],
          ['Bob',   {v: 7000,  f: '$7,000'},  true]
        ]);

        var table = new google.visualization.Table(document.getElementById('barchart_values9'));

        table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
    }

  </script>
  