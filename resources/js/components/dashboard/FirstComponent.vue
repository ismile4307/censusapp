<template>
    <div>
      <div class="row d-flex justify-content-center pb-4">
       <div class="col-md-2">
          <select class="control-select" style="width:100%" 
            @change="getChartData()"
            v-model="selectedCenter">
            <option value="0">All Centre</option>
            <template v-for="centre in allCenters" :key="centre.attribute_value">
            <option  :value="centre.attribute_value">{{centre.attribute_label}}</option>
            </template>
          </select>
        </div> 
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
        
            <div class="col-md-12">
                <div class="card p-0">
                    <div class="card-body p-0" style="overflow: hidden;">
                        <div id="barchart_values2"></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart1 }}</span>
                    </div>
                </div>
                
            </div>
            <div class="col-md-6">
                <div class="card p-0">
                    <div class="card-body p-0" style="overflow: hidden;">
                        <div id="barchart_values3"></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart2 }}</span>
                    </div>
                </div>
                
            </div>
            <div class="col-md-6">
                <div class="card p-0">
                    <div class="card-body" style="overflow: hidden;">
                        <div class="ml-5" id="barchart_values4"></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart3 }}</span>
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
        allCenters:[],
        selectedCenter:'',

        dataChart1:[],
        dataChart2:[],
        dataChart3:[],

        baseChart1:'',
        baseChart2:'',
        baseChart3:'',

        // message: "First component mounted"
      };
    },

    props:['project_id'],

    mounted(){
        // if(this.selectedCenter=='')
          this.selectedCenter=0;

        this.getCenter();
        this.getChartData();
        
        // google.charts.setOnLoadCallback(drawChart2);
    },

    methods:{
      getCenter(){
        axios.get('/data_analysis/'+this.project_id+'/dashboard/get_center_d1')
          .then(response => {
              this.allCenters = response.data
          });
      },

      getChartData(){
        console.log(this.selectedCenter);
        axios.post('/data_analysis/'+this.project_id+'/dashboard/dashboard1', {
          center_id: this.selectedCenter,
        }).then(response =>{
          //console.log(response.data);

          this.dataChart1 = response.data[0];
          this.baseChart1 = response.data[1];

          this.dataChart2 = response.data[2];
          this.baseChart2 = response.data[3];

          this.dataChart3 = response.data[4];
          this.baseChart3 = response.data[5];

          console.log(this.baseChart3);
          google.charts.setOnLoadCallback(drawChart1(this.dataChart1));
          google.charts.setOnLoadCallback(drawChart2(this.dataChart2));
          google.charts.setOnLoadCallback(drawChart3(this.dataChart3));

        });
      }

    },

    
  };



  google.charts.load("current", {packages:["corechart"]});
  google.charts.load('current', {packages:['gauge']});
  google.charts.load('current', {packages:['treemap']});
    
    function drawChart1(dataChart1) {
      var data = google.visualization.arrayToDataTable(dataChart1);
      
      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       ]);

      var options = {
        title: "Type of store",
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
        colors:['#b87333']
      };

      var chart2 = new google.visualization.ColumnChart(document.getElementById("barchart_values2"));
      chart2.draw(view, options);
  }

  function drawChart2(dataChart2) {
        var data = google.visualization.arrayToDataTable(dataChart2);

        var options = {
          title: 'Type of Area'
        };

        var chart3 = new google.visualization.PieChart(document.getElementById("barchart_values3"));
      chart3.draw(data, options);

      }

  
      function drawChart3(dataChart3) {
        var data = google.visualization.arrayToDataTable(dataChart3);

        var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       ]);

      // var options = {
      //   title: "Products selling from store",
      //   bar: {groupWidth: "95%"},
      //   legend: { position: "none" },
      // };

      var options = {
          width: 400, height: 155,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5
        };

      // var chart4 = new google.visualization.ColumnChart(document.getElementById("barchart_values4"));
      // chart4.draw(view, options);

      var chart = new google.visualization.Gauge(document.getElementById('barchart_values4'));

        chart.draw(data, options);

        // setInterval(function() {
        //   data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
        //   chart.draw(data, options);
        // }, 13000);
        // setInterval(function() {
        //   data.setValue(1, 1, 40 + Math.round(60 * Math.random()));
        //   chart.draw(data, options);
        // }, 5000);
        // setInterval(function() {
        //   data.setValue(2, 1, 60 + Math.round(20 * Math.random()));
        //   chart.draw(data, options);
        // }, 26000);
        
      

      }

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
  