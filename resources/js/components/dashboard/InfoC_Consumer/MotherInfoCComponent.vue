<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <button @click="loadDashboard(1)" id="dashboard1" type="button" class="btn btn-outline-primary pl-2 pt-1 pr-2 pb-1 btn-sm">General Section</button>
                        <button @click="loadDashboard(2)" id="dashboard2" type="button" class="btn btn-outline-info pl-2 pt-1 pr-2 pb-1 btn-sm ml-2">Marks Active School</button>
                        <button @click="loadDashboard(3)" id="dashboard3" type="button" class="btn btn-outline-warning pl-2 pt-1 pr-2 pb-1 btn-sm ml-2">Marks Gold</button>
                        <button @click="loadDashboard(4)" id="dashboard4" type="button" class="btn btn-outline-secondary pl-2 pt-1 pr-2 pb-1 btn-sm ml-2">Marks Diabetic</button>
                        <button @click="loadDashboard(5)" id="dashboard5" type="button" class="btn btn-outline-danger pl-2 pt-1 pr-2 pb-1 btn-sm ml-2">Marks Young Star</button>
                        <button @click="loadDashboard(6)" id="dashboard6" type="button" class="btn btn-outline-warning pl-2 pt-1 pr-2 pb-1 btn-sm ml-2">Marks Diet</button>
                        <button @click="loadDashboard(7)" id="dashboard7" type="button" class="btn btn-outline-secondary pl-2 pt-1 pr-2 pb-1 btn-sm ml-2">Marks Active School 2in1</button>
                        <button @click="loadDashboard(8)" id="dashboard8" type="button" class="btn btn-outline-danger pl-2 pt-1 pr-2 pb-1 btn-sm ml-2">Marks Tin</button>
                    </div>

                    <div class="card-body pt-2 pb-2">
                        <child01-component v-if="showComponent01" :project_id="this.project_id"></child01-component>
                        <child02-component v-if="showComponent02" :project_id="this.project_id"></child02-component>
                        <child03-component v-if="showComponent03" :project_id="this.project_id"></child03-component>
                        <child04-component v-if="showComponent04" :project_id="this.project_id"></child04-component>
                        <child05-component v-if="showComponent05" :project_id="this.project_id"></child05-component>
                        <child06-component v-if="showComponent06" :project_id="this.project_id"></child06-component>
                        <child07-component v-if="showComponent07" :project_id="this.project_id"></child07-component>
                        <child08-component v-if="showComponent08" :project_id="this.project_id"></child08-component>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// import FirstComponent from './components/dashboard/FirstComponent'
// import SecondComponent from './components/dashboard/SecondComponent'

    export default {

        // components: {
        //     FirstComponent,
        //     SecondComponent,
        //     ThirdComponent
        // },

        data() {
            return {
            showComponent01: false,
            showComponent02: false,
            showComponent03: false,
            showComponent04: false,
            showComponent05: false,
            showComponent06: false,
            showComponent07: false,
            showComponent08: false,
            };       
        },        
            
        props:["project_id"],


        mounted() {
            this.showComponent01 = true;
            console.log('dashboard',this.project_id);
            document.getElementById("dashboard1").classList.add("active")
        },

        methods:{
            loadDashboard(id) {
                this.showComponent01 = false;
                this.showComponent02 = false;
                this.showComponent03 = false;
                this.showComponent04 = false;
                this.showComponent05 = false;
                this.showComponent06 = false;
                this.showComponent07 = false;
                this.showComponent08 = false;
                
                document.getElementById("dashboard1").classList.remove("active");
                document.getElementById("dashboard2").classList.remove("active");
                document.getElementById("dashboard3").classList.remove("active");
                document.getElementById("dashboard4").classList.remove("active");
                document.getElementById("dashboard5").classList.remove("active");
                document.getElementById("dashboard6").classList.remove("active");
                document.getElementById("dashboard7").classList.remove("active");
                document.getElementById("dashboard8").classList.remove("active");

                if(id==1) {this.showComponent01 = true; document.getElementById("dashboard1").classList.add("active")}
                else if(id==2) {this.showComponent02 = true; document.getElementById("dashboard2").classList.add("active")}
                else if(id==3) {this.showComponent03 = true; document.getElementById("dashboard3").classList.add("active")}
                else if(id==4) {this.showComponent04 = true; document.getElementById("dashboard4").classList.add("active")}
                else if(id==5) {this.showComponent05 = true; document.getElementById("dashboard5").classList.add("active")}
                else if(id==6) {this.showComponent06 = true; document.getElementById("dashboard6").classList.add("active")}
                else if(id==7) {this.showComponent07 = true; document.getElementById("dashboard7").classList.add("active")}
                else if(id==8) {this.showComponent08 = true; document.getElementById("dashboard8").classList.add("active")}


            },


        }
    }
   
</script>
