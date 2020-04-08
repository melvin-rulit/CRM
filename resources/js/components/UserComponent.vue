<template>
<div>
<ul class="nav nav-tabs" id="myTab" role="tablist">
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
        <h4 class="card-title">{{ api.attributes.mother_surname }} {{ api.attributes.mother_name }}  {{ api.attributes.mother_middle_name }}</h4>
        <p class="card-text">Телефон: {{ api.attributes.mother_phone }}</p>
        <p class="card-text">Телефон: {{ api.attributes.mother_dop_phone }}</p>
        <p class="card-text">Телефон: {{ api.attributes.mother_email }}</p>
    </div>
  </div>
  <div class="tab-pane fade" id="father" role="tabpanel" aria-labelledby="father-tab">Отец</div>
  <div class="tab-pane fade" id="other_relative" role="tabpanel" aria-labelledby="other_relative-tab">Родственник</div>
  <div class="tab-pane fade" id="contract" role="tabpanel" aria-labelledby="contract-tab">Контракт</div>
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