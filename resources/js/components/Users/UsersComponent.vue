<template>
    <div>
        <addnewuser-component @get-method="fetch" v-if="can.user_create" ref="add_user_component"></addnewuser-component>
        <showuser-component :can="can" @get-method="fetch" ref="getmodal"></showuser-component>
        <userfilter-component  @get-method="returnFilterArray" ref="show_filter"></userfilter-component>


      <!-- Панель над фильтром -->
      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-2">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col">
                </div>
                <div class="col-auto">
                  <button class="btn btn-sm btn-info" @click="showFilterModal">Фильтр</button>
                  <button v-if="can.user_create" class="btn btn-sm btn-success" @click="addNewUser">Добавить сотрудника</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

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
                    <template v-slot:cell(role)="row">
                        <span v-for="item in row.item.roles" class="badge badge-info mr-2">
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
                        key: 'role',
                        label: 'Должность',
                    },
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

          addNewUser(){
            this.$refs.add_user_component.addNewUserModal()
          },

          showFilterModal(){
            this.$refs.show_filter.showUserFilter()
          },

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

          returnFilterArray(data){
            this.users = data.users
          }
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

