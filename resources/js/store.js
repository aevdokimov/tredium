import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core';

export const useMainStore = defineStore({
    id: 'main',
    state: () => ({
        likedIds: useStorage('likedIds', []),
    }),
    getters: {
        isLiked: (state) => {
            return (articleId) => state.likedIds.includes(articleId)
        },
    },
    actions: {
        like (articleId) {
            if (!this.isLiked(articleId)) {
                this.likedIds.push(articleId);
            }
        },
        unlike (articleId) {
            this.likedIds = this.likedIds.filter((value) => value != articleId);
        }
    }
});