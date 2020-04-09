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
                <a class="btn btn-sm btn-success" href="javascript:void(0)">Добавить клиента</a>
                <a class="btn btn-sm btn-info" href="javascript:void(0)">Фильтр</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

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

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10">
                        </th>
                        <th>
                            Фамилия
                        </th>
                        <th>
                            Имя
                        </th>
                        <th>
                            Отчество
                        </th>
                        <th>
                            Возраст
                        </th>
                        <th>
                            ХЗ
                        </th>
                    </tr>
                </thead>
                <tbody v-for="article in articles">
                        <tr v-for="ar in article">
                            <td>

                            </td>
                            <td>
                                <a href="javascript:void(0)" v-on:click="getModal(ar.id)">{{ ar.attributes.child_surname }}</a>
                            </td>
                            <td>
                                {{ ar.attributes.child_name }}
                            </td>
                            <td>
                                {{ ar.attributes.child_middle_name }}
                            </td>
                            <td>
                                {{ ar.attributes.age }} лет
                            </td>
                            <td>
                                3
                            </td>
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
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
</div>
</div>


<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content" v-for="api in apis">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">Карточка ребенка  &nbsp {{ api.attributes.child_surname }} {{ api.attributes.child_name }}</h4>
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
    <div class="col-md-8">
      <div class="card-body">
        <h4 class="card-title">{{ api.attributes.child_surname }}</h4>
        <h4 class="card-title">{{ api.attributes.child_name }}</h4>
        <h4 class="card-title">{{ api.attributes.child_middle_name }}</h4>
        <p class="card-text">{{ api.attributes.child_birthday }} ({{ api.attributes.age }} лет)</p>
        <h4 class="card-title mb-3">"Зирка Лева"</h4>
        <h6 class="text-uppercase text-muted mb-2">Люберецкий филиал</h6>
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
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p class="card-text">{{ api.attributes.mother_surname }} {{ api.attributes.mother_name }}  {{ api.attributes.mother_middle_name }}</p>
                <p class="card-text">Телефон: {{ api.attributes.mother_phone }}</p>
                <p class="card-text">Доп Телефон: {{ api.attributes.mother_dop_phone }}</p>
                <p class="card-text">Почта: {{ api.attributes.mother_email }}</p>
            </div>
            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Примечания:</label>
                    <textarea class="form-control" id="mother_notes" rows="3"></textarea>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="tab-pane fade" id="father" role="tabpanel" aria-labelledby="father-tab">
        <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p class="card-text">{{ api.attributes.father_surname }} {{ api.attributes.father_name }}  {{ api.attributes.father_middle_name }}</p>
                <p class="card-text">Телефон: {{ api.attributes.father_phone }}</p>
                <p class="card-text">Доп Телефон: {{ api.attributes.father_dop_phone }}</p>
                <p class="card-text">Почта: {{ api.attributes.father_email }}</p>
            </div>
            <div class="col-md-6">
                 <div class="form-group">
                    <label for="">Примечания:</label>
                    <textarea class="form-control" id="mother_notes" rows="3"></textarea>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="tab-pane fade" id="other_relative" role="tabpanel" aria-labelledby="other_relative-tab">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p class="card-text">{{ api.attributes.other_relative_surname }} {{ api.attributes.other_relative_name }}  {{ api.attributes.other_relative_middle_name }}</p>
                    <p class="card-text">Телефон: {{ api.attributes.other_relative_phone }}</p>
                    <p class="card-text">Доп Телефон: {{ api.attributes.other_relative_dop_phone }}</p>
                    <p class="card-text">Почта: {{ api.attributes.other_relative_email }}</p>
                </div>
                <div class="col-md-6">
                   <div class="form-group">
                    <label for="">Примечания:</label>
                    <textarea class="form-control" id="mother_notes" rows="3"></textarea>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="tab-pane fade" id="contract" role="tabpanel" aria-labelledby="contract-tab">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p class="card-text text-center">"Зирка Лева"</p>



        <div class="table-responsive">
            <table class=" table table-bordered table-hover datatable datatable-User">
                <tbody>
                        <tr>
                            <td>
                                Начало:
                            </td>
                            <td>
                                8.09.2020
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Окончание:
                            </td>
                            <td>
                                8.09.2021
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Окончание факт:
                            </td>
                            <td>
                                8.09.2020
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Заморозки:
                            </td>
                            <td>
                                24 | 15 | 9
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Тренировки:
                            </td>
                            <td>
                                81 | 28 | 53
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>

<p>Оплаты: 
    <span class="text-muted ml-2" data-toggle="tooltip" data-placement="bottom" title="Дата оплаты - 23.05.2015">4212</span>
    <a href="javascript:void(0)" class="text-success ml-2" v-on:click="getModalSale()">3159</a>
    <span class="text-danger ml-2">3348</span>
</p>
<p>Сумма и остаток: <span class="ml-2">10530 (3159)</span></p>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <p class="card-text text-center">Прошлые контракты</p>
                    <p><a href="javascript:void(0)" class="text-muted">"Вперед до зирок"  &nbsp 8.12.16 - 28.10.17</a></p>
                    <p><a href="javascript:void(0)" class="text-muted">"Народження зирки" &nbsp 30.10.17 - 25.08.18</a></p>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">История</div>
  <div class="tab-pane fade" id="interests" role="tabpanel" aria-labelledby="interests-tab">Интересы</div>
</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

</div>






</template>

<script>


    export default {
      //         data:{
      //   articles: null,
      //   users: null,
      //   posts: null,
      // },
        data() {
            return{
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
                edit: false
            }
        },
        created(){
            this.fetchArticles();
        },

        methods: {
            contact(){
                this.fetchArticles();
            },
            profile(){
                this.emails();
            },
            add(){
                axios.post('getone', {name: this.name}).then(res => {
                    this.users = res.data
                })
            },
            getModal(id){
                $('#addNew').modal('show');
                axios.post('api/v2/getinfo', {id : id}).then(response => {
                    this.apis = response.data
                    console.log(response)
                })
            },
            getModalSale(){
                // $('#modalSale').modal('show');
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
                 //.then(response => console.log(response.data));
                .then(response => this.users = response.data)
                .finally(() => console.log('Посты успешно загружены'));

            },
            // getOne(){
            //     axios.
            //     post('getOne/1')
            //     // delete('api/article/' + id)
            //     .then(response => console.log(response.data));
            //     this.fetchArticles();
            // },
            // countDown: function(){
            //     var input = this.message;
            //     alert(input);
            // },
        }
    }


</script>

<style type="text/css">
    .table td, .table th {
        padding: 10px;
        font-size: 14px;
    }
</style>