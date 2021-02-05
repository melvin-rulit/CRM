<template>
        <b-modal id="showPosition" centered hide-footer size="lg" ok-title="Сохранить" cancel-title="Отмена" @hidden="closeModal">
<pre><code>{{position}}</code></pre>
            <div class="card fix-height">
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">{{ position.article.name }}<hr></div>
<!--                        <div class="col-md-4">Склад: {{ position.warehouse.name }}</div>-->
<!--                        <div class="col-md-4">Поставщик: {{ position.supplier_name }}</div>-->
<!--                        <div class="col-md-2 text-center">{{ position.quantity }}</div>-->
                    </div>
                    <div class="form-group row">
                        <textarea class="form-control" rows="3" placeholder="Описание"></textarea>
                    </div>
                </div>
            </div>

<!-- Добавить -->
            <b-tabs>
                <b-tab title="Добавить">
                    <div class="card mt-3 fix-height">
                        <div class="card-body">
                            <div class="form-group row" :class="{ 'form-group--error': $v.quantity.$error &&  showErrors}">
                                <label class="col-sm-3 col-form-label">Количество</label>
                                <div class="col-sm-6">
                                    <input v-model.number="quantity" class="form-control" >
                                    <span v-if="!$v.quantity.required && showErrors" class="text-danger h5 ml-3">* Поле обязательно для заполнения</span><br>
                                    <span v-if="!$v.quantity.between.min && showErrors" class="text-danger h5 ml-3">* Значение должно быть между {{$v.quantity.$params.between.min}} и {{$v.quantity.$params.between.max}}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Поставщик</label>
                                <div class="col-sm-6">
                                    <select class="form-control" @change="changeSupplier($event)">
                                        <option
                                            v-for="supplier in suppliers"
                                            :value="supplier.id"
                                            :selected="supplier.id === position.supplier_id">{{ supplier.name }}</option>
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
                                <label class="col-md-3 align-self-center">Склад: {{ position.warehouse_name }}</label>
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
                                <textarea class="form-control" rows="3" placeholder="Коментарий"></textarea>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-sm btn-primary" @click="move">Переместить</button>
                            </div>
                        </div>
                    </div>
                </b-tab>

<!-- Выдать клиенту  -->
                <b-tab title="Выдать клиенту">
                    <div class="card mt-3 fix-height">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-2 align-self-center">Клиент</label>
                                <div class="col-md-4 align-self-center">
                                    <select class="form-control">
                                        <option></option>
                                    </select>
                                </div>
                                <div class="col-md-2 align-self-center">
                                    кол-во.:
                                </div>
                                <div class="col-md-2 align-self-center">
                                    <input type="" class="form-control" id="" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <textarea class="form-control" rows="3" placeholder="Коментарий"></textarea>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-sm btn-primary">Выдать</button>
                            </div>
                        </div>
                    </div>
                </b-tab>

<!-- Выдать сотруднику  -->
                <b-tab title="Выдать сотруднику">
                    <div class="card mt-3 fix-height">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-2 align-self-center">Клиент</label>
                                <div class="col-md-4 align-self-center">
                                    <select class="form-control">
                                        <option></option>
                                    </select>
                                </div>
                                <div class="col-md-2 align-self-center">
                                    кол-во.:
                                </div>
                                <div class="col-md-2 align-self-center">
                                    <input type="" class="form-control" id="" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <textarea class="form-control" rows="3" placeholder="Коментарий"></textarea>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-sm btn-primary">Выдать</button>
                            </div>
                        </div>
                    </div>
                </b-tab>

<!-- Списать  -->
                <b-tab title="Списать">
                    <div class="card mt-3 fix-height">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <p class="mt-3">Количество</p>
                                </div>
                                <div class="col-sm-4">
                                    <input class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <textarea class="form-control" rows="3" placeholder="Коментарий"></textarea>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-sm btn-primary">Списать</button>
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
        data() {
            return {
                quantity: '',
                showErrors: false,
                suppliers: [],
                newSuppliers: '',
                position: [],
                warehouses: [],
                warehouse: '',
                article: '',
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
                this.newSuppliers = event.target.value
                console.log(event.target)
            },

            getAllWarehouses(){
                axios.get('api/v2/getAllWarehouses')
                    .then(response => {this.warehouses = response.data.data})
            },

            addQuantity(){
                this.$v.$touch()

                if (this.$v.$invalid) {
                    this.showErrors = true
                }else{
                    this.position.quantity += this.quantity

                    axios.post('api/v2/addQuantity',{
                        id: this.position.id,
                        quantity: this.position.quantity,
                        supplier_id: this.newSuppliers ? this.newSuppliers : this.position.supplier_id,
                    })

                    this.quantity = ''
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

                if (this.$v.$invalid) {
                    this.showErrors = true
                }else{
                    if(!this.warehouse.id){
                        Vue.$toast.open({message: 'Выберите склад' ,type: 'error',duration: 2000,position: 'top-right'});
                        return false
                    }
                    if (this.position.warehouse_id === this.warehouse.id){
                        Vue.$toast.open({message: 'Нельзя переместить в тот же склад' ,type: 'error',duration: 2000,position: 'top-right'});
                        return false
                    }

                    if(this.quantity > this.position.quantity && this.warehouse.id){
                        Vue.$toast.open({message: 'Нельзя списать больше чем на складе' ,type: 'error',duration: 2000,position: 'top-right'});
                        return false
                    }else{
                        axios.post('api/v2/test',{
                            id: this.position.id,
                            warehouse_id: this.warehouse.id,
                            new_warehouse_quantity: this.this.quantity,
                            quantity: this.position.quantity -= this.quantity,

                        })

                        this.position.quantity -= this.quantity

                        this.quantity = ''
                        this.$v.$reset()
                        this.showErrors = false
                    }
                }
            },

            closeModal(){
                this.$emit('get-method', {id: this.position.warehouse.id})
                this.$v.$reset()
                this.showErrors = false
                this.position =  []
                this.quantity = ''
            }
        },
    }
</script>
