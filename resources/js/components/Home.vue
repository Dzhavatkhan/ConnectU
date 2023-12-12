<template>
    <div class="search">
        <div class="search-form">
            <input type="search" v-bind:class="{'focused': form.search}" v-on:keyup="searching" name="search" v-model="form.search" id="">
            <!-- <input type="submit" @click="searching()"> -->
        </div>
        <div class="search-result" v-for="result in results" :key="result.id">
            <p @click="getUser(result.id)">{{ result.name}}</p>
        </div>
    </div>
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

let form = ref({
    search: ''
})
let results = ref([])
const searching = async () => {
    let response = await axios.post("/api/search_people", {
        search: form.value.search
    })
    results.value = response.data.result
    console.log(response);
}
let router = useRouter();
    let posts = ref([])
    onMounted( async() => {
        getPosts()
        // searching()
    })

    const getPosts = async () => {
        let response = await axios.get("/api/posts")
        posts.value = response.data.posts
    }
    const getPost = (id) => {
        router.push('/post/id' + id)
    }
    const getUser = (id) => {
        location.href = "/user/id" + id;
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
