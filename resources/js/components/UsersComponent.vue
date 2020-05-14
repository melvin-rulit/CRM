<template>
    <div>
        <addnewuser-component v-if="add"></addnewuser-component>

        <div class="card">
            <div class="card-body pb-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Имя</th>
                                <th>Фамилия</th>
                                <th>Логин (почта)</th>
                                <th>Должность</th>
                                <th>Филиалы</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody v-for="(user, index) in users">
                            <tr>
                                <td>{{ user.name }}</td>
                                <td>{{ user.surname }}</td>
                                <td>{{ user.email }}</td>
                                <td><span v-for="role in user.roles" class="badge badge-info mr-2">{{ role.title }}</span></td>
                                <td><span v-for="branch in user.branches" class="badge badge-info mr-2">{{ branch.name }}</span></td>
                                <td class="text-center">
                                    <span class="fe fe-trash-2 h3 text-danger" @click="deleteUser(index, user.id, user.surname)"></span>
                                    <span class="fe fe-edit h3 text-info ml-3"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
            }
        },

        mounted() {
            this.fetch();
        },

        methods: {
            fetch() {
                this.busy = true;
                axios.get(`api/v2/users`)
                    .then(response => {
                        this.users = response.data.data;
                    })
            },
            deleteUser(index, id, surname){
                this.$confirm("Удалить сотрудника " + surname + " ?").then(() => {
                    this.users.splice(index,1);
                    // axios.delete('api/v2/users/'+ id);
                });
            },
        },
    }
</script>
