<template>
    <div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header row pt-2 pb-2">
                        <div class="col-md-6 align-middle pt-1">Panel Data ({{ this.project.project_name }})</div>
                            <div class="col-md-6 text-end">
                                <button @click="getCatiReport" type="button" class="btn btn-outline-info pl-2 pt-1 pr-2 pb-1 mr-2 btn-sm">Get CATI Report</button>
                                <button @click="exportToExcel" type="button" class="btn btn-outline-primary pl-2 pt-1 pr-2 pb-1 btn-sm">Export to Excel</button>
                            </div>

                        </div>
                        <div class="card-body pt-1">

                            <div class="row d-flex justify-content-center">                           

                                <div class="col-sm-3 mb-2" v-for="(attributes,index) in this.all_filter_attributes" :key="attributes">
                                    <label class="col-form-label col-form-label-sm ml-2" style="font-weight: normal;color: chocolate;">{{ all_filter_qtexts[index] }}</label>
                                    <!-- v-model="selected_filter_parameter[index]" -->
                                    <select id="selectpicker" class="form-control form-control-sm mr-2" v-model="selected_filter_parameter[index]">
                                        <option :value="0">Select {{ all_filter_qtexts[index] }}</option>
                                        <template v-for="attribute in attributes" :key="attribute">
                                            <option :value="attribute.attribute_value">{{ attribute.attribute_label}}</option>
                                        </template>
                                    </select>
                                </div>
                                <div class="col-sm-3 mb-2">
                                    <label class="col-form-label col-form-label-sm ml-2" style="font-weight: normal;color: chocolate;">Contact Type</label>
                                        <!-- v-model="selected_filter_parameter[index]" -->
                                        <select id="selectpicker" class="form-control form-control-sm mr-2" v-model="selected_contact_type">
                                            <option :value="0">Select Contact Type</option>
                                            <option :value="1">New Contact</option>
                                            <option :value="2">Incomplete Contact</option>
                                            <option :value="4">Ringing but not Received</option>
                                            <option :value="8">Busy or Waiting Contact</option>
                                            <option :value="10">Agree but Participate Later</option>
                                            <option :value="3">Complete Contact</option>
                                            <option :value="5">Switched Off</option>
                                            <option :value="6">Invalid Number</option>
                                        </select>
                                </div>
                                <div class="col-sm-3 text-start" style="margin-top: 30px;">
                                <button @click="getData" type="button" class="btn btn-outline-success pl-2 pt-1 pr-2 pb-1 btn-sm">Execute</button>
                                </div>
                            </div>

                            <div>
                                <label v-if="this.all_filter_data.length>0" class="col-form-label col-form-label-sm">Total Number of records : {{ this.all_filter_data.length }}</label>
                            </div>
                            
                            <div class="text-center">
                                <!-- <button @click="getData" type="button" class="btn btn-outline-success pl-2 pt-1 pr-2 pb-1 btn-sm">Execute</button> -->
                                <div>
                                <label v-if="this.all_data.length>0" class="col-form-label col-form-label-sm">Total Number of Records : {{ this.all_data.length+"/"+this.total_record[0].Total }}</label>
                                </div>
                            </div>
                                <div v-if="project_id==4">
                                    <div v-if="this.all_data.length>0" class="table-container mt-2"> 
                                        <table class="table table-sm table-bordered" style="font-size: smaller;">
                                            <thead style="background-color: white;">
                                            <tr>
                                                <!-- <th style="background-color:white;">#</th> -->
                                                <th style="background-color:white;">Respondent Id</th>
                                                <th style="background-color:white;">Respondent Name</th>
                                                <th style="background-color:white;">Contact Number</th>
                                                <!-- <th style="background-color:white;">Link</th> -->
                                                <th style="background-color:white;">Brand Buyer</th>
                                                <th style="background-color:white;">MTO Point</th>
                                                <!-- <th style="background-color:white;">Placement</th> -->
                                                <th style="background-color:white;">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(row,index) in this.all_data" :key="index">
                                                    <!-- <td> {{row.id}}</td> -->
                                                    <td> {{row.RespondentId}}</td>
                                                    <td> {{row.RespName}}</td>
                                                    <td> {{row.RespMobile}}</td>
                                                    <!-- <td> {{row.survey_link}}</td> -->
                                                    <td> {{row.PanelBrand}}</td>
                                                    <td> {{row.MtoPoint}}</td>
                                                    <!-- <td> {{row.Placement}}</td> -->
                                                    <td>
                                                        <button style="text-decoration:none;text-align: center" type="button" class="btn btn-link btn-sm pb-0 pt-0 pl-0 pr-0" v-on:click="view_modal(row.survey_link,row.RespondentId,row.RespName,row.RespMobile)">Start Survey</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div v-else-if="click_search==1" class="text-center mt-2">
                                        <label class="col-form-label col-form-label-sm" style="color:red"> No Data found/Today's quota for a particular selection is filled up </label>
                                    </div>
                                </div>
                                <div v-if="project_id==5">
                                    <div v-if="this.all_data.length>0" class="table-container mt-2"> 
                                        <table class="table table-sm table-bordered" style="font-size: smaller;">
                                            <thead style="background-color: white;">
                                            <tr>
                                                <!-- <th style="background-color:white;">#</th> -->
                                                <th style="background-color:white;">Respondent Id</th>
                                                <th style="background-color:white;">Outlet Name</th>
                                                <th style="background-color:white;">Contact Number</th>
                                                <!-- <th style="background-color:white;">Link</th> -->
                                                <th style="background-color:white;">Outlet Code</th>
                                                <th style="background-color:white;">Outlet Type</th>
                                                <th style="background-color:white;">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(row,index) in this.all_data" :key="index">
                                                    <!-- <td> {{row.id}}</td> -->
                                                    <td> {{row.RespondentId}}</td>
                                                    <td> {{row.RespName}}</td>
                                                    <td> {{row.RespMobile}}</td>
                                                    <!-- <td> {{row.survey_link}}</td> -->
                                                    <td> {{row.OutletCode}}</td>
                                                    <td> {{row.OutletType}}</td>
                                                    <td>
                                                        <button style="text-decoration:none;text-align: center" type="button" class="btn btn-link btn-sm pb-0 pt-0 pl-0 pr-0" v-on:click="view_modal(row.survey_link,row.RespondentId,row.RespName,row.RespMobile)">Start Survey</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- add modal  style=" height:435px;"  modal-dialog-scrollable-->
        <div class="modal fade" id="viewModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header p-1">
                    <h5 class="modal-title">Calling Information</h5>
                    <!-- <button type="button" class="btn btn-outline-primary btn-sm text-end" @click="tablePct()">Export to Excel</button> -->
                    <!-- data-bs-dismiss="modal" -->
                    <button type="button" class="btn-close btn-sm m-2 p-1" aria-label="Close" @click="closeModal"></button>
                </div>
                <div class="modal-body p-1 text-center mb-4">
                    <h2>Respondent Details</h2>     
                    <h4 class="mt-4">Respondent Name : {{ resp_name }}</h4>              
                    <h4>Contact Number : {{ resp_mobile }}</h4>          
                    <div class="mb-4 mt-4 row justify-content-center">
                        <label class="col-form-label col-form-label-sm ml-2" style="font-weight: normal;color: chocolate;">Calling Status</label>
                            <!-- v-model="selected_filter_parameter[index]" -->
                            <!-- <div class="col-md-4"></div> -->
                            <!-- <div class="col-md-4">
                                <select id="selectpicker" class="form-control form-control-sm" v-model="calling_status" @change="onChange">
                                    <option :value="0">Select Calling Status</option>
                                    <option :value="2">Ringing and Received</option>
                                    <option :value="4">Ringing but not Received</option>
                                    <option :value="5">Switched Off</option>
                                    <option :value="6">Invalid Number</option>
                                </select>
                            </div> -->
                            <!-- <div class="col-md-4"></div> -->
                            <div class="text-start col-md-auto">
                                <div class="form-check mt-2 col-12">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" :id=1 v-bind:value="2" v-model="calling_status" v-on:click="onChange(2)">
                                    <label class="form-check-label pl-2" :for=1 style="font-size:medium">Ringing and Received</label>
                                </div>
                                <div class="form-check mt-2 col-12">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" :id=2 v-bind:value="4" v-model="calling_status" v-on:click="onChange(4)">
                                    <label class="form-check-label pl-2" :for=2 style="font-size:medium">Ringing but not Received</label>
                                </div>
                                <div class="form-check mt-2 col-12">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" :id=5 v-bind:value="8" v-model="calling_status" v-on:click="onChange(8)">
                                    <label class="form-check-label pl-2" :for=5 style="font-size:medium">Number Busy / Waiting</label>
                                </div>
                                <div class="form-check mt-2 col-12">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" :id=3 v-bind:value="5" v-model="calling_status" v-on:click="onChange(5)">
                                    <label class="form-check-label pl-2" :for=3 style="font-size:medium">Switched Off</label>
                                </div>
                                <div class="form-check mt-2 col-12">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" :id=4 v-bind:value="6" v-model="calling_status" v-on:click="onChange(6)">
                                    <label class="form-check-label pl-2" :for=4 style="font-size:medium">Invalid Number</label>
                                </div>
                            </div>
                    </div>     
                    <button @click="start_survey(survey_link)" type="button" class="btn btn-outline-primary pl-2 pt-1 pr-2 pb-1 btn-sm">{{btn_label}}</button>
                </div>
                <div class="modal-footer p-1">
                    <!-- <button type="button" class="btn btn-primary btn-sm" v-on:click="saveSyntax">Save</button> -->
                    <!-- data-bs-dismiss="modal"  -->
                    <button type="button" class="btn btn-secondary btn-sm" @click="closeModal">Close</button>
                </div>
                </div>
            </div>
        </div>




        <!-- add modal  style=" height:435px;"  modal-dialog-scrollable-->
        <div class="modal fade" id="reportModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header p-1">
                    <h5 class="modal-title ml-3">Progress Report - CATI</h5>
                    <!-- <button type="button" class="btn btn-outline-primary btn-sm text-end" @click="tablePct()">Export to Excel</button> -->
                    <button type="button" class="btn-close btn-sm m-2 p-1" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-1 mb-4">
                    <div class="mb-4 mt-1 pl-2 row justify-content-left" id="duration">
                        <label class="col-md-1 col-form-label col-form-label-sm text-end">Start Date :</label>
                        <div class="col-md-2">
                            <input name="start_date" type="date" class="date form-control form-control-sm" v-model="start_date"  autocomplete="off">
                            <!-- <input name="start_date" type="text" class="date form-control form-control-sm"  autocomplete="off"> -->
                            <!-- <datepicker :format="customFormatterDate" input-class ="form-control form-control-sm" v-bind:key="1" name="start_date" v-model="end_date"></datepicker> -->
                        </div> 
                        <label class="col-md-1 col-form-label col-form-label-sm text-end">End Date :</label>
                        <div class="col-md-2">
                            <input name="end_date" type="date" class="date form-control form-control-sm" v-model="end_date" autocomplete="off">
                            <!-- <input name="end_date" type="text" class="date form-control form-control-sm" autocomplete="off"> -->
                            <!-- <datepicker :format="customFormatterDate" input-class ="form-control form-control-sm" v-bind:key="2" name="end_date" v-model="end_date"></datepicker> -->
                        </div> 
                        <div class="col-md-1">
                            <button type="button" class="btn btn-outline-primary btn-sm ml-3" v-on:click="getCatiReportInterval">Show</button> 
                        </div>
                    </div>   
                   
                    <div v-if="this.report_data.length>0" class="table-container mt-2 m-3" style="height: 300px;"> 
                        <table class="table table-sm table-bordered" style="font-size: smaller;">
                            <thead style="background-color: white;">
                            <tr>
                                <th style="background-color:white;">Interviewer Name</th>
                                <th  class="text-center" style="background-color:white;">Total Contact</th>
                                <th  class="text-center" style="background-color:white;">Complete Interview</th>
                                <th  class="text-center" style="background-color:white;">Terminate Interview</th>
                                <th  class="text-center" style="background-color:white;">Incomplete Interview</th>
                                <th  class="text-center" style="background-color:white;">Ringing not Received</th>
                                <th  class="text-center" style="background-color:white;">Switched Off</th>
                                <th  class="text-center" style="background-color:white;">Invalid Number</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row,index) in this.report_data" :key="index">
                                    <td> {{row.InterviewerName}}</td>
                                    <td class="text-center" style="font-weight: bold;"> {{row.ColTotal}}</td>
                                    <td class="text-center"> {{row.CompleteInterview}}</td>
                                    <td class="text-center"> {{row.TerminateInterview}}</td>
                                    <td class="text-center"> {{row.IncompleteInterview}}</td>
                                    <td class="text-center"> {{row.RingingnotReceived}}</td>
                                    <td class="text-center"> {{row.SwitchedOff}}</td>
                                    <td class="text-center"> {{row.InvalidNumber}}</td>
                                </tr>
                                <tr v-for="(row,index) in this.report_data_total" :key="index">
                                    <th> {{row.Total}}</th>
                                    <th class="text-center"> {{row.ColTotal}}</th>
                                    <th class="text-center"> {{row.CompleteInterview}}</th>
                                    <th class="text-center"> {{row.TerminateInterview}}</th>
                                    <th class="text-center"> {{row.IncompleteInterview}}</th>
                                    <th class="text-center"> {{row.RingingnotReceived}}</th>
                                    <th class="text-center"> {{row.SwitchedOff}}</th>
                                    <th class="text-center"> {{row.InvalidNumber}}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else class="text-center">
                        <h6 style="color: brown;">No record found for current date</h6>
                    </div>

                </div>
                <div class="modal-footer p-1">
                    <!-- <button type="button" class="btn btn-primary btn-sm" v-on:click="saveSyntax">Save</button> -->
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" >Close</button>
                </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
// import Datepicker from 'vuejs-datepicker';
// import VueTimepicker from 'vuejs-timepicker';
// import moment from 'moment';
    export default {
        // components: { Datepicker },
        
        data(){
            return {
            all_data:[],
            all_data_temp:[],
            all_keys:'',


            all_parameters:[],
            all_filters:[],
            all_filter_qids:[],
            all_filter_qtexts:[],
            all_filter_attributes:[],
            all_filter_data:[],
            all_fields:[],

            selected_filter_parameter:[],
            db_filter_parameter:[],
            selected_contact_type:'',

            filter_parameter:{
                project_id:'',
                selected_parameter:[],
            },

            selected_filter_qids_values:{
                all_filter_qids:[],
                selected_filter_values:[],
            },

            project:'',
            survey_link:'',
            resp_name:'',
            resp_mobile:'',
            calling_status:'',
            btn_label:'',
            respondent_id:'',
            report_data:[],
            start_date:'',
            end_date:'',
            total_record:'',
            report_data_total:[],

            click_search:'',
            }
        },

        props:['project_id'],

        mounted() {
            this.click_search=0;
            this.loadFilter();
            //console.log(this.project_name);
        },

        methods:{

            loadFilter(){
                // console.log("Ismile");
                axios.get('/data_analysis/'+this.project_id+'/survey_data/get_filter_parameter')
                     .then(response => {this.all_filters = response.data;
                        // console.log(this.all_filters[0]);
                        this.all_filter_qids=this.all_filters[0];
                        this.all_filter_attributes=this.all_filters[1];
                        this.all_filter_qtexts=this.all_filters[2];
                        this.project=this.all_filters[3];
                        // console.log(this.all_filters);

                        var i=0;
                        this.all_filter_qids.forEach(element=>{
                            this.selected_filter_parameter[i]=0;
                            i++;
                        });
                        this.selected_contact_type=0;
                        this.$nextTick(function(){ $('.selectpicker').selectpicker('refresh'); });

                })
                     .catch(function (error) {this.errors = error});
            },

            getData(){
                if(this.selected_contact_type>0){
                    axios.post('/data_analysis/'+this.project_id+'/survey_data/get_survey_data',
                    {'all_filter_qids':this.all_filter_qids,
                    'selected_filter_values':this.selected_filter_parameter, 
                    'contactType':this.selected_contact_type,})
                        .then(response => {this.all_data = response.data[0];
                            this.total_record = response.data[1];
                            // this.all_keys=this.all_data[0];
                            // console.log(Object.keys(this.all_keys));
                            this.click_search=1;                            
                    })
                        .catch(function (error) {this.errors = error});
                }else{
                    alert("Contact type should be selected");
                }
            },

            view_modal(mylink,resp_id,respName,respMobile){
                if(this.selected_contact_type!=3){
                var return_key;
                this.respondent_id=resp_id;
                axios.post('/data_analysis/'+this.project_id+'/survey_data/update_data_status',
                        {'myLink': mylink,
                        'all_filter_qids':this.all_filter_qids,
                        'selected_filter_values':this.selected_filter_parameter, 
                        'contactType':this.selected_contact_type,})
                            .then(response => {return_key=response.data[0];
                                this.all_data_temp = response.data[1];
                                // this.all_keys=this.all_data[0];
                                // console.log(Object.keys(this.all_keys));

                        if(return_key==1 && this.all_data_temp.length==0){
                            alert("Respondent Information is currently using/already used by others. Please try another");
                        }else{
                            this.all_data=this.all_data_temp;
                            $('#viewModal').modal({ backdrop: 'static',  keyboard: false });
                            this.survey_link=mylink;
                            this.resp_name=respName;
                            this.resp_mobile=respMobile;
                            this.calling_status=0;
                            this.btn_label="Save & Close";
                            $('#viewModal').modal('show');
                    }
                })
            }else{
                alert("Interview for this respondent has been completed successfully");
            }
                    
            },

            onChange(myValue){
                this.calling_status=myValue;
                if(this.calling_status==2)
                    this.btn_label="Start Interview";
                else
                    this.btn_label="Save & Close";
            },

            closeModal(){
                var save_status='';
                axios.post('/data_analysis/'+this.project_id+'/survey_data/set_to_new_contact',
                    {'myLink': this.survey_link})
                        .then(response => {
                            save_status = response.data;
                            // console.log(response.data);
                            // this.all_keys=this.all_data[0];
                            // console.log(Object.keys(this.all_keys));

                            if(save_status==1){
                                $('#viewModal').modal('hide');
                            }
                    })
                        .catch(function (error) {this.errors = error});
                
                //         console.log(this.calling_status);
                // console.log(save_status);
            },

            start_survey(mylink){
                var save_status='';
                axios.post('/data_analysis/'+this.project_id+'/survey_data/update_survey_data',
                    {'myLink': mylink,
                     'respondent_id':this.respondent_id,
                    'calling_status':this.calling_status,})
                        .then(response => {
                            save_status = response.data;
                            // console.log(response.data);
                            // this.all_keys=this.all_data[0];
                            // console.log(Object.keys(this.all_keys));


                            if(this.calling_status==2){
                                if(save_status==1){
                                    $('#viewModal').modal('hide');
                                    window.open(mylink, '_blank', '');
                                }
                            }else if (this.calling_status!=2 && this.calling_status!=0){
                                $('#viewModal').modal('hide');
                            }

                    })
                        .catch(function (error) {this.errors = error});
                
                //         console.log(this.calling_status);
                // console.log(save_status);
                
            },

            getCatiReport(){

                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();

                // today = mm + '/' + dd + '/' + yyyy;
                today = yyyy + '-' + mm + '-' + dd;

                // console.log(today);
                this.start_date=today;
                this.end_date=today;

                axios.post('/data_analysis/'+this.project_id+'/survey_data/cati_report',
                    {'start_date': this.start_date+' 00:00:00',
                     'end_date': this.end_date+' 23:59:59',})
                        .then(response => {
                            this.report_data = response.data[0];
                            this.report_data_total = response.data[1];

                    })
                        .catch(function (error) {this.errors = error});
                
                        
                $('#reportModal').modal('show');

            },

            getCatiReportInterval(){

                axios.post('/data_analysis/'+this.project_id+'/survey_data/cati_report',
                    {'start_date': this.start_date+' 00:00:00',
                    'end_date': this.end_date+' 23:59:59',})
                        .then(response => {
                            this.report_data = response.data[0];
                            this.report_data_total=response.data[1]

                    })
                        .catch(function (error) {this.errors = error});
                },

            exportToExcel(){
                if(this.selected_contact_type>0){
                    axios.post('/data_analysis/'+this.project_id+'/survey_data/export_survey_data',
                    {'all_filter_qids':this.all_filter_qids,
                    'selected_filter_values':this.selected_filter_parameter, 
                    'contactType':this.selected_contact_type,},{responseType: 'blob'})
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
                        link.setAttribute('download', this.project.project_name+'_survey_data.xlsx');
                
                        // Place the link in the DOM.
                        document.body.appendChild(link);
                
                        // Make the magic happen!
                        link.click();
                    }) // Please catch me!

                     .catch(function (error) {this.errors = error});
                
                }else{
                    alert("Contact type should be selected");
                }
            },

            // customFormatterDate(date) {
            //     return moment(date).format('DD/MM/YYYY');
            // },
        },
        
    }
   
</script>
