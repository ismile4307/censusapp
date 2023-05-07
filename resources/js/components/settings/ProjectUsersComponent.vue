<template>
    <div>
        <div class="form-inline" style="margin-bottom: 10px;">
            
            <div class="form-group col-sm-8" v-for="(row,index) in ProjectInfo" :key="index">                
            <label for="filter_by" class="col-form-label col-form-label-sm">Project Name : {{row.project_name}} </label>                
            </div>
            <div class="text-end col-sm-4">
                <button @click="getUsers" type="button" class="btn btn-sm btn-success">Add User</button>
            </div>           
        </div> 
        
        <table class="table table-sm table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>User Name</th>
                <th>User Type</th>
                <th>Organization</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in allProjectUsers" :key="index">
                    <td> {{index+1}}</td>
                    <td> {{row.name}}</td>
                    <td> {{row.user_type}}</td>
                    <td> {{row.organization_name}}</td>
                    <td>
                    <button style="text-decoration:none" type="button" class="btn btn-link btn-sm pb-0 pt-0" v-on:click="getConfirmation(row)">Remove</button>
                    </td>
                </tr>
            </tbody>
        </table>



        <!-- The Modal -->
        <div class="modal fade" id="interviewerModal" >
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form class="container mt-3" ref="addUser" @submit.prevent="saveUsers()">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">User Info</h4>
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    
                        <table class="table table-sm table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>User Type</th>
                                <th>Organizatoin</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row,index) in Users" :key="index">
                                    <td> 
                                        <input type="checkbox" :value=row.id v-model="ProjectUsers.selectedUsers" id="defaultCheck1">
                                    </td>
                                    <td> {{row.name}}</td>
                                    <td> {{row.user_type}}</td>
                                    <td> {{row.organization_name}}</td>
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
            return {
            // bSaveCode:'',
            ProjectInfo:[],
            Users:[],
            allProjectUsers:[],
            myId:'',
            
            // filterStatus:{status:''},

            ProjectUsers:{
                project_id:'',
                selectedUsers:[],
            },

            }
        },

        props:['project_id'],

        mounted() {
            this.initdata();
            // console.log('Component mounted.')
        },

        methods:{
            initdata() {
                // console.log(this.project_id);
                axios.get('/settings/'+this.project_id+'/project_users/get_project_info')
                     .then(response => {this.ProjectInfo = response.data})
                     .catch(function (error) {this.errors = error});
                
                // this.projectName=this.myProject[0].project_name;
                    //  console.log(this.myProject);
                this.loadTable();

            },

            getUsers(){
                axios.get('/settings/'+this.project_id+'/project_users/get_users')
                     .then(response => {this.Users = response.data})
                     .catch(function (error) {this.errors = error});

                this.$refs.addUser.reset();
                this.ProjectUsers.selectedUsers=[];
                $('#interviewerModal').modal('show');
            },

            saveUsers(){
                event.preventDefault();
                var app = this;
                // app.user.user_type_id = this.userType.filter(p => p.user_type === this.user.user_type)[0].id

                var newData = app.ProjectUsers;
                newData.project_id=this.project_id;
                console.log(newData);
                axios.post('/settings/project_users/assign_users', newData)
                    .then(function (resp) {
                        //app.$router.push({path: '/'});
                        console.log(resp.data);
                        
                        // alert(resp.data);
                    })
                    .catch(function (resp) {
                        // console.log(resp);
                        // alert("Could not create new data");
                    });

                $('#interviewerModal').modal('hide');

                this.loadTable();
            },

            loadTable(){
                axios.get('/settings/'+this.project_id+'/project_users/get_project_user_info')
                     .then(response => {this.allProjectUsers = response.data})
                     .catch(function (error) {this.errors = error});
            },

            getConfirmation(row){
                this.myId=row.id;
              $('#myConfModal').modal('show');
            },

            removeRecord(){
                axios.get('/settings/'+this.myId+'/project_users/delete_project_user')
                        .then(function (resp) {
                        //app.$router.push({path: '/'});
                        console.log(resp);
                        
                        // alert(resp.data.success);
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Fail to delete record");
                    });

                $('#myConfModal').modal('hide');

                this.loadTable();
            },

            myCounter(myIndex){
        		return myIndex+1;
        	},
        }
    }
</script>