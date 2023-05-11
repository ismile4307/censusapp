<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-8">
                <div class="card">
                    <div class="card-header text-center"><h4>Column List</h4></div>
                    <div class="card-body pt-2">
                        <div class="text-end mt-0">
                            <button type="button" class="btn btn-outline-success btn-sm mt-0" v-on:click="getColumnList()">Add Columns</button>
                        </div>
                        <div v-if="this.tablealldata.length>0" class="table-container mt-2"> 
                            <table id="myTable" class="table table-sm table-bordered" style="font-size: smaller;">
                                <thead style="background-color: white;">
                                <tr>
                                    <th style="background-color:white;width: 5%;">#</th>
                                    <th style="background-color:white;width: 10%;">Column Name</th>
                                    <th style="background-color:white;">Column Description</th>
                                    <th style="background-color:white;width: 5%;">action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(row,index) in tablealldata" :key="index">
                                        <td> {{row.id}}</td>
                                        <td> {{row.column_name}}</td>
                                        <td> {{row.column_description}}</td>
                                        <td>
                                            <button style="text-decoration:none;text-align: center" type="button" class="btn btn-link btn-sm pb-0 pt-0 pl-0 pr-0" v-on:click="removeColumn(row.id)">Remove</button>
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
        <div class="modal fade" id="ColumnListModal" >
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title text-center">Column List</h4>
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body p-0">
                        <form class="container" ref="addVariables" @submit.prevent="savColumn()">
                        
                            <table v-if="all_column.length>0" class="table table-sm table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="bg-white">Column Name</th>
                                    <th class="bg-white">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(row,index) in all_column" :key="index">
                                        <td> 
                                            <input type="checkbox" :value="row.id" v-model="selectedColumn" id="defaultCheck1">
                                        </td>
                                        <td> {{row.field_name}}</td>
                                        <td> {{row.description}}</td>
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

    </div>
</template>

<script>
import axios from 'axios'
    export default {
        props:['project_id'],

        data(){
            return {
                all_column:[],
                selectedColumn:[],
                tablealldata:[],
            }
        },
        
        mounted(){
            this.tableShowColumn();
        },

        methods:{
            getColumnList(){
                axios.get('/resp_panel/set_column/all_column')
                .then(response =>{
                    this.all_column = response.data;
                  //  console.log(response.data);
                })
                .catch(function (error) {this.errors = error});
                this.$refs.addVariables.reset();
                this.selectedColumn=[];
                $('#ColumnListModal').modal('show');
            },

            savColumn(){
                axios.post('/resp_panel/set_column/save_column', {
                    selectedColumn_id:this.selectedColumn
                })
                .then(response =>{
                    this.tableShowColumn();
                    response.data

                })
                .catch(function (error) {this.errors = error});

                $('#ColumnListModal').modal('hide');
            },

            tableShowColumn(){
                axios.get('/resp_panel/set_column/tableshow_column')
                .then(response=>{
                   this.tablealldata = response.data;
                })
                .catch(function (error) {this.errors = error});
            },

            removeColumn(id){
                axios.post('/resp_panel/'+id+'/remove_column')
                .then(response=>{
                    this.tableShowColumn();
                    response.data
                })
                .catch(function (error) {this.errors = error});

            }


        },
        
    }
</script>