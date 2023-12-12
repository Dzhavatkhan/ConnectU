import {createRouter, createWebHistory} from 'vue-router'
import Home from '../components/Home.vue'
import notFound from '../components/notFound.vue'
import Chat from '../components/Chat.vue';
import Post from '../components/Post.vue';
import UserPage from '../components/UserPage.vue'


let routes = [
    {
        path: "/",
        component: Home,
        name: Home
    },
    {
        path: "/:patchMatch(.*)*",
        component: notFound,
        name: notFound
    },
    {
        path: "/user/id:id",
        component: UserPage,
        name: UserPage,
        props: true
    },
    {
        path: "/chat/id:id",
        component: UserPage,
        name: UserPage,
        props: true
    },
    {
        path: "/post/id:id",
        component: Post,
        name: Post,
        props: true
    }
]


let router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
