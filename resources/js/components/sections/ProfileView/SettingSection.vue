<template>
    <div class="w-full flex flex-col gap-5 max-lg:mt-4 last:mb-20  font-display text-white bg-grey rounded-xl lg:rounded-2xl">
        <div class="p-3 lg:p-6 lg:px-10 flex justify-between items-center gap-3 lg:gap-8 border-light-grey border-b">

            <router-link to="/messanger" class="flex items-center gap-3 lg:gap-4 cursor-pointer">
                <svg viewBox="0 0 43 28" fill="none" class="w-5 lg:w-7">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M43 14C43 13.5875 42.8382 13.1919 42.5502 12.9002C42.2622 12.6085 41.8717 12.4447 41.4644 12.4447H5.24534L14.9105 2.65848C15.0533 2.51387 15.1665 2.3422 15.2438 2.15326C15.3211 1.96432 15.3608 1.76181 15.3608 1.5573C15.3608 1.35279 15.3211 1.15029 15.2438 0.961348C15.1665 0.772408 15.0533 0.600732 14.9105 0.456123C14.7677 0.311514 14.5982 0.196804 14.4117 0.118543C14.2251 0.0402809 14.0252 0 13.8233 0C13.6214 0 13.4214 0.0402809 13.2349 0.118543C13.0483 0.196804 12.8788 0.311514 12.7361 0.456123L0.451145 12.8988C0.308138 13.0433 0.194678 13.2149 0.117263 13.4039C0.0398486 13.5928 0 13.7954 0 14C0 14.2046 0.0398486 14.4072 0.117263 14.5961C0.194678 14.7851 0.308138 14.9567 0.451145 15.1012L12.7361 27.5439C12.8788 27.6885 13.0483 27.8032 13.2349 27.8815C13.4214 27.9597 13.6214 28 13.8233 28C14.0252 28 14.2251 27.9597 14.4117 27.8815C14.5982 27.8032 14.7677 27.6885 14.9105 27.5439C15.0533 27.3993 15.1665 27.2276 15.2438 27.0387C15.3211 26.8497 15.3608 26.6472 15.3608 26.4427C15.3608 26.2382 15.3211 26.0357 15.2438 25.8467C15.1665 25.6578 15.0533 25.4861 14.9105 25.3415L5.24534 15.5553H41.4644C41.8717 15.5553 42.2622 15.3915 42.5502 15.0998C42.8382 14.8081 43 14.4125 43 14Z" fill="white"/>
                </svg>

                <div class="font-sans text-sm lg:text-2xl">Назад</div>
            </router-link>

            <div>
                <svg viewBox="0 0 28 26" fill="none" class="w-5 lg:w-7">
                    <path d="M0 24H28V26H0V24ZM23.4 7C24.2 6.2 24.2 5 23.4 4.2L19.8 0.6C19 -0.2 17.8 -0.2 17 0.6L2 15.6V22H8.4L23.4 7ZM18.4 2L22 5.6L19 8.6L15.4 5L18.4 2ZM4 20V16.4L14 6.4L17.6 10L7.6 20H4Z" fill="white"/>
                </svg>
            </div>
        </div>

        <div class="p-3 lg:p-6 lg:px-10 ">
            <div class=" gap-10">
                <div class="lg:flex lg:gap-10">
                    <img :src="userStore.image" alt="" class="block w-36 lg:w-72 max-lg:m-auto rounded-lg">

                    <div class="flex flex-col justify-between max-lg:text-center">
                        <div class="max-lg:mt-5 max-lg:mb-5 lg:text-4xl">
                            {{ userStore.name + ' ' + userStore.surname }}
                        </div>
                    </div>
                </div>

                <div class="lg:mt-10">
                    <div class="font-sans lg:text-3xl">Категории</div>

                    <div class="flex gap-3 lg:gap-5 mt-2 lg:mt-4 lg:text-2xl">
                        <div v-if="profile" v-for="category in profile[0].category"  class=" w-max px-2  bg-white text-black rounded-[4px]">
                            {{category.name}}
                        </div>
                    </div>
                </div>

                <div class="mt-6 lg:mt-10">
                    <div class="font-sans lg:text-3xl">Логин</div>

                    <div class="mt-1 lg:mt-3 lg:text-2xl">@{{userStore.login}}</div>
                </div>

                <div class="mt-6 lg:mt-10">
                    <div class="font-sans lg:text-3xl">Почта</div>

                    <div class="mt-1 lg:mt-3 lg:text-2xl">{{userStore.email}}</div>
                </div>

                <div @click="open = !open" class="mt-6 lg:mt-10 text-center text-grey lg:text-3xl p-2 lg:p-3 font-sans bg-white rounded-lg cursor-pointer">Редактировать</div>
            </div>

        </div>
    </div>

    <UserEdit v-if="open" @closeModal="open=false" :categoriesRef="profile[0].category" :categoriesIdRef="categoriesId" :imageRef="userStore.image"/>
</template>

<script setup>
import axios from 'axios';
import {onMounted, ref, watch} from 'vue'
import { useUserStore } from '../../../store/user-store';
import UserEdit from '../../modals/UserEdit.vue'

let userStore = useUserStore()

let open = ref(false)

let categoriesId = ref([])

let profile = ref(null)

onMounted(async() => {
    await getUser()
})



watch(open, (newValue) => {
    if (newValue) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
})

let getUser = async () => {
    try {
        let res = await axios('http://127.0.0.1:8000/api/profile', {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
            }
        })

        profile.value = res.data.profile

        console.log(res.data.profile)

        for (let index = 0; index < profile.value[0].category.length; index++) {
            console.log(profile.value[0].category[index].id)
            categoriesId.value.push(profile.value[0].category[index].id)
        }
    } catch (err) {
        console.log(err)
    }
}

</script>
