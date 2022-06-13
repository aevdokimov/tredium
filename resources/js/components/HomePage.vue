<template>
    <div class="bg-light">
        <div class="container pt-3 pb-5 mb-5">
            <h1 class="display-1">Успех</h1>
            <p>Для молодых и успешных</p>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

            <div class="col" v-for="article in articles" :key="article.id" @click="$router.push('/articles/' + article.slug)">
                <div class="card shadow-sm">
                    <img
                        :src="article.cover_thumbnail_url"
                        class="card-img-top"
                    >

                    <div class="card-body">
                        <h5 class="card-title">{{ article.title }}</h5>
                        <p class="card-text">{{ article.excerpt }}</p>
                        <div
                            class="d-flex justify-content-between align-items-center"
                        >
                            <small class="text-muted">
                                <i class="fa-solid fa-eye"></i>
                                {{ article.views }}
                            </small>

                            <like-button :articleId="article.id" :likes="article.likes" :liked="false"></like-button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</template>
<script>
import axios from "axios";
import LikeButton from './UI/LikeButton.vue';
export default {
    components: { LikeButton },
    data() {
        return {
            articles: []
        }
    },
    methods: {
        async fetchArticles () {
            try {
                const response = await axios.get('/api');
                this.articles = response.data.data;
            } catch (e) {
                alert("Error");
            }
        },
    },
    mounted() {
        this.fetchArticles();
    }
}
</script>
<style scoped>
    div.card {
        cursor: pointer;
    }
</style>