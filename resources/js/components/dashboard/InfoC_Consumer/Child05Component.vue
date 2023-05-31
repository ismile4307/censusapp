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
        
            <div class="col-md-2">
                <!-- <div class="card p-0 pl-2">
                    <div class="card-body p-0" style="overflow: hidden;">
                        <div id="gaugechart_panelsize"></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart1 }}</span>
                    </div>
                </div> -->
                

                <!-- small card -->
              <!-- <div class="small-box bg-info">
                <div class="inner">
                  <h3>150</h3>

                  <p>New Orders</p>
                </div>
                <div class="icon">
                  <i class="fas fa-shopping-cart"></i>
                </div>
                <a href="#" class="small-box-footer">
                  More info <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div> -->

              <div class="info-box card-outline card-warning" style="margin-bottom: 6px;">
                <!-- <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span> -->

                <div class="info-box-content text-center">
                  <span class="info-box-text">Panel Size</span>
                  <span class="info-box-number mt-0">{{panel_size}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>

              <div class="info-box card-outline card-success" style="margin-bottom: 6px;">
                <!-- <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span> -->

                <div class="info-box-content text-center">
                  <span class="info-box-text">Achieved Sample</span>
                  <span class="info-box-number mt-0">{{baseChart1}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>

              <div class="info-box card-outline card-info mb-1">
                <!-- <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span> -->

                <div class="info-box-content text-center">
                  <span class="info-box-text">Current buyers</span>
                  <span class="info-box-number mt-0">{{baseChart1}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>

            </div>
            <div class="col-md-3">
                <div class="card p-0 card-outline card-info">
                    <div class="card-body p-0" style="overflow: hidden;">
                        <div id="paichart_LoyalConsumer"></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart2 }}</span>
                    </div>
                </div>
                
            </div>
            <div class="col-md-3">
                <div class="card p-0 card-outline card-primary">
                    <div class="card-body p-0" style="overflow: hidden;">
                        <div id="paichart_LapserConsumer"></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart3 }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card pl-3 pr-3 card-outline card-secondary">
                    <div class="card-body p-0" style="overflow: hidden;">
                        <div id="columnchart_loyalbyBrand"></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart4 }}</span>
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
        
            <div class="col-md-3">
                <div class="card p-0 card-outline card-danger">
                    <div class="card-body p-0" style="overflow: hidden;">
                        <div id="paichart_needAlternative"></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart5 }}</span>
                    </div>
                </div>
                
            </div>
            
            <div class="col-md-6">
                <div class="card p-0 card-outline card-warning">
                    <div class="card-body p-0" style="overflow: hidden;">
                        <div id="columnchart_Invfluncer"></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart6 }}</span>
                    </div>
                </div>    
            </div>
            <div class="col-md-3">
                <div class="card p-0 card-outline card-primary">
                    <div class="card-body p-0" style="overflow: hidden;">
                        <div id="columnchart_PlaceOfPurchase"></div>
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
  // name: "FirstComponent",
  data() {
    return {
      allCenters:[],
      selectedCenter:'',
      panel_size:'',

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

      is_display:false,

      // message: "First component mounted"
    };
  },

  props:['project_id'],

  mounted(){
      // if(this.selectedCenter=='')
        this.is_display=false;
        this.selectedCenter=4;

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
      axios.post('/dashboard_infoc/'+this.project_id+'/child02', {
        panel_brand: this.selectedCenter,
      }).then(response =>{
        // console.log(response.data);
        

        this.dataChart1 = response.data[0];
        this.baseChart1 = response.data[1];
        this.panel_size=this.dataChart1[0].Total;
        // console.log(this.dataChart1);
        this.dataChart2 = response.data[2];
        this.baseChart2 = response.data[3];

        this.dataChart3 = response.data[4];
        this.baseChart3 = response.data[5];

        this.dataChart4 = response.data[6];
        this.baseChart4 = response.data[7];

        this.dataChart5 = response.data[8];
        this.baseChart5 = response.data[9];

        this.dataChart6 = response.data[10];
        this.baseChart6 = response.data[11];

        this.dataChart7 = response.data[12];
        this.baseChart7 = response.data[13];

        // this.dataChart6 = response.data[6];
        // this.baseChart6 = response.data[7];

        // console.log(this.dataChart2);
        $('#spinner').hide();
        $('#display').show();
        
        //google.charts.setOnLoadCallback(drawChartCallSummary);
        // google.charts.setOnLoadCallback(drawChartPanelSize(this.dataChart1));
        google.charts.setOnLoadCallback(drawChartLoyalConsumer(this.dataChart2));
        google.charts.setOnLoadCallback(drawChartLapserConsumer(this.dataChart3));
        google.charts.setOnLoadCallback(drawChartPricePerception(this.dataChart4));

        
        google.charts.setOnLoadCallback(drawChartNeedAlternative(this.dataChart5));
        google.charts.setOnLoadCallback(drawChartInfluncer(this.dataChart6));
        google.charts.setOnLoadCallback(drawChartPlaceOfpurchase(this.dataChart7));

        // google.charts.setOnLoadCallback(drawChart1(this.dataChart1));
        // google.charts.setOnLoadCallback(drawChart2(this.dataChart2));
        // google.charts.setOnLoadCallback(drawChart3(this.dataChart3));

        
        
       

      });
    }

  },

  
};



google.charts.load("current", {packages:["corechart"]});
google.charts.load('current', {packages:['gauge']});
google.charts.load('current', {packages:['treemap']});
google.charts.load('current', {'packages':['bar']});
google.charts.load('current', {'packages':['table']});

//*** Gauge */
// function drawChartPanelSize(dataChart1) {
//     var data = google.visualization.arrayToDataTable(dataChart1);

//     var view = new google.visualization.DataView(data);
//     view.setColumns([0, 1,
//                       { calc: "stringify",
//                         sourceColumn: 1,
//                         type: "string",
//                         role: "annotation" },
//                       ]);

//     var options = {
//         width: 400, height: 155,
//         redFrom: 90, redTo: 100,
//         yellowFrom:75, yellowTo: 90,
//         minorTicks: 5,
//         legend: { position: "bottom", textStyle: {fontSize: 13} },
//       };

//     var chart = new google.visualization.Gauge(document.getElementById('gaugechart_panelsize'));
//     chart.draw(data, options);

//     }

    //***pie chart */
    function drawChartLoyalConsumer(dataChart2) {
      var data = google.visualization.arrayToDataTable(dataChart2);

      var options = {
        title: 'Loyal Consumer',
        // pieHole: 0.4,
        chartArea:{left:20,top:40,width:'95%',height:'70%'},
        height:230,
        width:270,
        colors:['#008080','#be0032','#008080','#800000'],
      };

    var piechart = new google.visualization.PieChart(document.getElementById("paichart_LoyalConsumer"));
    piechart.draw(data, options);

    }

    //***pie chart */
    function drawChartLapserConsumer(dataChart3) {
      var data = google.visualization.arrayToDataTable(dataChart3);

      var options = {
        title: 'Lapser Consumer by store type',
        pieHole: 0.4,
        chartArea:{left:20,top:40,width:'95%',height:'70%'},
        height:230,
        width:270,
      };

    var piechart = new google.visualization.PieChart(document.getElementById("paichart_LapserConsumer"));
    piechart.draw(data, options);

    }

    //***column chart */
    function drawChartPricePerception(dataChart4){
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
        title: "Price Perception by consumer type",
        // width: 600,
        // height: 400,
        fontSize: 10,
        bar: {groupWidth: "50%"},
        tooltip:{textStyle: {fontSize: 12}},
        // bars:'horizontal',
        // hAxis: { title: 'Users', titleTextStyle: { color: 'red', fontSize: 16} },
        legend: { position: "top", textStyle: {fontSize: 9} },
        chartArea:{left:20,top:40,width:'100%',height:'70%'},
        height:230,
        width:300,
        
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_loyalbyBrand'));
      chart.draw(view, options);

  }

  //***pie chart */
  function drawChartNeedAlternative(dataChart) {
      var data = google.visualization.arrayToDataTable(dataChart);

      var options = {
        title: 'Need of alternative brands',
        is3D: true,
        chartArea:{left:20,top:40,width:'95%',height:'70%'},
        height:230,
        width:270,
      };

    var piechart = new google.visualization.PieChart(document.getElementById("paichart_needAlternative"));
    piechart.draw(data, options);

    }

  //***column chart */
  function drawChartInfluncer(dataChart){
    var data = google.visualization.arrayToDataTable(dataChart);

    var view = new google.visualization.DataView(data);
      view.setColumns([0, 1, {
                          calc: "stringify",
                          sourceColumn: 1,
                          type: "string",
                          role: "annotation"
                      }]);

      var options = {
        title: "Influencers",
        // width: 600,
        // height: 400,
        fontSize: 10,
        bar: {groupWidth: "50%"},
        tooltip:{textStyle: {fontSize: 12}},
        // bars:'horizontal',
        // hAxis: { title: 'Users', titleTextStyle: { color: 'red', fontSize: 16} },
        legend: { position: "none", textStyle: {fontSize: 13} },
        chartArea:{left:50,top:40,width:'95%',height:'70%'},
        height:230,
        width:530,
        
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


      var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_Invfluncer'));
      chart.draw(view, options);

  }
  //***column chart */
    function drawChartPlaceOfpurchase(dataChart){
    var data = google.visualization.arrayToDataTable(dataChart);

    var view = new google.visualization.DataView(data);
      view.setColumns([0, 1, {
                          calc: "stringify",
                          sourceColumn: 1,
                          type: "string",
                          role: "annotation"
                      }]);

      var options = {
        title: "Place of purchase",
        // width: 600,
        // height: 400,
        fontSize: 10,
        bar: {groupWidth: "50%"},
        tooltip:{textStyle: {fontSize: 12}},
        color:'black',
        // bars:'horizontal',
        // hAxis: { title: 'Users', titleTextStyle: { color: 'red', fontSize: 16} },
        legend: { position: "none", textStyle: {fontSize: 13} },
        colors:['#b87333'],
        chartArea:{left:50,top:40,width:'95%',height:'70%'},
        height:230,
        width:240,
        
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


      var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_PlaceOfPurchase'));
      chart.draw(view, options);

  }

  

</script>
