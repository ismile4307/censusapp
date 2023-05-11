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
                            <button @click="exportToExcel()" type="button" class="btn btn-outline-primary pl-2 pt-1 pr-2 pb-1 btn-sm">Export to Excel</button>
                        </div>
                    </div>  
                    <div class="card-body pt-0 pb-2 pl-2 pr-2">
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-3 mb-2" v-for="(values,index) in this.dropdown_value" :key="values">
                                <label class="col-form-label col-form-label-sm ml-2" style="font-weight: normal;color: chocolate;">{{ dropdown_name[index] }}</label>
                                <select id="selectpicker" class="selectpicker form-control form-control-sm mr-2" multiple v-model="selected_filter_values[index]">
                                    <template v-for="value in values" :key="value">
                                        <option :value="value.label">{{value.label}}</option>
                                    </template>
                                </select>
                            </div>
                        </div>
                        <div class="text-center">
                            <button @click="getData" type="button" class="btn btn-outline-success pl-2 pt-1 pr-2 pb-1 btn-sm">Execute</button>
                            <div>
                                <label v-if="this.all_data.length>0" class="col-form-label col-form-label-sm">Total Number of Respondent : {{ this.all_data.length }}</label>
                            </div>
                        </div>

                        <div v-if="this.all_data.length>0" class="table-container mt-2"> 
                            <table class="table table-sm table-bordered" style="font-size: smaller;">
                                <thead style="background-color: white;">
                                    <tr>
                                        <!-- <th style="background-color:white;">#</th> -->
                                        <template v-for="(row,index) in this.table_column" :key="index">
                                            <th style="background-color:white;">
                                                {{ row.column_description }}
                                            </th>
                                        </template>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(row1,index) in all_data" :key="index">
                                        <template  v-for="(row2,ind) in table_column" :key="ind">
                                            <td>{{ row1[row2.column_name] }}</td>
                                        </template>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center" v-else><label class="col-form-label col-form-label-sm">No Record Found</label></div>
                    </div>
                </div>
            </div>
        </div>


        <!-- The Modal -->
        <div class="modal fade" id="filterParameterModal">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md"  role="document">
                <div class="modal-content">    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Filter Parameter</h4>
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body p-0">
                        <form class="container" ref="filterParameterModal" @submit.prevent="saveFilterParameter()">
                            <!-- Modal body -->
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="bg-white">Filter parameter</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row,index) in all_parameters" :key="index">
                                            <td class="align-middle"> 
                                                <input type="checkbox" :value="row.field_name" v-model="save_filter_parameter" id="defaultCheck1">
                                            </td>
                                            <td> {{row.description}}</td>
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
import axios from 'axios';

    export default {
        data(){
            return {
                all_parameters:[],
                save_filter_parameter:[],
                field_nama:[],
                dropdown_name:[],
                dropdown_value:[],
                selected_filter_values:[],
                all_data:[],
                table_column:[],

            }
        },

        props:['project_id'],

        mounted() {
            this.loadFilter();
            this.getColumn();
        },

        methods:{
            getFilterQuestion(){
                axios.get('/resp_panel/search_operation/get_all_parameter')
                     .then(response => {
                        this.all_parameters = response.data[0];
                        this.save_filter_parameter = response.data[1];
                      })
                     .catch(function (error) {this.errors = error});

                this.$refs.filterParameterModal.reset();
                //this.filter_parameter.selected_parameter=[];
                $('#filterParameterModal').modal('show');
            },

            saveFilterParameter(){
                axios.post('/resp_panel/save_filter_data/save_data', {
                    save_filter_parameter:this.save_filter_parameter
                })
                .then(response =>{
                    this.field_nama = response.data[0];
                    this.dropdown_name = response.data[1];
                    this.dropdown_value = response.data[2];
                    this.$nextTick(function(){ $('.selectpicker').selectpicker('refresh'); });
                })
                .catch(function (error){this.errors = error});
                $('#filterParameterModal').modal('hide');
            },

            loadFilter(){
                axios.get('/resp_panel/resp_dropdown/resp_data')
                .then(response =>{
                    this.field_nama = response.data[0];
                    this.dropdown_name = response.data[1];
                    this.dropdown_value = response.data[2];

                    let i=0;
                    this.field_nama.forEach(element=>{
                            this.selected_filter_values[i]=0;
                            i++;
                        });

                    this.$nextTick(function(){ $('.selectpicker').selectpicker('refresh'); });
                })
                .catch(function (error) {this.errors = error});
            },

            getData(){
                axios.post('/resp_panel/filter_parameter/get_data', {
                    selected_filter_values:this.selected_filter_values,
                    field_nama:this.field_nama,
                    table_column:this.table_column,
                })
                .then(response => {
                    this.getColumn();
                    this.all_data = response.data;
                })
                .catch(function (error) {this.errors=error});
            },
            getColumn(){
                axios.get('/resp_panel/report_column/table_column')
                .then(response=>{
                    this.table_column=response.data;
                   // console.log(response.data);
                })
                .catch(function(error){this.erorrs=error});
            },

            exportToExcel(){
                axios.post('/resp_panel/export_excel/excel_data',{
                    selected_filter_values:this.selected_filter_values,
                    field_nama:this.field_nama,
                    table_column:this.table_column,

                },{responseType: 'blob'}
                )
                .then(response=>{
                    let today= new Date().toLocaleDateString("de-DE");
                    let fileURL = window.URL.createObjectURL(new Blob([response.data]));
                    let fileLink = document.createElement('a');
                    fileLink.href = fileURL;
                    fileLink.setAttribute('download', 'Repondent_report_'+today+'.xlsx');
                    document.body.appendChild(fileLink);
                    fileLink.click();
                })
                .catch(function (error) {this.errors=error})
            },

        }

    }
   
</script>
