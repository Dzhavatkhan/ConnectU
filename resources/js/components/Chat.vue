<template>
    <div class="chat">
        <h2>
            {{ chat.participant}}

        </h2>
        <p>
            {{ chat.message}}
        </p>

    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";

    let chat = ref([])
    let props = defineProps({
        id: {
            type:String,
            default: ''
        }
    })
    onMounted( async() => [
        getChat()
    ])

    const getChat = async () => {
        let response = await axios.get(`/api/chat/id${props.id}`)
        console.log(props.id, response);
        chat.value = response.data.chat[0]
    }
</script>

<style scoped>

</style>
