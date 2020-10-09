
<template>
    <div>

<!--        <button class="btn btn-danger m-5" @click="getTest">Получить</button>-->

        <base-modal-component ref="showmoda"></base-modal-component>

        <!-- Панель над фильтром -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                            </div>
                            <div class="col-auto">
                                <a class="btn btn-sm btn-success" href="#" data-toggle="modal" @click.prevent="getBranches() , getUsers()" data-target="#addNewUser">Добавить клиента</a>
                                <button class="btn btn-sm btn-info" @click="showCollapse(), filter = !filter">Фильтр</button>
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
                                <select class="form-control" v-model="birthday" >
                                    <option v-for="(curr, index) in new Date().getFullYear()" v-if="index + 1 >= 1980">{{ curr }}</option>
                                </select>
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

        <!-- Модальное окно с добавление нового клиента -->
        <div class="modal fade" id="addNewUser" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Добавление нового клиента</h4>
                        <button type="button" @click="cancelAddNewUser" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fe fe-x h2"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="addNewUser">
                            <div class="form-group row" :class="{ 'form-group--error': $v.new_child_surname.$error }">
                                <label class="col-sm-3 col-form-label required">Фамилия</label>
                                <div class="col-sm-9">
                                    <input v-model.trim="$v.new_child_surname.$model" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row" :class="{ 'form-group--error': $v.new_child_name.$error }">
                                <label class="col-sm-3 col-form-label required">Имя</label>
                                <div class="col-sm-9">
                                    <input v-model.trim="$v.new_child_name.$model" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Отчество</label>
                                <div class="col-sm-9">
                                    <input v-model.trim="new_child_middle_name" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label required">Филиал</label>
                                <div class="col-sm-9">
                                    <dynamic-select :options="branches.branches" option-value="id" option-text="name" placeholder="Введите для поиска" v-model="branch" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Менеджер</label>
                                <div class="col-sm-9">
                                    <dynamic-select :options="users" option-value="id" option-text="surname" placeholder="Введите для поиска" v-model="manager" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Тренер</label>
                                <div class="col-sm-9">
                                    <dynamic-select :options="users" option-value="id" option-text="surname" placeholder="Введите для поиска" v-model="instructor" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button @click="cancelAddNewUser" type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                <button type="submit" class="btn btn-success">Добавить</button>
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


    import Vuelidate from 'vuelidate'
    Vue.use(Vuelidate)
    import { required, minLength } from 'vuelidate/lib/validators'


    import DynamicSelect from 'vue-dynamic-select'
    Vue.use(DynamicSelect)


    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    Vue.use(Loading);


    export default {
        data() {
            return{
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
                URLaddNewUser: "api/v2/addnewuser",
            }
        },

        validations: {
            new_child_surname: {
                required,
            },
            new_child_name: {
                required,
            }
        },
        created(){
            this.fetchArticles();
        },

        methods: {

            showCollapse(){
                this.filter  ? $('#filter').collapse('hide') : $('#filter').collapse('show');
            },
            fetch() {
                this.busy = true;
                axios.get(`api/v2/filter`, {
                    params: {
                        surname: this.surname,
                        name: this.name,
                        birthday: this.birthday,
                        phone: this.phone,
                    }
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

            BaseModal(index){
                this.$refs.showmoda.showModa(index.id)
            },
            addNewUser(){
                this.$v.$touch()
                if (!this.$v.$invalid) {
                    if (!this.branch.id) {
                        this.$alert("Выберите филиал");
                        return false
                    }
                    let loader = this.$loading.show({
                        container: this.fullPage ? null : this.$refs.formContainer,
                        color: '#0080ff',
                    });
                    $('#addNewUser').modal('hide');
                    $(document.body).removeClass("modal-open");
                    $(".modal-backdrop.show").hide();
                    axios.post(this.URLaddNewUser, {
                        child_surname: this.new_child_surname,
                        child_name: this.new_child_name,
                        child_middle_name: this.new_child_middle_name,
                        manager: this.manager ? this.manager.id : null,
                        instructor: this.instructor ? this.instructor.id : null,
                        branch: this.branch.id
                    })
                        .then(response =>
                            setTimeout(() => {
                                loader.hide()
                                Vue.$toast.open({message: 'Клиент успешно добавлен',type: 'success',duration: 5000,position: 'top-right'}),
                                this.fetchArticles()
                            },500)
                        );
                    this.submitStatus = 'OK'
                    this.new_child_surname = null
                    this.new_child_middle_name = ''
                    this.$v.new_child_surname.$reset()
                    this.new_child_name = null
                    this.$v.new_child_name.$reset()
                    this.branch = []
                    this.manager = []
                    this.instructor = []
                }
            },
            cancelAddNewUser(){
                this.new_child_surname = null
                this.new_child_middle_name = ''
                this.$v.new_child_surname.$reset()
                this.new_child_name = null
                this.$v.new_child_name.$reset()
                this.branch = []
                this.manager = []
                this.instructor = []
            },
            getBranches(){
                axios.get('api/v2/getbranches')
                    .then(response => this.branches = response.data.data)
            },
            getUsers(){
                axios.get('api/v2/getusers')
                    .then(response => this.users = response.data.data)
            },
            closeUserModal(){
                this.showBranch = false
                this.showManager = false
                this.showInstructor = false
                this.showProgramm = false

                $('#info li:first-child a').tab('show')

                this.dataObject.contracts_active = [];
                this.indexactiveContract = 0
                this.fetchArticles()
                this.showForm = false
            },

            getTest(){
                axios.get('api/v2/getAgregatorLids')
            }
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
