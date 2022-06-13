<template>
    <div class="container mb-5">
        <div class="row">
            <img :src="cover_url">
        </div>
        <div class="row">
            <h1>{{ title }}</h1>
            <div v-if="id !== 0" class="d-flex justify-content-start align-items-center mb-2">
                <small class="text-muted">
                    <i class="fa-solid fa-eye"></i>
                    {{ views }}
                </small>
                <like-button :articleId="id" :likes="likes" :liked="false" class="ms-3"></like-button>
            </div>
            <div class="mb-4">
                <a v-for="tag in tags" :key="tag.slug" class="btn btn-secondary btn-sm me-1" :href="'/#/tags/' + tag.slug" >{{ tag.label }}</a>
            </div>
        </div>
        <div class="row mb-4" v-html="body"></div>
        <div v-if="id !== 0" class="row border-top pt-2">
            <p class="display-6">Оставить комментарий</p>
            <form v-if="!comment_posted" @submit.prevent="submitComment" :class="[comment_posting ? 'opacity-50' : '']">
                <div class="mb-3">
                    <input v-model.trim="comment_title" type="text" :class="[comment_title_error === '' ? '' : 'is-invalid',  'form-control']" id="commentTitle" placeholder="Тема сообщения">
                    <div class="invalid-feedback">{{ comment_title_error }}</div>
                </div>
                <div class="mb-3">                    
                    <textarea v-model.trim="comment_body" :class="[comment_body_error === '' ? '' : 'is-invalid',  'form-control']" class="form-control" id="commentBody" placeholder="Текст сообщения" rows="3"></textarea>
                    <div class="invalid-feedback">{{ comment_body_error }}</div>
                </div>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
            <div v-else class="alert alert-success" role="alert">
                <h4 class="alert-heading">Комментарий отправлен</h4>
                <p>Он появится на сайте после обработки</p>
            </div>
        </div>
        <div class="row pt-3">
            <div v-for="comment in comments" :key="comment.id" class="card mb-3 bg-light">
                
                <div class="card-body">
                    <h5 class="card-title">{{ comment.subject }}</h5>                        
                    <p class="card-text">{{ comment.body }}</p>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import LikeButton from './UI/LikeButton.vue';
export default {
    components: {
        LikeButton
    },
    data () {
        return {
            id: 0,
            title: '',
            body: '',
            cover_url: '',
            likes: 0,
            views: 0,
            tags: [],
            comments: [],

            comment_posting: false, // для блокировки формы, пока ответ не пришел
            comment_posted: false, // для замены формы на alert

            comment_title: '',
            comment_title_error: '',
            comment_body: '',
            comment_body_error: ''
        }
    },
    methods: {
        async fetchArticle () {
            try {
                const response = await axios.get("/api/articles/" + this.$route.params.slug);

                ['id', 'title', 'body', 'cover_url', 'likes', 'views', 'tags', 'comments']
                    .forEach(key => this[key] = response.data.data[key]);

            } catch (e) {
                alert('Error');
            }
        },
        async submitComment () {
            if (this.comment_posting) {
                return;
            }

            this.comment_posting = true;

            try {
                const response = await axios.post("/api/comments/create", {
                    article_id: this.id,
                    subject: this.comment_title,
                    body: this.comment_body
                });

                this.comment_posted = true;
                
            } catch(e) {
                if (e.response) {
                    this.comment_title_error = e.response.data?.errors?.subject
                        ? e.response.data.errors.subject[0]
                        : '';
                    this.comment_body_error = e.response.data?.errors?.body
                        ? e.response.data.errors.body[0]
                        : '';
                }
            } finally {
                this.comment_posting = false;
            }
        }
    },
    mounted () {
        this.fetchArticle();

        setTimeout(async () => {
            axios
                .get('/api/view-article/' + this.id)
                .then(response => {
                    this.views = response.data.views;
                })
                .catch(e => {
                    alert('Error');
                });
        }, 5000);
    }
}
</script>
<style scoped>
    
</style>