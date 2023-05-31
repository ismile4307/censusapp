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
          <div class="col-md-6">
              <div class="card p-0">
                  <div class="card-body p-0" style="overflow: hidden;">
                      <div id="barchart_values1"></div>
                      <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart1 }}</span>
                  </div>
              </div>
              
          </div>
          <div class="col-md-6">
              <div class="card p-0">
                  <div class="card-body p-0" style="overflow: hidden;">
                      <div id="barchart_values2"></div>
                      <span style="font-size: smaller;margin-left: 20px; color: white;">Base: {{ this.baseChart2}}</span>
                  </div>
              </div>
              
          </div>
          <div class="col-md-6">
              <div class="card p-0">
                  <div class="card-body p-0" style="overflow: hidden;">
                      <div id="barchart_values3"></div>
                      <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart3 }}</span>
                  </div>
              </div>
              
          </div>
          <div class="col-md-6">
              <div class="card p-0">
                  <div class="card-body p-0" style="overflow: hidden;">
                      <div id="barchart_values4" ></div>
                      <span style="font-size: smaller;margin-left: 20px;">Base: {{ this.baseChart4 }}</span>
                  </div>
              </div>
          </div>
      
          <!-- <div class="col-md-4">
              <div class="card p-0">
                  <div class="card-body p-0 text-center" style="overflow: hidden;">
                      <div id="barchart_values5"></div>
                  </div>
              </div>
              
          </div> -->
          
      </div>
  </div>
</template>

<script>
export default {
  name: "SecondComponent",
  data() {
    return {
      allCenters:[],
      selectedCenter:'',

      allShopTypes:[],
      selectedShopType:'',

      

      baseChart1:'',
        baseChart2:'',
        baseChart3:'',
        baseChart4:'',
        baseChart5:'',

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
      axios.get('/data_analysis/'+this.project_id+'/dashboard/get_center_d3')
        .then(response => {
            this.allCenters = response.data[0];
            this.allShopTypes = response.data[1];
        });
    },
    getChartData(){
      console.log(this.selectedCenter);
      axios.post('/data_analysis/'+this.project_id+'/dashboard/dashboard3', {
        center_id: this.selectedCenter,
        shop_type_id: this.selectedShopType,
      }).then(response =>{
        //console.log(response.data);

        this.dataChart1 = response.data[0];
        this.baseChart1 = response.data[1];

        this.dataChart2 = response.data[2];
        this.baseChart2 = response.data[3];

        this.dataChart3 = response.data[4];
        this.baseChart3 = response.data[5];

        this.dataChart4 = response.data[6];
        this.baseChart4 = response.data[7];

        this.dataChart5 = response.data[8];
        this.baseChart5 = response.data[9];

        // console.log(this.baseChart3);
        google.charts.setOnLoadCallback(drawChart1(this.dataChart1));
        google.charts.setOnLoadCallback(drawChart2(this.dataChart2));
        google.charts.setOnLoadCallback(drawChart3(this.dataChart3));
        google.charts.setOnLoadCallback(drawChart4(this.dataChart4));
        google.charts.setOnLoadCallback(drawChart5(this.dataChart5));

      });
    }
  }
  
};

google.charts.load("current", {packages:["corechart"]});
google.charts.load('current', {packages:['gauge']});
google.charts.load('current', {'packages':['treemap']});
  
  function drawChart1(dataChart1) {
    var data = google.visualization.arrayToDataTable(dataChart1);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
                     { calc: "stringify",
                       sourceColumn: 1,
                       type: "string",
                       role: "annotation" }]);

    var options = {
      title: "Brands of Tea sell from this store",
      bar: {groupWidth: "95%"},
      legend: { position: "none" },
      colors:['#4863A0']
    };

    var chart1 = new google.visualization.BarChart(document.getElementById("barchart_values1"));
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
      title: "Average Sell (in terms of money) in last month",
      bar: {groupWidth: "95%"},
      legend: { position: "none" },
      colors:['#368BC1']
    };

    var chart1 = new google.visualization.ColumnChart(document.getElementById("barchart_values2"));
    chart1.draw(view, options);

  }
  // function drawChart2() {
  //     var data = google.visualization.arrayToDataTable([
  //       ['Task', 'Hours per Day'],
  //       ['Work',     11],
  //       ['Eat',      2],
  //       ['Commute',  2],
  //       ['Watch TV', 2],
  //       ['Sleep',    7]
  //     ]);

  //     var options = {
  //       title: 'My Daily Activities',
  //       is3D: true,
  //     };

  //     var chart = new google.visualization.PieChart(document.getElementById('barchart_values3'));
  //     chart.draw(data, options);
  // }

  function drawChart3(dataChart3) {
    var data = google.visualization.arrayToDataTable(dataChart3);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
                     { calc: "stringify",
                       sourceColumn: 1,
                       type: "string",
                       role: "annotation" }]);

    var options = {
      title: "Available SKUs of Seylon",
      bar: {groupWidth: "95%"},
      legend: { position: "none" },
      colors:['#1F6357']
    };

    var chart3 = new google.visualization.ColumnChart(document.getElementById("barchart_values3"));
    chart3.draw(view, options);

  }

  function drawChart4(dataChart4) {
    var data = google.visualization.arrayToDataTable(dataChart4);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
                     { calc: "stringify",
                       sourceColumn: 1,
                       type: "string",
                       role: "annotation" }]);

    var options = {
      title: "Available SKUs of Starship",
      bar: {groupWidth: "95%"},
      legend: { position: "none" },
      colors:['#665D1E']
    };

    var chart3 = new google.visualization.ColumnChart(document.getElementById("barchart_values4"));
    chart3.draw(view, options);

  }

  // function drawChart5(dataChart5) {
  //   var data = google.visualization.arrayToDataTable(dataChart5);

  //   var view = new google.visualization.DataView(data);
  //   view.setColumns([0, 1,
  //                    { calc: "stringify",
  //                      sourceColumn: 1,
  //                      type: "string",
  //                      role: "annotation" }]);

  //   var options = {
  //     title: "Available SKUs of STARSHIP",
  //     bar: {groupWidth: "95%"},
  //     legend: { position: "none" },
  //     colors:['#665D1E'],
  //   };

  //   var chart3 = new google.visualization.ColumnChart(document.getElementById("barchart_values5"));
  //   chart3.draw(view, options);

  // }

  // function drawChart3() {
  //     var data = google.visualization.arrayToDataTable([
  //       ['Task', 'Hours per Day'],
  //       ['Work',     11],
  //       ['Eat',      2],
  //       ['Commute',  2],
  //       ['Watch TV', 2],
  //       ['Sleep',    7]
  //     ]);

  //     var options = {
  //       title: 'My Daily Activities',
  //       pieHole: 0.4,
  //     };

  //     var chart = new google.visualization.PieChart(document.getElementById('barchart_values4'));
  //     chart.draw(data, options);
  // }

  // function drawChart4() {

  //     var data = new google.visualization.DataTable();
  //     data.addColumn('string', 'Pizza');
  //     data.addColumn('number', 'Populartiy');
  //     data.addRows([
  //     ['Pepperoni', 33],
  //     ['Hawaiian', 26],
  //     ['Mushroom', 22],
  //     ['Sausage', 10], // Below limit.
  //     ['Anchovies', 9] // Below limit.
  //     ]);

  //     var options = {
  //     title: 'Popularity of Types of Pizza',
  //     sliceVisibilityThreshold: .2
  //     };

  //     var chart = new google.visualization.PieChart(document.getElementById('barchart_values5'));
  //     chart.draw(data, options);
  // }

  // function drawChart5() {
  //     var data = google.visualization.arrayToDataTable([
  //       ['Location', 'Parent', 'Market trade volume (size)', 'Market increase/decrease (color)'],
  //       ['Global',    null,                 0,                               0],
  //       ['America',   'Global',             0,                               0],
  //       ['Europe',    'Global',             0,                               0],
  //       ['Asia',      'Global',             0,                               0],
  //       ['Australia', 'Global',             0,                               0],
  //       ['Africa',    'Global',             0,                               0],
  //       ['Brazil',    'America',            11,                              10],
  //       ['USA',       'America',            52,                              31],
  //       ['Mexico',    'America',            24,                              12],
  //       ['Canada',    'America',            16,                              -23],
  //       ['France',    'Europe',             42,                              -11],
  //       ['Germany',   'Europe',             31,                              -2],
  //       ['Sweden',    'Europe',             22,                              -13],
  //       ['Italy',     'Europe',             17,                              4],
  //       ['UK',        'Europe',             21,                              -5],
  //       ['China',     'Asia',               36,                              4],
  //       ['Japan',     'Asia',               20,                              -12],
  //       ['India',     'Asia',               40,                              63],
  //       ['Laos',      'Asia',               4,                               34],
  //       ['Mongolia',  'Asia',               1,                               -5],
  //       ['Israel',    'Asia',               12,                              24],
  //       ['Iran',      'Asia',               18,                              13],
  //       ['Pakistan',  'Asia',               11,                              -52],
  //       ['Egypt',     'Africa',             21,                              0],
  //       ['S. Africa', 'Africa',             30,                              43],
  //       ['Sudan',     'Africa',             12,                              2],
  //       ['Congo',     'Africa',             10,                              12],
  //       ['Zaire',     'Africa',             8,                               10]
  //     ]);

  //     var tree = new google.visualization.TreeMap(document.getElementById('barchart_values1'));

  //     tree.draw(data, {
  //       minColor: '#f00',
  //       midColor: '#ddd',
  //       maxColor: '#0d0',
  //       headerHeight: 15,
  //       fontColor: 'black',
  //       showScale: true
  //     });

  //   }
</script>
