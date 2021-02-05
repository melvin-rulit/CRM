<template>
    <div>

<!--        Окно добавления товарной позиции-->
        <b-modal id="article" title="Новая товарная позиция" @ok="saveArticle" @hidden="resetModalArticle" centered ok-only ok-title="Добавить">
            <div class="card-body py-0">
                <div class="form-group row" :class="{ 'form-group--error': $v.article_name.$error &&  showErrors}">
                    <label class="col-sm-3 col-form-label">Наименование</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-model="$v.article_name.$model">
                        <span v-if="!$v.article_name.required && showErrors" class="text-danger h5 ml-3">* Поле обязательно для заполнения</span>
                        <span v-if="!$v.article_name.minLength && showErrors" class="text-danger h5 ml-3">* Имя не может меньше {{$v.article_name.$params.minLength.min}} символа</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Группа</label>
                    <div class="col-sm-9">
                        <dynamic-select
                            :options="groups"
                            v-model="article_group"
                            option-value="id"
                            option-text="name"
                            placeholder="Введите для поиска группы"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Поставщик</label>
                    <div class="col-sm-9">
                        <dynamic-select
                            :options="suppliers"
                            v-model="article_supplier"
                            option-value="id"
                            option-text="name"
                            placeholder="Введите для поиска поставщика"/>
                    </div>
                </div>
                <div class="form-group row">
                    <textarea class="form-control" v-model="article_description" rows="3" placeholder="Описание"></textarea>
                </div>
            </div>
        </b-modal>


<!--        Окно добавления группы склада-->
        <b-modal id="group" title="Новая группа" @ok="saveGroup" @hidden="resetModalGroup" centered ok-only ok-title="Добавить">
            <div class="card-body py-0">
                    <div class="form-group row" :class="{ 'form-group--error': $v.group_name.$error &&  showErrors}">
                        <label class="col-sm-3 col-form-label">Наименование</label>
                        <div class="col-sm-9">
                            <input class="form-control" v-model="$v.group_name.$model">
                            <span v-if="!$v.group_name.required && showErrors" class="text-danger h5 ml-3">* Поле обязательно для заполнения</span>
                            <span v-if="!$v.group_name.minLength && showErrors" class="text-danger h5 ml-3">* Имя не может меньше {{$v.name.$params.minLength.min}} символа</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <textarea class="form-control" v-model="group_description" rows="3" placeholder="Описание"></textarea>
                    </div>
            </div>
        </b-modal>


<!--        Окно добавления поставщика-->
        <b-modal id="supplier" title="Новый поставщик" @ok="saveSupplier" @hidden="resetModalSupplier" centered ok-only ok-title="Добавить">
            <div class="card-body py-0">
                <div class="form-group row" :class="{ 'form-group--error': $v.supplier_name.$error &&  showErrors}">
                    <label class="col-sm-3 col-form-label">Наименование</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-model="$v.supplier_name.$model">
                        <span v-if="!$v.supplier_name.required && showErrors" class="text-danger h5 ml-3">* Поле обязательно для заполнения</span>
                        <span v-if="!$v.supplier_name.minLength && showErrors" class="text-danger h5 ml-3">* Имя не может меньше {{$v.supplier_name.$params.minLength.min}} символа</span>
                    </div>
                </div>
                <div class="form-group row">
                    <textarea class="form-control" v-model="supplier_description" rows="3" placeholder="Описание"></textarea>
                </div>
                <div class="form-group row">
                    <textarea class="form-control" v-model="supplier_contacts" rows="3" placeholder="Контакты"></textarea>
                </div>
            </div>
        </b-modal>



        <div class="card">
            <b-tabs content-class="mt-3" justified>

                <b-tab title="Товарные позиции" @click="getArticles" active>
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <div class="card mb-2">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <button @click="getModalArticle" class="btn btn-sm btn-success">Добавить товарную позицию</button>
                                        </div>
                                        <div class="col-auto">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Список товарных позиций -->
                    <div class="card-body pb-0">
                        <b-table
                            hover
                            sticky-header="700px"
                            :items="articles"
                            :fields="fieldsArticles"
                            head-variant="light">
                        </b-table>
                    </div>
                </b-tab>


                <b-tab title="Группы товаров" @click="getArticleGroups">
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <div class="card mb-2">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <button v-b-modal="'group'" class="btn btn-sm btn-success">Добавить группу</button>
                                        </div>
                                        <div class="col-auto">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Список групп склада -->
                    <div class="card-body pb-0">
                        <b-table
                            hover
                            sticky-header="700px"
                            :items="groups"
                            :fields="fieldsGroups"
                            head-variant="light">
                        </b-table>
                    </div>
                </b-tab>





                <b-tab @click="getSuppliers" title="Поставщики">
                    <!-- Панель над фильтром -->
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <div class="card mb-2">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <button v-b-modal="'supplier'" class="btn btn-sm btn-success">Добавить поставщика</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <b-table
                            hover
                            sticky-header="700px"
                            :items="suppliers"
                            :fields="fieldsSuppliers"
                            head-variant="light">
                        </b-table>
                    </div>
                </b-tab>
            </b-tabs>
        </div>
    </div>
</template>

<script>

    import { required, minLength } from 'vuelidate/lib/validators';

    export default {
        data() {
            return{
                showErrors: false,
                groups: [],
                articles: [],
                group_name: '',
                group_description: '',
                fieldsArticles: [
                    {
                        key: 'name',
                        label: 'Название',
                    },
                    {
                        key: 'article_group',
                        label: 'Группа',
                    },
                    {
                        key: 'supplier',
                        label: 'Поставщик',
                    },
                    {
                        key: 'description',
                        label: 'Описание',
                    },
                ],
                fieldsGroups: [
                    {
                        key: 'name',
                        label: 'Название',
                    },
                    {
                        key: 'description',
                        label: 'Описание',
                    },
                ],
                suppliers: [],
                fieldsSuppliers: [
                    {
                        key: 'name',
                        label: 'Название',
                    },
                    {
                        key: 'description',
                        label: 'Описание',
                    },
                    {
                        key: 'contacts',
                        label: 'Контакты',
                    }
                ],
                supplier_name: '',
                supplier_description: '',
                supplier_contacts: '',
                article_name: '',
                article_description: '',
                article_group: '',
                article_supplier: '',
            }
        },

        validations: {
            article_name: {
                required,
                minLength: minLength(4)
            },
            group_name: {
                required,
                minLength: minLength(4)
            },
            supplier_name: {
                required,
                minLength: minLength(4)
            },
        },

        created(){
            this.getArticles()
        },

        methods: {

            getArticles(){
                axios.get('api/v2/article')
                    .then(response => {this.articles = response.data.data})
            },

            getArticleGroups(){
                axios.get('api/v2/article_groups')
                    .then(response => {this.groups = response.data.data})
            },

            getSuppliers(){
                axios.get('api/v2/suppliers')
                    .then(response => {this.suppliers = response.data.data})
            },

            saveGroup(bvModalEvt){
                this.$v.$touch()

                if (this.$v.group_name.$invalid){
                    this.showErrors = true
                    bvModalEvt.preventDefault()
                    Vue.$toast.open({message: 'Заполните все необходимые поля' ,type: 'error',duration: 1000,position: 'top-right'});
                }else{
                        axios.post('api/v2/article_groups', {
                            name: this.group_name,
                            description: this.group_description,
                        })
                        Vue.$toast.open({message: 'Группа создана успешно' ,type: 'success',duration: 1000,position: 'top-right'});
                        this.$v.$reset()
                        this.showErrors = false
                        this.getArticleGroups()
                }
            },

            resetModalGroup(){
                this.group_name = ''
                this.group_description = ''
                this.showErrors = false
            },

            saveSupplier(bvModalEvt){
                this.$v.$touch()

                if (this.$v.supplier_name.$invalid){
                    this.showErrors = true
                    bvModalEvt.preventDefault()
                    Vue.$toast.open({message: 'Заполните все необходимые поля' ,type: 'error',duration: 1000,position: 'top-right'});
                }else{
                    axios.post('api/v2/suppliers', {
                        name: this.supplier_name,
                        description: this.supplier_description,
                        contacts: this.supplier_contacts,
                    })
                    Vue.$toast.open({message: 'Поставщик успешно создан' ,type: 'success',duration: 1000,position: 'top-right'});
                    this.$v.$reset()
                    this.showErrors = false
                    this.getSuppliers()
                }
            },

            resetModalSupplier(){
                this.supplier_name = ''
                this.supplier_description = ''
                this.supplier_contacts = ''
                this.showErrors = false
            },

            getModalArticle(){
                this.$bvModal.show('article')
                this.getArticleGroups()
                this.getSuppliers()
            },

            saveArticle(bvModalEvt){
                this.$v.$touch()

                if (this.$v.article_name.$invalid){
                    this.showErrors = true
                    bvModalEvt.preventDefault()
                    Vue.$toast.open({message: 'Заполните все необходимые поля' ,type: 'error',duration: 1000,position: 'top-right'});
                }else{
                    axios.post('api/v2/article', {
                        name: this.article_name,
                        article_group_id: this.article_group.id,
                        supplier_id: this.article_supplier.id,
                        description: this.article_description,
                    })
                    Vue.$toast.open({message: 'Поставщик успешно создан' ,type: 'success',duration: 1000,position: 'top-right'});
                    this.$v.$reset()
                    this.showErrors = false
                    this.getArticles()
                }
            },

            resetModalArticle(){
                this.article_name = ''
                this.article_group = ''
                this.article_supplier = ''
                this.article_description = ''
                this.showErrors = false
            },
        }
    }
</script>
