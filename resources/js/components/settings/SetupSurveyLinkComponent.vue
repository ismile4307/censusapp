<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Setup Survey Link ({{ project.project_name }})</div>

                    <div class="card-body pt-2">
                        <div class="text-center">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <th>Title</th>
                                    <th>Count</th>
                                </thead>
                                <tbody>
                                    <tr v-for="(panel_data,index) in total_panel_data" :key="index">
                                        <td>Total Panel Data </td>
                                        <td>{{panel_data.TotalData}}</td>
                                    </tr>
                                    <tr v-for="(panel_data_with_link,index) in total_panel_data_with_link" :key="index">
                                        <td>Total Panel Data (With Link) </td>
                                        <td>{{panel_data_with_link.TotalData}}</td>
                                    </tr>
                                    <tr v-for="(panel_data_without_link,index) in total_panel_data_without_link" :key="index">
                                        <td>Total Panel Data (Without Link) </td>
                                        <td>{{panel_data_without_link.TotalData}}</td>
                                    </tr>
                                    <tr v-for="(survey_link,index) in total_survey_link" :key="index">
                                        <td>Total Survey Link </td>
                                        <td>{{survey_link.TotalLink}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center">
                                <button type="button" class="btn btn-outline-success btn-sm" @click="SetLinkToPanelData">Set Survey link to Data</button>
                            </div>
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
            return{
                project:'',
                total_panel_data:[],
                total_survey_link:[],
                total_panel_data_with_link:[],
                total_panel_data_without_link:[],
            }

        },

        props:['project_id'],

        mounted() {
            this.getPanelDataInfo();
        },

        methods:{
            getPanelDataInfo(){
                axios.get('/settings/'+this.project_id+'/setup_survey_link/get_panel_data_info')
                .then(response => {
                    this.project = response.data[0];
                    this.total_panel_data = response.data[1];
                    this.total_survey_link = response.data[2];
                    this.total_panel_data_without_link=response.data[3];
                    this.total_panel_data_with_link=response.data[4];
                    console.log(response.data);
                });
            },
            SetLinkToPanelData(){
                if(this.total_survey_link[0].TotalLink-this.total_panel_data[0].TotalData>=0)
                {
                    axios.get('/settings/'+this.project_id+'/setup_survey_link/set_link_to_panel_data')
                        .then(response => {
                            this.project = response.data[0];
                            this.total_panel_data = response.data[1];
                            this.total_survey_link = response.data[2];
                            this.total_panel_data_without_link=response.data[3];
                            this.total_panel_data_with_link=response.data[4];
                            console.log(response.data);
                        });
                }else{
                    alert("Not enough link to set to panel data ("+(this.total_panel_data[0].TotalData-this.total_survey_link[0].TotalLink)+")");
                }
            }

            
        },
    }
   
</script>
