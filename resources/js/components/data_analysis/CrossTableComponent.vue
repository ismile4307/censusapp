<template>
    <div class="row pl-2">
        <div class="col-3 col-md-3 float-start card p-0 border-info">
            <div class="card-header text-center text-white bg-info p-1">Table Title</div>
            <div class="card-body p-0">

                    <div class="drop-zone" @drop="onDrop($event, 1)" @dragenter.prevent @dragover.prevent >
                        <div class="table-container pt-1" style="height:590px;" >
                        <table class="table table-bordered table-sm" style="font-size: smaller;">
                            <!-- <thead class="text-center" style=" top: 0; position: sticky; background-color:#33FFBD">
                                <tr>
                                    <th  scope="col">Question Label</th>
                                </tr>
                            </thead> -->
                            <tbody>
                                <tr v-for="item in itemsA" :key="item.id" class="drag-el table-sm table-striped" draggable="true" @dragstart="startDrag($event, item)">
                                    <td class="pl-3">{{ item.question_text }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="col-9 col-md-9">
            <div class="row">
                <div class="col-4 col-md-4">
                    <div class="card">
                        <div class="card-header text-center text-white bg-info p-1">Side-break</div>
                        <div class="card-body p-0">
                            <div class="drop-zone" @drop="onDropX($event, 2)" @dragenter.prevent @dragover.prevent>
                                <div class="table-container pt-1" style=" height:100px;">
                                <table class="table table-bordered table-sm m-0" style="font-size: smaller;">
                                    <!-- <thead>
                                        <tr>
                                            <th class="p-3 text-success"><h5>X-Axis</h5></th>
                                        </tr>
                                    </thead> -->
                                    <tbody id="clear">
                                        <tr v-for="item in itemsB" :key="item.id" class="drag-el table-sm table-bordered" draggable="true" @dragstart="startDragX($event, item)">
                                            <td class="pl-3">{{ item.question_text }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
  
                <div class="col-4 col-md-4">
                    <div class="card">
                        <div class="card-header text-center text-white bg-info p-1">Top-break</div>
                        <div class="card-body p-0">
                            <div class="drop-zone" @drop="onDropY($event, 3)" @dragenter.prevent @dragover.prevent>
                                <div class="table-container pt-1" style=" height:100px;">
                                <table class="table table-bordered table-sm m-0" style="font-size: smaller;">
                                    <!-- <thead>
                                        <tr>
                                            <th class="p-3 text-success"><h5>Y-Axis</h5></th>
                                        </tr>
                                    </thead> -->
                                    <tbody id="clear">
                                        <tr v-for="item in itemsC" :key="item.id" class="drag-el" draggable="true" @dragstart="startDragY($event, item)">
                                        <td class="pl-3"> {{ item.question_text }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
  
                <div class="col-4 col-md-4">
                    <div class="card">
                        <div class="card-header text-center text-white bg-info p-1">Filter</div>
                        <div class="card-body p-0">
                            <div class="drop-zone" @drop="onDropZ($event, 3)" @dragenter.prevent @dragover.prevent>
                                <div class="table-container pt-1" style=" height:100px;">
                                <table class="table table-bordered table-sm m-0" style="font-size: smaller;">
                                    <!-- <thead>
                                        <tr>
                                            <th class="p-3 text-success"><h5>Filter By</h5></th>
                                        </tr>
                                    </thead> -->
                                    <tbody id="clear">
                                        <tr v-for="item in itemsD" :key="item.id" class="drag-el" draggable="true" @dragstart="startDragZ($event, item)">
                                            <td class="pl-3">{{ item.question_text }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>



                <div v-if="this.all_filter_attributes.length>0" class="row d-flex justify-content-left mb-3">
                    <div class="col-sm-4 mb-2" v-for="(attributes,index) in this.all_filter_attributes" :key="attributes">
                        <label class="col-form-label col-form-label-sm ml-2" style="font-weight: normal;color: chocolate;">{{ all_filter_qids[index].question_text }}</label>
                        <select class="form-control form-control-sm mr-2" v-model="selected_filter_parameter[index]">
                            <option value="0">Select {{ all_filter_qids[index].question_text }}</option>
                            <template v-for="attribute in attributes" :key="attribute">
                                <option :value="attribute.attribute_value">{{ attribute.attribute_label}}</option>
                            </template>
                        </select>
                    </div>
                </div>



                <div class="col-12 col-md-12 ">
                    <div class="row">
                        <div class="text-start col-4 col-md-4 m-0">
                            <button type="button" class="btn btn-outline-info btn-sm pl-2 pr-2" @click="refresh()">Refresh</button>
                        </div>
                        <div class="text-center col-4 col-md-4 m-0">
                            <button type="button" class="btn btn-outline-success btn-sm pl-2 pr-2" @click="tablePct()">Get Table</button>
                        </div>
                        <div class="text-end col-4 col-md-4 m-0">
                            <button type="button" class="btn btn-outline-primary btn-sm pl-2 pr-2" @click="tablePct()">Export to Excel</button>
                        </div>
                    </div>

                </div>


                <!-- <div class="col-12 col-md-12 mt-2" v-if="tableColPct !=''">
                    <div class="card m-0 p-0" >
                        <Label class="pl-1 pb-0" style="font-size: small;">Table Title:</Label>
                        <Label class="pl-1 pb-0" style="font-size: small;">Base : All respondent</Label>
                        <div class="table-container" style=" height:435px;">
                            <table class="table table-bordered table-sm mt-2">
                                <thead style="top: 0; position: sticky; background-color: white;">
                                    <tr>
                                        <th class="text-white" style="width: 10%;"></th>
                                        <th style="width: 5%; text-align: center;">Total</th>
                                        <th v-for="(attrLbel, index) in attr_label" :key="index" class="text-center table-bordered" style="width: 5%;white-space: pre-wrap;">
                                            {{ attrLbel.attribute_label }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in tableBase" :key="index" class="pl-2">
                                        <th style="background-color: white; font-size: smaller; width: 10%;">Base</th>
                                        <th style="background-color: white; font-size: smaller; width: 5%;text-align: center;">{{ data.total }}</th>
                                        <th class="text-center" v-for="(attrLbel, index1) in attr_label" :key="index1" style="font-size: smaller;width: 5%;">{{ data[yaxis[0].qid+attrLbel.attribute_value] }}</th>
                                    </tr>
                                    <tr v-for="(data, index) in tableColPct" :key="index" class="pl-2">
                                        <td style="background-color: white; font-size: smaller; width: 10%;">{{ data.Label }}</td>
                                        <td style="background-color: white; font-size: smaller; width: 5%;text-align: center;">{{ data.total }}</td>
                                        <td class="text-center" v-for="(attrLbel, index1) in attr_label" :key="index1" style="font-size: smaller;width: 5%;">{{ data[yaxis[0].qid+attrLbel.attribute_value] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> -->

                <!-- add modal  style=" height:435px;"  modal-dialog-scrollable-->
                <div class="modal fade" id="viewModal">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                        <div class="modal-header p-1">
                            <h5 class="modal-title">Add Script Syntax</h5>
                            <!-- <button type="button" class="btn btn-outline-primary btn-sm text-end" @click="tablePct()">Export to Excel</button> -->
                            <button type="button" class="btn-close btn-sm m-2 p-1" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-1">
                            <div class="col-12 col-md-12 mt-2" v-if="tableColPct !=''">
                                <div class="card m-0 p-0" >
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="pl-1 pb-0" style="font-size: medium;">Table Title:</div>
                                            <div class="pl-1 pb-0" style="font-size: medium;">Base : All respondent</div>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <button type="button" class="btn btn-outline-primary btn-sm m-2" @click="tablePct()">Export to Excel</button>
                                        </div>
                                    </div>
                                    <div class="table-container">
                                        <table class="table table-bordered table-sm mt-2">
                                            <thead style="top: 0; position: sticky; background-color: white;">
                                                <tr>
                                                    <th style="background-color: white;width: 10%;"></th>
                                                    <th style="background-color: white;width: 5%; text-align: center;">Total</th>
                                                    <th v-for="(attrLbel, index) in attr_label" :key="index" class="text-center table-bordered" style="width: 5%;white-space: pre-wrap;">
                                                        {{ attrLbel.attribute_label }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(data, index) in tableBase" :key="index" class="pl-2">
                                                    <th style="background-color: white; font-size: smaller; width: 10%;">Base</th>
                                                    <th style="background-color: white; font-size: smaller; width: 5%;text-align: center;">{{ data.total }}</th>
                                                    <th class="text-center" v-for="(attrLbel, index1) in attr_label" :key="index1" style="font-size: smaller;width: 5%;">{{ data[yaxis[0].qid+attrLbel.attribute_value] }}</th>
                                                </tr>
                                                <tr v-for="(data, index) in tableColPct" :key="index" class="pl-2">
                                                    <td style="background-color: white; font-size: smaller; width: 10%;">{{ data.Label }}</td>
                                                    <td style="background-color: white; font-size: smaller; width: 5%;text-align: center;">{{ data.total }}</td>
                                                    <td class="text-center" v-for="(attrLbel, index1) in attr_label" :key="index1" style="font-size: smaller;width: 5%;">{{ data[yaxis[0].qid+attrLbel.attribute_value] }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer p-1">
                            <!-- <button type="button" class="btn btn-primary btn-sm" v-on:click="saveSyntax">Save</button> -->
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" >Close</button>
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
    data() {
        return {
            dragId:'',
            dropId:'',
            itemsA:[],
            itemsB:[],
            itemsC:[],
            itemsD:[],
            tableBase:[],
            tableCount:[],
            tableColPct:[],
            attr_label:[],

            xaxis:[],
            yaxis:[],
            zaxis:[],

            //qinfos hold the qid and qtext
            all_filter_qinfos:[],
            all_filter_attributes:[],
            selected_filter_parameter:[],

        }
    },
    props:['project_id'],

    mounted() {
        this.getCrossTableInfo();
    },
    
    computed: {
        
        // listOne() {
        //   // return this.items.filter((item) => item.list === 1)
        //   return this.itemsA;
        // },
        // listTwo() {
        //   // return this.items.filter((item) => item.list === 2)
        //   return this.itemsB;
        // },
    },

    methods: {

        getCrossTableInfo(){
                axios.get('/data_analysis/'+this.project_id+'/cross_table/get_table_info')
                    .then(response => {
                        this.itemsA = response.data;
                        //console.log(response.data);
                    });
            },

            tablePct(){
                this.tableColPct=[];
                axios.post('/data_analysis/'+this.project_id+'/crossData', {
                    xaxis: this.itemsB,
                    yaxis: this.itemsC,
                    filter: this.itemsD,
                    filter_value:this.selected_filter_parameter,
                }).then(response => {
                    this.tableBase=response.data[0];
                    this.tableCount=response.data[1];
                    this.tableColPct=response.data[2];
                    this.attr_label=response.data[3];
                    this.xaxis=response.data[4];
                    this.yaxis=response.data[5];
                    this.xaxis=response.data[6];
                    // console.log(this.tableBase);
                });

               // console.log(this.itemsD)
               $('#viewModal').modal('show');
            },

            refresh(){
                this.tableColPct=[];
                this.itemsB=[];
                this.itemsC=[];
                this.itemsD=[];
                this.all_filter_attributes=[];
                this. getCrossTableInfo();
            },

            loadFilter(){
                axios.post('/data_analysis/'+this.project_id+'/cross_table/get_filter_parameter',{qinfo:this.all_filter_qinfos})
                     .then(response => {this.all_filters = response.data;
                        this.all_filter_qids=this.all_filters[0];
                        this.all_filter_attributes=this.all_filters[1];
                        // this.all_filter_qtexts=this.all_filters[2];

                        var i=0;
                        this.all_filter_attributes.forEach(element=>{
                            this.selected_filter_parameter[i]=0;
                            i++;
                        });
                        console.log(this.all_filter_attributes);

                })
                     .catch(function (error) {this.errors = error});
            },









            startDrag(evt, item) {
                evt.dataTransfer.dropEffect = 'move'
                evt.dataTransfer.effectAllowed = 'move'
                evt.dataTransfer.setData('itemID', item.id)
                this.dragId='all';
            },
            startDragX(evt, item) {
                evt.dataTransfer.dropEffect = 'move'
                evt.dataTransfer.effectAllowed = 'move'
                evt.dataTransfer.setData('itemID', item.id)
                this.dragId='x';
            },
            startDragY(evt, item) {
                evt.dataTransfer.dropEffect = 'move'
                evt.dataTransfer.effectAllowed = 'move'
                console.log('ismile',item);
                evt.dataTransfer.setData('itemID', item.id)
                this.dragId='y';
            },
            startDragZ(evt, item) {
                evt.dataTransfer.dropEffect = 'move'
                evt.dataTransfer.effectAllowed = 'move'
                evt.dataTransfer.setData('itemID', item.id)
                this.dragId='z';
            },

            onDrop(evt, list) {
            this.dropId='all';
            if(this.dragId==this.dropId){
                
                const itemID = evt.dataTransfer.getData('itemID')
                const item = this.itemsA.find((item) => item.id == itemID)

                this.itemsA.splice(this.itemsA.indexOf(item),1);
                this.itemsA.push(item);
            }else if(this.dragId=='x' && this.dropId=='all'){
                const itemID = evt.dataTransfer.getData('itemID')
                const item = this.itemsB.find((item) => item.id == itemID)

                this.itemsA.push(item);
                this.itemsB.splice(this.itemsB.indexOf(item),1);
            }else if(this.dragId=='y' && this.dropId=='all'){
                const itemID = evt.dataTransfer.getData('itemID')
                console.log('Nasim',this.itemsC,itemID);
                const item = this.itemsC.find((item) => item.id == itemID)

                this.itemsA.push(item);
                this.itemsC.splice(this.itemsC.indexOf(item),1);
            }else if(this.dragId=='z' && this.dropId=='all'){
                const itemID = evt.dataTransfer.getData('itemID')
                const item = this.itemsD.find((item) => item.id == itemID)

                this.itemsA.push(item);
                this.itemsD.splice(this.itemsD.indexOf(item),1);

                this.all_filter_qinfos=this.itemsD;
                this.loadFilter();
            }

            this.itemsA.sort( (a,b) => a.qorder - b.qorder );
            },

            onDropX(evt, list) {
            this.dropId='x';
            if(this.dragId==this.dropId){
                const itemID = evt.dataTransfer.getData('itemID')
                const item = this.itemsB.find((item) => item.id == itemID)

                this.itemsB.splice(this.itemsB.indexOf(item),1);
                this.itemsB.push(item);
                
            }else if(this.dragId=='all' && this.dropId=='x'){
                const itemID = evt.dataTransfer.getData('itemID')
                const item = this.itemsA.find((item) => item.id == itemID)

                if(this.itemsB.length<3){
                    this.itemsB.push(item);
                    this.itemsA.splice(this.itemsA.indexOf(item),1);
                }else{
                    alert("Maximum 3 nesting is allowed");
                }
            }
            },

            onDropY(evt, list) {
            this.dropId='y';
            if(this.dragId==this.dropId){
                const itemID = evt.dataTransfer.getData('itemID')
                const item = this.itemsC.find((item) => item.id == itemID)

                this.itemsC.splice(this.itemsC.indexOf(item),1);
                this.itemsC.push(item);
                
            }else if(this.dragId=='all' && this.dropId=='y'){
                const itemID = evt.dataTransfer.getData('itemID')
                const item = this.itemsA.find((item) => item.id == itemID)

                if(this.itemsB.length<3){
                    this.itemsC.push(item);
                    this.itemsA.splice(this.itemsA.indexOf(item),1);
                }else{
                    alert("Maximum 3 nesting is allowed");
                }

            }
            },

            onDropZ(evt, list) {

            this.dropId='z';

            if(this.dragId==this.dropId){
                const itemID = evt.dataTransfer.getData('itemID')
                const item = this.itemsC.find((item) => item.id == itemID)

                this.itemsD.splice(this.itemsD.indexOf(item),1);
                this.itemsD.push(item);
                
            }else if(this.dragId=='all' && this.dropId=='z'){
                const itemID = evt.dataTransfer.getData('itemID')
                const item = this.itemsA.find((item) => item.id == itemID)

                if(this.itemsB.length<3){
                    this.itemsD.push(item);
                    this.itemsA.splice(this.itemsA.indexOf(item),1);
                    
                    this.all_filter_qinfos=[];
                    this.all_filter_qinfos=this.itemsD;
                    this.loadFilter();
                }else{
                    alert("Maximum 3 nesting is allowed");
                }
            }
            },
            
        },

    }
</script>


<!-- <style>
    .drop-zone {
        height:auto!important;
    }
</style> -->
