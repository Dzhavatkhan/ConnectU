<template>
    <div class="max-lg:fixed lg:sticky lg:top-48 max-lg:inset-0 max-lg:h-screen lg:h-[750px] lg:grow max-lg:z-50 flex flex-col font-display text-white bg-grey lg:rounded-xl">
        <div class="p-3 lg:p-6 lg:px-8 flex justify-between items-center gap-3 lg:gap-5 border-light-grey border-b">

            <router-link to="/messanger" class="cursor-pointer">
                <svg viewBox="0 0 43 28" fill="none" class="w-5 lg:w-10">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M43 14C43 13.5875 42.8382 13.1919 42.5502 12.9002C42.2622 12.6085 41.8717 12.4447 41.4644 12.4447H5.24534L14.9105 2.65848C15.0533 2.51387 15.1665 2.3422 15.2438 2.15326C15.3211 1.96432 15.3608 1.76181 15.3608 1.5573C15.3608 1.35279 15.3211 1.15029 15.2438 0.961348C15.1665 0.772408 15.0533 0.600732 14.9105 0.456123C14.7677 0.311514 14.5982 0.196804 14.4117 0.118543C14.2251 0.0402809 14.0252 0 13.8233 0C13.6214 0 13.4214 0.0402809 13.2349 0.118543C13.0483 0.196804 12.8788 0.311514 12.7361 0.456123L0.451145 12.8988C0.308138 13.0433 0.194678 13.2149 0.117263 13.4039C0.0398486 13.5928 0 13.7954 0 14C0 14.2046 0.0398486 14.4072 0.117263 14.5961C0.194678 14.7851 0.308138 14.9567 0.451145 15.1012L12.7361 27.5439C12.8788 27.6885 13.0483 27.8032 13.2349 27.8815C13.4214 27.9597 13.6214 28 13.8233 28C14.0252 28 14.2251 27.9597 14.4117 27.8815C14.5982 27.8032 14.7677 27.6885 14.9105 27.5439C15.0533 27.3993 15.1665 27.2276 15.2438 27.0387C15.3211 26.8497 15.3608 26.6472 15.3608 26.4427C15.3608 26.2382 15.3211 26.0357 15.2438 25.8467C15.1665 25.6578 15.0533 25.4861 14.9105 25.3415L5.24534 15.5553H41.4644C41.8717 15.5553 42.2622 15.3915 42.5502 15.0998C42.8382 14.8081 43 14.4125 43 14Z" fill="white"/>
                </svg>
            </router-link>

            <div v-if="msgs" class="text-center text-sm lg:text-3xl font-medium">
                {{ msgs[0].recipient }}
            </div>

            <img :src="'http://127.0.0.1:8000/images/avatars/' + msgs[0].avatar"  alt="" class="w-8 lg:w-16 block rounded-full">

        </div>

        <div class="p-3 lg:p-8 flex flex-col gap-8 grow overflow-auto" id="chat">
            <div v-for="msg in msgs" :key="msg" class="relative flex flex-col " :class="userStore.id != msg.user_id ? 'items-start' : 'items-end'">
                <img v-if="userStore.id != msg.user_id" :src="'http://127.0.0.1:8000/images/avatars/' + msg.avatar" alt="" class="inline-block w-8 lg:w-16 rounded-full">
                <img v-else :src="userStore.image" alt="" class="inline-block w-8 lg:w-16 rounded-full">

                <div v-if="userStore.id != msg.user_id" class="absolute left-12 lg:left-[90px] top-1 lg:top-4 lg:text-2xl">
                    {{msg.recipient}}
                </div>

                <div v-else class="absolute right-12 lg:right-[90px] top-1 lg:top-4 lg:text-2xl">
                    {{msg.you}}
                </div>

                <div class="mt-3 lg:mt-5 flex flex-col gap-3">
                    <div class=" p-2 lg:p-4 break-all bg-light-black rounded-md">
                        <div class="lg:text-2xl">
                            {{ msg.message }}
                        </div>


                        <div class="mt-2 flex justify-end items-center text-[12px] gap-4 lg:text-lg text-light-grey font-medium">
                            <div>
                                {{ msg.time }}
                            </div>

                            <svg v-if="userStore.id == msg.user_id" @click="deleteMessage(msg.id)" viewBox="0 0 16 18" fill="none" class="w-5 cursor-pointer">
                                <path d="M2.98857 18C2.4781 18 2.04267 17.8204 1.68229 17.4613C1.32267 17.1021 1.14286 16.6672 1.14286 16.1566V2.02029H0V0.878884H4.57143V0H11.4286V0.878884H16V2.02029H14.8571V16.1566C14.8571 16.6817 14.6811 17.12 14.3291 17.4715C13.9764 17.8238 13.5371 18 13.0114 18H2.98857ZM13.7143 2.02029H2.28571V16.1566C2.28571 16.3613 2.35162 16.5295 2.48343 16.6611C2.61524 16.7928 2.78362 16.8586 2.98857 16.8586H13.0114C13.1867 16.8586 13.3478 16.7855 13.4949 16.6394C13.6411 16.4926 13.7143 16.3316 13.7143 16.1566V2.02029ZM5.49486 14.5758H6.63771V4.30311H5.49486V14.5758ZM9.36229 14.5758H10.5051V4.30311H9.36229V14.5758Z" fill="grey"/>
                            </svg>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div id="enter" class="p-3 lg:p-6 lg:px-8 flex justify-between items-center gap-3 lg:gap-5 border-light-grey border-t">
            <Textinput
                placeholder="Написать сообщение..."
                v-model:input="message"
                stylesInput="border-b-0 placeholder:text-light-grey text-sm"
            />

            <div @click="sendMessage()">
                <svg viewBox="0 0 32 32" fill="none" class="w-5 lg:w-8">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.553585 0.392092C0.792391 0.184632 1.08733 0.0526268 1.40114 0.0127582C1.71494 -0.0271104 2.03352 0.0269479 2.31661 0.168101L31.1138 14.5675C31.38 14.7002 31.604 14.9045 31.7605 15.1575C31.9171 15.4104 32 15.702 32 15.9995C32 16.297 31.9171 16.5886 31.7605 16.8415C31.604 17.0944 31.38 17.2987 31.1138 17.4314L2.31661 31.8309C2.03354 31.9725 1.71482 32.027 1.40077 31.9875C1.08673 31.9479 0.791475 31.8161 0.552375 31.6086C0.313275 31.4012 0.141075 31.1275 0.057564 30.8222C-0.0259467 30.5168 -0.0170141 30.1936 0.0832313 29.8934L4.18203 17.5994H12.8004C13.2247 17.5994 13.6316 17.4309 13.9316 17.1308C14.2317 16.8308 14.4002 16.4238 14.4002 15.9995C14.4002 15.5752 14.2317 15.1682 13.9316 14.8682C13.6316 14.5681 13.2247 14.3996 12.8004 14.3996H4.18203L0.0816312 2.10563C-0.0180977 1.8055 -0.0266437 1.48254 0.0570727 1.17755C0.140789 0.87257 0.314612 0.599239 0.553585 0.392092Z" fill="#989898"/>
                </svg>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, onUnmounted, ref } from 'vue'
import axios from 'axios';
import Textinput from '../../reusable/textinput.vue';
import { useRoute } from 'vue-router'
import { useUserStore } from '../../../store/user-store';

let userStore = useUserStore()

let route = useRoute()

console.log(route.query.sel)

let message = ref(null)

let msgs = ref(null)

onMounted(async() => {
    await getMessages()
    document.addEventListener('keydown', async function(e) {
        if(e.code == 'Enter'){
           await sendMessage()
        }
    })


})

onUnmounted(() => {
    clearInterval(timerId)
})

let timerId = setInterval(async() => await getMessages(), 2500);

async function scrollToBottom() {
    let block = document.getElementById("chat")
    block.scrollTop = block.scrollHeight;
    console.log(block.scrollHeight);
}

let getMessages = async() => {
    try {

        let res = await axios('http://127.0.0.1:8000/api/chat/id' + route.query.sel, {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
            }
        })

        console.log(res.data.chat)
        msgs.value = res.data.chat

    } catch (err) {
        console.log(err)
    }
}
    console.log("user_id " + route.query.sel_user);
let sendMessage = async () => {
    console.log(message.value)

    try {
        let res = await axios.post('http://127.0.0.1:8000/api/message/chat/id' + route.query.sel_user, {
            message: message.value,
            chat_id: route.query.sel
        },
        {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
            }
        })

        console.log(res.data)
        // scrollToBottom()
        // setTimeout(scrollToBottom, 3000);
        await getMessages()
    await scrollToBottom()


        message.value = ''
    } catch (err) {
        console.log(err)
    }
}

let deleteMessage = async(id) => {
    try {
        let res = await axios('http://127.0.0.1:8000/api/message/delete/id' + id,
        {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
            }
        })

        console.log(res.data)
    } catch (error) {
        console.log(error)
    }
}

</script>
