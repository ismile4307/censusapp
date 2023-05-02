<template>
    <div>
        <div class="row mb-2">
            <div class="text-end">
                <button @click="addInfo" type="button" class="btn btn-sm btn-success">add</button>
            </div>           
        </div> 
        
        <table class="table table-sm table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>User Type</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in allData" :key="index">
                    <td> {{index+1}}</td>
                    <td> {{row.info}}</td>
                    <td>
                    <button style="text-decoration:none" type="button" class="btn btn-link btn-sm pb-0 pt-0" v-on:click="editUserType(row)">Edit</button>
                    </td>
                </tr>
            </tbody>
        </table>



        <!-- The Modal -->
        <div class="modal fade" id="interviewerModal" >
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <!-- <form class="container mt-3" ref="addInfo" @submit.prevent="saveUsers()"> -->
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">User Info</h4>
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    
                        <!-- <table class="table table-sm table-bordered">
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
                        </table> -->
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info btn-sm">Save</button>
                    </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>
</template>




<script>
    export default {
        data(){
            return {
            allData:[],
            myLabel:'',

            }
        },

        props:['id'],

        mounted() {
            this.initdata();
            // console.log('Component mounted.')
        },

        methods:{
            initdata() {
                // console.log(this.project_id);
                axios.get('/settings/'+this.id+'/get_support_info')
                     .then(response => {this.allData = response.data})
                     .catch(function (error) {this.errors = error});
                
                // this.projectName=this.myProject[0].project_name;
                    //  console.log(this.myProject);

            },

            // getUsers(){
            //     axios.get('/project_user/'+this.project_id+'/get_users')
            //          .then(response => {this.Users = response.data})
            //          .catch(function (error) {this.errors = error});

            //     this.$refs.addUser.reset();
            //     this.ProjectUsers.selectedUsers=[];
            //     $('#interviewerModal').modal('show');
            // },

            addInfo(){
                // this.$refs.addInfo.reset();
                // //  this.bSaveCode=0;      //Here 0 means add
                // console.log(this.ProjectInterviewers.selectedInterviewers);
                // $('#interviewerModal').modal('hide');
            },
            

            // editInterviewer(row){
            //     this.Interviewer.id=row.id;
            //     this.Interviewer.interviewer_id=row.interviewer_id;
            //     this.Interviewer.interviewer_name=row.interviewer_name;
            //     this.Interviewer.password=row.password;
            //     this.Interviewer.status=row.status;
            //     this.bSaveCode=1;      //Here 0 means edit
            //     $('#interviewerModal').modal('show');
            // },

            // editUser(row){
            //     this.user.id=row.id;
            //     this.user.name=row.name;
            //     this.user.email=row.email;
            //     this.user.user_type=row.user_type;
            //     this.user.user_type_id=this.userType.filter(c => c.user_type.indexOf(this.user.user_type) > -1)[0].id;
            //     this.user.status=row.status;


            //     $('#viewModal').modal('show');
            // },

            // saveUsers(){
            //     event.preventDefault();
            //     var app = this;
            //     // app.user.user_type_id = this.userType.filter(p => p.user_type === this.user.user_type)[0].id

            //     var newData = app.ProjectUsers;
            //     newData.project_id=this.project_id;
            //     console.log(newData);
            //     axios.post('/project_user/assign_users', newData)
            //         .then(function (resp) {
            //             //app.$router.push({path: '/'});
            //             console.log(resp.data);
                        
            //             // alert(resp.data);
            //         })
            //         .catch(function (resp) {
            //             // console.log(resp);
            //             // alert("Could not create new data");
            //         });

            //     $('#interviewerModal').modal('hide');

            //     this.loadTable();
            // },

            // loadTable(){
            //     axios.get('/project_user/'+this.project_id+'/get_project_user_info')
            //          .then(response => {this.allProjectUsers = response.data})
            //          .catch(function (error) {this.errors = error});
            // },

            myCounter(myIndex){
        		return myIndex+1;
        	},
        }
    }
</script>