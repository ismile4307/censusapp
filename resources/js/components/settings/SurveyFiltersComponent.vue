<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Variable List (Filter)</div>

                    <div class="card-body pt-2">
                        <div class="text-end mt-0">
                            <button type="button" class="btn btn-outline-success btn-sm mt-0" v-on:click="getVariableList()">Add Variables</button>
                        </div>
                        <div v-if="this.TableData.length>0" class="table-container mt-2"> 
                            <table id="myTable" class="table table-sm table-bordered" style="font-size: smaller;">
                                <thead style="background-color: white;">
                                <tr>
                                    <th style="background-color:white;width: 5%;">#</th>
                                    <th style="background-color:white;width: 10%;">Qid</th>
                                    <th style="background-color:white;">Question</th>
                                    <th style="background-color:white;width: 5%;">action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(row,index) in TableData" :key="index">
                                        <td> {{row.id}}</td>
                                        <td> {{row.qid}}</td>
                                        <td> {{row.question_text}}</td>
                                        <td>
                                            <button style="text-decoration:none;text-align: center" type="button" class="btn btn-link btn-sm pb-0 pt-0 pl-0 pr-0" v-on:click="removeVariable(row.id)">Remove</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- The Modal -->
        <div class="modal fade" id="variableListModal" >
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Variable List</h4>
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form class="container mt-3" ref="addVariables" @submit.prevent="saveVariables()">
                        
                            <table v-if="VariableList.length>0" class="table table-sm table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Qid</th>
                                    <th>Question</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(row,index) in VariableList" :key="index">
                                        <td> 
                                            <input type="checkbox" :value=row.qid v-model="selectedVariables" id="defaultCheck1">
                                        </td>
                                        <td> {{row.qid}}</td>
                                        <td> {{row.question_text}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div v-else> No interviewer found</div>
                        
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info btn-sm">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for confirmation-->
        <div id="myConfModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">

                <!-- Modal content-->
                <div class="modal-content">
                <!-- <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div> -->
                    <div class="modal-body">
                        <h6>Do you want to delete.</h6>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-info btn-sm" data-bs-dismiss="modal" style="margin:-2px">No</button>
                        <button type="submit" class="btn btn-outline-danger btn-sm" v-on:click="removeRecord">Yes</button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data(){
            return{
                TableData:[],
                VariableList:[],
                selectedVariables:[],

            }

        },

        props:['project_id'],

        mounted() {
            this.getTableData();
        },

        methods:{
            getTableData(){
                axios.get('/settings/'+this.project_id+'/survey_filters/get_table_data')
                .then(response => {
                    this.TableData = response.data;
                    console.log(response.data);
                });
            },

            getVariableList(){
                axios.get('/settings/'+this.project_id+'/survey_filters/get_variable_list')
                .then(response => {
                    this.VariableList = response.data;
                    // console.log(response.data);
                });

                this.$refs.addVariables.reset();
                this.selectedVariables=[];
                $('#variableListModal').modal('show');
            },

            saveVariables(){
                event.preventDefault();
                var app = this;

                var newData = app.selectedVariables;
                // console.log(newData);
                axios.post('/settings/'+this.project_id+'/survey_filters/set_variable_list', {'varList':newData})
                    .then(response => {
                    // this.VariableList = response.data;
                        // alert(resp.data.success);
                        // this.$forceUpdate();
                        // this.$nextTick(function(){ $('.myTable').DataTable('refresh'); });
                        
                    })
                    .catch(function (resp) {
                        // console.log(resp);
                        alert("Operation Fail");
                    });

                $('#variableListModal').modal('hide');
                
                this.getTableData();
            },

            removeVariable(id){
                axios.get('/settings/'+this.project_id+'/'+id+'/survey_filters/remove_variable')
                .then(response => {
                    this.TableData = response.data;
                    // console.log(response.data);
                });
            }
        },
    }
   
</script>
