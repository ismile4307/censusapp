<template>
    <div>
    <div class="text-center mt-9" id="spinner" style="height:480px">
        <div class="spinner-grow text-info align-middle" style="width: 3rem; height: 3rem;" role="status">
          <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div id="display">
      <div class="row d-flex justify-content-center pb-2">
       <!-- <div class="col-md-2">
          <select class="control-select" style="width:100%" 
            @change="getChartData()"
            v-model="selectedCenter">
            <option value="0">All Centre</option>
            <template v-for="centre in allCenters" :key="centre.attribute_value">
            <option  :value="centre.attribute_value">{{centre.attribute_label}}</option>
            </template>
          </select>
        </div>  -->
        <!-- <div class="col-md-2">
          <select class="control-select" style="width:100%">
            <option value="0">All Centre</option>
            <option value="1">Dhaka</option>
            <option value="2">Cittagong</option>
          </select>
        </div> -->
        
      </div>

        <div class="row">
            <!-- <div class="col-md-6">
                <div class="card p-0">
                    <div class="card-body p-0">
                        <div id="barchart_values1" ></div>
                    </div>
                </div>
            </div> -->
        
            <div class="col-md-4">
                <div class="card p-0">
                    <div class="card-body p-0 card-outline card-primary" style="overflow: hidden;">
                        <div id="table_chart1"></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart1 }}</span>
                    </div>
                </div>
                
            </div>
            <div class="col-md-4">
                <div class="card p-0">
                    <div class="card-body p-0 card-outline card-primary" style="overflow: hidden;">
                        <div id="paichart_callsummary"></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart2 }}</span>
                    </div>
                </div>
                
            </div>
            <div class="col-md-4">
                <div class="card p-0">
                    <div class="card-body p-0 card-outline card-primary" style="overflow: hidden;">
                        <div id="barchart_placeofbuying"></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart5 }}</span>
                    </div>
                </div>
                
            </div>
            
        </div>


        <div class="row">
            <!-- <div class="col-md-6">
                <div class="card p-0">
                    <div class="card-body p-0">
                        <div id="barchart_values1" ></div>
                    </div>
                </div>
            </div> -->
        
            <div class="col-md-4">
                <div class="card p-0">
                    <div class="card-body p-0 card-outline card-primary" style="overflow: hidden;">
                        <div id="paichart_loyalconsumer"></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart3 }}</span>
                    </div>
                </div>
                
            </div>
            <div class="col-md-8">
                <div class="card pl-3 pr-3 card-outline card-primary">
                    <div class="card-body p-0" style="overflow: hidden;">
                        <div id="columnchart_loyalbyBrand"></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart6 }}</span>
                    </div>
                </div>
                
            </div>
            <!-- <div class="col-md-4">
                <div class="card p-0">
                    <div class="card-body p-0" style="overflow: hidden;">
                        <div id="barchart_values4"></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart3 }}</span>
                    </div>
                </div>
                
            </div> -->
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card pl-3 pr-3 card-outline card-primary">
                    <div class="card-body p-0" style="overflow: hidden;">
                        <div id="columnchart_busket1"></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart7 }}</span>
                    </div>
                </div>                
            </div>
            <div class="col-md-4">
                <div class="card pl-3 pr-3 card-outline card-primary">
                    <div class="card-body p-0" style="overflow: hidden;">
                        <div id="columnchart_busket2"></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart7 }}</span>
                    </div>
                </div>                
            </div>
            <div class="col-md-4">
                <div class="card pl-3 pr-3 card-outline card-primary">
                    <div class="card-body p-0" style="overflow: hidden;">
                        <div id="columnchart_busket3"></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart7 }}</span>
                    </div>
                </div>                
            </div>
        </div>


    </div>


    </div>
  </template>
  
  <script>
// import func from 'vue-editor-bridge';
  export default {
    name: "FirstComponent",
    data() {
      return {
        allCenters:[],
        selectedCenter:'',

        dataChart1:[],
      dataChart2:[],
      dataChart3:[],
      dataChart4:[],
      dataChart5:[],
      dataChart6:[],
      dataChart7:[],

      baseChart1:'',
      baseChart2:'',
      baseChart3:'',
      baseChart4:'',
      baseChart5:'',
      baseChart6:'',
      baseChart7:'',

        // message: "First component mounted"
      };
    },

    props:['project_id'],

    mounted(){
        // if(this.selectedCenter=='')
          this.selectedCenter=0;

        // this.getCenter();
        this.getChartData();
        
        // google.charts.setOnLoadCallback(drawChart2);

        $('#display').hide();
      // $('#spinner').show();
    },

    methods:{
      getCenter(){
        axios.get('/data_analysis/'+this.project_id+'/dashboard/get_center_d1')
          .then(response => {
              this.allCenters = response.data
          });
      },

      getChartData(){
        // console.log(this.selectedCenter);
        axios.post('/dashboard_infoc/'+this.project_id+'/child01', {
          center_id: this.selectedCenter,
        }).then(response =>{
          // console.log(response.data);

          this.dataChart2 = response.data[0];
          this.baseChart2 = response.data[1];

          this.dataChart2 = response.data[2];
          this.baseChart2 = response.data[3];

          this.dataChart3 = response.data[4];
          this.baseChart3 = response.data[5];

          this.dataChart5 = response.data[6];
          this.baseChart5 = response.data[7];

          this.dataChart6 = response.data[8];
          this.baseChart6 = response.data[9];
          

          this.dataChart7 = response.data[10];
          this.baseChart7 = response.data[11];

          

this.dataChart8 = response.data[12];
this.baseChart8 = response.data[13];


this.dataChart9 = response.data[14];
        this.baseChart9 = response.data[15];


          // console.log(this.dataChart2);
          $('#spinner').hide();
        $('#display').show();
          
          google.charts.setOnLoadCallback(drawChartCallSummary);
          google.charts.setOnLoadCallback(drawChartPanelSize(this.dataChart2));
          google.charts.setOnLoadCallback(drawChartLoyalConsumer(this.dataChart3));
          google.charts.setOnLoadCallback(drawChartPlaceOfBuying(this.dataChart5));
          google.charts.setOnLoadCallback(drawChartLoyaltyByBrand(this.dataChart6));

          
          google.charts.setOnLoadCallback(drawChartBusketMilkPowder1(this.dataChart7));
          google.charts.setOnLoadCallback(drawChartBusketMilkPowder2(this.dataChart8));
          google.charts.setOnLoadCallback(drawChartBusketMilkPowder3(this.dataChart9));

          // google.charts.setOnLoadCallback(drawChart1(this.dataChart1));
          // google.charts.setOnLoadCallback(drawChart2(this.dataChart2));
          // google.charts.setOnLoadCallback(drawChart3(this.dataChart3));

        });

        google.charts.setOnLoadCallback(drawChartCallSummary);
      }

    },

    
  };



  google.charts.load("current", {packages:["corechart"]});
  google.charts.load('current', {packages:['gauge']});
  google.charts.load('current', {packages:['treemap']});
  google.charts.load('current', {'packages':['bar']});
  google.charts.load('current', {'packages':['table']});
  
  function drawChartCallSummary() {
        var data = new google.visualization.DataTable();
        
        data.addColumn('string', 'Name');
        data.addColumn('number', 'Salary');
        data.addColumn('boolean', 'Full Time Employee');
        data.addRows([
          ['Mike',  {v: 10000, f: '$10,000'}, true],
          ['Jim',   {v: 8000,   f: '$8,000'},  false],
          ['Alice', {v: 12500, f: '$12,500'}, true],
          ['Bob',   {v: 7000,  f: '$7,000'},  true]
        ]);

        var table = new google.visualization.Table(document.getElementById('table_chart1'));

        table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
    }

  //*** pie Chart */
  function drawChartPanelSize(dataChart) {
      var data = google.visualization.arrayToDataTable(dataChart);

      var options = {
        title: 'Panel Size & Distribution',
        subtitle:'aa',
        pieHole: 0.4,
        // pieSliceText: 'value',
        pieSliceTextStyle:{fontSize:11},
        // legend: {position: 'top', textStyle: {color: 'blue', fontSize: 10}}
        height:230,
        // width:380,
        chartArea:{left:20,top:40,width:'100%',height:'70%'}
      };

    var piechart = new google.visualization.PieChart(document.getElementById("paichart_callsummary"));
    piechart.draw(data, options);

    }

    //*** pie Chart */
  function drawChartLoyalConsumer(dataChart2) {
    var data = google.visualization.arrayToDataTable(dataChart2);

    var options = {
      title: 'Loyality of Consumer',
          is3D: true,
          height:230,
          chartArea:{left:20,top:40,width:'100%',height:'70%'}
    };

    var piechart = new google.visualization.PieChart(document.getElementById("paichart_loyalconsumer"));
    piechart.draw(data, options);

  }

  //*** bar Chart */
  function drawChartPlaceOfBuying(dataChart3) {
      var data = google.visualization.arrayToDataTable(dataChart3);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation"}]);

      var options = {
        title: "Usual place of buying milk powder",
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
        colors:['#b87333'],
        height:230,
        chartArea:{left:80,top:40,width:'90%',height:'70%'}
      };

      var chart1 = new google.visualization.BarChart(document.getElementById("barchart_placeofbuying"));
      chart1.draw(view, options);

    }

  function drawChartLoyaltyByBrand(dataChart4){
    var data = google.visualization.arrayToDataTable(dataChart4);

    var view = new google.visualization.DataView(data);
      view.setColumns([0, 1, {
                          calc: "stringify",
                          sourceColumn: 1,
                          type: "string",
                          role: "annotation"
                      }, 2, {
                          calc: "stringify",
                          sourceColumn: 2,
                          type: "string",
                          role: "annotation"
                      }]);

      var options = {
        title: "Loyal consumer by brand",
        
        // width: 600,
        // height: 400,
        fontSize: 11,
        bar: {groupWidth: "50%"},
        tooltip:{textStyle: {fontSize: 12}},
        // bars:'horizontal',
        // hAxis: { title: 'Users', titleTextStyle: { color: 'red', fontSize: 16} },
        legend: { position: "right", textStyle: {fontSize: 9} },
        height:230,
        chartArea:{left:40,top:40,width:'82%',height:'70%'}
        
      };

        // var options = {
        //   chart: {
        //     title: 'Loyal consumer by brnd',
        //     // subtitle: 'Sales, Expenses, and Profit: 2014-2017',
        //   },
        //   // bars: 'horizontal' // Required for Material Bar Charts.
        // };

        // var chart = new google.charts.Bar(document.getElementById('columnchart_loyalbyBrand'));

        // chart.draw(data, google.charts.Bar.convertOptions(options));


      var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_loyalbyBrand'));
      chart.draw(view, options);

  }


  function drawChartBusketMilkPowder1(dataChart4){
    var data = google.visualization.arrayToDataTable(dataChart4);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1, {calc: "stringify", sourceColumn: 1, type: "string", role: "annotation" }, 
    //                       2 , {calc: "stringify", sourceColumn: 2 , type: "string", role: "annotation" },
    //                       3 , {calc: "stringify", sourceColumn: 3 , type: "string", role: "annotation" },
    //                       4 , {calc: "stringify", sourceColumn: 4 , type: "string", role: "annotation" },
    //                       5 , {calc: "stringify", sourceColumn: 5 , type: "string", role: "annotation" },
    //                       6 , {calc: "stringify", sourceColumn: 6 , type: "string", role: "annotation" },
    //                       7 , {calc: "stringify", sourceColumn: 7 , type: "string", role: "annotation" },
    //                       8 , {calc: "stringify", sourceColumn: 8 , type: "string", role: "annotation" },
    //                       9 , {calc: "stringify", sourceColumn: 9 , type: "string", role: "annotation" },
    //                       10, {calc: "stringify", sourceColumn: 10, type: "string", role: "annotation" },
    //                       11, {calc: "stringify", sourceColumn: 11, type: "string", role: "annotation" },
    //                       12, {calc: "stringify", sourceColumn: 12, type: "string", role: "annotation" },
    //                       13, {calc: "stringify", sourceColumn: 13, type: "string", role: "annotation" },
    //                       14, {calc: "stringify", sourceColumn: 14, type: "string", role: "annotation" },
    //                       15, {calc: "stringify", sourceColumn: 15, type: "string", role: "annotation" },
    //                       16, {calc: "stringify", sourceColumn: 16, type: "string", role: "annotation" },
    //                       17, {calc: "stringify", sourceColumn: 17, type: "string", role: "annotation" },
    //                       18, {calc: "stringify", sourceColumn: 18, type: "string", role: "annotation" },
    //                       // 19, {calc: "stringify", sourceColumn: 19, type: "string", role: "annotation" },
    //                       // 20, {calc: "stringify", sourceColumn: 20, type: "string", role: "annotation" },
                        ]);

      var options = {
        title: "Basket of Milk Powder (All)",
        
        // width: 600,
        // height: 400,
        fontSize: 11,
        bar: {groupWidth: "95%"},
        tooltip:{textStyle: {fontSize: 12}},
        // colors:['#008080','#be0032','#008080','#800000'],
        // bars:'horizontal',
        // hAxis: { title: 'Users', titleTextStyle: { color: 'red', fontSize: 16} },
        legend: { position: "none", textStyle: {fontSize: 9} },
        height:480,
        chartArea:{left:100,top:40,width:'80%',height:'85%'}
        
      };

      var chart = new google.visualization.BarChart(document.getElementById('columnchart_busket1'));
      chart.draw(view, options);

  }

  function drawChartBusketMilkPowder2(dataChart4){
    var data = google.visualization.arrayToDataTable(dataChart4);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1, {calc: "stringify", sourceColumn: 1, type: "string", role: "annotation" }, 
    //                       2 , {calc: "stringify", sourceColumn: 2 , type: "string", role: "annotation" },
    //                       3 , {calc: "stringify", sourceColumn: 3 , type: "string", role: "annotation" },
    //                       4 , {calc: "stringify", sourceColumn: 4 , type: "string", role: "annotation" },
    //                       5 , {calc: "stringify", sourceColumn: 5 , type: "string", role: "annotation" },
    //                       6 , {calc: "stringify", sourceColumn: 6 , type: "string", role: "annotation" },
    //                       7 , {calc: "stringify", sourceColumn: 7 , type: "string", role: "annotation" },
    //                       8 , {calc: "stringify", sourceColumn: 8 , type: "string", role: "annotation" },
    //                       9 , {calc: "stringify", sourceColumn: 9 , type: "string", role: "annotation" },
    //                       10, {calc: "stringify", sourceColumn: 10, type: "string", role: "annotation" },
    //                       11, {calc: "stringify", sourceColumn: 11, type: "string", role: "annotation" },
    //                       12, {calc: "stringify", sourceColumn: 12, type: "string", role: "annotation" },
    //                       13, {calc: "stringify", sourceColumn: 13, type: "string", role: "annotation" },
    //                       14, {calc: "stringify", sourceColumn: 14, type: "string", role: "annotation" },
    //                       15, {calc: "stringify", sourceColumn: 15, type: "string", role: "annotation" },
    //                       16, {calc: "stringify", sourceColumn: 16, type: "string", role: "annotation" },
    //                       17, {calc: "stringify", sourceColumn: 17, type: "string", role: "annotation" },
    //                       18, {calc: "stringify", sourceColumn: 18, type: "string", role: "annotation" },
    //                       // 19, {calc: "stringify", sourceColumn: 19, type: "string", role: "annotation" },
    //                       // 20, {calc: "stringify", sourceColumn: 20, type: "string", role: "annotation" },
                        ]);

      var options = {
        title: "Basket of Milk Powder (Regular User)",
        
        // width: 600,
        // height: 400,
        fontSize: 11,
        bar: {groupWidth: "95%"},
        tooltip:{textStyle: {fontSize: 12}},
        colors:['#008080','#be0032','#008080','#800000'],
        // bars:'horizontal',
        // hAxis: { title: 'Users', titleTextStyle: { color: 'red', fontSize: 16} },
        legend: { position: "none", textStyle: {fontSize: 9} },
        height:480,
        chartArea:{left:100,top:40,width:'80%',height:'85%'}
        
      };

      var chart = new google.visualization.BarChart(document.getElementById('columnchart_busket2'));
      chart.draw(view, options);

  }

  function drawChartBusketMilkPowder3(dataChart4){
    var data = google.visualization.arrayToDataTable(dataChart4);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1, {calc: "stringify", sourceColumn: 1, type: "string", role: "annotation" }, 
    //                       2 , {calc: "stringify", sourceColumn: 2 , type: "string", role: "annotation" },
    //                       3 , {calc: "stringify", sourceColumn: 3 , type: "string", role: "annotation" },
    //                       4 , {calc: "stringify", sourceColumn: 4 , type: "string", role: "annotation" },
    //                       5 , {calc: "stringify", sourceColumn: 5 , type: "string", role: "annotation" },
    //                       6 , {calc: "stringify", sourceColumn: 6 , type: "string", role: "annotation" },
    //                       7 , {calc: "stringify", sourceColumn: 7 , type: "string", role: "annotation" },
    //                       8 , {calc: "stringify", sourceColumn: 8 , type: "string", role: "annotation" },
    //                       9 , {calc: "stringify", sourceColumn: 9 , type: "string", role: "annotation" },
    //                       10, {calc: "stringify", sourceColumn: 10, type: "string", role: "annotation" },
    //                       11, {calc: "stringify", sourceColumn: 11, type: "string", role: "annotation" },
    //                       12, {calc: "stringify", sourceColumn: 12, type: "string", role: "annotation" },
    //                       13, {calc: "stringify", sourceColumn: 13, type: "string", role: "annotation" },
    //                       14, {calc: "stringify", sourceColumn: 14, type: "string", role: "annotation" },
    //                       15, {calc: "stringify", sourceColumn: 15, type: "string", role: "annotation" },
    //                       16, {calc: "stringify", sourceColumn: 16, type: "string", role: "annotation" },
    //                       17, {calc: "stringify", sourceColumn: 17, type: "string", role: "annotation" },
    //                       18, {calc: "stringify", sourceColumn: 18, type: "string", role: "annotation" },
    //                       // 19, {calc: "stringify", sourceColumn: 19, type: "string", role: "annotation" },
    //                       // 20, {calc: "stringify", sourceColumn: 20, type: "string", role: "annotation" },
                        ]);

      var options = {
        title: "Basket of Milk Powder (Lapser)",
        
        // width: 600,
        // height: 400,
        fontSize: 11,
        bar: {groupWidth: "95%"},
        tooltip:{textStyle: {fontSize: 12}},
        colors:['#be0032','#008080','#008080','#800000'],
        // bars:'horizontal',
        // hAxis: { title: 'Users', titleTextStyle: { color: 'red', fontSize: 16} },
        legend: { position: "none", textStyle: {fontSize: 9} },
        height:480,
        chartArea:{left:100,top:40,width:'80%',height:'85%'}
        
      };

      var chart = new google.visualization.BarChart(document.getElementById('columnchart_busket3'));
      chart.draw(view, options);

  }



  // function drawChart1(dataChart1) {
  //   var data = google.visualization.arrayToDataTable(dataChart1);
    
  //   var view = new google.visualization.DataView(data);
  //   view.setColumns([0, 1,
  //                     { calc: "stringify",
  //                       sourceColumn: 1,
  //                       type: "string",
  //                       role: "annotation" },
  //                     ]);

  //   var options = {
  //     title: "Type of store",
  //     bar: {groupWidth: "95%"},
  //     legend: { position: "none" },
  //     colors:['#b87333']
  //   };

  //   var chart2 = new google.visualization.ColumnChart(document.getElementById("barchart_values2"));
  //   chart2.draw(view, options);
  // }

  // function drawChart2(dataChart2) {
  //     var data = google.visualization.arrayToDataTable(dataChart2);

  //     var options = {
  //       title: 'Type of Area'
  //     };

  //     var chart3 = new google.visualization.PieChart(document.getElementById("barchart_values3"));
  //   chart3.draw(data, options);

  //   }

  
  //   function drawChart3(dataChart3) {
  //     var data = google.visualization.arrayToDataTable(dataChart3);

  //     var view = new google.visualization.DataView(data);
  //   view.setColumns([0, 1,
  //                     { calc: "stringify",
  //                       sourceColumn: 1,
  //                       type: "string",
  //                       role: "annotation" },
  //                     ]);

  //   // var options = {
  //   //   title: "Products selling from store",
  //   //   bar: {groupWidth: "95%"},
  //   //   legend: { position: "none" },
  //   // };

  //   var options = {
  //       width: 400, height: 155,
  //       redFrom: 90, redTo: 100,
  //       yellowFrom:75, yellowTo: 90,
  //       minorTicks: 5
  //     };

  //   // var chart4 = new google.visualization.ColumnChart(document.getElementById("barchart_values4"));
  //   // chart4.draw(view, options);

  //   var chart = new google.visualization.Gauge(document.getElementById('barchart_values4'));

  //     chart.draw(data, options);

  //     // setInterval(function() {
  //     //   data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
  //     //   chart.draw(data, options);
  //     // }, 13000);
  //     // setInterval(function() {
  //     //   data.setValue(1, 1, 40 + Math.round(60 * Math.random()));
  //     //   chart.draw(data, options);
  //     // }, 5000);
  //     // setInterval(function() {
  //     //   data.setValue(2, 1, 60 + Math.round(20 * Math.random()));
  //     //   chart.draw(data, options);
  //     // }, 26000);
      
    

  //   }

    // function drawChart3(dataChart1) {
    //   var data = google.visualization.arrayToDataTable(dataChart1);

    //   var options = {
    //     title: 'Type of area',
    //     curveType: 'function',
    //     legend: { position: 'bottom' }
    //   };

    //   var chart = new google.visualization.LineChart(document.getElementById('barchart_values4'));

    //   chart.draw(data, options);
    // }
  </script>
  