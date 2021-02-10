<template>
    <div>

        <add-warehouse-component @get-method="fetch" ref="addWarehouse"></add-warehouse-component>
        <edit-warehouse-component @get-method="fetch" ref="editWarehouse"></edit-warehouse-component>
        <add-article-component @get-method="showWarehouseEmit" ref="addPosition"></add-article-component>
        <show-article-component @get-method="showWarehouseEmit" ref="showPosition"></show-article-component>
        <show-log-component ref="showLog"></show-log-component>

        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <button @click="addPosition" class="btn btn-sm btn-info">Добавить позицию</button>
                                <button @click="addWarehouse" class="btn btn-sm btn-success">Добавить склад</button>
                                    <button
                                        v-for="item in warehouses"
                                        @click="showWarehouseArticle(item.id)"
                                        class="btn btn-sm ml-3" :class="warehouse_id == item.id ? 'btn-outline-success' : 'btn-outline-primary'">{{ item.name }}
                                        <i v-if="warehouse_id == item.id" @click="showLog(item.id)" class="fe fe-align-right ml-4"></i>
                                        <i v-if="warehouse_id == item.id" @click="editWarehouse(item.id)" class="fe fe-edit ml-2"></i>
                                        <i v-if="warehouse_id == item.id" @click="deleteWarehouse(item.id, item.name)" class="fe fe-trash-2 text-danger ml-2"></i></button>
                            </div>
                            <div class="col-auto"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-body pb-0">
                <b-table
                    ref="table"
                    hover
                    sticky-header="750px"
                    :items="positions"
                    :fields="fields"
                    :sort-by.sync="sortBy"
                    :sort-desc.sync="sortDesc"
                    @row-clicked="ShowModalPosition"
                    head-variant="light">
                    <template v-slot:cell(name)="row">
                        {{row.item.article.name}}
                    </template>
                    <template v-slot:cell(group)="row">
                        <span v-if="row.item.group">{{row.item.group.name}}</span>
                    </template>
                    <template v-slot:cell(warehouse)="row">
                        {{row.item.warehouse.name}}
                    </template>
                </b-table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                fullPage: false,
                warehouses: [],
                warehouse_id: '',
                positions: [],
                can: [],
                add: true,
                sortBy: 'id',
                sortDesc: false,
                fields: [
                    {
                        key: 'name',
                        label: 'Наименование',
                    },
                    {
                        key: 'group',
                        label: 'Группа',
                    },
                    {
                        key: 'quantity',
                        label: 'Количество',
                    },
                    {
                        key: 'warehouse',
                        label: 'Склад',
                    }
                ],
            }
        },


        beforeRouteEnter (to, from, next) {
            axios.get('api/v2/warehouses')
                .then(response => {
                    next(vm => (vm.warehouses = response.data) )
                })

            // axios.get('api/v2/article')
            //     .then(response => {
            //         next(vm => (vm.positions = response.data.data) )
            //     })
        },

        methods: {

            fetch(){
                this.getWarehouses()
                this.getPositions()
            },

            showWarehouseArticle(id){
                axios.post('api/v2/showWarehouseArticle', {warehouse_id: id})
                    .then(response => {this.positions = response.data.data})

                this.warehouse_id = id
            },

            showWarehouseEmit(data){
                this.showWarehouseArticle(data.id)

            },

            getWarehouses(){
                axios.get('api/v2/warehouses')
                    .then(response => {this.warehouses = response.data})
            },

            getPositions(id){
                axios.get('api/v2/article')
                    .then(response => {this.positions = response.data})
            },

            addWarehouse(){
                this.$refs.addWarehouse.showModal()
            },

            editWarehouse(id){
                this.$refs.editWarehouse.showModal(id)
            },

            addPosition(){
                this.$refs.addPosition.showModal()
            },

            ShowModalPosition(items){
                this.$refs.showPosition.showModal(items)
            },

            showLog(id){
                this.$refs.showLog.showLog(id)
            },

            deleteWarehouse(id, name){

                this.$confirm("Удалить склад " + name + " ?").then(() => {

                    axios.delete('api/v2/warehouses/'+ id)
                        .then((response) => {

                        if (response.data.response == "error"){
                            Vue.$toast.open({message: 'На складе есть остатки товаров переместите или спишите их' ,type: 'error',duration: 3000,position: 'top-right'})
                        }else{
                            Vue.$toast.open({message: 'Склад успешно удален' ,type: 'success',duration: 3000,position: 'top-right'});
                            this.getWarehouses()
                        }

                    });
                });
            },

            getShowModal(index){
                if (this.can.user_show){
                    this.$refs.getmodal.addNewUserModal(index.id)
                }
            },

        },
    }
</script>
