<template>
    <!-- <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-info">
                    <div class="card-header">Frequency Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div>
        <div class="col-3 col-md-3 float-start card p-0 border-info">
            <div class="card-header text-center text-white bg-info p-1">Table Title</div>
            <div class="card-body p-0">
                <div class="table-container pt-1" style=" height:460px;">
                <table class="table table-bordered table-sm" style="font-size:smaller;">
                    <tbody>
                        <tr v-for="(tableInfo, index) in TableInfos" :key="index">
                            <!-- <td>{{ index }}</td> -->
                            <td class="pl-3"><a class="text-decoration-none" href="#" style="display:block" @click="getTable(tableInfo.id)">{{ tableInfo.question_text }}</a></td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <div class="pl-2">
            <div class="col-9 col-md-9 float-end card p-0 border-info" style=" height:480px;">
                <div class="card-header text-center text-white bg-info p-1">Frequency Table</div>
                <div class="card-body pt-0 pb-0">
                    <!-- <h6 class="text-black"><b>{{ tabCap }}</b></h6>
                    <hr> -->
                    
                    <div class="text-center mt-1">
                        <label v-if="perData.length>0">{{ tabCap }}</label>
                    </div>

                        <div v-if="perData.length>0" class="table-container mt-1" >
                            <table class="table table-bordered table-sm" style="font-size:smaller;">
                                <thead>
                                    <tr>
                                        <th style="width:50%; top:0;">Attribute Label</th>
                                        <th class="text-center" style="width:25%; background-color: white; top:0;">Total</th>
                                        <th class="text-center" style="width:25%; background-color: white; top:0;">Percentage</th>
                                    </tr>
                                </thead>
                                        
                                <tbody>
                                    <tr v-for="(data, index) in perData" :key="index" >
                                        <td>{{ data.Label }}</td>
                                        <td class="text-center">{{ data.Total }}</td>
                                        <td class="text-center">{{ data.Percentage }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Total</b></td>
                                        <td class="text-center"><b>{{ GrandTotal.count_total}}</b></td>
                                        <td class="text-center"><b>{{ GrandTotal.pct_total }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
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
                TableInfos:[],
                AllTables:[],
                perData:'',
                tabCap:'',
                GrandTotal:'',
            }

        },

        props:['project_id'],
        
        mounted() {
            this.getFrequencyTableInfo();
            // console.log('Component mounted.')
        },
        methods:{
            getFrequencyTableInfo(){
                axios.get('/data_analysis/'+this.project_id+'/frequency_table/get_table_info')
                .then(response => {
                    this.TableInfos = response.data;
                    console.log(response.data);
                });
            },

            getTable(id){
                console.log(id);
                axios.get('/data_analysis/'+this.project_id+'/frequency_table/'+id+'/get_freqyency_table')
                     .then(response => {
                        this.perData = response.data[0];
                        this.tabCap = response.data[1];
                        this.GrandTotal=response.data[2];
                        // console.log(response.data);
                    })
                     .catch(function (error) {this.errors = error});
                
                // this.projectName=this.myProject[0].project_name;
                    //  console.log(this.AllTables);
                //this.loadTable();

            }
        }
    }
   
</script>
