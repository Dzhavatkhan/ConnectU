import {createRouter, createWebHistory} from 'vue-router'
// import Home from '../components/Home.vue'
import notFound from '../components/notFound.vue'
// import Chat from '../components/Chat.vue';
import Post from '../components/Post.vue';
import UserPage from '../components/UserPage.vue'

import ProfileView from '../views/ProfileView.vue'
import FeedView from '../views/FeedView.vue'
import FriendsView from '../views/FriendsView.vue'
import MessangerView from '../views/MessangerView.vue'
import ChatSection from '../components/sections/MessangerView/ChatSection.vue'

let routes = [
    {
        path: '/',
        redirect: '/feed'
    },
    {
        path: '/profile',
        component: ProfileView,
        name: 'profile'
    },
    {
        path: "/feed",
        component: FeedView,
        name: 'feed'
    },
    {
        path: "/friends",
        component: FriendsView,
        name: "friends"
    },
    {
        path: "/messanger",
        component: MessangerView,
        name: "messanger",
    },
    {
        path: '/messanger',
        component: ChatSection,
        name: 'chat'
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
