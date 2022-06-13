<template>
    <div class="container mb-5">
        <div class="row row-cols-1 g-3 mb-4">

            <div class="col" v-for="article in articles" :key="article.id" @click="$router.push('/articles/' + article.slug)">
                <div class="card shadow-sm">
                    <img
                        :src="article.cover_url"
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
        <div class="row">
            <nav>
                <ul class="pagination justify-content-center">
                    <li
                        class="page-item"
                        v-for="link in paginationLinks"
                        :class="{ disabled: !link.url, active: link.active }"
                        :key="link.label"
                    >
                        <a
                            href="#"
                            class="page-link"
                            v-html="link.label"
                            @click.prevent="changePage(link.url)"
                        ></a>
                    </li>
                </ul>
            </nav>
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
            articles: [],
            paginationLinks: [],
            currentPageUrl: "/api" + this.$route.path
        }
    },
    methods: {
        async fetchArticles () {
            try {
                const response = await axios.get(this.currentPageUrl);
                this.articles = response.data.data;
                this.paginationLinks = response.data.meta.links;
            } catch (e) {
                alert("Error");
            }
        },
        changePage(url) {
            this.currentPageUrl = url;
            this.fetchArticles();
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