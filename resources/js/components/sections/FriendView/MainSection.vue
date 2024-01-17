<template>
    <div class="w-full flex flex-col gap-10">
        <div class="">
            <div class=" font-display text-white bg-grey rounded-xl lg:rounded-2xl">
                <div class="p-3 lg:p-4 lg:px-8 flex items-center gap-3 lg:gap-8 border-light-grey border-b">
                    <svg viewBox="0 0 30 30" fill="none" class="w-[30px] lg:w-12">
                        <path d="M21.6667 21.6667L27 27M3 13.6667C3 16.4956 4.12381 19.2088 6.12419 21.2091C8.12458 23.2095 10.8377 24.3333 13.6667 24.3333C16.4956 24.3333 19.2088 23.2095 21.2091 21.2091C23.2095 19.2088 24.3333 16.4956 24.3333 13.6667C24.3333 10.8377 23.2095 8.12458 21.2091 6.12419C19.2088 4.12381 16.4956 3 13.6667 3C10.8377 3 8.12458 4.12381 6.12419 6.12419C4.12381 8.12458 3 10.8377 3 13.6667Z" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                    <TextInput
                        placeholder="Поиск"
                        v-model:input="input"
                        stylesInput="border-b-0 font-sans"
                    />
                </div>

                <div class="font-display lg:text-4xl overflow-auto">
                    <div v-for="friend in friends" :key="friend.id" class="p-3 lg:p-6 flex items-center gap-4 lg:gap-8 border-light-grey border-b">
                        
                        <div>
                            <img :src="'http://127.0.0.1:8000/images/avatars/' + friend.image" alt="" class="w-14 lg:w-24 rounded-full">
                        </div>

                        <div class="lg:text-2xl max-lg:w-2/3 grow font-medium">
                            {{friend.name + ' ' + friend.surname}}
                        </div>

                        <div class="max-lg:w-1/3 flex justify-between gap-5 lg:gap-10">
                            <div @click="openModal(friend.id, friend.image, friend.name, friend.surname)" class="block">
                                <svg viewBox="0 0 30 30" fill="none" class="w-[23px] lg:w-[40px]">
                                    <path d="M10.0006 12.4971C10.0006 12.1656 10.1323 11.8476 10.3667 11.6132C10.6011 11.3788 10.919 11.2471 11.2505 11.2471H18.7503C19.0818 11.2471 19.3998 11.3788 19.6342 11.6132C19.8686 11.8476 20.0003 12.1656 20.0003 12.4971C20.0003 12.8286 19.8686 13.1466 19.6342 13.381C19.3998 13.6154 19.0818 13.7471 18.7503 13.7471H11.2505C10.919 13.7471 10.6011 13.6154 10.3667 13.381C10.1323 13.1466 10.0006 12.8286 10.0006 12.4971ZM11.2505 16.2471C10.919 16.2471 10.6011 16.3788 10.3667 16.6132C10.1323 16.8476 10.0006 17.1656 10.0006 17.4971C10.0006 17.8286 10.1323 18.1466 10.3667 18.381C10.6011 18.6154 10.919 18.7471 11.2505 18.7471H16.2504C16.5819 18.7471 16.8998 18.6154 17.1342 18.381C17.3687 18.1466 17.5003 17.8286 17.5003 17.4971C17.5003 17.1656 17.3687 16.8476 17.1342 16.6132C16.8998 16.3788 16.5819 16.2471 16.2504 16.2471H11.2505ZM0.000863139 14.9971C0.00150101 11.6947 1.09189 8.48484 3.10289 5.86542C5.11389 3.246 7.93309 1.36345 11.1231 0.509809C14.3132 -0.343834 17.6958 -0.120852 20.7462 1.14416C23.7966 2.40918 26.3443 4.64551 27.994 7.50626C29.6438 10.367 30.3034 13.6922 29.8706 16.9661C29.4377 20.24 27.9366 23.2795 25.6001 25.6132C23.2635 27.9469 20.2222 29.4443 16.9479 29.873C13.6735 30.3018 10.3492 29.638 7.49064 27.9846L1.64581 29.9346C1.42988 30.0067 1.19835 30.0184 0.97622 29.9686C0.754091 29.9187 0.549796 29.8091 0.385383 29.6517C0.22097 29.4942 0.102684 29.2948 0.0432897 29.075C-0.0161045 28.8553 -0.0143507 28.6234 0.0483619 28.4046L1.82831 22.1771C0.625885 19.9752 -0.00259464 17.5059 0.000863139 14.9971ZM15.0004 2.49711C12.7934 2.49697 10.6258 3.08118 8.71774 4.19037C6.80972 5.29955 5.22938 6.89416 4.13737 8.8121C3.04535 10.73 2.4806 12.9029 2.50051 15.1099C2.52042 17.3168 3.12429 19.4792 4.25074 21.3771C4.33741 21.5237 4.3932 21.6865 4.41469 21.8554C4.43619 22.0244 4.42293 22.1959 4.37573 22.3596L3.10327 26.8096L7.24815 25.4296C7.42418 25.3708 7.61108 25.352 7.79529 25.3745C7.9795 25.397 8.15639 25.4602 8.31312 25.5596C9.95124 26.5963 11.8081 27.2378 13.7368 27.4333C15.6655 27.6289 17.6133 27.3731 19.4261 26.6862C21.239 25.9994 22.8672 24.9002 24.1822 23.4757C25.4971 22.0512 26.4627 20.3403 27.0026 18.4783C27.5425 16.6164 27.6419 14.6544 27.293 12.7473C26.9441 10.8403 26.1564 9.04062 24.9922 7.49046C23.828 5.9403 22.3192 4.68219 20.5851 3.81556C18.851 2.94894 16.939 2.49756 15.0004 2.49711Z" fill="white"/>
                                </svg>
                            </div>

                            <div @click="deleteFriend(friend.friend_id)" class="">
                                <svg viewBox="0 0 76 81" fill="none" class="w-6">
                                    <path d="M54.7788 55.0922C57.2278 53.7693 60.0309 53.0163 63.0163 53.0163H63.0264C63.33 53.0163 63.4717 52.65 63.249 52.4465C60.1444 49.6448 56.5979 47.382 52.7548 45.7508C52.7143 45.7304 52.6738 45.7202 52.6334 45.6999C58.9178 41.1106 63.0062 33.6516 63.0062 25.2362C63.0062 11.2952 51.7934 0 37.9596 0C24.1259 0 12.9232 11.2952 12.9232 25.2362C12.9232 33.6516 17.0116 41.1106 23.3062 45.6999C23.2657 45.7202 23.2252 45.7304 23.1847 45.7508C18.6612 47.674 14.6031 50.4317 11.1118 53.9525C7.64063 57.4366 4.87713 61.5668 2.97548 66.1127C1.10446 70.5642 0.0946859 75.3337 0.000253056 80.1656C-0.00244797 80.2742 0.0164966 80.3822 0.055971 80.4834C0.0954454 80.5845 0.154651 80.6767 0.230098 80.7544C0.305546 80.8322 0.395709 80.894 0.495275 80.9361C0.594841 80.9783 0.701797 81 0.809838 81H6.8716C7.30675 81 7.67107 80.6438 7.68119 80.2063C7.88358 72.3505 11.0106 64.9933 16.5461 59.417C22.2638 53.6472 29.8739 50.4724 37.9698 50.4724C43.7077 50.4724 49.2129 52.07 53.9591 55.0617C54.081 55.1387 54.2209 55.1821 54.3648 55.1875C54.5087 55.1928 54.6515 55.16 54.7788 55.0922ZM37.9698 42.7387C33.3349 42.7387 28.9733 40.9172 25.6843 37.6101C24.0661 35.9871 22.7833 34.0582 21.9096 31.9345C21.036 29.8109 20.5889 27.5344 20.5941 25.2362C20.5941 20.5655 22.4055 16.1695 25.6843 12.8623C28.9631 9.55515 33.3248 7.73367 37.9698 7.73367C42.6148 7.73367 46.9663 9.55515 50.2552 12.8623C51.8734 14.4853 53.1563 16.4141 54.0299 18.5378C54.9035 20.6615 55.3506 22.938 55.3455 25.2362C55.3455 29.9069 53.534 34.3029 50.2552 37.6101C46.9663 40.9172 42.6046 42.7387 37.9698 42.7387ZM75.1904 66.9573H50.9029C50.4576 66.9573 50.0933 67.3236 50.0933 67.7714V73.4698C50.0933 73.9176 50.4576 74.2839 50.9029 74.2839H75.1904C75.6357 74.2839 76 73.9176 76 73.4698V67.7714C76 67.3236 75.6357 66.9573 75.1904 66.9573Z" fill="white"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="">
            <div class="last:mb-20 font-display text-white bg-grey rounded-xl lg:rounded-2xl">
                <div class="p-3 lg:p-6 lg:px-8 text-3xl font-sans flex justify-between items-center gap-3 lg:gap-8 border-light-grey border-b">
                    <div class="">Заявки</div>

                    <div class="flex gap-5 text-black">
                        <div @click="toggleModal(1)" class="p-2 bg-white rounded-lg">
                            Мне
                        </div>

                        <div @click="toggleModal(2)" class="p-2 bg-white rounded-lg">
                            Мои
                        </div>
                    </div>
                </div>

                <div v-if="openMe" v-for="apllication in apllications" class="p-3 lg:p-6 flex items-center gap-4 lg:gap-8 border-light-grey border-b">
                    <div>
                        <img :src="apllication.me.avatar" alt="" class="w-14 lg:w-20 rounded-full">
                    </div>

                    <div class="max-lg:w-2/3 lg:text-3xl grow font-medium">
                        {{ apllication.me.friend }}
                    </div>

                    <div @click="sendFriend(user.id)" class="underline">
                        <svg viewBox="0 0 40 32" fill="none" class="w-[30px] lg:w-16">
                            <path d="M26 14H32M32 14H38M32 14V20M32 14V8M26 30V27.5C26 23.358 22.162 20 17.428 20H10.572C5.838 20 2 23.358 2 27.5V30M20 8C20 9.5913 19.3679 11.1174 18.2426 12.2426C17.1174 13.3679 15.5913 14 14 14C12.4087 14 10.8826 13.3679 9.75736 12.2426C8.63214 11.1174 8 9.5913 8 8C8 6.4087 8.63214 4.88258 9.75736 3.75736C10.8826 2.63214 12.4087 2 14 2C15.5913 2 17.1174 2.63214 18.2426 3.75736C19.3679 4.88258 20 6.4087 20 8Z" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>

                <div v-if="openMy" v-for="apllication in apllications" class="p-3 lg:p-6 flex items-center gap-4 lg:gap-8 border-light-grey border-b">
                    <div>
                        <img :src="apllication.my.avatar" alt="" class="w-14 lg:w-20 rounded-full">
                    </div>

                    <div class="max-lg:w-2/3 lg:text-3xl grow font-medium">
                        {{ apllication.my.friend }}
                    </div>

                    <div @click="sendFriend(user.id)" class="underline">
                        <svg viewBox="0 0 40 32" fill="none" class="w-[30px] lg:w-16">
                            <path d="M26 14H32M32 14H38M32 14V20M32 14V8M26 30V27.5C26 23.358 22.162 20 17.428 20H10.572C5.838 20 2 23.358 2 27.5V30M20 8C20 9.5913 19.3679 11.1174 18.2426 12.2426C17.1174 13.3679 15.5913 14 14 14C12.4087 14 10.8826 13.3679 9.75736 12.2426C8.63214 11.1174 8 9.5913 8 8C8 6.4087 8.63214 4.88258 9.75736 3.75736C10.8826 2.63214 12.4087 2 14 2C15.5913 2 17.1174 2.63214 18.2426 3.75736C19.3679 4.88258 20 6.4087 20 8Z" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>

                <router-link to="/messanger/chat1" class="p-3 lg:p-6 flex items-center gap-4 lg:gap-8 border-light-grey border-b">
                    <div>
                        <img src="../../../../../storage/app/public/avatars/Avatar.jpg" alt="" class="w-14 lg:w-20 rounded-full">
                    </div>

                    <div class="max-lg:w-2/3 lg:text-3xl grow font-medium">
                        Джаватхан Джаватханов
                    </div>

                    <div class="text-[12px] lg:text-lg">
                        11.12.23
                    </div>
                </router-link>

                <router-link to="/messanger/chat1" class="p-3 lg:p-6 flex items-center gap-4 lg:gap-8 border-light-grey">
                    <div>
                        <img src="../../../../../storage/app/public/avatars/Avatar.jpg" alt="" class="w-14 lg:w-20 rounded-full">
                    </div>

                    <div class="max-lg:w-2/3 lg:text-3xl grow font-medium">
                        Джаватхан Джаватханов
                    </div>

                    <div class="text-[12px] lg:text-lg">
                        11.12.23
                    </div>
                </router-link>
            </div>
        </div>

    </div>

    <SendMessage v-if="open" @closeModal="open = false" :user_id="userId" :image="image" :name="name" :surname="surname" />
    <Cover v-if="open" @click="open = !open" stylesInput="fixed z-20 top-0"/>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
import TextInput from '../../reusable/TextInput.vue';
import axios from 'axios';
import { useUserStore } from '../../../store/user-store.js'
import SendMessage from '../../modals/SendMessage.vue';
import Cover from '../../reusable/Cover.vue';

let userStore = useUserStore()

onMounted(async() => {
    // await search()

    await friendsAPI()
})

let input = ref('')

let applications = ref(null)
let friends = ref([])
let openMe = ref(true)
let openMy = ref(false)
let open = ref(false)

let userId = ref(null)
let image = ref(null)
let name = ref(null)
let surname = ref(null)

let openModal = (userIdVal, imageVal, nameVal, surnameVal) => {
    open.value = true

    userId.value = userIdVal
    image.value = imageVal
    name.value = nameVal
    surname.value = surnameVal
}

watch(input, async (newValue) => {
    // let regexp = /[&$?!\\^/#@"',`~=+\-_()[\]%:;№<>]/
    // if (newValue == ' ') {
    //     inputComputed.value = ''
    // } else if (newValue.indexOf('  ') > -1) {
    //     inputComputed.value = inputComputed.value.replace('  ', ' ')
    // } else if (newValue.indexOf(' |') > -1) {
    //     inputComputed.value = inputComputed.value.replace(' |', '|')
    // }
        // await search()
})

let friendsAPI = async() => {
    console.log(1)
    try {
        // console.log(userStore.token)
        let res = await axios('http://127.0.0.1:8000/api/myfriends', {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
            }
        })

        applications.value = res.data.data

        for(let index = 0; index < applications.value.length; index++) {
            if (applications.value[index].friend) {
                friends.value.push(applications.value[index].friend[0])
            }
        }

        console.log(applications.value)
        console.log(friends.value)
    } catch (err) {
        console.log(err)
    }
}

let toggleModal = async(id) => {
    if (id == 1) {
        // console.log(applications.value[0].me)
        openMy.value = false
        openMe.value = true
    } else {
        // console.log(applications.value[0].my)

        openMe.value = false
        openMy.value = true
    }
}

// let search = async() => {
//     try {
//         // console.log(userStore.token)
//         let res = await axios.post('http://127.0.0.1:8000/api/search', {
//             search: input.value,

//         }, {
//             headers:
//             {
//                 Authorization: `Bearer ${userStore.token}`,
//             }
//         })

//         users.value = res.data.users

//         console.log(users.value)
//     } catch (err) {
//         console.log(err)
//     }
// }

// let me = async() => {
//     meFriends.value = friends.value.me
// }

let sendFriend = async(userId) => {
    try {
        let res = await axios.post('http://127.0.0.1:8000/api/send-friend/id' + userId, {}, {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })

        console.log(res.data)
    } catch (err) {
        console.log(err)
    }
}

let deleteFriend = async(userId) => {
    try {
        let res = await axios.delete('http://127.0.0.1:8000/api/delete-friend/id' + userId, {
            headers: {
                Authorization: `Bearer ${userStore.token}`,
            }
        })

        console.log(res.data)
    } catch (err) {
        console.log(err)
    }
}
</script>