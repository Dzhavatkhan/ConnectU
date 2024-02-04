<template>
    <div class="grow">
        <div @click="open = !open" class="flex justify-center gap-3 lg:gap-5 p-2 lg:py-4 text-white lg:text-3xl border-white border-2 lg:border-[3px] rounded-lg lg:rounded-xl cursor-pointer">
            <svg viewBox="0 0 43 43" fill="none" class="w-5 lg:w-7">
                <path d="M39.9286 24.5714H24.5714V39.9286C24.5714 40.7432 24.2478 41.5244 23.6718 42.1004C23.0958 42.6764 22.3146 43 21.5 43C20.6854 43 19.9042 42.6764 19.3282 42.1004C18.7522 41.5244 18.4286 40.7432 18.4286 39.9286V24.5714H3.07143C2.25683 24.5714 1.47561 24.2478 0.899601 23.6718C0.323597 23.0958 0 22.3146 0 21.5C0 20.6854 0.323597 19.9042 0.899601 19.3282C1.47561 18.7522 2.25683 18.4286 3.07143 18.4286H18.4286V3.07143C18.4286 2.25684 18.7522 1.4756 19.3282 0.8996C19.9042 0.323595 20.6854 0 21.5 0C22.3146 0 23.0958 0.323595 23.6718 0.8996C24.2478 1.4756 24.5714 2.25684 24.5714 3.07143V18.4286H39.9286C40.7432 18.4286 41.5244 18.7522 42.1004 19.3282C42.6764 19.9042 43 20.6854 43 21.5C43 22.3146 42.6764 23.0958 42.1004 23.6718C41.5244 24.2478 40.7432 24.5714 39.9286 24.5714Z" fill="white"/>
            </svg>

            Создать пост
        </div>

        <div v-for="post in posts" :key="post" class="mt-4 lg:mt-10 last:mb-20 font-display text-white bg-grey rounded-xl lg:rounded-2xl">
            <div class="p-3 lg:p-6 lg:px-8 flex items-center gap-3 lg:gap-5 border-light-grey border-b">
                <img :src="'http://127.0.0.1:8000/images/avatars/' + post.avatar    " alt="" class="w-10 lg:w-20 block rounded-full">

                <div class="">
                    <div class="text-sm lg:text-3xl font-medium">
                        {{ post.author }}
                    </div>

                    <div class="mt-1 lg:mt-2 font-regular text-[10px] lg:text-xl">
                        {{ post.created_at }}
                    </div>
                </div>
            </div>

            <div class="p-3 lg:p-8">
                <div class="text-sm lg:text-3xl">
                    {{ post.text }}
                </div>

                <div class="flex flex-wrap gap-6" v-for="attachment in post.attachment" :key="attachment">
                    <img v-if="attachment.type == 'photo'" :src="'http://127.0.0.1:8000/images/attachments/' + attachment.name" alt="" class="block w-full lg:w-96 h-max mt-4 lg:mt-10 rounded-md lg:rounded-xl">
                    <iframe v-else allowfullscreen :src="attachment.name" class="lg:w-[600px] lg:h-[300px]"></iframe>
                </div>

                <!-- <div class="flex flex-wrap gap-6" v-if="post.type.indexOf('photo')">
                    <img v-for="attachment in post.attachment" :key="attachment" :src="'http://127.0.0.1:8000/images/attachments/' + attachment" alt="" class="block w-full lg:w-96 h-max mt-4 lg:mt-10 rounded-md lg:rounded-xl">
                </div>
                <div class="flex flex-wrap gap-6" v-if="post.type.indexOf('video')">
                    <iframe allowfullscreen v-for="attachment in post.attachment" :key="attachment" :src="attachment" class="lg:w-[600px] lg:h-[300px]"></iframe>
                </div> -->

                <div class="flex gap-2 lg:gap-3 mt-4 lg:mt-10 lg:text-3xl" v-if="post.likes.likes == 0">
                    <svg @click="like(post.id)" viewBox="0 0 36 33" fill="none" class="w-[22px] lg:w-10 cursor-pointer">
                        <path d="M18.18 27.9646L18 28.1444L17.802 27.9646C9.252 20.2136 3.6 15.0883 3.6 9.89101C3.6 6.29428 6.3 3.59673 9.9 3.59673C12.672 3.59673 15.372 5.3951 16.326 7.84087H19.674C20.628 5.3951 23.328 3.59673 26.1 3.59673C29.7 3.59673 32.4 6.29428 32.4 9.89101C32.4 15.0883 26.748 20.2136 18.18 27.9646ZM26.1 0C22.968 0 19.962 1.45668 18 3.7406C16.038 1.45668 13.032 0 9.9 0C4.356 0 0 4.33406 0 9.89101C0 16.6708 6.12 22.2278 15.39 30.6262L18 33L20.61 30.6262C29.88 22.2278 36 16.6708 36 9.89101C36 4.33406 31.644 0 26.1 0Z" fill="white"/>
                    </svg>
                </div>
                <div class="flex gap-2 lg:gap-3 mt-4 lg:mt-10 lg:text-3xl" v-else>
                    <svg v-if="!post.likes.my_like.length"  viewBox="0 0 36 33" fill="none" class="w-[22px] lg:w-10 cursor-pointer">
                        <path d="M18.18 27.9646L18 28.1444L17.802 27.9646C9.252 20.2136 3.6 15.0883 3.6 9.89101C3.6 6.29428 6.3 3.59673 9.9 3.59673C12.672 3.59673 15.372 5.3951 16.326 7.84087H19.674C20.628 5.3951 23.328 3.59673 26.1 3.59673C29.7 3.59673 32.4 6.29428 32.4 9.89101C32.4 15.0883 26.748 20.2136 18.18 27.9646ZM26.1 0C22.968 0 19.962 1.45668 18 3.7406C16.038 1.45668 13.032 0 9.9 0C4.356 0 0 4.33406 0 9.89101C0 16.6708 6.12 22.2278 15.39 30.6262L18 33L20.61 30.6262C29.88 22.2278 36 16.6708 36 9.89101C36 4.33406 31.644 0 26.1 0Z" fill="white"/>
                    </svg>

                    <svg v-else @click="like(post.id)" viewBox="0 0 36 33" fill="none" class="w-[22px] lg:w-10 cursor-pointer">
                        <path d="M18 33L15.39 30.6262C6.12 22.2278 0 16.6708 0 9.89101C0 4.33406 4.356 0 9.9 0C13.032 0 16.038 1.45668 18 3.7406C19.962 1.45668 22.968 0 26.1 0C31.644 0 36 4.33406 36 9.89101C36 16.6708 29.88 22.2278 20.61 30.6262L18 33Z" fill="white"/>
                    </svg>


                    {{ post.likes.likes }}
                </div>
            </div>
        </div>

        <div v-if="!posts" class="text-white text-5xl text-center mt-10">
            Загрузка постов...
        </div>

        <div class="mt-4 lg:mt-10 last:mb-20 font-display text-white bg-grey rounded-xl lg:rounded-2xl">
            <div class="p-3 lg:p-6 lg:px-8 flex items-center gap-3 lg:gap-5 border-light-grey border-b">
                <img src="../../../../../storage/app/public/avatars/Avatar.jpg" alt="" class="w-10 lg:w-20 block rounded-full">

                <div class="">
                    <div class="text-sm lg:text-3xl font-medium">
                        Джаватхан Джаватханов
                    </div>

                    <div class="mt-1 lg:mt-2 font-regular text-[10px] lg:text-xl">
                        11.12.23
                    </div>
                </div>
            </div>

            <div class="p-3 lg:p-8">
                <div class="text-sm lg:text-3xl">
                    Aывфывфывыфвыфвфы Aывфывфывыфвыфвфы
                    Aывфывфывыфвыфвфы Aывфывфывыфвыфвфы
                    Aывфывфывыфвыфвфы Aывфывфывыфвыфвфы
                    Aывфывфывыфвыфвфы Aывфывфывыфвыфвфы
                </div>

                <img src="../../../../../storage/app/public/img/new_year.jpg" alt="" class="block w-full mt-4 lg:mt-10 rounded-md lg:rounded-xl">

                <div class="flex gap-2 lg:gap-3 mt-4 lg:mt-10 lg:text-3xl">
                    <svg viewBox="0 0 36 33" fill="none" class="w-[22px] lg:w-10">
                        <path d="M18.18 27.9646L18 28.1444L17.802 27.9646C9.252 20.2136 3.6 15.0883 3.6 9.89101C3.6 6.29428 6.3 3.59673 9.9 3.59673C12.672 3.59673 15.372 5.3951 16.326 7.84087H19.674C20.628 5.3951 23.328 3.59673 26.1 3.59673C29.7 3.59673 32.4 6.29428 32.4 9.89101C32.4 15.0883 26.748 20.2136 18.18 27.9646ZM26.1 0C22.968 0 19.962 1.45668 18 3.7406C16.038 1.45668 13.032 0 9.9 0C4.356 0 0 4.33406 0 9.89101C0 16.6708 6.12 22.2278 15.39 30.6262L18 33L20.61 30.6262C29.88 22.2278 36 16.6708 36 9.89101C36 4.33406 31.644 0 26.1 0Z" fill="white"/>
                    </svg>

                    123
                </div>
            </div>
        </div>

        <PostModal v-if="open" @closeModal="open = false" />
    </div>
</template>

<script setup>
import {ref, watch, onMounted} from 'vue'
import PostModal from '../../modals/PostModal.vue'
import { useUserStore } from '../../../store/user-store';
let userStore = useUserStore()
import eventBus from '@/eventBus';
import axios from 'axios';

let open = ref(false)

let posts = ref(null)

watch(open, (newValue) => {
    if (newValue) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
})

onMounted(async() => {
    eventBus.on('addPost', async()=>{
        await getPosts()
    })

    await getPosts()

})
let like = async(id)=>{
    try {
        let response = await axios.get("http://127.0.0.1:8000/api/like-post/id" + id, {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
            }
        });
        getPosts();
        console.log(response + id);

    } catch (error) {
        console.log(error);

    }
}
let getPosts = async() => {
    try {
        let res = await axios('http://127.0.0.1:8000/api/posts', {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
            }
        })

        posts.value = res.data.posts

        console.log(res.data)
    } catch (err) {
        console.log(err)
    }
}
</script>
