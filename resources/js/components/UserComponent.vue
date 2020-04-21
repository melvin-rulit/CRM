
<template>
<div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card mb-2">
          <div class="card-header">
            <div class="row align-items-center">
              <div class="col">
              </div>
              <div class="col-auto">
                <a class="btn btn-sm btn-success" href="javascript:void(0)" data-toggle="modal" data-target="#addNewUser">Добавить клиента</a>
                <!-- <a class="btn btn-sm btn-info" href="javascript:void(0)">Фильтр</a> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<!-- <input v-model="dataObject.attributes.child_surname" type="tel" v-mask="'SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS'" /> -->

    <!-- Модальное окно с выбором контрактом -->
<div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle">Добавление нового клиента</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label required">Фамилия</label>
                <div class="col-sm-9">
                    <input v-model="new_child_surname" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label required">Имя</label>
                <div class="col-sm-9">
                    <input v-model="new_child_name" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label required">Отчество</label>
                <div class="col-sm-9">
                    <input v-model="new_child_middle_name" class="form-control" required>
                </div>
            </div>
        </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button @click="addNewUser" type="button" class="btn btn-success" data-dismiss="modal">Добавить</button>
              </div>
            </div>
          </div>

</div>


<dogovor-component :user_id="dataObject.id"></dogovor-component>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
    <a class="nav-link" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="false">Все</a>
  </li>
  <li class="nav-item">
    <a v-on:click="contact()" class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Текущие</a>
  </li>
  <li class="nav-item">
    <a v-on:click="profile()" class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">В работе</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Продления</a>
  </li>
</ul>


<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab">666</div>
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="card">
            <div class="card-body pb-0">
                <div class="table-responsive">
                    <table class=" table table-bordered table-hover datatable datatable-User">
                        <thead>
                            <tr>
                                <th width="10"></th>
                                <th>Фамилия</th>
                                <th>Имя</th>
                                <th>Отчество</th>
                                <th>Возраст</th>
                                <th class="text-center">?</th>
                            </tr>
                        </thead>
                        <tbody v-for="article in articles">
                            <tr v-for="ar in article">
                                <td></td>
                                <td><a href="javascript:void(0)" v-on:click="getModal(ar.id)">{{ ar.attributes.child_surname }}</a></td>
                                <td>{{ ar.attributes.child_name }}</td>
                                <td>{{ ar.attributes.child_middle_name }}</td>
                                <td>{{ ar.attributes.age }} лет</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <p v-for="user in users">{{ user }}</p>
    </div>
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab"></div>
</div>


<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="addNew" data-backdrop="static" data-keyboard="false" ref="vuemodals" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">Карточка ребенка  &nbsp {{ dataObject.attributes['child_surname'] }} {{ dataObject.attributes['child_name'] }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
      </div>
      <div class="modal-body">
        <div class="card mb-3">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <svg class="bd-placeholder-img" width="100%" height="250" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Image"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"></rect></svg>
                </div>
                <div class="col-md-4">
                    <div class="card-body">
                        <h4><input-form v-model="dataObject.attributes.child_surname" name="child_surname" @edit-field="editField"></input-form></h4>
                        <h4><input-form v-model="dataObject.attributes.child_name" name="child_name" @edit-field="editField"></input-form></h4>
                        <h4><input-form v-model="dataObject.attributes.child_middle_name" name="child_middle_name" @edit-field="editField"></input-form></h4>
                        <p class="card-text"><input-form placeholder="12.05.1988" v-mask="'##.##.####'" v-model="dataObject.attributes.child_birthday" name="child_birthday" @edit-field="editField"></input-form> <span>({{ dataObject.attributes.age }} лет)</span></p>
                        <h6 class="text-uppercase text-muted mb-2">Люберецкий филиал</h6>
                    </div>
                </div>
                <div class="col-md-4 border-left">
                    <div class="card-body">
                        <h4 class="text-center">Документы</h4>
                    </div>
                </div>
            </div>
        </div>

<ul class="nav nav-tabs" id="info" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="mother-tab" data-toggle="tab" href="#mother" role="tab" aria-controls="mother" aria-selected="true">Мать</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="father-tab" data-toggle="tab" href="#father" role="tab" aria-controls="father" aria-selected="false">Отец</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="other_relative-tab" data-toggle="tab" href="#other_relative" role="tab" aria-controls="other_relative" aria-selected="false">Родственник</a>
  </li>
    <li class="nav-item">
    <a class="nav-link" id="contract-tab" data-toggle="tab" href="#contract" role="tab" aria-controls="contract" aria-selected="false">Контракт</a>
  </li>
    <li class="nav-item">
    <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">История</a>
  </li>
    <li class="nav-item">
    <a class="nav-link" id="interests-tab" data-toggle="tab" href="#interests" role="tab" aria-controls="interests" aria-selected="false">Интересы</a>
  </li>
</ul>

<div class="tab-content" id="infoContent" style="min-height: 150px">
  <div class="tab-pane fade show active" id="mother" role="tabpanel" aria-labelledby="mother-tab">
    <div class="card-body pb-0 pb-0">
        <div class="row">
            <div class="col-md-6">
                    <table class=" table table-bordered">
                        <tbody>
                            <tr>
                                <td class="w-25">Фамилия</td>
                                <td class="w-75"><input-form v-model="dataObject.attributes.mother_surname" name="mother_surname" @edit-field="editField"></input-form></td>
                            </tr>
                            <tr>
                                <td class="w-25">Имя</td>
                                <td class="w-75"><input-form v-model="dataObject.attributes.mother_name" name="mother_name" @edit-field="editField"></input-form></td>
                            </tr>
                            <tr>
                                <td class="w-25">Отчество</td>
                                <td class="w-75"><input-form v-model="dataObject.attributes.mother_middle_name" name="mother_middle_name" @edit-field="editField"></input-form></td>
                            </tr>
                            <tr>
                                <td class="w-25">Телефон</td>
                                <td class="w-75"><input-form placeholder="+3 (926) 123-45-67" v-mask="'+# (###) ###-##-##'" v-model="dataObject.attributes.mother_phone" name="mother_phone" @edit-field="editField"></input-form></td>
                            </tr>
                            <tr>
                                <td class="w-25">Телефон</td>
                                <td class="w-75"><input-form placeholder="+3 (926) 123-45-67" v-mask="'+# (###) ###-##-##'" v-model="dataObject.attributes.mother_dop_phone" name="mother_dop_phone" @edit-field="editField"></input-form></td>
                            </tr>
                            <tr>
                                <td class="w-25">Viber</td>
                                <td class="w-75"><input-form placeholder="+3 (926) 123-45-67" v-mask="'+# (###) ###-##-##'" v-model="dataObject.attributes.mother_viber" name="mother_viber" @edit-field="editField"></input-form></td>
                            </tr>
                            <tr>
                                <td class="w-25">Почта</td>
                                <td class="w-75"><input-form v-model="dataObject.attributes.mother_email" name="mother_email" @edit-field="editField"></input-form></td>
                            </tr>
                        </tbody>
                    </table>
            </div>
            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Примечания:</label>
                    <textarea class="form-control" v-model="dataObject.attributes.mother_notes" @blur="event => editField(event, 'mother_notes')" rows="3"></textarea>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="tab-pane fade" id="father" role="tabpanel" aria-labelledby="father-tab">
        <div class="card-body pb-0">
        <div class="row">
            <div class="col-md-6">
                    <table class=" table table-bordered">
                        <tbody>
                            <tr>
                                <td class="w-25">Фамилия</td>
                                <td class="w-75"><input-form v-model="dataObject.attributes.father_surname" name="father_surname" @edit-field="editField"></input-form></td>
                            </tr>
                            <tr>
                                <td class="w-25">Имя</td>
                                <td class="w-75"><input-form v-model="dataObject.attributes.father_name" name="father_name" @edit-field="editField"></input-form></td>
                            </tr>
                            <tr>
                                <td class="w-25">Отчество</td>
                                <td class="w-75"><input-form v-model="dataObject.attributes.father_middle_name" name="father_middle_name" @edit-field="editField"></input-form></td>
                            </tr>
                            <tr>
                                <td class="w-25">Телефон</td>
                                <td class="w-75"><input-form placeholder="+3 (926) 123-45-67" v-mask="'+# (###) ###-##-##'" v-model="dataObject.attributes.father_phone" name="father_phone" @edit-field="editField"></input-form></td>
                            </tr>
                            <tr>
                                <td class="w-25">Телефон</td>
                                <td class="w-75"><input-form placeholder="+3 (926) 123-45-67" v-mask="'+# (###) ###-##-##'" v-model="dataObject.attributes.father_dop_phone" name="father_dop_phone" @edit-field="editField"></input-form></td>
                            </tr>
                            <tr>
                                <td class="w-25">Viber</td>
                                <td class="w-75"><input-form placeholder="+3 (926) 123-45-67" v-mask="'+# (###) ###-##-##'" v-model="dataObject.attributes.father_viber" name="father_viber" @edit-field="editField"></input-form></td>
                            </tr>
                            <tr>
                                <td class="w-25">Почта</td>
                                <td class="w-75"><input-form v-model="dataObject.attributes.father_email" name="father_email" @edit-field="editField"></input-form></td>
                            </tr>
                        </tbody>
                    </table>
            </div>
            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Примечания:</label>
                    <textarea class="form-control" v-model="dataObject.attributes.father_notes" @blur="event => editField(event, 'father_notes')" rows="3"></textarea>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="tab-pane fade" id="other_relative" role="tabpanel" aria-labelledby="other_relative-tab">
        <div class="card-body pb-0">
            <div class="row">
                <div class="col-md-6">
                    <table class=" table table-bordered">
                        <tbody>
                            <tr>
                                <td class="w-25">Фамилия</td>
                                <td class="w-75"><input-form v-model="dataObject.attributes.other_relative_surname" name="other_relative_surname" @edit-field="editField"></input-form></td>
                            </tr>
                            <tr>
                                <td class="w-25">Имя</td>
                                <td class="w-75"><input-form v-model="dataObject.attributes.other_relative_name" name="other_relative_name" @edit-field="editField"></input-form></td>
                            </tr>
                            <tr>
                                <td class="w-25">Отчество</td>
                                <td class="w-75"><input-form v-model="dataObject.attributes.other_relative_middle_name" name="other_relative_middle_name" @edit-field="editField"></input-form></td>
                            </tr>
                            <tr>
                                <td class="w-25">Телефон</td>
                                <td class="w-75"><input-form placeholder="+3 (926) 123-45-67" v-mask="'+# (###) ###-##-##'" v-model="dataObject.attributes.other_relative_phone" name="other_relative_phone" @edit-field="editField"></input-form></td>
                            </tr>
                            <tr>
                                <td class="w-25">Телефон</td>
                                <td class="w-75"><input-form placeholder="+3 (926) 123-45-67" v-mask="'+# (###) ###-##-##'" v-model="dataObject.attributes.other_relative_dop_phone" name="other_relative_dop_phone" @edit-field="editField"></input-form></td>
                            </tr>
                            <tr>
                                <td class="w-25">Viber</td>
                                <td class="w-75"><input-form placeholder="+3 (926) 123-45-67" v-mask="'+# (###) ###-##-##'" v-model="dataObject.attributes.other_relative_viber" name="other_relative_viber" @edit-field="editField"></input-form></td>
                            </tr>
                            <tr>
                                <td class="w-25">Почта</td>
                                <td class="w-75"><input-form v-model="dataObject.attributes.other_relative_email" name="other_relative_email" @edit-field="editField"></input-form></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                   <div class="form-group">
                        <label for="">Примечания:</label>
                        <textarea class="form-control" v-model="dataObject.attributes.other_relative_notes" @blur="event => editField(event, 'other_relative_notes')" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>
  </div>
  <div class="tab-pane fade" id="contract" role="tabpanel" aria-labelledby="contract-tab">
    <div class="card-body pb-0 pt-3">
        <div class="row">
            <div class="col-md-6 border-bottom">
                <div class="row">
                    <div class="btn-group btn-group-sm mb-3 text-center mx-auto" v-if="dataObject.contracts_active.length > 0">
                        <button class="btn btn-sm btn-outline-secondary mr-4" @click="indexActiveUser--" :disabled="indexActiveUser <= 0">Предыдущий</button>
                        <button class="btn btn-sm btn-outline-secondary ml-4" @click="indexActiveUser++" :disabled="indexActiveUser === dataObject.contracts_active.length - 1">Следующий</button>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-md-6 border-bottom">
                <div class="row">
                    <div class="center mb-3">
                        <button @click="closeModal()" class="btn btn-sm btn-success">Добавить контракт</button>
                    </div>
                </div>
            </div>
            <hr>
        </div>

        <div class="row">

            <div class="col-md-6 mt-3">
                <transition name="fade" mode="out-in">
                <div v-if="dataObject.contracts_active.length > 0" class="table-responsive" :key="indexActiveUser">
                    <p class="card-text text-center">"{{ activeUser.name }}"</p>
                    <table class=" table table-bordered table-hover datatable datatable-User">
                        <tbody>
                            <tr>
                                <td>Начало:</td>
                                <td>{{ activeUser.start }}</td>
                            </tr>
                            <tr>
                                <td>Окончание:</td>
                                <td>{{ activeUser.end }}</td>
                            </tr>
                            <tr>
                                <td>Окончание факт:</td>
                                <td>{{ activeUser.end_actually }}</td>
                            </tr>
                            <tr>
                                <td>Заморозки:</td>
                                <td>24 | 15 | 9</td>
                            </tr>
                            <tr>
                                <td>Тренировки:</td>
                                <td>81 | 28 | 53</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="text-center font-weight-bold" v-else>Нет активных контрактов</p>
                </transition>
                <p>Оплаты: 
                    <span class="text-muted ml-2" data-toggle="tooltip" data-placement="bottom" title="Дата оплаты - 23.05.2015">4212</span>
                    <a href="javascript:void(0)" class="text-success ml-2" v-on:click="getModalSale()">3159</a>
                    <span class="text-danger ml-2">3348</span>
                </p>
                <p>Сумма и остаток: <span class="ml-2">10530 (3159)</span></p>
            </div>

            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <p class="card-text text-center">Прошлые контракты</p>
                    <p v-for="contracts_not_active in dataObject.contracts_not_active"><a href="javascript:void(0)" class="text-muted">"{{contracts_not_active.name}}"  &nbsp {{contracts_not_active.start}} - {{contracts_not_active.end}}</a></p>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab"></div>
  <div class="tab-pane fade" id="interests" role="tabpanel" aria-labelledby="interests-tab"></div>
</div>
      </div>
      <div class="modal-footer pt-3 pb-3">
        <button @click="this.fetchArticles" type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

</div>
</template>

<script>


import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask)


Vue.component('inputForm', {
  props: {
    value: {
      type: String,
      required: true
    },
    name: {
      type: String,
      required: true
    },
    placeholder: {
    }
  },
  data() {
    return {
      keyInputForm: null,
      thisValue: this.value,
    }
  },
  template: `

    <span>
    <a href="#" v-if="!value && !keyInputForm" @click.prevent="keyInputForm=true;thisValue=''" style="color: green;">Добавить</a>
    <span>
      <span v-if="!keyInputForm" class="card-title" @dblclick="keyInputForm = true">{{ value }}</span>
      <input v-else type="text" :value="value" :placeholder="placeholder" :name="name" v-model="value" @input="$emit('input', value)" @blur="keyInputForm = false" v-on:keyup.enter="keyInputForm = false;$emit('edit-field', $event)">
      </div>
    </div>

  `
})


import Vue from 'vue';
import VueHtmlToPaper from 'vue-html-to-paper';

const options = {
  name: '_blank',
  specs: [
    'fullscreen=yes',
    'titlebar=yes',
    'scrollbars=yes'
  ],
  styles: [
    'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
    'https://unpkg.com/kidlat-css/css/kidlat.css'
  ]
}

Vue.use(VueHtmlToPaper, options);


    export default {
        data() {
            return{
                dataVm: {},
                name:'',
                options: [
                  { text: 'Зирка лева', value: 'А' },
                  { text: 'Народження зирки', value: 'Б' },
                ],      
                dataObject: {
                     attributes: {},
                     contracts_not_active: {},
                     contracts_active: {},
                },
                dataUser: [{
                    name: 'Alex',
                    time: '8.09.2020'
                  }, {
                    name: 'Ivan',
                    time: '8.01.2020'
                  }, {
                    name: 'Olga',
                    time: '8.02.2020'
                  }],
                motherFields: [{
                    title: 'Фамилия:',
                    data: 'dataObject.attributes.mother_name',
                    name: 'mother_name',
                  }],
                contract:{},
                indexActiveUser: 0,
                vmContract: true,
                contractSelected: false,
                getURL: "api/v2/getinfo",
                postURL: "getone",
                URLaddNewUser: "api/v2/addnewuser",
                showInput: false,
                articles: [],
                users: [],
                apis: null,
                article: {
                    id: '',
                    title: '',
                    body: ''
                },
                article_id: '',
                pagination: {},
                edit: false,
                new_child_surname: '',
                new_child_name: '',
                new_child_middle_name: '',
                rep: [],
                telephone: '4565456',
            }
        },
        created(){
            this.fetchArticles();
        },

        computed: {
            activeUser() {
              return this.dataObject.contracts_active[this.indexActiveUser]
            }
          },

        methods: {
                doSomethingOnHidden(){
      alert('hidden')
    },
            print() {
                this.$htmlToPaper('printVM');
            },
            contact(){
                this.fetchArticles();
            },
            profile(){
                this.emails();
            },
            add(){
                axios.post('getone', {user_id: 1, id: this.$refs.child.id, name: this.title}).then(res => {
                    this.users = res.data
                })
            },
            getModal(id){
                $('#addNew').modal('show');
                axios.post('api/v2/getinfo', {id : id}).then(response => {
                    this.dataObject = response.data.data
                })
                // $(this.$refs.vuemodals).on("hidden.bs.modal", this.fetchArticles)
            },
            fetchArticles(){
                axios.
                get('api/v2/collection')
                 //.then(response => console.log(response.data));
                .then(response => this.articles = response.data)
                .finally(() => console.log('Посты успешно загружены'));

            },
            emails(){
                axios.
                get('get_email')
                .then(response => this.users = response.data)
                .finally(() => console.log('Посты успешно загружены'));

            },
            getData(id){
                axios.post(this.getURL, {id : id}).then((response) => {
                this.dataObject = response.data.data
                })
            },
            saveData(){
                axios.post(this.postURL, this.dataObject)
            },
            // editNotes(event, key) {
            //     const value = event.target.value;
            //     if(value !== this.dataObject.attributes[key]){
            //         this.dataObject.attributes[key] = value;
            //         axios.post(this.postURL, {user_id: this.dataObject.id, field_name: key, field_value: value})
            //     }
            // },
            editField(e, name) {
                const value = e.target.value;
                const key = e.currentTarget.getAttribute('name');
                axios.post(this.postURL, { user_id: this.dataObject.id, field_name: name ? name : key, field_value: value })
                // key ? this.fetchArticles(): null;
            },
            closeModal(){
                $('#addNew').modal('hide');
                $('#selectModal').modal('show');
            },
            addNewUser(){
                $('#addNewUser').modal('hide');
                axios.post(this.URLaddNewUser, {child_surname: this.new_child_surname, child_name: this.new_child_name, child_middle_name: this.new_child_middle_name})
                .then(response => this.getModal(response.data));
            },
        }
    }
</script>

<style type="text/css">
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
</style>
