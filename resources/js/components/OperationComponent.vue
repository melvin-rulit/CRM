<template>
    <div>

        <b-modal id="coming" title="Новая операция" centered ok-only ok-title="Добавить">
            <div class="card-body py-0">
                <form ref="formSettingsGroup" @submit.stop.prevent="handleSubmit">
                    <b-form-checkbox-group
                        v-model="selected"
                        :options="options"
                        class="mb-5 text-center"
                        value-field="item"
                        text-field="name"
                        disabled-field="notEnabled"
                    ></b-form-checkbox-group>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Наименование</label>
                        <div class="col-sm-9">
                            <input class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Группа</label>
                        <div class="col-sm-9">
                            <dynamic-select
                                :options="articles"
                                option-value="id"
                                option-text="name"
                                placeholder="Введите для поиска группы"/>
                        </div>
                    </div>
                </form>
            </div>
        </b-modal>

        <!-- Панель над фильтром -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <button v-b-modal="'coming'" class="btn btn-sm btn-success">Добавить операцию</button>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-sm btn-info">Фильтр</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Список клиентов -->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab"></div>
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="card">
                    <div class="card-body pb-0">
                        <b-table
                            hover
                            sticky-header="700px"
                            :items="articles"
                            :fields="fields"
                            @row-clicked="BaseModal"
                            head-variant="light">
                            <template v-slot:cell(coming)="row">
                                <span v-if="row.item.coming" class="text-success">●</span>
                            </template>
                            <template v-slot:cell(expenditure)="row">
                                <span v-if="row.item.expenditure" class="text-success">●</span>
                            </template>
                            <template v-slot:cell(nal)="row">
                                <span v-if="row.item.nal" class="text-success">●</span>
                            </template>
                            <template v-slot:cell(beznal)="row">
                                <span v-if="row.item.beznal" class="text-success">●</span>
                            </template>
                        </b-table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return{
                selected: '',
                fields: [
                    {
                        key: 'name',
                        label: 'Название',
                    },
                    {
                        key: 'coming',
                        label: 'Приход',
                    },
                    {
                        key: 'expenditure',
                        label: 'Расход',
                    },
                    {
                        key: 'nal',
                        label: 'Наличные',
                    },
                    {
                        key: 'beznal',
                        label: 'Экваринг',
                    },
                    {
                        key: 'coment',
                        label: 'Коментарий',
                    },
                ],
                articles: [
                    {
                        id: 1,
                        name: 'Зарплата тренера Маслов А.А',
                        coming: false,
                        expenditure: true,
                        nal: true,
                        beznal: false,
                    },
                    {
                        id: 2,
                        name: 'Зарплата Маврин А.А',
                        coming: true,
                        expenditure: true,
                        nal: false,
                        beznal: true,
                    },
                ],
                options: [
                    { item: 'A', name: 'Приход' },
                    { item: 'B', name: 'Расход' },
                    { item: 'C', name: 'Наличные' },
                    { item: 'D', name: 'Экваринг' },
                ]
            }
        },

        created(){
            // this.fetchArticles();
        },

        methods: {

            fetchArticles(){
                axios.get('api/v2/getAgregatorLids')
                    .then(response => this.articles = response.data.data)
            },

        }
    }
</script>
