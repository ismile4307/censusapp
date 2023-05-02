<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header row pt-2 pb-2">
                        <div class="col-md-4 align-middle pt-1">Search Operation</div>
                        <div class="col-md-4 text-center">
                            <button @click="getFilterQuestion" type="button" class="btn btn-outline-info pl-2 pt-1 pr-2 pb-1 btn-sm">Set Filter Parameter</button>
                        </div>
                        <div class="col-md-4 text-end">
                            <button @click="exportToExcel" type="button" class="btn btn-outline-primary pl-2 pt-1 pr-2 pb-1 btn-sm">Export to Excel</button>
                        </div>
                    </div>                        
                    <div class="card-body pt-0 pb-2 pl-2 pr-2">
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-3 mb-2" v-for="(attributes,index) in this.all_filter_attributes" :key="attributes">
                                <label class="col-form-label col-form-label-sm ml-2" style="font-weight: normal;color: chocolate;">{{ all_filter_qtexts[index] }}</label>
                                <!-- v-model="selected_filter_parameter[index]" -->
                                <select id="selectpicker" class="selectpicker form-control form-control-sm mr-2" multiple v-model="selected_filter_parameter[index]">
                                    <!-- <option value="0">Select {{ all_filter_qtexts[index] }}</option> -->
                                    <template v-for="attribute in attributes" :key="attribute">
                                        <option :value="attribute.attribute_value">{{ attribute.attribute_label}}</option>
                                    </template>
                                </select>
                            </div>
                        </div>
                        <div class="text-center">
                            <button @click="getData" type="button" class="btn btn-outline-success pl-2 pt-1 pr-2 pb-1 btn-sm">Execute</button>
                            <div>
                            <label v-if="this.all_filter_data.length>0" class="col-form-label col-form-label-sm">Total Number of outlet : {{ this.all_filter_data.length }}</label>
                            </div>
                        </div>
                                <div v-if="this.all_filter_data.length>0" class="table-container mt-2"> 
                                    <table class="table table-sm table-bordered" style="font-size: smaller;">
                                        <thead style="background-color: white;">
                                        <tr>
                                            <!-- <th style="background-color:white;">#</th> -->
                                            <template v-for="(row,index) in this.all_fields" :key="index">
                                                <th style="background-color:white;">
                                                    {{ row.question_text }}
                                                </th>
                                            </template>
                                            <!-- <th style="background-color:white;">Respondent Id</th>
                                            <th style="background-color:white;">Latitude</th>
                                            <th style="background-color:white;">Longitude</th>
                                            <th style="background-color:white;">Centre</th>
                                            <th style="background-color:white;">Thana</th>
                                            <th style="background-color:white;">Bazar/Land Mark</th>
                                            <th style="background-color:white;">Store Name</th>
                                            <th style="background-color:white;">Store Address</th>
                                            <th style="background-color:white;">Name of shop owner or manager</th>
                                            <th style="background-color:white;">Mobile number of shop owner or manager</th> -->
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(row,index) in this.all_filter_data" :key="index">
                                                <!-- <td> {{row.id}}</td> -->
                                                <template v-for="(field,i) in this.all_fields" :key="i">
                                                    <td> {{row[field.qid]}}</td>
                                                </template>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center" v-else><label class="col-form-label col-form-label-sm">No Record Found</label></div>
                            
                            <!-- <div v-if="this.project_id==2">
                                <div v-if="this.all_filter_data.length>0" class="table-container mt-2"> 
                                    <table class="table table-sm table-bordered" style="font-size: smaller;">
                                        <thead style="background-color: white;">
                                        <tr>
                                            <th style="background-color:white;">#</th>
                                            <th style="background-color:white;">Respondent Id</th>
                                            <th style="background-color:white;">Latitude</th>
                                            <th style="background-color:white;">Longitude</th>
                                            <th style="background-color:white;">Centre</th>
                                            <th style="background-color:white;">Type of Area</th>
                                            <th style="background-color:white;">Area</th>
                                            <th style="background-color:white;">Store Name</th>
                                            <th style="background-color:white;">Respondent Name</th>
                                            <th style="background-color:white;">Mobile Number</th>
                                            <th style="background-color:white;">Type of Store</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(row,index) in this.all_filter_data" :key="index">
                                                <td> {{row.id}}</td>
                                                <td> {{row.RespondentId}}</td>
                                                <td> {{row.Latitude}}</td>
                                                <td> {{row.Longitude}}</td>
                                                <td> {{row.Centre}}</td>
                                                <td> {{row.TypeOfArea}}</td>
                                                <td> {{row.Area}}</td>
                                                <td> {{row.StoreName}}</td>
                                                <td> {{row.RespName}}</td>
                                                <td> {{row.RespMobile}}</td>
                                                <td> {{row.Q16}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center" v-else><label class="col-form-label col-form-label-sm">No Record Found</label></div>
                            </div> -->
                        
                    </div>
                </div>
            </div>
        </div>


        <!-- The Modal -->
        <div class="modal fade" id="filterParameterModal" >
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md"  role="document">
                <div class="modal-content">               
               
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Filter Parameter</h4>
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form class="container mt-3" ref="filterParameterModal" @submit.prevent="saveFilterParameter()">

                            <!-- Modal body -->
                            
                                <table class="table table-sm table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Filter parameter</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row,index) in all_parameters" :key="index">
                                            <td class="align-middle"> 
                                                <input type="checkbox" :value=row.qid v-model="filter_parameter.selected_parameter" id="defaultCheck1">
                                            </td>
                                            <td> {{row.question_text}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-info btn-sm">Done</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data(){
            return {
            all_parameters:[],
            all_filters:[],
            all_filter_qids:[],
            all_filter_qtexts:[],
            all_filter_attributes:[],
            all_filter_data:[],
            all_fields:[],

            selected_filter_parameter:[],
            db_filter_parameter:[],

            filter_parameter:{
                project_id:'',
                selected_parameter:[],
            },

            selected_filter_qids_values:{
                all_filter_qids:[],
                selected_filter_values:[],
            },

            }
        },

        props:['project_id'],

        mounted() {
            //console.log('Component mounted.')
            this.loadFilter();
        },

        // computed:{

            
        // },
        // updated: function(){
        //    this.$nextTick(function(){ $('.selectpicker').selectpicker('refresh'); });
        // },

        methods:{
            // initdata() {
            //     axios.get('/role/get_user_type')
            //          .then(response => {this.allUserType = response.data})
            //          .catch(function (error) {this.errors = error});

            // },

            getFilterQuestion(){
                this.filter_parameter.selected_parameter=[];
                
                axios.get('/data_analysis/'+this.project_id+'/search_operation/get_all_parameter')
                     .then(response => {
                        this.all_parameters = response.data[0];
                        this.db_filter_parameter=response.data[1];

                        this.db_filter_parameter.forEach(element => {
                            this.filter_parameter.selected_parameter.push(element.qid);
                        });
                    })
                     .catch(function (error) {this.errors = error});

                this.$refs.filterParameterModal.reset();
                //this.filter_parameter.selected_parameter=[];
                $('#filterParameterModal').modal('show');
            },

            saveFilterParameter(){
                event.preventDefault();
                var app = this;
                // app.user.user_type_id = this.userType.filter(p => p.user_type === this.user.user_type)[0].id

                var newData = app.filter_parameter;
                newData.project_id=this.project_id;
                // console.log(newData);
                axios.post('/data_analysis/'+this.project_id+'/search_operation/save_filter_parameter', newData)
                    .then(function (resp) {
                        //app.$router.push({path: '/'});
                        // console.log(resp);
                        
                        // alert(resp.data.success);
                    })
                    .catch(function (resp) {
                        // console.log(resp);
                        alert("Could not create new data");
                    });

                $('#filterParameterModal').modal('hide');

                this.loadFilter();


            },

            loadFilter(){
                // console.log("Ismile");
                axios.get('/data_analysis/'+this.project_id+'/search_operation/get_filter_parameter')
                     .then(response => {this.all_filters = response.data;
                        // console.log(this.all_filters[0]);
                        this.all_filter_qids=this.all_filters[0];
                        this.all_filter_attributes=this.all_filters[1];
                        this.all_filter_qtexts=this.all_filters[2];
                        // console.log(this.all_filters);

                        var i=0;
                        this.all_filter_qids.forEach(element=>{
                            this.selected_filter_parameter[i]=0;
                            i++;
                        });
                        this.$nextTick(function(){ $('.selectpicker').selectpicker('refresh'); });

                })
                     .catch(function (error) {this.errors = error});
            },

            getData(){
                
                event.preventDefault();
                var app = this;
                // app.user.user_type_id = this.userType.filter(p => p.user_type === this.user.user_type)[0].id

                var newData = app.selected_filter_qids_values;
                newData.all_filter_qids=this.all_filter_qids;
                newData.selected_filter_values=this.selected_filter_parameter;
                // console.log(newData);
                this.all_filter_data=[];
                axios.post('/data_analysis/'+this.project_id+'/search_operation/get_filter_data', newData)
                     .then(response => {this.all_filter_data = response.data[0];
                        this.all_fields=response.data[1];
                        // console.log(this.all_filter_data);
                })
                     .catch(function (error) {this.errors = error});
            },

            exportToExcel(){
                event.preventDefault();
                var app = this;
                // app.user.user_type_id = this.userType.filter(p => p.user_type === this.user.user_type)[0].id

                var newData = app.selected_filter_qids_values;
                newData.all_filter_qids=this.all_filter_qids;
                newData.selected_filter_values=this.selected_filter_parameter;

                axios.post('/data_analysis/'+this.project_id+'/search_operation/download_search_data', newData,{responseType: 'blob'}
                     )
                     .then(response => {
                        // this.all_filter_data = response.data
                        // programmatically 'click'.
                        const link = document.createElement('a');
                
                        // Tell the browser to associate the response data to
                        // the URL of the link we created above.
                        link.href = window.URL.createObjectURL(
                            new Blob([response.data])
                        );
                
                        // Tell the browser to download, not render, the file.
                        link.setAttribute('download', 'search_report.xlsx');
                
                        // Place the link in the DOM.
                        document.body.appendChild(link);
                
                        // Make the magic happen!
                        link.click();
                    }) // Please catch me!

                     .catch(function (error) {this.errors = error});
            }

        }
    }
   
</script>
