<template>
    <div class="grow">
        <div class="last:mb-20 font-display text-white bg-grey rounded-xl lg:rounded-2xl">
            <div class="p-3 lg:p-6 lg:px-8 flex items-center gap-3 lg:gap-8 border-light-grey border-b">
                <svg viewBox="0 0 30 30" fill="none" class="w-[30px] lg:w-12">
                    <path d="M21.6667 21.6667L27 27M3 13.6667C3 16.4956 4.12381 19.2088 6.12419 21.2091C8.12458 23.2095 10.8377 24.3333 13.6667 24.3333C16.4956 24.3333 19.2088 23.2095 21.2091 21.2091C23.2095 19.2088 24.3333 16.4956 24.3333 13.6667C24.3333 10.8377 23.2095 8.12458 21.2091 6.12419C19.2088 4.12381 16.4956 3 13.6667 3C10.8377 3 8.12458 4.12381 6.12419 6.12419C4.12381 8.12458 3 10.8377 3 13.6667Z" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                <TextInput
                    placeholder="Поиск"
                    stylesInput="border-b-0 font-sans"
                />
            </div>

            <router-link v-for="chat in chats" :key="chat" :to="{name: 'chat', path: '/messanger', query: { sel: chat.id,sel_user: chat.sel_user }}" class="p-3 lg:p-6 flex items-center gap-4 lg:gap-8 border-light-grey border-b">
                <div>
                    <img :src="'http://127.0.0.1:8000/images/avatars/' + chat.avatar" alt="" class="w-14 lg:w-20 rounded-full">
                </div>

                <div class="max-lg:w-2/3 lg:text-3xl grow font-medium">
                    {{chat.name}}

                </div>

                <div class="text-[12px] lg:text-lg">
                    {{chat.time}}
                </div>
            </router-link>

        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import TextInput from '../../reusable/TextInput.vue';
import axios from 'axios';
import { useUserStore } from '../../../store/user-store.js'

let userStore = useUserStore()

onMounted(async() => {
    await getChats()
})
let chats = ref(null)

let getChats = async() => {
    try {
        let res = await axios('http://127.0.0.1:8000/api/chats', {
            headers: {
                Authorization: `Bearer ${userStore.token}`
            }
        })

        chats.value = res.data.chats

        console.log(res.data.chats)
    } catch (err) {
        console.log(err)
    }
}

</script>
