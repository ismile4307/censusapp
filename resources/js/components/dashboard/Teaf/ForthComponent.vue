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
      <div class="col-md-2">
        <select class="control-select" style="width:100%" 
          @change="getChartData()"
          v-model="selectedShopType">
          <option value="0">All Shop Type</option>
          <template v-for="shopType in allShopTypes" :key="shopType.attribute_value">
          <option  :value="shopType.attribute_value">{{shopType.attribute_label}}</option>
          </template>
        </select>
        </div>
        
      </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card p-0 pb-2" style="overflow:hidden">
                  <!-- <div class="card-header"></div> -->
                    <div class="card-body border-primary p-0">
                        <div class="p-0" id="barchart_values1" ></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart1 }}</span>
                    </div>
                </div>
            </div>
        
            <div class="col-md-12">
                <div class="card p-0 pb-2" style="overflow:hidden">
                  <!-- <div class="card-header"></div> -->
                    <div class="card-body border-primary p-0">
                        <div class="p-0" id="barchart_values2" ></div>
                        <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart2 }}</span>
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
            <!-- <div class="col-md-6">
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
                
            </div> -->
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

      allShopTypes:[],
      selectedShopType:'',

      

      baseChart1:'',
        baseChart2:'',
        // baseChart3:'',
        // baseChart4:'',
        // baseChart5:'',
      };
    },
    
    props:['project_id'],

    mounted(){
      this.selectedCenter=0;
    this.selectedShopType=0;

    this.getCenter();
      this.getChartData();
    },

    methods:{
      getCenter(){
      axios.get('/data_analysis/'+this.project_id+'/dashboard/get_center_d4')
        .then(response => {
            this.allCenters = response.data[0];
            this.allShopTypes = response.data[1];
        });
      },

      getChartData(){
      console.log(this.selectedCenter);
      axios.post('/data_analysis/'+this.project_id+'/dashboard/dashboard4', {
        center_id: this.selectedCenter,
        shop_type_id: this.selectedShopType,
      }).then(response =>{
        //console.log(response.data);

        this.dataChart1 = response.data[0];
        this.baseChart1 = response.data[1];

        this.dataChart2 = response.data[2];
        this.baseChart2 = response.data[3];

        // this.dataChart3 = response.data[4];
        // this.baseChart3 = response.data[5];

        // this.dataChart4 = response.data[6];
        // this.baseChart4 = response.data[7];

        // this.dataChart5 = response.data[8];
        // this.baseChart5 = response.data[9];

        // console.log(this.baseChart3);
        google.charts.setOnLoadCallback(drawChart1(this.dataChart1));
        google.charts.setOnLoadCallback(drawChart2(this.dataChart2));
        // google.charts.setOnLoadCallback(drawChart3(this.dataChart3));
        // google.charts.setOnLoadCallback(drawChart4(this.dataChart4));
        // google.charts.setOnLoadCallback(drawChart5(this.dataChart5));

      });
    }

    }

    
  };

  google.charts.load("current", {packages:["corechart"]});
  google.charts.load('current', {packages:['gauge']});
  google.charts.load('current', {packages:['treemap']});
  google.charts.load('current', {'packages':['bar']});
    
  function drawChart1(dataChart1) {
    var data = google.visualization.arrayToDataTable(dataChart1);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
                     { calc: "stringify",
                       sourceColumn: 1,
                       type: "string",
                       role: "annotation" }]);

    var options = {
      title: "FCMP brand's display is seen in the shop",
      bar: {groupWidth: "95%"},
      legend: { position: "none" },
      colors:['#4863A0']
    };

    var chart1 = new google.visualization.ColumnChart(document.getElementById("barchart_values1"));
    chart1.draw(view, options);

  }
  function drawChart2(dataChart2) {
    var data = google.visualization.arrayToDataTable(dataChart2);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
                     { calc: "stringify",
                       sourceColumn: 1,
                       type: "string",
                       role: "annotation" }]);

    var options = {
      title: "Tea brand's display is seen in the shop",
      bar: {groupWidth: "95%"},
      legend: { position: "none" },
      colors:['#368BC1']
    };

    var chart1 = new google.visualization.ColumnChart(document.getElementById("barchart_values2"));
    chart1.draw(view, options);

  }

      // $(document).ready(function () {
      //   $('select').selectpicker();
      // });
  </script>
  