<template>
    <div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header row pt-2 pb-2">
                        <div class="col-md-6 align-middle pt-1">Survey Data</div>
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
                                            <option :value="3">Complete Contact</option>
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
                                <label v-if="this.all_data.length>0" class="col-form-label col-form-label-sm">Total Number of outlet : {{ this.all_data.length }}</label>
                                </div>
                            </div>
                            
                                <div v-if="this.all_data.length>0" class="table-container mt-2"> 
                                    <table class="table table-sm table-bordered" style="font-size: smaller;">
                                        <thead style="background-color: white;">
                                        <tr>
                                            <th style="background-color:white;">#</th>
                                            <th style="background-color:white;">Respondent Id</th>
                                            <th style="background-color:white;">Respondent Name</th>
                                            <th style="background-color:white;">Contact Number</th>
                                            <th style="background-color:white;">Link</th>
                                            <th style="background-color:white;">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(row,index) in this.all_data" :key="index">
                                                <td> {{row.id}}</td>
                                                <td> {{row.RespondentId}}</td>
                                                <td> {{row.RespName}}</td>
                                                <td> {{row.RespMobile}}</td>
                                                <td> {{row.survey_link}}</td>
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




        <!-- add modal  style=" height:435px;"  modal-dialog-scrollable-->
        <div class="modal fade" id="viewModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header p-1">
                    <h5 class="modal-title">Calling Information</h5>
                    <!-- <button type="button" class="btn btn-outline-primary btn-sm text-end" @click="tablePct()">Export to Excel</button> -->
                    <button type="button" class="btn-close btn-sm m-2 p-1" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-1 text-center mb-4">
                    <h2>Call to Respondent</h2>     
                    <h4 class="mt-4">Respondent Name : {{ resp_name }}</h4>              
                    <h4>Contact Number : {{ resp_mobile }}</h4>          
                    <div class="mb-4 mt-4 row justify-content-center">
                        <label class="col-form-label col-form-label-sm ml-2" style="font-weight: normal;color: chocolate;">Calling Status</label>
                            <!-- v-model="selected_filter_parameter[index]" -->
                            <!-- <div class="col-md-4"></div> -->
                            <div class="col-md-4">
                                <select id="selectpicker" class="form-control form-control-sm" v-model="calling_status" @change="onChange">
                                    <option :value="0">Select Calling Status</option>
                                    <option :value="2">Ringing and Received</option>
                                    <option :value="4">Ringing but not Received</option>
                                    <option :value="5">Switched Off</option>
                                    <option :value="6">Invalid Number</option>
                                </select>
                            </div>
                            <!-- <div class="col-md-4"></div> -->
                    </div>     
                    <button @click="start_survey(survey_link)" type="button" class="btn btn-outline-primary pl-2 pt-1 pr-2 pb-1 btn-sm">{{btn_label}}</button>
                </div>
                <div class="modal-footer p-1">
                    <!-- <button type="button" class="btn btn-primary btn-sm" v-on:click="saveSyntax">Save</button> -->
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" >Close</button>
                </div>
                </div>
            </div>
        </div>




        <!-- add modal  style=" height:435px;"  modal-dialog-scrollable-->
        <div class="modal fade" id="reportModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header p-1">
                    <h5 class="modal-title ml-3">Calling Report</h5>
                    <!-- <button type="button" class="btn btn-outline-primary btn-sm text-end" @click="tablePct()">Export to Excel</button> -->
                    <button type="button" class="btn-close btn-sm m-2 p-1" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-1 mb-4">
                    <div class="mb-4 mt-1 pl-2 row justify-content-left" id="duration">
                        <label class="col-md-1 col-form-label col-form-label-sm text-end">Start Date :</label>
                        <div class="col-md-2">
                            <input name="start_date" type="text" class="date form-control form-control-sm"  autocomplete="off">
                        </div> 
                        <label class="col-md-1 col-form-label col-form-label-sm text-end">End Date :</label>
                        <div class="col-md-2">
                            <input name="end_date" type="text" class="date form-control form-control-sm" autocomplete="off">
                        </div> 
                        <div class="col-md-1">
                            <button type="button" class="btn btn-outline-primary btn-sm ml-3">Show</button> 
                        </div>
                    </div>   
                   
                    <div v-if="this.report_data.length>0" class="table-container mt-2 m-3" style="height: 300px;"> 
                        <table class="table table-sm table-bordered" style="font-size: smaller;">
                            <thead style="background-color: white;">
                            <tr>
                                <th style="background-color:white;">Interviewer Name</th>
                                <th style="background-color:white;">Complete Interview</th>
                                <th style="background-color:white;">Incomplete Interview</th>
                                <th style="background-color:white;">Ringing not Received</th>
                                <th style="background-color:white;">Switched Off</th>
                                <th style="background-color:white;">Invalid Number</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row,index) in this.report_data" :key="index">
                                    <td> {{row.InterviewerName}}</td>
                                    <td> {{row.CompleteInterview}}</td>
                                    <td> {{row.IncompleteInterview}}</td>
                                    <td> {{row.RingingnotReceived}}</td>
                                    <td> {{row.SwitchedOff}}</td>
                                    <td> {{row.InvalidNumber}}</td>
                                </tr>
                            </tbody>
                        </table>
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
    export default {
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

            survey_link:'',
            resp_name:'',
            resp_mobile:'',
            calling_status:'',
            btn_label:'',
            respondent_id:'',
            report_data:[],

            }
        },

        props:['project_id'],

        mounted() {
            this.loadFilter();
            // console.log('Component mounted.')
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
                        .then(response => {this.all_data = response.data;
                            // this.all_keys=this.all_data[0];
                            // console.log(Object.keys(this.all_keys));
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

            onChange(){
                if(this.calling_status==2)
                    this.btn_label="Start Interview";
                else
                    this.btn_label="Save & Close";
            },

            start_survey(mylink){
                var save_status='';
                axios.post('/data_analysis/'+this.project_id+'/survey_data/update_survey_data',
                    {'myLink': mylink,
                     'respondent_id':this.respondent_id,
                    'calling_status':this.calling_status,})
                        .then(response => {
                            save_status = response.data;
                            console.log(response.data);
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
                axios.post('/data_analysis/'+this.project_id+'/survey_data/cati_report',
                    {'start_date': '30/04/2023',
                     'end_date': '30/04/2023',})
                        .then(response => {
                            this.report_data = response.data;

                    })
                        .catch(function (error) {this.errors = error});

        //                 $("body").delegate(".date", "focusin", function () {
            
        //     $(this).datepicker({  
        //    format: 'dd-mm-yyyy',
        //    autoclose:true,
        //  });
        // }); 

                        
                $('#reportModal').modal('show');

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
                        link.setAttribute('download', 'survey_data.xlsx');
                
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

        },
    }
   
</script>
