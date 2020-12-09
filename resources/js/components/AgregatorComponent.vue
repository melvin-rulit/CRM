<template>
    <div>

        <base-modal-component @get-method="fetchArticles" ref="showmoda"></base-modal-component>

        <!-- Панель над фильтром -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <button class="btn btn-sm btn-success" @click="">Сегодня</button>
                                <button class="btn btn-sm btn-success" @click="">Завтра</button>
                                <button class="btn btn-sm btn-success" @click="">Послезавтра</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Список клиентов -->

                <div class="card">
                    <div class="card-body pb-0">
                        <b-table
                            hover
                            sticky-header="800px"
                            :items="articles"
                            :fields="fields"
                            @row-clicked="BaseModal"
                            head-variant="light">
                            <template v-slot:cell(status)="row">
                                    <span :style="{ color: row.item.color }">{{ row.item.status }}</span>
                            </template>
                            <template v-slot:cell(step)="row">
                                    <span :style="{ color: row.item.steps_color }">{{ row.item.steps }}</span>
                            </template>
                            <template v-slot:cell(next_call_date)="row">
                                    <span>{{ row.item.call_date }}</span>
                            </template>
                        </b-table>
                    </div>
                </div>

    </div>
</template>

<script>
    export default {
        data() {
            return{
                fields: [
                    {
                        key: 'child_surname',
                        label: 'Фамилия',
                    },
                    {
                        key: 'child_name',
                        label: 'Имя',
                    },
                    {
                        key: 'child_middle_name',
                        label: 'Отчество',
                    },
                    {
                        key: 'age',
                        label: 'Возраст',
                    },
                    {
                        key: 'status',
                        label: 'Статус',
                    },
                    {
                        key: 'step',
                        label: 'Этап',
                    },
                    {
                        key: 'call_date',
                        label: 'Дата звонка',
                    },

                ],
                articles: [],
            }
        },

        beforeRouteEnter (to, from, next) {
            axios.get('api/v2/getAgregatorLids')
                .then(response => {
                    next(vm => (vm.articles = response.data.data) )
                })
        },

        methods: {

            fetchArticles(){
                axios.get('api/v2/getAgregatorLids')
                    .then(response => this.articles = response.data.data)
            },

            BaseModal(index){
                this.$refs.showmoda.showModa(index.id)
            },
        }
    }
</script>
