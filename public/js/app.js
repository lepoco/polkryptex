import { createApp, h } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import App from './../vue/App.vue.js';

const root = document.getElementById('app');
const path = './../vue/';

const routes = [//each import will be loaded when route is active
    { path: '/', component: () => import(path + './Home.vue.js') },
    { path: '/about', component: () => import(path + './About.vue.js') },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

const app = createApp({
    render: () => h(App),
});

app.use(router);
app.mount(root);