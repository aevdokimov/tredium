require('./bootstrap');

import { createApp } from 'vue';
import { createRouter, createWebHashHistory } from 'vue-router';
import HomePage from './components/HomePage.vue';
import Articles from './components/Articles.vue';
import Article from './components/Article.vue';

const routes = [
    { path: '/', component: HomePage },
    { path: '/articles', component: Articles },
    { path: '/articles/:slug', component: Article },
    { path: '/tags/:slug', component: Articles }
];

const router = createRouter({
    history: createWebHashHistory(),
    linkActiveClass: 'active',
    routes
});

import App from './App.vue';
const app = createApp(App);

app.use(router);

app.mount('#app');