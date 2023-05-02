<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <button @click="load1stDashboard" id="dashboard1" type="button" class="btn btn-outline-primary pl-2 pt-1 pr-2 pb-1 btn-sm">Coverage</button>
                        <button @click="load2ndDashboard" id="dashboard2" type="button" class="btn btn-outline-info pl-2 pt-1 pr-2 pb-1 btn-sm ml-2">Category Summary [FCMP]</button>
                        <button @click="load3rdDashboard" id="dashboard3" type="button" class="btn btn-outline-warning pl-2 pt-1 pr-2 pb-1 btn-sm ml-2">Category Summary [Tea]</button>
                        <button @click="load4thDashboard" id="dashboard4" type="button" class="btn btn-outline-warning pl-2 pt-1 pr-2 pb-1 btn-sm ml-2">Brand in Display</button>
                        <button @click="load5thDashboard" id="dashboard5" type="button" class="btn btn-outline-warning pl-2 pt-1 pr-2 pb-1 btn-sm ml-2">Available Chart</button>
                    </div>

                    <div class="card-body pt-2 pb-2">
                        <first-component
                            v-if="showComponentOne" :project_id="this.project_id" 
                        ></first-component>
                        
                        <second-component 
                            v-if="showComponentTwo" :project_id="this.project_id" 
                        ></second-component>

                        <third-component 
                            v-if="showComponentThree" :project_id="this.project_id" 
                        ></third-component>

                        <forth-component 
                            v-if="showComponentForth" :project_id="this.project_id" 
                        ></forth-component>

                        <fifth-component 
                            v-if="showComponentFifth" :project_id="this.project_id" 
                        ></fifth-component>

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
            showComponentOne: false,
            showComponentTwo: false,
            showComponentThree: false,
            showComponentForth: false,
            showComponentFifth: false,
            };
        },

        props:["project_id"],


        mounted() {
            this.showComponentOne = true;
            console.log('dashboard',this.project_id);
        },
        methods:{
            load1stDashboard () {
                this.showComponentOne = true;
                this.showComponentTwo = false;
                this.showComponentThree = false;
                this.showComponentForth = false;
                this.showComponentFifth = false;
                
                document.getElementById("dashboard1").classList.add("active");
                document.getElementById("dashboard2").classList.remove("active");
                document.getElementById("dashboard3").classList.remove("active");
                document.getElementById("dashboard4").classList.remove("active");
                document.getElementById("dashboard5").classList.remove("active");
            },
            load2ndDashboard () {
                this.showComponentOne = false;
                this.showComponentTwo = true;
                this.showComponentThree = false;
                this.showComponentForth = false;
                this.showComponentFifth = false;

                document.getElementById("dashboard1").classList.remove("active");
                document.getElementById("dashboard2").classList.add("active");
                document.getElementById("dashboard3").classList.remove("active");
                document.getElementById("dashboard4").classList.remove("active");
                document.getElementById("dashboard5").classList.remove("active");
            },
            load3rdDashboard () {
                this.showComponentOne = false;
                this.showComponentTwo = false;
                this.showComponentThree = true;
                this.showComponentForth = false;
                this.showComponentFifth = false;

                document.getElementById("dashboard1").classList.remove("active");
                document.getElementById("dashboard2").classList.remove("active");
                document.getElementById("dashboard3").classList.add("active");
                document.getElementById("dashboard4").classList.remove("active");
                document.getElementById("dashboard5").classList.remove("active");
            },
            load4thDashboard () {
                this.showComponentOne = false;
                this.showComponentTwo = false;
                this.showComponentThree = false;
                this.showComponentForth = true;
                this.showComponentFifth = false;
                
                document.getElementById("dashboard1").classList.remove("active");
                document.getElementById("dashboard2").classList.remove("active");
                document.getElementById("dashboard3").classList.remove("active");
                document.getElementById("dashboard4").classList.add("active");
                document.getElementById("dashboard5").classList.remove("active");
            },
            load5thDashboard () {
                this.showComponentOne = false;
                this.showComponentTwo = false;
                this.showComponentThree = false;
                this.showComponentForth = false;
                this.showComponentFifth = true;
                
                document.getElementById("dashboard1").classList.remove("active");
                document.getElementById("dashboard2").classList.remove("active");
                document.getElementById("dashboard3").classList.remove("active");
                document.getElementById("dashboard4").classList.remove("active");
                document.getElementById("dashboard5").classList.add("active");
            },
        }
    }
   
</script>
