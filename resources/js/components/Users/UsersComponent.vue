<template>
    <div>
        <addnewuser-component @get-method="fetch" v-if="can.user_create"></addnewuser-component>
        <showuser-component :can="can" @get-method="fetch" ref="getmodal"></showuser-component>

        <div class="card">
            <div class="card-body pb-0">
                <b-table
                    hover
                    sticky-header="750px"
                    :items="users"
                    :fields="fields"
                    :sort-by.sync="sortBy"
                    :sort-desc.sync="sortDesc"
                    @row-clicked="getShowModal"
                    head-variant="light">
                    <template v-slot:cell(network)="row">
                            <span v-if="row.item.online" class="text-success">●</span>
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
                users: [],
                can: [],
                add: true,
                sortBy: 'id',
                sortDesc: false,
                fields: [
                    {
                        key: 'id',
                        label: 'ID',
                    },
                    {
                        key: 'network',
                        label: 'В сети',
                    },
                    {
                        key: 'name',
                        label: 'Имя',
                    },
                    {
                        key: 'surname',
                        label: 'Фамилия',
                    },
                    {
                        key: 'email',
                        label: 'Логин (почта)',
                    }
                ],
            }
        },

        beforeRouteEnter (to, from, next) {
            axios.get('api/v2/users')
                .then(response => {
                    next(vm => (vm.users = response.data.data, vm.can = response.data.can) )
                })
        },

        methods: {
            getShowModal(index){
                if (this.can.user_show){
                    this.$refs.getmodal.addNewUserModal(index.id)
                }
            },
            fetch() {
                axios.get(`api/v2/users`)
                    .then(response => {
                        this.users = response.data.data;
                    })
            },
            deleteUser(index, id, surname){
                this.$confirm("Удалить сотрудника " + surname + " ?").then(() => {
                    this.users.splice(index,1);
                    axios.delete('api/v2/users/'+ id);
                });
            },
        },
    }
</script>

<style scoped>
    table {
        width:100%;
        table-layout: fixed;
    }

    .tbl-content {
        height: 800px;
        overflow-x: auto;
        margin-top: 0px;
    }
</style>

