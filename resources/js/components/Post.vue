<template>
    <div>
        <h2>
            {{ post.user }}
        </h2>
        <p>
            {{ post.text }}
        </p>
        <div class="like">
            <button @click="like(post.id)">Like</button>
            <p class="">{{ post.like }}</p>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";

let post = ref([])
let props = defineProps({
    id: {
        type:String,
        default: ''
    }
})
onMounted( async() => [
    getPost()
])

const getPost = async () => {
    let response = await axios.get(`/api/post/id${props.id}`)
    console.log(props.id, response);
    post.value = response.data.post[0]
}
const like = async () => {
    let response = await axios.get(`/api/like/${props.id}`)
    console.log(response.data.post);
    getPost()
}
</script>

<style scoped>

</style>
