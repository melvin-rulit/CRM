<template>
    <div>
        <h3>Посты в базе даных</h3>
        <div class="card mb-3" v-for="article in articles">
            <div class="card-body">
                <b>{{ article.name }} - </b>
                <span>{{ article.email }}</span>
            </div>
        </div>
    </div>

    
</template>

<script>
    export default {
              data:{
        articles: null,
      },
        data() {
            return{
                articles: [],
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
            fetchArticles(){
                axios.
                get('http://127.0.0.1:8000/admin/users/create')
                 // .then(response => console.log(response.data));
                .then(response => this.articles = response.data)
                .finally(() => console.log('Посты успешно загружены'));

            },
            deleteArticle(id){
                // console.log(url)
                axios.
                post('api/article/' + id)
                // delete('api/article/' + id)
                .then(response => console.log(response.data));
                this.fetchArticles();
            }
        }
    }
</script>