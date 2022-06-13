<template>
    <button type="button" :class="[like_processing ? 'opacity-50' : '', 'btn', 'btn-light']" @click.stop="vote">
        <i :class="[liked ? 'fa-solid' : 'fa-regular', 'fa-heart']"></i>
        {{ localLikes }}
    </button>
</template>
<script>
export default {
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
                var lsLiked = localStorage.getItem("liked");
                if (this.liked) {
                    const response = await axios.get("/api/likes/unlike/" + this.articleId);                    
                    lsLiked = lsLiked.replace('['+this.articleId+']', '');
                    this.localLikes--;              
                } else {
                    const response = await axios.get("/api/likes/like/" + this.articleId);
                    lsLiked += '['+this.articleId+']';
                    this.localLikes++;
                }
                localStorage.setItem("liked", lsLiked);
                this.liked = !this.liked
            } catch (e) {
                alert('Error');
            } finally {
                this.like_processing = false;
            }
        }
    },
    mounted() {
        this.liked = localStorage.getItem("liked").includes('['+this.articleId+']');
    }
}
</script>
<style scoped>
    
</style>