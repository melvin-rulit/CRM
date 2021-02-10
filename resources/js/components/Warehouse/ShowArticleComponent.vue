<template>
        <b-modal id="showPosition" centered hide-footer size="lg" ok-title="Сохранить" cancel-title="Отмена" @hidden="closeModal">
<!--<pre><code>{{position}}</code></pre>-->
            <div class="card fix-height" v-if="position.article || position.supplier">
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">{{ position.article.name }}<hr></div>
                        <div class="col-md-4">Склад: {{ position.warehouse.name }}</div>
                        <div class="col-md-4">Поставщик: <span v-if="position.supplier">{{ position.supplier.name }}</span></div>
                        <div class="col-md-2 text-center">Кол-во: {{ position.quantity }}</div>
                    </div>
                    <div class="form-group row">
                        <textarea class="form-control" v-model="position.article.description" rows="3" placeholder="Описание"></textarea>
                    </div>
                </div>
            </div>

<!-- Добавить -->
            <b-tabs>
                <b-tab title="Добавить"  @click="addQuantityTab">
                    <div class="card mt-3 fix-height">
                        <div class="card-body">
                            <div class="form-group row" :class="{ 'form-group--error': $v.quantity.$error &&  showErrors}">
                                <label class="col-sm-3 col-form-label">Количество</label>
                                <div class="col-sm-6">
                                    <input v-model.number="quantity" class="form-control" >
                                    <span v-if="!$v.quantity.required && showErrors" class="text-danger h5 ml-3 mt-2">* Поле обязательно для заполнения</span><br>
                                    <span v-if="!$v.quantity.between.min && showErrors" class="text-danger h5 ml-3 mt-2">* Значение должно быть между {{$v.quantity.$params.between.min}} и {{$v.quantity.$params.between.max}}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Поставщик</label>
                                <div class="col-sm-6">
                                    <select class="form-select" @change="changeSupplier($event)">
                                        <option value="" selected>Без поставщика</option>
                                        <option
                                            v-if="!position.supplier"
                                            v-for="supplier in suppliers"
                                            :value="supplier.id"
                                            @change="changeSupplier($event)"
                                            >{{ supplier.name }}
                                        </option>
                                        <option
                                            v-if="position.supplier"
                                            v-for="supplier in suppliers"
                                            :value="supplier.id"
                                            @change="changeSupplier($event)"
                                            :selected="supplier.id === position.supplier.id">{{ supplier.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="text-center">
                                <button @click="addQuantity" class="btn btn-sm btn-primary">Добавить</button>
                            </div>
                        </div>
                    </div>
                </b-tab>

<!-- Переместить -->
                <b-tab title="Переместить" @click="moveTab">
                    <div class="card mt-3 fix-height">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 align-self-center" v-if="position.warehouse">Склад: {{ position.warehouse.name }}</label>
                                <div class="col-md-5 align-self-center">
                                    <dynamic-select
                                        :options="warehouses"
                                        v-model="warehouse"
                                        option-value="id"
                                        option-text="name"
                                        placeholder="Введите для поиска склада"/>
                                </div>
                                <div class="col-md-2 align-self-center">
                                    кол-во.:
                                </div>
                                <div class="col-md-2 align-self-center" :class="{ 'form-group--error': $v.quantity.$error &&  showErrors}">
                                    <input class="form-control" v-model.number="quantity">
                                </div>
                            </div>
                            <div class="form-group row">
                                <textarea class="form-control" v-model="comment" rows="3" placeholder="Коментарий"></textarea>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-sm btn-primary" @click="move">Переместить</button>
                            </div>
                        </div>
                    </div>
                </b-tab>

<!-- Выдать клиенту  -->
                <b-tab title="Выдать клиенту" @click="baseTab">
                    <div class="card mt-3 fix-height">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-2 align-self-center">Клиент</label>
                                <div class="col-md-4 align-self-center">
                                    <dynamic-select
                                        :options="bases"
                                        v-model="base"
                                        option-value="id"
                                        option-text="child_surname"
                                        placeholder="Введите для поиска клиента"/>
                                </div>
                                <div class="col-md-2 align-self-center">
                                    кол-во.:
                                </div>
                                <div class="col-md-2 align-self-center" :class="{ 'form-group--error': $v.quantity.$error &&  showErrors}">
                                    <input v-model.number="quantity" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <textarea class="form-control" v-model="comment" rows="3" placeholder="Коментарий"></textarea>
                            </div>
                            <div class="text-center">
                                <button @click="removeBase" class="btn btn-sm btn-primary">Выдать</button>
                            </div>
                        </div>
                    </div>
                </b-tab>

<!-- Выдать сотруднику  -->
                <b-tab title="Выдать сотруднику" @click="userTab">
                    <div class="card mt-3 fix-height">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-2 align-self-center">Сотрудник</label>
                                <div class="col-md-4 align-self-center">
                                    <dynamic-select
                                        :options="users"
                                        v-model="user"
                                        option-value="id"
                                        option-text="name"
                                        placeholder="Введите для поиска сотрудника"/>
                                </div>
                                <div class="col-md-2 align-self-center">
                                    кол-во.:
                                </div>
                                <div class="col-md-2 align-self-center" :class="{ 'form-group--error': $v.quantity.$error &&  showErrors}">
                                    <input v-model.number="quantity" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <textarea class="form-control" v-model="comment" rows="3" placeholder="Коментарий"></textarea>
                            </div>
                            <div class="text-center">
                                <button @click="removeUser" class="btn btn-sm btn-primary">Выдать</button>
                            </div>
                        </div>
                    </div>
                </b-tab>

<!-- Списать  -->
                <b-tab title="Списать">
                    <div class="card mt-3 fix-height">
                        <div class="card-body">
                            <div class="form-group row" :class="{ 'form-group--error': $v.quantity.$error &&  showErrors}">
                                <div class="col-sm-3">
                                    <p class="mt-3">Количество</p>
                                </div>
                                <div class="col-sm-6">
                                    <input v-model.number="quantity" class="form-control">
                                    <span v-if="!$v.quantity.required && showErrors" class="text-danger h5 ml-3 mt-2">* Поле обязательно для заполнения</span><br>
                                </div>
                            </div>
                            <div class="form-group row" :class="{ 'form-group--error': $v.comment.$error &&  showErrors}">
                                <textarea class="form-control" v-model="comment" rows="3" placeholder="Коментарий"></textarea>
                                <span v-if="!$v.comment.required && showErrors" class="text-danger h5 ml-3 mt-2 mt-2">* Поле обязательно для заполнения</span><br>
                            </div>
                            <div class="text-center">
                                <button @click="removeQuantity" class="btn btn-sm btn-primary">Списать</button>
                            </div>
                        </div>
                    </div>
                </b-tab>
            </b-tabs>
        </b-modal>
</template>

<script>

    import { required, numeric, between } from 'vuelidate/lib/validators';

    export default {
        props: {
            item: {

            },
        },

        data() {
            return {
                quantity: '',
                showErrors: false,
                suppliers: [],
                users: [],
                bases: [],
                base: {},
                user: {},
                newSuppliers: '',
                comment: '',
                position: [],
                warehouses: [],
                warehouse: {},
                article: {},
            }
        },

        validations: {
            quantity: {
                required,
                numeric,
                between: between(1, 999)
            },
            comment: {
                required,
            },
        },

        methods: {

            showModal(item){
                this.$bvModal.show('showPosition')
                this.position = item
                this.getAllSuppliers()
                // this.getPosition(item.id)
            },

            getPosition(id){
                axios.get('api/v2/article/' + id)
                .then(response => {this.position = response.data.data})
            },

            getAllSuppliers(){
                axios.get('api/v2/suppliers')
                    .then(response => {this.suppliers = response.data.data})
            },

            changeSupplier($event){
                this.newSuppliers = $event.target.value
            },

            getAllWarehouses(){
                axios.get('api/v2/warehouses')
                    .then(response => {this.warehouses = response.data})
            },

            getAllUsers(){
                axios.post('api/v2/usersInBranch', {branch_id: this.position.warehouse.branch_id})
                    .then(response => {this.users = response.data.data})
            },

            getAllbases(){
                axios.post('api/v2/basesInBranch', {branch_id: this.position.warehouse.branch_id})
                    .then(response => {this.bases = response.data.data})
            },

            addQuantityTab(){
                this.quantity = ''
                this.$v.$reset()
                this.showErrors = false
            },

            addQuantity(){
                this.$v.$touch()

                if (this.$v.$invalid) {
                    this.showErrors = true
                }else{
                    this.position.quantity += this.quantity

                    axios.post('api/v2/addQuantity',{
                        id: this.position.id,
                        quantity: this.quantity,
                        supplier_id: this.newSuppliers ? this.newSuppliers : this.position.supplier.id,
                    })

                    this.resetVuelidate()

                    Vue.$toast.open({message: 'Добавленно' ,type: 'success',duration: 2000,position: 'top-right'});
                }
            },

            moveTab(){
                this.getAllWarehouses()
                this.quantity = ''
                this.$v.$reset()
                this.showErrors = false
            },

            move(){
                this.$v.$touch()

                if (this.$v.quantity.$invalid) {
                    this.showErrors = true
                }else{
                    if(!this.warehouse.id){
                        Vue.$toast.open({message: 'Выберите склад' ,type: 'error',duration: 2000,position: 'top-right'});
                        return false
                    }
                    if (this.position.warehouse.id === this.warehouse.id){
                        Vue.$toast.open({message: 'Нельзя переместить в тот же склад' ,type: 'error',duration: 2000,position: 'top-right'});
                        return false
                    }

                    if(this.quantity > this.position.quantity && this.warehouse.id){
                        Vue.$toast.open({message: 'Нельзя списать больше чем на складе' ,type: 'error',duration: 2000,position: 'top-right'});
                        return false
                    }else{
                        axios.post('api/v2/moveArticle',{
                            id: this.position.id,
                            article_id: this.position.article.id,
                            quantity: this.quantity,
                            warehouse_id: this.position.warehouse.id,
                            supplier_id: this.position.supplier.id,
                            new_warehouse_id: this.warehouse.id,
                            comment: this.comment
                        })

                        Vue.$toast.open({message: 'Списано' ,type: 'success',duration: 2000,position: 'top-right'});

                        this.position.quantity -= this.quantity

                        this.resetVuelidate()

                        this.warehouse = ''
                        this.comment = ''
                    }
                }
            },

            removeQuantity(){
                this.$v.$touch()

                if (this.$v.$invalid) {
                    this.showErrors = true
                    return false
                }

                if(this.quantity > this.position.quantity && this.warehouse.id) {
                    Vue.$toast.open({
                        message: 'Нельзя списать больше чем на складе',
                        type: 'error',
                        duration: 2000,
                        position: 'top-right'
                    });
                    return false
                }else{
                    if(this.quantity > this.position.quantity){
                        Vue.$toast.open({message: 'Нельзя списать больше чем на складе' ,type: 'error',duration: 2000,position: 'top-right'});
                        return false
                    }else{
                    axios.post('api/v2/removeQuantity',{
                        id: this.position.id,
                        quantity: this.quantity,
                        comment: this.comment
                    })

                        this.position.quantity -= this.quantity
                        this.comment = ''

                        this.resetVuelidate()

                    Vue.$toast.open({message: 'Списано' ,type: 'success',duration: 2000,position: 'top-right'});
                    }
                }
            },

            baseTab(){
                this.getAllbases()
                this.quantity = ''
                this.$v.$reset()
                this.showErrors = false
            },

            removeBase(){
                this.$v.$touch()

                if (this.$v.quantity.$invalid) {
                    this.showErrors = true
                    return false
                }

                if(!this.base.id){
                    Vue.$toast.open({message: 'Выберите клиента' ,type: 'error',duration: 2000,position: 'top-right'});
                    return false
                }

                if(this.quantity > this.position.quantity){
                    Vue.$toast.open({message: 'Нельзя списать больше чем на складе' ,type: 'error',duration: 2000,position: 'top-right'});
                    return false
                }else{
                    axios.post('api/v2/removeBase',{
                        id: this.position.id,
                        quantity: this.quantity,
                        base_id: this.base.id,
                        comment: this.comment
                    })

                    this.resetVuelidate()

                    this.position.quantity -= this.quantity
                    this.comment = ''
                    Vue.$toast.open({message: 'Выдано клиенту' ,type: 'success',duration: 2000,position: 'top-right'});
                }
            },

            userTab(){
                this.getAllUsers()
                this.quantity = ''
                this.$v.$reset()
                this.showErrors = false
            },

            removeUser(){
                this.$v.$touch()

                if (this.$v.quantity.$invalid) {
                    this.showErrors = true
                    return false
                }

                if(!this.user.id){
                    Vue.$toast.open({message: 'Выберите сотрудника' ,type: 'error',duration: 2000,position: 'top-right'});
                    return false
                }

                    if(this.quantity > this.position.quantity){
                        Vue.$toast.open({message: 'Нельзя списать больше чем на складе' ,type: 'error',duration: 2000,position: 'top-right'});
                        return false
                    }else{
                        axios.post('api/v2/removeUser',{
                            id: this.position.id,
                            quantity: this.quantity,
                            user_id: this.user.id,
                            comment: this.comment
                        })

                        this.resetVuelidate()

                        this.position.quantity -= this.quantity
                        this.comment = ''

                        Vue.$toast.open({message: 'Выдано сотруднику' ,type: 'success',duration: 2000,position: 'top-right'});
                    }
            },

            resetVuelidate(){
                this.$v.$reset()
                this.showErrors = false
                this.quantity = ''
            },

            closeModal(){
                // this.$emit('get-method', {id: this.position.warehouse.id})
                this.$v.$reset()
                this.showErrors = false
                this.position =  []
                this.quantity = ''
                this.warehouse = ''
                this.comment = ''
            }
        },
    }
</script>
