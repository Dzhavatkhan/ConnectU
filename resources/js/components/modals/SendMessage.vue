<template>
    <div class="fixed lg:max-w-[35%] lg:max-h-[60%] lg:m-auto flex flex-col inset-0 z-40 bg-grey lg:rounded-xl">
        <div @click="$emit('closeModal')" class="absolute lg:-right-24 lg:w-max max-lg:inset-x-0 p-2 lg:p-4 bg-light-black lg:bg-grey lg:rounded-lg">
            <svg viewBox="0 0 18 18" fill="none" class="w-[25px] lg:w-10 m-auto">
                <path d="M15.072 17.3952L9.26367 11.5868L3.4553 17.3952C3.1472 17.7033 2.72933 17.8764 2.29362 17.8764C1.8579 17.8764 1.44004 17.7033 1.13194 17.3952C0.823848 17.0871 0.650761 16.6692 0.650761 16.2335C0.650761 15.7978 0.823849 15.3799 1.13194 15.0718L6.94032 9.26346L1.13194 3.45508C0.823848 3.14698 0.650762 2.72912 0.650762 2.2934C0.650762 1.85769 0.823848 1.43982 1.13194 1.13173C1.44004 0.823633 1.85791 0.650547 2.29362 0.650547C2.72933 0.650547 3.1472 0.823633 3.45529 1.13173L9.26367 6.94011L15.072 1.13173C15.3801 0.823633 15.798 0.650546 16.2337 0.650546C16.6694 0.650546 17.0873 0.823632 17.3954 1.13173C17.7035 1.43982 17.8766 1.85769 17.8766 2.2934C17.8766 2.72912 17.7035 3.14698 17.3954 3.45508L11.587 9.26346L17.3954 15.0718C17.7035 15.3799 17.8766 15.7978 17.8766 16.2335C17.8766 16.6692 17.7035 17.0871 17.3954 17.3952C17.0873 17.7033 16.6694 17.8764 16.2337 17.8764C15.798 17.8764 15.3801 17.7033 15.072 17.3952Z" class="fill-grey lg:fill-white" />
            </svg>
        </div>

        <div class="flex flex-col h-full   ">
            <div class="p-3 lg:p-10 max-lg:pt-[52px] text-center text-2xl lg:text-5xl text-white border-light-grey border-b-2">
                Новое сообщение
            </div>

            <div class="flex gap-3 lg:gap-5 font-display p-3 py-6 lg:p-10 text-center text-lg lg:text-4xl text-white ">
                <img :src="'http://127.0.0.1:8000/images/avatars/' + image" alt="" class="w-10 lg:w-20 rounded-full">
                <div class="flex items-center">{{ name + ' ' + surname }}</div>
            </div>

            <form class=" px-3 lg:px-10 flex flex-col gap-5 lg:gap-10 font-display overflow-auto">
                <TextArea
                    placeholder="Напишите что-нибудь..."
                    v-model:input="message"
                    :error="errors.message ? errors.message[0] : ''"
                />
            </form>

            <div @click="sendMessage" class="p-3 lg:p-10 ">
                <div  class="max-lg:mt-5 p-2 lg:py-5 text-center lg:text-3xl text-grey bg-white rounded-lg">
                    Отправить
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, toRefs, defineProps } from 'vue';
import axios from 'axios';
import { useUserStore } from '@/store/user-store';
import TextArea from '../reusable/TextArea.vue';

const userStore = useUserStore()

let message = ref(null)

let errors = ref([])

let props = defineProps([
   'user_id', 'image', 'name', 'surname'
])

let { user_id, image, name, surname } = toRefs(props)


let sendMessage = async () => {
    console.log(message.value)
    try {
        let res = await axios.post('http://127.0.0.1:8000/api/message/chat/id' + user_id.value, {
            message: message.value
        },
        {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
            }
        })

        console.log(res.data)

    } catch (err) {
        console.log(err)
    }
}
</script>
