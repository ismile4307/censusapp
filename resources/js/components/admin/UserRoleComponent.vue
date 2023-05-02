<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Active User List</div>

                    <div class="card-body pt-2">

                        <div v-if="this.UserData.length>0" class="table-container mt-2"> 
                            <table id="myTable" class="table table-sm table-bordered">
                                <thead style="background-color: white;">
                                <tr>
                                    <th style="background-color:white;">#</th>
                                    <th style="background-color:white;">User Name</th>
                                    <th style="background-color:white;">Email Id</th>
                                    <th style="background-color:white;">Organization</th>
                                    <th style="background-color:white;">User Type</th>
                                    <th style="background-color:white;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(row,index) in UserData" :key="index">
                                        <td> {{row.id}}</td>
                                        <td> {{row.name}}</td>
                                        <td> {{row.email}}</td>
                                        <td> {{ row.org_name }}</td>
                                        <td> {{row.user_type}}</td>
                                        <td>
                                            <button style="text-decoration:none;text-align: center" type="button" class="btn btn-link btn-sm pb-0 pt-0 pl-0 pr-0" v-on:click="viewRole(row.id)">Set Role</button>
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
        <!-- The Modal -->
        <div class="modal fade" id="userRoleModal" >
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md"  role="document">
                <div class="modal-content">               
               
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">User Role</h4>
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form class="container mt-3" ref="userRoleModal" @submit.prevent="saveUserRole()">
                            <!-- <label>{{ Auth::user()->name }}</label> -->
                            <!-- Modal body -->
                            
                                <table class="table table-sm table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width: 10%;">#</th>
                                        <th>Role</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row,index) in UserRoles" :key="index">
                                            <td style="width: 10%;"> 
                                                <input type="checkbox" :value=row.activity_id v-model="selected_roles" id="defaultCheck1">
                                            </td>
                                            <td> {{row.activity}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            
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
                UserData:[],
                UserRoles:[],
                activity_id:[],
                selected_roles:[],
                user_id:'',
                VariableList:[],
                selectedVariables:[],
            }

        },

        props:['project_id'],

        mounted() {
            this.getUserData();
        },

        methods:{
            getUserData(){
                axios.get('/admin/user_role/get_user_data')
                .then(response => {
                    this.UserData = response.data;
                    // console.log(response.data);
                });
            },

            getVariableList(){
                axios.get('/settings/'+this.project_id+'/set_variables/get_variable_list')
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
                axios.post('/settings/'+this.project_id+'/set_variables/set_variable_list', {'varList':newData})
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
                
                this.getUserData();
            },

            viewRole(user_id){
                this.user_id=user_id;
                axios.get('/admin/'+user_id+'/user_role/get_user_role')
                .then(response => {
                    this.UserRoles = response.data;
                    // console.log(response.data);

                    // var i=0;
                    this.selected_roles=[];
                    this.UserRoles.forEach(element=>{
                        if(element.activity_id==element.user_activity_id)
                        this.selected_roles.push(element.activity_id);
                    });
                });

                $('#userRoleModal').modal('show');
            },


            saveUserRole(){
                // console.log(this.selected_role);

                axios.post('/admin/'+this.user_id+'/user_role/save_user_role',{'selected_roles':this.selected_roles})
                .then(response => {
                    // this.UserRoles = response.data;
                    // console.log(response.data);
                });

                $('#userRoleModal').modal('hide');
            },
        },
    }
   
</script>
