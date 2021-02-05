<template>
    <div>
        <showrole-component @get-method="getAllRoles" ref="showRole" :can="can"></showrole-component>
        <addnewrole-component  @get-method="getAllRoles" v-if="can.role_create"></addnewrole-component>

        <div class="card">
            <div class="card-body pb-0">
                <b-table
                    hover
                    sticky-header="750px"
                    :items="roles"
                    :fields="fields"
                    :sort-by.sync="sortBy"
                    :sort-desc.sync="sortDesc"
                    @row-clicked="getShowModal"
                    head-variant="light">
                    <template v-slot:cell(permissions)="row">
                        <span v-for="item in row.item.permissions" class="badge badge-info mr-2">
                            {{item.name}}
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
                roles: {},
                can: '',
                add: true,
                sortBy: 'id',
                sortDesc: false,
                fields: [
                    {
                        key: 'id',
                        label: 'ID',
                    },
                    {
                        key: 'title',
                        label: 'Должность',
                    },
                    {
                        key: 'permissions',
                        label: 'Доступы',
                    }
                ],
            }
        },

        beforeRouteEnter (to, from, next) {
            axios.get('api/v2/roles')
                .then(response => {
                    next(vm => (vm.roles = response.data.data, vm.can = response.data.can) )
                })
        },

        mounted() {
            this.getAllRoles();
        },

        methods: {
            getShowModal(index){
                this.$refs.showRole.showRoleModal(index.id)
            },
            getAllRoles() {
                axios.get(`api/v2/roles`)
                    .then(response => {this.roles = response.data.data;})
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

