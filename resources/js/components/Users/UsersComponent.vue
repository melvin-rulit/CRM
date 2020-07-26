<template>
    <div>
        <addnewuser-component v-if="add"></addnewuser-component>
        <showuser-component ref="getmodal"></showuser-component>


        <div class="card">
            <div class="card-body pb-0">
                <b-table
                    sticky-header="650px"
                    :items="users"
                    :fields="fields"
                    :sort-by.sync="sortBy"
                    :sort-desc.sync="sortDesc"
                    head-variant="light">

                    <template v-slot:cell(show_details)="row">
                        <span class="fe fe-eye h3 text-warning" @click="getShowModal(row.item.id)"></span>
                        <span class="fe fe-trash-2 h3 text-danger" @click="deleteUser(row.index, row.item.id, row.item.surname)"></span>
                    </template>

                    <template v-slot:cell(network)="row">
                        <td>
                            <span class="text-success">●</span>
                        </td>
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
                users: {},
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
                    },
                    {
                        key: 'show_details',
                        label: 'Действия',
                    },
                ],
            }
        },

        mounted() {
            this.fetch();
        },

        methods: {
            getShowModal(id){
                this.$refs.getmodal.addNewUserModal(id)
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

