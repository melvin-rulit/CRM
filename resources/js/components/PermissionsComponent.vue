<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col"></div>
                            <div class="col-auto">
                                <!-- <button class="btn btn-sm btn-success" @click="buttonAddNewPermissions">Добавить разрешение</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<!-- Модальное окно с добавлением нового доступа -->
<div class="modal fade" id="modalPermission" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle">Добавление нового доступа</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-0">
                <form @submit.prevent="addNewPermissions">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label required">Название</label>
                        <div class="col-sm-9">
                            <input v-model.trim="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label required">Код</label>
                        <div class="col-sm-9">
                            <input v-model.trim="title" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label required">Описание</label>
                        <div class="col-sm-9">
                            <textarea v-model.trim="description" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Отменить</button>
                        <button type="submit" class="btn btn-success">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        <div class="card">
            <div class="card-body pb-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Название</th>
<!--                                <th>Код</th>-->
                                <th>Описание</th>
                            </tr>
                        </thead>
                        <tbody v-for="(permission, index) in permissions">
                            <tr>
                                <td>{{ permission.id }}</td>
                                <td>{{ permission.name }}</td>
<!--                                <td>{{ permission.title }}</td>-->
                                <td>{{ permission.description }}</td>
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
                permissions: {},
                name: '',
                title: '',
                description: '',
            }
        },

        mounted() {
            this.getAllPermissions();
        },

        methods: {
            getAllPermissions() {
                axios.get(`api/v2/apipermissions`)
                    .then(response => {
                        this.permissions = response.data.data;
                    })
            },

            buttonAddNewPermissions() {
                $('#modalPermission').modal('show');
            },

            addNewPermissions() {
                $('#modalPermission').modal('hide');
                this.getAllPermissions();
            }
        },
    }

</script>
