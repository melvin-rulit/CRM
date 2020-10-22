<template>
    <div>
        <show-user-access-component @get-method="getAllUserAccess" ref="showUserAccess"></show-user-access-component>

        <div class="card">
            <div class="card-body pb-0">
                <b-table
                    hover
                    sticky-header="800px"
                    :items="userAccess"
                    :fields="fields"
                    :sort-by.sync="sortBy"
                    :sort-desc.sync="sortDesc"
                    @row-clicked="getShowModal"
                    head-variant="light">
                    <template v-slot:cell(useraccess)="row">
                        <span v-for="item in row.item.useraccess" class="badge badge-info mr-2">
                            {{item.title}}
                        </span>
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
                userAccess: [],
                sortBy: 'id',
                sortDesc: false,
                fields: [
                    {
                        key: 'id',
                        label: 'ID',
                    },
                    {
                        key: 'surname',
                        label: 'Фамилия',
                    },
                    {
                        key: 'name',
                        label: 'Имя',
                    },
                    {
                        key: 'useraccess',
                        label: 'Доступы на добавлении должностей',
                    }
                ],
            }
        },

        mounted() {
            this.getAllUserAccess();
        },

        methods: {
            getShowModal(index){
                this.$refs.showUserAccess.showModal(index.id)
            },
            getAllUserAccess() {
                axios.get(`api/v2/userAccess`)
                    .then(response => {this.userAccess = response.data.data;})
            },
        },
    }
</script>

