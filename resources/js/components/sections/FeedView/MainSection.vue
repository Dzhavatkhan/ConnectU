<template>
    <div class="grow">
        <div @click="open = !open" class="flex justify-center gap-3 lg:gap-5 p-2 lg:py-4 text-white lg:text-3xl border-white border-2 lg:border-[3px] rounded-lg lg:rounded-xl cursor-pointer transition-all hover:text-light-black hover:bg-white duration-100 group">
            <svg viewBox="0 0 43 43" fill="none" class="w-5 lg:w-7">
                <path d="M39.9286 24.5714H24.5714V39.9286C24.5714 40.7432 24.2478 41.5244 23.6718 42.1004C23.0958 42.6764 22.3146 43 21.5 43C20.6854 43 19.9042 42.6764 19.3282 42.1004C18.7522 41.5244 18.4286 40.7432 18.4286 39.9286V24.5714H3.07143C2.25683 24.5714 1.47561 24.2478 0.899601 23.6718C0.323597 23.0958 0 22.3146 0 21.5C0 20.6854 0.323597 19.9042 0.899601 19.3282C1.47561 18.7522 2.25683 18.4286 3.07143 18.4286H18.4286V3.07143C18.4286 2.25684 18.7522 1.4756 19.3282 0.8996C19.9042 0.323595 20.6854 0 21.5 0C22.3146 0 23.0958 0.323595 23.6718 0.8996C24.2478 1.4756 24.5714 2.25684 24.5714 3.07143V18.4286H39.9286C40.7432 18.4286 41.5244 18.7522 42.1004 19.3282C42.6764 19.9042 43 20.6854 43 21.5C43 22.3146 42.6764 23.0958 42.1004 23.6718C41.5244 24.2478 40.7432 24.5714 39.9286 24.5714Z" fill="white" class="group-hover:fill-light-black"/>
            </svg>

            Создать пост
        </div>

        <div @click="(openCategories = !openCategories) && (openCategories ? getCategories() : '')" class="mt-4 lg:mt-8 flex justify-center gap-3 lg:gap-5 p-2 lg:py-4 text-white lg:text-3xl border-white border-2 lg:border-[3px] rounded-lg lg:rounded-xl cursor-pointer transition-all hover:text-light-black hover:bg-white duration-100 group">
            <span>{{activeCategory}}</span>

            <svg viewBox="0 0 50 26" fill="none" class="w-[17px] lg:w-7">
                <path d="M46.5295 0.582918L24.9978 21.3046L3.46612 0.582918C3.08142 0.211941 2.56499 0.00425292 2.02723 0.00425292C1.48946 0.00425292 0.973036 0.211941 0.588336 0.582918C0.402065 0.763102 0.254083 0.978169 0.15306 1.21553C0.0520356 1.45288 0 1.70776 0 1.96522C0 2.22268 0.0520356 2.47755 0.15306 2.7149C0.254083 2.95226 0.402065 3.16733 0.588336 3.34751L23.4943 25.3962C23.8965 25.7833 24.4361 26 24.9978 26C25.5595 26 26.099 25.7833 26.5013 25.3962L49.4073 3.35177C49.5948 3.17145 49.7439 2.95585 49.8457 2.71771C49.9476 2.47957 50 2.2237 50 1.96522C50 1.70673 49.9476 1.45086 49.8457 1.21272C49.7439 0.974578 49.5948 0.758983 49.4073 0.578663C49.0226 0.207686 48.5061 0 47.9684 0C47.4306 0 46.9142 0.207686 46.5295 0.578663V0.582918Z" fill="white" class="group-hover:fill-light-black"/>
            </svg>
        </div>

        <div v-if="openCategories" class="mt-2  border-white border-[4px] last:border-b-0 rounded-lg text-center text-white">
            <div v-for="category in categories" :key="category.id" @click="clickCategory(category)" class="relative flex justify-center items-center py-2 lg:py-4 lg:text-2xl border-white border-b-[4px] last:border-b-0 cursor-pointer transition-all duration-100 hover:bg-white hover:text-light-black">
                {{ category.name }}

                <!-- <svg v-if="activeCategoriesId.includes(category.id)" viewBox="0 0 20 17" fill="none" class="absolute right-5 w-3 lg:w-5">
                    <path d="M19 1L6.4 16L1 10.375" stroke="#8B8B8B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg> -->
            </div>

            <div @click="clickCategory(false, true)" class="relative flex justify-center items-center py-2 lg:py-4 lg:text-2xl border-grey border-b-2 last:border-b-0 cursor-pointer transition-all duration-100 hover:bg-white hover:text-light-black">
                Все

                <!-- <svg v-if="activeCategoriesId.includes(category.id)" viewBox="0 0 20 17" fill="none" class="absolute right-5 w-3 lg:w-5">
                    <path d="M19 1L6.4 16L1 10.375" stroke="#8B8B8B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg> -->
            </div>
        </div>

        <div v-for="post in posts" :key="post" class="mt-4 lg:mt-10 last:mb-20 font-display text-white bg-grey rounded-xl lg:rounded-2xl">
            <div class="p-3 lg:p-6 lg:px-8 flex items-center gap-3 lg:gap-5 border-light-grey border-b">
                <img v-if="post.avatar" :src="'http://127.0.0.1:8000/images/avatars/' + post.avatar" alt="" class="w-10 lg:w-20 block rounded-full">
                <img v-else :src="'http://127.0.0.1:8000/images/avatars/default.jpg'" alt="" class="w-10 lg:w-20 block rounded-full">

                <div class="">
                    <div class="text-sm lg:text-3xl font-medium">
                        {{ post.author }}
                    </div>

                    <div class="mt-2 lg:mt-3 flex items-center gap-2 lg:gap-4 font-regular text-[10px] lg:text-xl">
                        {{ post.created_at }}
                    </div>
                </div>
            </div>

            <div class="p-3 lg:p-8">
                <div class="text-sm lg:text-3xl">
                    {{ post.text }}
                </div>
                <div class="flex flex-wrap gap-6">
                    <div  v-for="attachment in post.attachment" :key="attachment">
                        <img v-if="attachment.type == 'photo'" :src="'http://127.0.0.1:8000/images/attachments/' + attachment.name" alt="" class="block w-full lg:w-96 h-max mt-4 lg:mt-10 rounded-md lg:rounded-xl">
                        <iframe v-else allowfullscreen :src="attachment.name" class="w-full lg:w-[600px] lg:h-[300px] mt-4 lg:mt-10"></iframe>
                    </div>
                </div>


                <!-- <div class="flex flex-wrap gap-6" v-if="post.type.indexOf('photo')">
                    <img v-for="attachment in post.attachment" :key="attachment" :src="'http://127.0.0.1:8000/images/attachments/' + attachment" alt="" class="block w-full lg:w-96 h-max mt-4 lg:mt-10 rounded-md lg:rounded-xl">
                </div>
                <div class="flex flex-wrap gap-6" v-if="post.type.indexOf('video')">
                    <iframe allowfullscreen v-for="attachment in post.attachment" :key="attachment" :src="attachment" class="lg:w-[600px] lg:h-[300px]"></iframe>
                </div> -->

                <div class="flex items-center justify-between mt-4 lg:mt-10">
                    <div class="flex gap-2 lg:gap-3  lg:text-3xl" v-if="post.likes.likes == 0">
                        <svg @click="like(post.id)" viewBox="0 0 36 33" fill="none" class="w-[22px] lg:w-10 cursor-pointer">
                            <path d="M18.18 27.9646L18 28.1444L17.802 27.9646C9.252 20.2136 3.6 15.0883 3.6 9.89101C3.6 6.29428 6.3 3.59673 9.9 3.59673C12.672 3.59673 15.372 5.3951 16.326 7.84087H19.674C20.628 5.3951 23.328 3.59673 26.1 3.59673C29.7 3.59673 32.4 6.29428 32.4 9.89101C32.4 15.0883 26.748 20.2136 18.18 27.9646ZM26.1 0C22.968 0 19.962 1.45668 18 3.7406C16.038 1.45668 13.032 0 9.9 0C4.356 0 0 4.33406 0 9.89101C0 16.6708 6.12 22.2278 15.39 30.6262L18 33L20.61 30.6262C29.88 22.2278 36 16.6708 36 9.89101C36 4.33406 31.644 0 26.1 0Z" fill="white"/>
                        </svg>
                    </div>

                    <div class="flex gap-2 lg:gap-3 lg:text-3xl" v-else>
                        <svg v-if="!post.likes.my_like.length" @click="like(post.id)" viewBox="0 0 36 33" fill="none" class="w-[22px] lg:w-10 cursor-pointer">
                            <path d="M18.18 27.9646L18 28.1444L17.802 27.9646C9.252 20.2136 3.6 15.0883 3.6 9.89101C3.6 6.29428 6.3 3.59673 9.9 3.59673C12.672 3.59673 15.372 5.3951 16.326 7.84087H19.674C20.628 5.3951 23.328 3.59673 26.1 3.59673C29.7 3.59673 32.4 6.29428 32.4 9.89101C32.4 15.0883 26.748 20.2136 18.18 27.9646ZM26.1 0C22.968 0 19.962 1.45668 18 3.7406C16.038 1.45668 13.032 0 9.9 0C4.356 0 0 4.33406 0 9.89101C0 16.6708 6.12 22.2278 15.39 30.6262L18 33L20.61 30.6262C29.88 22.2278 36 16.6708 36 9.89101C36 4.33406 31.644 0 26.1 0Z" fill="white"/>
                        </svg>

                        <svg v-else @click="like(post.id)" viewBox="0 0 36 33" fill="none" class="w-[22px] lg:w-10 cursor-pointer">
                            <path d="M18 33L15.39 30.6262C6.12 22.2278 0 16.6708 0 9.89101C0 4.33406 4.356 0 9.9 0C13.032 0 16.038 1.45668 18 3.7406C19.962 1.45668 22.968 0 26.1 0C31.644 0 36 4.33406 36 9.89101C36 16.6708 29.88 22.2278 20.61 30.6262L18 33Z" fill="white"/>
                        </svg>


                        {{ post.likes.likes }}
                    </div>

                    <div class="flex gap-2 lg:gap-4">
                        <div v-for="cat in post.category" :key="cat" class="max-lg:text-[10px] lg:text-xl h-max p-2 bg-light-black text-white rounded-[4px]">
                            {{ cat.name }}
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div v-if="!posts" class="text-white text-5xl text-center mt-10">
            Нет постов
        </div>

        <!-- <div class="mt-4 lg:mt-10 last:mb-20 font-display text-white bg-grey rounded-xl lg:rounded-2xl">
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
                </div>w

                <img src="../../../../../storage/app/public/img/new_year.jpg" alt="" class="block w-full mt-4 lg:mt-10 rounded-md lg:rounded-xl">

                <div class="flex gap-2 lg:gap-3 mt-4 lg:mt-10 lg:text-3xl">
                    <svg viewBox="0 0 36 33" fill="none" class="w-[22px] lg:w-10">
                        <path d="M18.18 27.9646L18 28.1444L17.802 27.9646C9.252 20.2136 3.6 15.0883 3.6 9.89101C3.6 6.29428 6.3 3.59673 9.9 3.59673C12.672 3.59673 15.372 5.3951 16.326 7.84087H19.674C20.628 5.3951 23.328 3.59673 26.1 3.59673C29.7 3.59673 32.4 6.29428 32.4 9.89101C32.4 15.0883 26.748 20.2136 18.18 27.9646ZM26.1 0C22.968 0 19.962 1.45668 18 3.7406C16.038 1.45668 13.032 0 9.9 0C4.356 0 0 4.33406 0 9.89101C0 16.6708 6.12 22.2278 15.39 30.6262L18 33L20.61 30.6262C29.88 22.2278 36 16.6708 36 9.89101C36 4.33406 31.644 0 26.1 0Z" fill="white"/>
                    </svg>

                    123
                </div>
            </div>
        </div> -->

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

let categories = ref(null)
let openCategories = ref(false)

let activeCategory = ref('Категории')

let getCategories = async() => {
    try {
        let res = await axios('http://127.0.0.1:8000/api/categories', {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
            }
        })

        categories.value = res.data.categories

        console.log(res)
    } catch (err) {
        console.log(err)
        // errors.value = err.response.data.errors
    }
}

let clickCategory = async(category, isAll) => {
    if (!isAll) {
        activeCategory.value = category.name

        let res = await axios('http://127.0.0.1:8000/api/sort_category/' + category.id, {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
            }
        })
        posts.value = res.data.posts

        console.log(res.data)
    } else {
        activeCategory.value = 'Категории'
        await getPosts()
    }

}

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
