<template>
    <div>

        <b-modal id="coming" title="Приходная операция" scrollable centered ok-only ok-title="Сохранить">
            <div class="card-body py-0">
                <form ref="formSettingsGroup" @submit.stop.prevent="handleSubmit">
                    <b-form-radio-group
                        v-model="selected"
                        :options="options"
                        class="mb-5 text-center"
                        value-field="item"
                        text-field="name"
                        disabled-field="notEnabled"
                    ></b-form-radio-group>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Сумма</label>
                        <div class="col-sm-9">
                            <input class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Операция</label>
                        <div class="col-sm-9">
                            <dynamic-select
                                :options="articles"
                                option-value="id"
                                option-text="comment"
                                placeholder="Введите для поиска операции"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Сотрудник</label>
                        <div class="col-sm-9">
                            <dynamic-select
                                :options="articles"
                                option-value="id"
                                option-text="user"
                                placeholder="Введите для поиска сотрудника"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <textarea class="form-control" rows="3" placeholder="Коментарий"></textarea>
                    </div>
                </form>
            </div>
        </b-modal>

        <b-modal id="expenditure" title="Расходная операция" scrollable centered ok-only ok-title="Сохранить">
            <div class="card-body py-0">
                <form ref="formSettingsGroup" @submit.stop.prevent="handleSubmit">
                    <b-form-radio-group
                        v-model="selected"
                        :options="options"
                        class="mb-5 text-center"
                        value-field="item"
                        text-field="name"
                        disabled-field="notEnabled"
                    ></b-form-radio-group>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Сумма</label>
                        <div class="col-sm-9">
                            <input class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Операция</label>
                        <div class="col-sm-9">
                            <dynamic-select
                                :options="articles"
                                option-value="id"
                                option-text="comment"
                                placeholder="Введите для поиска операции"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Сотрудник</label>
                        <div class="col-sm-9">
                            <dynamic-select
                                :options="articles"
                                option-value="id"
                                option-text="user"
                                placeholder="Введите для поиска сотрудника"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <textarea class="form-control" rows="3" placeholder="Коментарий"></textarea>
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
                                <button v-b-modal="'coming'" class="btn btn-sm btn-success">Приход</button>
                                <button v-b-modal="'expenditure'" class="btn btn-sm btn-danger">Рассход</button>
                                <button class="ml-4 btn btn-sm btn-info">День</button>
                                <button class="btn btn-sm btn-info">Неделя</button>
                                <button class="btn btn-sm btn-info">Месяц</button>
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
        </div>


        <!-- Панель под данными -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span>Баланс на конец периода: <span class="font-weight-bold">321 519</span></span>
                            </div>
                        </div>
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
                        key: 'date',
                        label: 'Дата/Время',
                    },
                    {
                        key: 'user',
                        label: 'Сотрудник',
                    },
                    {
                        key: 'article',
                        label: 'Статья расходов',
                    },
                    {
                        key: 'comment',
                        label: 'Комментарий',
                    },
                    {
                        key: 'source',
                        label: 'Источник',
                    },
                    {
                        key: 'summ',
                        label: 'Сумма',
                    },
                    {
                        key: 'balance',
                        label: 'Баланс',
                    },
                    {
                        key: 'operation',
                        label: 'Операция',
                    },
                    {
                        key: 'kassa',
                        label: 'Касса',
                    }

                ],
                articles: [
                    {
                        id: 1,
                        date: '21.02.2020/18:36',
                        user: 'Марченко А.В',
                        article: 'Зарплата Маврин А.А',
                        comment: 'Зарплата',
                        source: 'Аванс',
                        summ: '15 000',
                        balance: '156 000',
                        operation: 'Безнал',
                        kassa: 'Школа',
                    },
                    {
                        id: 2,
                        date: '21.02.2020/18:36',
                        user: 'Марченко А.В',
                        article: 'Зарплата Маврин А.А',
                        comment: 'Зарплата',
                        source: 'Аванс',
                        summ: '15 000',
                        balance: '156 000',
                        operation: 'Безнал',
                        kassa: 'Школа',
                    }
                ],
                options: [
                    { item: 'A', name: 'Наличные' },
                    { item: 'B', name: 'Карта' },
                    { item: 'C', name: 'Счет' },
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
