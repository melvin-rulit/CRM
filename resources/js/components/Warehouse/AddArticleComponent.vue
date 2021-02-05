<template>
        <b-modal id="addArticleWarehouse" title="Приходная операция" centered ok-title="Приход" @hidden="closeModal" cancel-title="Отмена" @ok="saveArticle">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label required">Название</label>
                <div class="col-sm-9">
                    <dynamic-select
                        :options="articles"
                        v-model="article"
                        option-value="id"
                        option-text="name"
                        placeholder="Введите для поиска товарной позиции"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Группа</label>
                <div class="col-sm-9">
                    <dynamic-select
                        :options="groups"
                        v-model="group"
                        option-value="id"
                        option-text="name"
                        @input="getArticleInGroup"
                        placeholder="Введите для поиска группы"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label required">Склад</label>
                <div class="col-sm-9">
                    <dynamic-select
                        :options="warehouses"
                        v-model="warehouse"
                        option-value="id"
                        option-text="name"
                        placeholder="Введите для поиска склада"/>
                </div>
            </div>
            <div class="form-group row" :class="{ 'form-group--error': $v.quantity.$error &&  showErrors}">
                <label class="col-sm-3 col-form-label required">Количество</label>
                <div class="col-sm-9">
                    <input class="form-control" v-model="$v.quantity.$model">
                    <span v-if="!$v.quantity.required && showErrors" class="text-danger h5 ml-3">* Поле обязательно для заполнения</span><br>
                    <span v-if="!$v.quantity.between.min && showErrors" class="text-danger h5 ml-3">* Значение должно быть между {{$v.quantity.$params.between.min}} и {{$v.quantity.$params.between.max}}</span>
                </div>
            </div>
        </b-modal>
</template>

<script>

    import {required, minLength, numeric, between} from 'vuelidate/lib/validators';

    export default {
        data() {
            return {
                showErrors: false,
                article: '',
                warehouses: [],
                articles: [],
                warehouse: '',
                groups: [],
                group: '',
                quantity: '',
                resultArticle: []
            }
        },

        validations: {
            quantity: {
                required,
                numeric,
                between: between(1, 999)
            },
        },

        methods: {


            showModal(){
                this.$bvModal.show('addArticleWarehouse')
                this.getAllArticles()
                this.getAllWarehouses()
                this.getWarehousesGroups()
            },

            getAllArticles(){
                axios.get('api/v2/article')
                    .then(response => {this.articles = response.data.data})
            },

            getAllWarehouses(){
                axios.get('api/v2/warehouses')
                    .then(response => {this.warehouses = response.data})
            },

            getWarehousesGroups(){
                axios.get('api/v2/article_groups')
                    .then(response => {this.groups = response.data.data})
            },

            getArticleInGroup(){
                this.article = ''

                axios.post('api/v2/getArticleInGroup', {id: this.group.id})
                    .then(response => {this.articles = response.data})
            },

            async saveArticle(bvModalEvt){
                this.$v.$touch()

                if (this.$v.$invalid || !this.warehouse || !this.article) {
                    this.showErrors = true
                    bvModalEvt.preventDefault()
                    Vue.$toast.open({
                        message: 'Заполните все необходимые поля',
                        type: 'error',
                        duration: 1000,
                        position: 'top-right'
                    });
                    return false
                }

                try {

                    let res = await axios.post('api/v2/warehouse_article', {
                        article_id: this.article.id,
                        warehouse_id: this.warehouse.id,
                        quantity: this.quantity,
                    })

                    if(res.status == 200){
                        if (res.data.id == 1){
                            Vue.$toast.open({message: 'Позиция уже есть на складе' ,type: 'error',duration: 2000,position: 'top-right'});
                            return false
                        }else{
                            Vue.$toast.open({message: 'Позиция добавлена' ,type: 'success',duration: 2000,position: 'top-right'});
                            this.$emit('get-method', {id: this.warehouse.id})
                            this.$v.$reset()
                            this.showErrors = false
                        }
                    }
                    return res.data.data
                }
                catch (err) {
                    console.error(err);
                }
            },

            closeModal(){
                this.article = ''
                this.$v.$reset()
                this.showErrors = false
                this.warehouses =  []
                this.articles =  []
                this.warehouse = ''
                this.groups = []
                this.group = ''
                this.quantity = ''
            }
        }
    }
</script>
