<template>
    <button type="button" :class="[like_processing ? 'opacity-50' : '', 'btn', 'btn-light']" @click.stop="vote">
        <i :class="[liked ? 'fa-solid' : 'fa-regular', 'fa-heart']"></i>
        {{ localLikes }}
    </button>
</template>
<script>
import { useMainStore } from "../../store.js";
export default {
    setup() {
        const store = useMainStore();
        return { store };
    },
    data() {
        return {
            localLikes: JSON.parse(JSON.stringify(this.likes)),
            liked: false,
            like_processing: false
        }
    },
    props: {
        articleId: {
            type: Number,
            required: true
        },
        likes: {
            type: Number,
            required: true
        }
    },
    methods: {
        async vote () {
            if (this.like_processing) {
                return;
            }

            this.like_processing = true;

            try {
                if (this.liked) {
                    const response = await axios.get("/api/likes/unlike/" + this.articleId);                    
                    this.store.unlike(this.articleId);
                    this.localLikes--;              
                } else {
                    const response = await axios.get("/api/likes/like/" + this.articleId);
                    this.store.like(this.articleId);
                    this.localLikes++;
                }
                this.liked = !this.liked
            } catch (e) {
                alert('Error');
            } finally {
                this.like_processing = false;
            }
        }
    },
    mounted() {
        this.liked = this.store.isLiked(this.articleId);
    }
}
</script>
<style scoped>
    
</style>