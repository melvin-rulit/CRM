<template>
    <div>
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

        beforeRouteEnter (to, from, next) {
            axios.get('api/v2/apipermissions')
                .then(response => {
                    next(vm => (vm.permissions = response.data.data) )
                })
        }
    }

</script>
