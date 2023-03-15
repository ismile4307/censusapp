<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Survey Data Component</div>

                    <div class="card-body">
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
                                    <th style="background-color:white;">Latitude</th>
                                    <th style="background-color:white;">Longitude</th>
                                    <th style="background-color:white;">Centre</th>
                                    <th style="background-color:white;">Thana</th>
                                    <th style="background-color:white;">Bazar/Land Mark</th>
                                    <th style="background-color:white;">Store Name</th>
                                    <th style="background-color:white;">Store Address</th>
                                    <th style="background-color:white;">Name of shop owner or manager</th>
                                    <th style="background-color:white;">Mobile number of shop owner or manager</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(row,index) in this.all_data" :key="index">
                                        <td> {{row.id}}</td>
                                        <td> {{row.RespondentId}}</td>
                                        <td> {{row.Latitude}}</td>
                                        <td> {{row.Longitude}}</td>
                                        <td> {{row.Centre}}</td>
                                        <td> {{row.Thana}}</td>
                                        <td> {{row.Q3}}</td>
                                        <td> {{row.StoreName}}</td>
                                        <td> {{row.StoreAddress}}</td>
                                        <td> {{row.RespName}}</td>
                                        <td> {{row.RespMobile}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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

            }
        },

        props:['project_id'],

        mounted() {
            this.getData();
            // console.log('Component mounted.')
        },

        methods:{
            getData(){

                axios.get('/data_analysis/'+this.project_id+'/get_survey_data')
                     .then(response => {this.all_data = response.data;
                        console.log(this.all_data);
                })
                     .catch(function (error) {this.errors = error});
            },
        },
    }
   
</script>
