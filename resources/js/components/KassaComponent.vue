<template>
    <div>

        <!-- Окно добавления редактирования операции -->
        <b-modal id="editOperation" title="Изменить операцию" centered ok-title="Сохранить" cancel-title="Отмена" @ok="">
<!--            <pre><code>{{edit_operation}}</code></pre>-->
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Сумма</label>
                <div class="col-sm-9">
                    <input v-model.trim="edit_operation.sum" class="form-control">
                </div>
            </div>
            <b-form-group
                label-cols-sm="3"
                label-cols-lg="3"
                label="Касса"
            >
                <select class="form-control" @change="changeProgrammValue($event)">
                    <option
                        v-for="item in branches"
                        :value="item.id"
                        :selected="item.id === edit_operation.branch">{{ item.name }}</option>
                </select>

            </b-form-group>
            <div class="form-group row">
                <textarea v-model="edit_operation.coment" class="form-control" rows="3" placeholder="Коментарий"></textarea>
            </div>
        </b-modal>

<!--        Операции модальное окно-->
        <b-modal id="coming" :title="text" @ok="handleOk" @hidden="resetModalComing" scrollable centered ok-only ok-title="Сохранить">
            <div class="card-body py-0">
                <form @submit.stop.prevent="submit">
                    <div class="form-group row" :class="{ 'form-group--error': $v.sum.$error }">
                        <label class="col-sm-3 col-form-label">Сумма</label>
                        <div class="col-sm-9">
                            <input v-model.trim="$v.sum.$model" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Касса</label>
                        <div class="col-sm-9">
                            <dynamic-select
                                :options="branches"
                                v-model="branch"
                                option-value="id"
                                option-text="name"
                                @input="getOperationsType()"
                                placeholder="Введите для поиска кассы"/>
<!--                            <div v-if="!branch.id && checkGroup" class="text-danger"><small>Не выбрана касса</small></div>-->
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Операция</label>
                        <div class="col-sm-9">
                            <dynamic-select
                                :options="operations_type"
                                v-model="operations_type_model"
                                option-value="id"
                                option-text="name"
                                @input="getRadioButton()"
                                placeholder="Введите для поиска операции"/>
<!--                            <div v-if="!operations_type.id && checkOperationType" class="text-danger"><small>Не выбрана операция</small></div>-->
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Оплата</label>
                        <div class="col-sm-9">
                            <b-form-radio-group
                                v-if="operations_type_model"
                                v-model="payment"
                                :options="getRadio"
                                class="mt-2"
                                value-field="id"
                                text-field="name"
                                disabled-field="disabled"
                            ></b-form-radio-group>
                        </div>
                    </div>
                    <div class="form-group row">
                        <textarea v-model="coment" class="form-control" rows="3" placeholder="Коментарий"></textarea>
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
                                <button @click=getModal(1) class="btn btn-sm btn-success">Приход</button>
                                <button @click=getModal(0) class="btn btn-sm btn-danger">Рассход</button>
                                <button class="ml-4 btn btn-sm btn-info">День</button>
                                <button class="btn btn-sm btn-info">Неделя</button>
                                <button class="btn btn-sm btn-info">Месяц</button>

                              <button
                                  v-for="item in branches_access"
                                  @click="showKassaOperation(item.id)"
                                  class="btn btn-sm ml-3"
                                  :class="kassa_id == item.id ? 'btn-outline-success' : 'btn-outline-primary'">{{
                                item.name }}
                              </button>
                            </div>
                            <div class="col-auto">
<!--                                <button class="btn btn-sm btn-info">Фильтр</button>-->
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
                            @row-clicked="editOperation"
                            sticky-header="700px"
                            :items="kassa_operations"
                            :fields="fields"
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

    import { required, email, minLength, sameAs } from "vuelidate/lib/validators";

    export default {
        data() {
            return{
                text: '',
                com: 'Приходная операция',
                ou: 'Расходная операция',
                type: '',
                payment: '',
                sum: '',
                coment: '',
                branch: '',
                kassa_id: '',
                kassa_operations: [],
                operations_type: [],
                operations_type_model: '',
                branches: [],
                edit_operation: [],
                fields: [
                    {
                        key: 'datetime',
                        label: 'Дата/Время',
                    },
                    {
                        key: 'user',
                        label: 'Сотрудник',
                    },
                    {
                        key: 'operation_type',
                        label: 'Источник',
                    },
                    {
                        key: 'coment',
                        label: 'Комментарий',
                    },
                    {
                        key: 'source',
                        label: 'Тип операции',
                    },
                    {
                        key: 'sum',
                        label: 'Сумма',
                    },
                    // {
                    //     key: 'balance',
                    //     label: 'Баланс',
                    // },
                    {
                        key: 'operation',
                        label: 'Операция',
                    },
                    {
                        key: 'kassa',
                        label: 'Касса',
                    }

                ],
                options: [],
              branches_access: []
            }
        },

        validations: {
            sum: {
                required,
                minLength: minLength(1)
            }
        },

      beforeRouteEnter (to, from, next) {
        axios.get('api/v2/kassa_operation')
            .then(response => {
              next(vm => (vm.branches_access = response.data) )
            })
      },

        computed:{
            getRadio(){
                const radio = [
                    { name: 'Наличные', id: 1, disabled: !this.options.cash },
                    { name: 'Безнал', id: 2,  disabled: !this.options.beznal },
                ]

                const radio_null = [
                    { name: 'Наличные', id: 1 },
                    { name: 'Безнал', id: 2 },
                ]

                if (!this.options.cash && !this.options.beznal){
                    return radio_null
                }else{
                    return radio
                }
            }
        },

      mounted() {
        if(this.branches_access[0]) {
          this.showKassaOperation(this.branches_access[0].id)
        }
      },

        methods: {

            editOperation(index){
                this.$bvModal.show('editOperation')
                this.edit_operation = index
                this.getBranches()
            },

            resetModalComing(){
                this.sum = ''
                this.payment = ''
                this.branch = []
                this.operations_type = []
                this.operations_type_model = ''
                this.coment = ''
                this.$v.$reset()
            },

            handleOk(bvModalEvt) {
                this.$v.$touch()

                if (this.$v.$invalid || !this.branch || !this.payment || !this.operations_type_model) {
                    bvModalEvt.preventDefault()
                    Vue.$toast.open({message: 'Заполните все необходимые поля' ,type: 'error',duration: 5000,position: 'top-right'});
                } else {
                    this.sendOperation()
                }
            },

            getModal(type){
                type === 1 ? this.text = this.com : this.ou
                this.type = type
                this.$bvModal.show('coming')
                this.getBranches()
            },

            getRadioButton(){
                this.payment = ''
                axios.post('api/v2/getRadioButton',{id: this.operations_type_model.id})
                    .then(response => this.options = response.data)
            },

            getBranches(){
                axios.get('api/v2/getbranches')
                    .then(response => this.branches = response.data.data)
            },

            getOperationsType(){
                this.operations_type_model = ''
                axios.post('api/v2/getOperationsType', {id: this.branch.id, type: this.type})
                    .then(response => this.operations_type = response.data.data)
            },

            sendOperation(){
                axios.post('api/v2/addOperation', {
                    branch_id: this.branch.id,
                    operation_type_id: this.operations_type_model.id,
                    payment: this.payment,
                    in_or_out: this.type,
                    sum: this.sum,
                    coment: this.coment,
                    type: this.type
                })
                this.showKassaOperation(this.kassa_id)
            },

          showKassaOperation(id){
            axios.post('api/v2/showKassaOperation', {kassa_id: id})
                .then(response => {this.kassa_operations = response.data.data})

            this.kassa_id = id
            },

        }
    }
</script>

<style scoped>
    .select-error{
        border: 1px solid red;
    }
.form-group--error {
        animation-name: shakeError;
        animation-fill-mode: forwards;
        animation-duration: .6s;
        animation-timing-function: ease-in-out;
    }
</style>
