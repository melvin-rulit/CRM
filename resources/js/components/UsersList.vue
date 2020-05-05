<template>
    <div>
        <div class="row mb-3">
            <div class="col-12">
                <form class="d-flex justify-content-around">
                    <div class="filter">
                        <input v-model="name" type="text" class="form-control" placeholder="Name">
                    </div>
                    <div class="filter">
                        <select v-model="manager" class="form-control">
                            <option value="1">Male</option>
                            <option value="7">Female</option>
                        </select>
                    </div>
                    <div class="filter">
                        <div class="form-check">
                            <input value="1" v-model="is_active" class="form-check-input" type="checkbox" id="is-active">
                            <label class="form-check-label" for="is-active">
                                Is Active
                            </label>
                        </div>
                    </div>
                    <div class="filter">
                        <input v-model="birthday" type="text" class="form-control" placeholder="Birthday">
                    </div>

                    <div class="submit">
                        <button type="submit" @click.prevent="fetch" class="btn btn-primary" :disabled="busy">
                            <i v-if="busy" class="fa fa-spin fa-spinner"></i>
                            Фильтр
                        </button>
                    </div>

                    <div class="submit">
                        <button type="submit" @click.prevent="reset" class="btn btn-default"  :disabled="busy">
                            Сброс
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Is Active</th>
                            <th>Birthday</th>
                        </tr>

                        <tr v-for="user in users">
                            <td>{{ user.child_surname }}</td>
                        </tr>
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
                name: null,
                is_active: null,
                birthday: null,
                manager: null,
                users: [],
                busy: false,
            }
        },

        methods: {
            reset() {
                this.name = null;
                this.is_active = null;
                this.birthday = null;
                this.manager = null;
                this.fetch();
            },

            fetch() {
                this.busy = true;
                axios.get(`/products`, {
                    params: {
                        name: this.name,
                        is_active: this.is_active,
                        manager: this.manager,
                        birthday: this.birthday,
                    }
                })
                    .then(response => {
                        this.users = response.data;
                        this.busy = false;
                    })
            }
        },

        mounted() {
            // this.fetch();
        }
    }
</script>
