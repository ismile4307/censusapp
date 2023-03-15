<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <button @click="load1stDashboard" type="button" class="btn btn-outline-primary pl-2 pt-1 pr-2 pb-1 btn-sm">Dashboard 1</button>
                        <button @click="load2ndDashboard" type="button" class="btn btn-outline-primary pl-2 pt-1 pr-2 pb-1 btn-sm ml-2">Dashboard 2</button>
                        <button @click="load3rdDashboard" type="button" class="btn btn-outline-primary pl-2 pt-1 pr-2 pb-1 btn-sm ml-2">Dashboard 3</button>
                    </div>

                    <div class="card-body">
                        <first-component
                            v-if="showComponentOne"
                        />
                        <second-component 
                            v-if="showComponentTwo"
                        />
                        <third-component 
                            v-if="showComponentThree"
                        />
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
        //     SecondComponent
        // },
        data() {
            return {
            showComponentOne: false,
            showComponentTwo: false,
            showComponentThree: false
            };
        },
        mounted() {
            this.showComponentOne = true;
            console.log('Component mounted.')
        },
        methods:{
            load1stDashboard () {
                this.showComponentOne = true;
                this.showComponentTwo = false;
                this.showComponentThree = false;
            },
            load2ndDashboard () {
                this.showComponentOne = false;
                this.showComponentTwo = true;
                this.showComponentThree = false;
            },
            load3rdDashboard () {
                this.showComponentOne = false;
                this.showComponentTwo = false;
                this.showComponentThree = true;
            },
        }
    }
   
</script>
