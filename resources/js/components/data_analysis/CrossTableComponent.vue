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
                        <div class="card-header text-center text-white bg-info p-1">X-Axis</div>
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
                        <div class="card-header text-center text-white bg-info p-1">Y-Axis</div>
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

                <div class="col-12 col-md-12 ">
                    <div class="row">
                        <div class="text-start col-4 col-md-4 m-0">
                            <button type="button" class="btn btn-outline-info btn-sm pl-2 pr-2" @click="refresh()">Refresh</button>
                        </div>
                        <div class="text-center col-4 col-md-4 m-0">
                            <button type="button" class="btn btn-outline-success btn-sm pl-2 pr-2" @click="crossdata()">Get Data</button>
                        </div>
                        <div class="text-end col-4 col-md-4 m-0">
                            <button type="button" class="btn btn-outline-primary btn-sm pl-2 pr-2" @click="crossdata()">Export to Excel</button>
                        </div>
                    </div>

                </div>


                <div class="col-12 col-md-12 mt-2" v-if="crossData !=''">
                    <div class="card m-0 p-0" >
                        <div class="table-container" style=" height:435px;">
                            <table class="table table-bordered table-sm mt-2">
                                <thead style="top: 0; position: sticky; background-color: white;">
                                    <tr>
                                        <th class="text-white"></th>
                                        <th v-for="(attrLbel, index) in attr_label" :key="index" class="text-center table-bordered">
                                            {{ attrLbel.attribute_label }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in crossData" :key="index" class="pl-2">
                                        <td style="background-color: white; font-size: smaller;">{{ data.Label }}</td>
                                        <td class="text-center" v-for="(attrLbel, index1) in attr_label" :key="index1" style="font-size: smaller;">{{ data[yaxis[0].qid+attrLbel.attribute_value] }}</td>
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
    data() {
        return {
            dragId:'',
            dropId:'',
            itemsA:[],
            itemsB:[],
            itemsC:[],
            itemsD:[],
            crossData:[],
            attr_label:[],

            xaxis:[],
            yaxis:[],
            zaxis:[],

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

            crossdata(){
                axios.post('/data_analysis/crossData', {
                    xaxis: this.itemsB,
                    yaxis: this.itemsC,
                    filter: this.itemsD,
                }).then(response => {
                    this.crossData = response.data[0];
                    this.attr_label = response.data[1];
                    this.xaxis=response.data[2];
                    this.yaxis=response.data[3];
                    this.xaxis=response.data[4];
                });

               // console.log(this.itemsD)
            },

            refresh(){
                this.crossData=[];
                this.itemsB=[];
                this.itemsC=[];
                this.itemsD=[];
                this. getCrossTableInfo();
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
