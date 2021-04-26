
<template>
    <div>

        <base-modal-component @get-method="fetchArticles" ref="showmoda" :can="can"></base-modal-component>
        <add-new-base-component @get-method="newMethod" ref="showmodal"></add-new-base-component>
        <base-filter-component  @get-method="returnFilterArray" ref="show_filter"></base-filter-component>

        <!-- Панель над фильтром -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-sm btn-info" @click="showCollapse(), filter = !filter">Поиск</button>
                                <button class="btn btn-sm btn-danger" @click="showFilterModal()">Фильтр</button>
                                <button v-if="can.base_create" class="btn btn-sm btn-success" @click="ShowNewUser">Добавить клиента</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Фильтр -->
        <div class="collapse" id="filter">
            <div class="card card-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <form class="d-flex justify-content-around">
                            <div class="filter">
                                <input v-model="surname" class="form-control" placeholder="Фамилия">
                            </div>
                            <div class="filter">
                                <input v-model="name" class="form-control" placeholder="Имя">
                            </div>
                            <div class="filter">
                                <input
                                    v-model="phone"
                                    class="form-control"
                                    placeholder="Телефон"
                                    v-mask="'+## (###) ###-##-##'"
                                >
                            </div>
                            <div class="filter">
<!--                                <select class="form-control" v-model="birthday" >-->
<!--                                    <option v-for="(curr, index) in new Date().getFullYear()" v-if="index + 1 >= 1980">{{ curr }}</option>-->
<!--                                </select>-->
                              <input v-model="birthday" class="form-control" placeholder="Год">
                            </div>
                            <div class="submit">
                                <button type="submit" @click.prevent="fetch" class="btn btn-success" :disabled="busy">
                                    <i v-if="busy" class="fa fa-spin fa-spinner"></i>
                                    Фильтр
                                </button>
                            </div>
                            <div class="submit">
                                <button type="submit" @click.prevent="resetFilter()" class="btn btn-primary" :disabled="busy">
                                    Сброс
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Табы основного интерфейса -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true">Все</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Текущие</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">В работе</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Продления</a>
            </li>
        </ul>

        <!-- Список клиентов -->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab"></div>
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="card">
                    <div class="card-body pb-0">
                        <b-table
                            hover
                            sticky-header="650px"
                            :items="articles"
                            :fields="fields"
                            :sort-by.sync="sortBy"
                            :sort-desc.sync="sortDesc"
                            @row-clicked="BaseModal"
                            head-variant="light">
                        </b-table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"></div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab"></div>
        </div>

    </div>
</template>

<script>

    // import vueHeadful from 'vue-headful';
    // Vue.component('vue-headful', vueHeadful);


    // import Vuelidate from 'vuelidate'
    // Vue.use(Vuelidate)
    // import { required, minLength } from 'vuelidate/lib/validators'
    //
    //
    // import DynamicSelect from 'vue-dynamic-select'
    // Vue.use(DynamicSelect)
    //
    //
    // import Loading from 'vue-loading-overlay';
    // import 'vue-loading-overlay/dist/vue-loading.css';
    // Vue.use(Loading);


    export default {
        data() {
            return{
                can: [],
                sortBy: 'child_surname',
                sortDesc: false,
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
                ],
                surname: null,
                branch: null,
                manager: null,
                instructor: null,
                new_child_middle_name: '',
                name:'',
                phone:'',
                birthday: null,
                busy: false,
                filter: false,
                managers: [],
                instructor: '',
                branches: {
                    branches: [],
                },
                articles: [],
                users: [],
                newuser: [],
            }
        },

        beforeRouteEnter (to, from, next) {
            axios.get('api/v2/collection')
                .then(response => {
                    next(vm => (vm.articles = response.data.data, vm.can = response.data.can) )
                })
        },

        methods: {

          returnFilterArray(data){
            this.articles = data.users
          },

          showFilterModal(){
            this.$refs.show_filter.showUserFilter()
          },

          showCollapse(){
                this.filter  ? $('#filter').collapse('hide') : $('#filter').collapse('show');
            },

            fetch() {
                this.busy = true;
                axios.post('api/v2/baseFilter', {
                        surname: this.surname,
                        name: this.name,
                        yearBirthday: this.birthday,
                        phone: this.phone,
                })
                    .then(response => {
                        this.articles = response.data.data;
                        this.busy = false;
                    })
            },
            resetFilter() {
                this.surname = null
                this.name = null
                this.birthday = null
                this.phone = null
                this.fetchArticles()
            },

            fetchArticles(){
                axios.get('api/v2/collection')
                    .then(response => this.articles = response.data.data)
            },

            newMethod(users){
                this.newuser = users
                this.$refs.showmoda.showModa(this.newuser)
            },

            BaseModal(index){
                this.$refs.showmoda.showModa(index.id)
            },

            ShowNewUser(){
                this.$refs.showmodal.addNewUserModal()
            },

        }
    }
</script>

<style scoped>
    .table td, .table th {
        padding: 10px;
        font-size: 14px;
    }

    .center{
        display: block;
        margin: 0 auto;
    }

    .slide-fade-enter-active {
        transition: all .3s ease;
    }

    .slide-fade-leave-active {
        transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active до версии 2.1.8 */ {
        transform: translateX(10px);
        opacity: 0;
    }

    .toast{
        max-width: 1200px;
    }

    .table-collection tr {
        cursor: pointer;
    }

    .hoverim:hover{
        opacity: 0.5;
        cursor: pointer;
    }

    .not-photo{
        display: flex;
        width: 250px;
        height: 250px;
        border-radius: 0px;
        font: 100px / 250px Helvetica, Arial, sans-serif;
        align-items: center;
        justify-content: center;
        text-align: center;
        user-select: none;
        background-color: rgb(255, 193, 7);
        color: rgb(255, 255, 255);
    }

    .photo{
        display: flex;
        width: 250px;
        height: 250px;
        border-radius: 0px;
    }

    .form-group--error input, .form-group--error textarea, .form-group--error input:focus, .form-group--error input:hover {
        border-color: #f79483;
    }

    .form-group--error + .form-group__message, .form-group--error + .error {
        display: block;
        color: #f57f6c;
    }
    .form-group__message, .error {
        font-size: 0.75rem;
        line-height: 1;
        display: none;
        margin-left: 14px;
        margin-top: -0.687rem;
        margin-bottom: 0.9375rem;
    }
    .result-list {
        max-height: 200px;
        overflow-y: auto;
    }

    .fix-height{
        min-height: 300px;
    }
    .center{
        display: block;
        margin: 0 auto;
    }

    .input__file {
        opacity: 0;
        visibility: hidden;
        position: absolute;
    }

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
