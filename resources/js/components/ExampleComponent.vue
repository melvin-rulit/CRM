<template>

    <div class="container">
        <h1>Новый регион</h1>
        <div class="card">
                <div class="card-body">
                    <label class="required" for="name">Введите имя</label>
                    <input class="form-control" type="text" name="name" id="name" v-model="name">
                </div>
                <div class="form-group ml-4">
                    <button class="btn btn-danger" type="submit" @click="add">
                        Добавить
                    </button>
                    <button class="btn btn-danger" @click="fetchArticles">
                        Получить
                    </button>
                </div>
        </div>

    <ul class="list-group">
        <li v-for="user in users" class="list-group-item list-group-item-action">{{ user.id }} - {{ user.name }} - {{ user.email }}</li>
    </ul>


        <div class="card">
    <div class="card-header">
        Список пользователей
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            1
                        </th>
                        <th>
                            2
                        </th>
                        <th>
                            3
                        </th>
                        <th>
                            4
                        </th>
                    </tr>
                </thead>
                <tbody>

                        <tr v-for="article in articles">
                            <td>

                            </td>
                            <td>
                                {{ article.id }}
                            </td>
                            <td>
                                {{ article.name }}
                            </td>
                            <td>
                                {{ article.email }}
                            </td>
                            <td>
                                    <a class="btn btn-sm btn-primary" href="">
                                        Посмотреть
                                    </a>

                                    <a class="btn btn-sm btn-info" href="">
                                        Редактировать
                                    </a>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


    </div>


</template>

<script>
    export default {
              data:{
        articles: null,
        users: null,
      },
        data() {
            return{
                articles: [],
                users: [],
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
            // this.fetchArticles();
        },

        methods: {
            add(){
                axios.post('getone', {name: this.name}).then(res => {
                    this.users = res.data
                })
            },
            fetchArticles(){
                axios.
                get('get')
                 //.then(response => console.log(response.data));
                .then(response => this.articles = response.data)
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


