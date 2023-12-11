<template>
    <div>

        <div class="chat" v-for="post in posts" :key=post.id>
            <h2 class="name" @click="getPost(post.id)">{{ post.text }}</h2>
            <p class="lalo">{{ post.like }}</p>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import {useRouter} from 'vue-router'

let router = useRouter();
    let posts = ref([])
    onMounted( async() => {
        getPosts()
    })

    const getPosts = async () => {
        let response = await axios.get("/api/posts")
        posts.value = response.data.posts
    }
    const getPost = (id) => {
        router.push('/post/id' + id)
    }
</script>

<style scoped>

    .name{
        cursor: pointer;
    }
    .name:hover{
        text-decoration: underline;
        opacity: 0.8;
    }
    .chat{
        margin-top: 50px;
        margin-left: 250px;
    }
    .lalo{
        width:500px;
        overflow:hidden;
    }
</style>
