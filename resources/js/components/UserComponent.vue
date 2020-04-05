<template>
                <tbody>

                        <tr v-for="article in articles">
                            <td>

                            </td>
                            <td>
                                {{ article.name }}
                            </td>
                            <td>
                                {{ article.surname }}
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
            this.fetchArticles();
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


