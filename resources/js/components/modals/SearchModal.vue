<template>
    <div class="fixed inset-0 z-20 lg:w-max lg:h-[80%] lg:m-auto flex flex-col text-white bg-grey lg:rounded-xl">
        <div @click="emit('closeModal')" class="lg:absolute lg:-right-24 lg:rounded-lg p-2 lg:p-4 bg-light-black lg:bg-grey">
            <svg viewBox="0 0 18 18" fill="none" class="m-auto w-6 lg:w-10">
                <path d="M15.072 17.3952L9.26367 11.5868L3.4553 17.3952C3.1472 17.7033 2.72933 17.8764 2.29362 17.8764C1.8579 17.8764 1.44004 17.7033 1.13194 17.3952C0.823848 17.0871 0.650761 16.6692 0.650761 16.2335C0.650761 15.7978 0.823849 15.3799 1.13194 15.0718L6.94032 9.26346L1.13194 3.45508C0.823848 3.14698 0.650762 2.72912 0.650762 2.2934C0.650762 1.85769 0.823848 1.43982 1.13194 1.13173C1.44004 0.823633 1.85791 0.650547 2.29362 0.650547C2.72933 0.650547 3.1472 0.823633 3.45529 1.13173L9.26367 6.94011L15.072 1.13173C15.3801 0.823633 15.798 0.650546 16.2337 0.650546C16.6694 0.650546 17.0873 0.823632 17.3954 1.13173C17.7035 1.43982 17.8766 1.85769 17.8766 2.2934C17.8766 2.72912 17.7035 3.14698 17.3954 3.45508L11.587 9.26346L17.3954 15.0718C17.7035 15.3799 17.8766 15.7978 17.8766 16.2335C17.8766 16.6692 17.7035 17.0871 17.3954 17.3952C17.0873 17.7033 16.6694 17.8764 16.2337 17.8764C15.798 17.8764 15.3801 17.7033 15.072 17.3952Z" class="fill-grey lg:fill-white"/>
            </svg>
        </div>

        <div class="flex flex-col overflow-auto">
            <div class="flex items-center gap-5 lg:gap-7 p-3 lg:p-6 border-light-grey border-b">
                <svg viewBox="0 0 30 30" fill="none" class="w-[30px] lg:w-12">
                    <path d="M21.6667 21.6667L27 27M3 13.6667C3 16.4956 4.12381 19.2088 6.12419 21.2091C8.12458 23.2095 10.8377 24.3333 13.6667 24.3333C16.4956 24.3333 19.2088 23.2095 21.2091 21.2091C23.2095 19.2088 24.3333 16.4956 24.3333 13.6667C24.3333 10.8377 23.2095 8.12458 21.2091 6.12419C19.2088 4.12381 16.4956 3 13.6667 3C10.8377 3 8.12458 4.12381 6.12419 6.12419C4.12381 8.12458 3 10.8377 3 13.6667Z" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                <TextInput
                    placeholder="Поиск"
                    v-model:input="input"
                    stylesInput="border-b-0"
                />
            </div>

            <div class="font-display lg:text-4xl overflow-auto">
                <div v-for="user in users" :key="user.id" class="p-3 lg:p-6 flex items-center gap-3 lg:gap-8 border-light-grey border-b">
                    <div>
                        <img :src="'http://127.0.0.1:8000/images/avatars/' + user.image" alt="" class="w-14 lg:w-24 rounded-full">
                    </div>

                    <div class="max-lg:w-2/3 grow mr-16 font-medium">
                        {{user.name + ' ' + user.surname}}
                    </div>

                    <div class="max-lg:w-1/3 flex justify-between lg:gap-10">
                        <router-link :to="{name: 'chat', path: '/messanger', query: { sel_user: user.id }}" class="block">
                            <svg viewBox="0 0 30 30" fill="none" class="w-[23px] lg:w-[50px]">
                                <path d="M10.0006 12.4971C10.0006 12.1656 10.1323 11.8476 10.3667 11.6132C10.6011 11.3788 10.919 11.2471 11.2505 11.2471H18.7503C19.0818 11.2471 19.3998 11.3788 19.6342 11.6132C19.8686 11.8476 20.0003 12.1656 20.0003 12.4971C20.0003 12.8286 19.8686 13.1466 19.6342 13.381C19.3998 13.6154 19.0818 13.7471 18.7503 13.7471H11.2505C10.919 13.7471 10.6011 13.6154 10.3667 13.381C10.1323 13.1466 10.0006 12.8286 10.0006 12.4971ZM11.2505 16.2471C10.919 16.2471 10.6011 16.3788 10.3667 16.6132C10.1323 16.8476 10.0006 17.1656 10.0006 17.4971C10.0006 17.8286 10.1323 18.1466 10.3667 18.381C10.6011 18.6154 10.919 18.7471 11.2505 18.7471H16.2504C16.5819 18.7471 16.8998 18.6154 17.1342 18.381C17.3687 18.1466 17.5003 17.8286 17.5003 17.4971C17.5003 17.1656 17.3687 16.8476 17.1342 16.6132C16.8998 16.3788 16.5819 16.2471 16.2504 16.2471H11.2505ZM0.000863139 14.9971C0.00150101 11.6947 1.09189 8.48484 3.10289 5.86542C5.11389 3.246 7.93309 1.36345 11.1231 0.509809C14.3132 -0.343834 17.6958 -0.120852 20.7462 1.14416C23.7966 2.40918 26.3443 4.64551 27.994 7.50626C29.6438 10.367 30.3034 13.6922 29.8706 16.9661C29.4377 20.24 27.9366 23.2795 25.6001 25.6132C23.2635 27.9469 20.2222 29.4443 16.9479 29.873C13.6735 30.3018 10.3492 29.638 7.49064 27.9846L1.64581 29.9346C1.42988 30.0067 1.19835 30.0184 0.97622 29.9686C0.754091 29.9187 0.549796 29.8091 0.385383 29.6517C0.22097 29.4942 0.102684 29.2948 0.0432897 29.075C-0.0161045 28.8553 -0.0143507 28.6234 0.0483619 28.4046L1.82831 22.1771C0.625885 19.9752 -0.00259464 17.5059 0.000863139 14.9971ZM15.0004 2.49711C12.7934 2.49697 10.6258 3.08118 8.71774 4.19037C6.80972 5.29955 5.22938 6.89416 4.13737 8.8121C3.04535 10.73 2.4806 12.9029 2.50051 15.1099C2.52042 17.3168 3.12429 19.4792 4.25074 21.3771C4.33741 21.5237 4.3932 21.6865 4.41469 21.8554C4.43619 22.0244 4.42293 22.1959 4.37573 22.3596L3.10327 26.8096L7.24815 25.4296C7.42418 25.3708 7.61108 25.352 7.79529 25.3745C7.9795 25.397 8.15639 25.4602 8.31312 25.5596C9.95124 26.5963 11.8081 27.2378 13.7368 27.4333C15.6655 27.6289 17.6133 27.3731 19.4261 26.6862C21.239 25.9994 22.8672 24.9002 24.1822 23.4757C25.4971 22.0512 26.4627 20.3403 27.0026 18.4783C27.5425 16.6164 27.6419 14.6544 27.293 12.7473C26.9441 10.8403 26.1564 9.04062 24.9922 7.49046C23.828 5.9403 22.3192 4.68219 20.5851 3.81556C18.851 2.94894 16.939 2.49756 15.0004 2.49711Z" fill="white"/>
                            </svg>
                        </router-link>

                        <div class="underline">
                            <svg viewBox="0 0 40 32" fill="none" class="w-[30px] lg:w-16">
                                <path d="M26 14H32M32 14H38M32 14V20M32 14V8M26 30V27.5C26 23.358 22.162 20 17.428 20H10.572C5.838 20 2 23.358 2 27.5V30M20 8C20 9.5913 19.3679 11.1174 18.2426 12.2426C17.1174 13.3679 15.5913 14 14 14C12.4087 14 10.8826 13.3679 9.75736 12.2426C8.63214 11.1174 8 9.5913 8 8C8 6.4087 8.63214 4.88258 9.75736 3.75736C10.8826 2.63214 12.4087 2 14 2C15.5913 2 17.1174 2.63214 18.2426 3.75736C19.3679 4.88258 20 6.4087 20 8Z" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Cover @click="emit('closeModal')" stylesInput="absolute"/>
</template>

<script setup>
import { onMounted, ref, watch, defineEmits } from 'vue'
import axios from 'axios';
import Cover from '../reusable/Cover.vue';
import TextInput from '../reusable/TextInput.vue';
import { useUserStore } from '../../store/user-store';

let userStore = useUserStore()

let emit = defineEmits(['closeModal'])

onMounted(async() => {
    await search()
})

let input = ref('')

let users = ref(null)

watch(input, async (newValue) => {
    // let regexp = /[&$?!\\^/#@"',`~=+\-_()[\]%:;№<>]/
    // if (newValue == ' ') {
    //     inputComputed.value = ''
    // } else if (newValue.indexOf('  ') > -1) {
    //     inputComputed.value = inputComputed.value.replace('  ', ' ')
    // } else if (newValue.indexOf(' |') > -1) {
    //     inputComputed.value = inputComputed.value.replace(' |', '|')
    // }
        await search()
})

let search = async() => {
    try {
        console.log(userStore.token)
        let res = await axios.post('http://127.0.0.1:8000/api/search', {
            search: input.value,

        }, {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
            }
        })

        console.log(res.data.users)
        users.value = res.data.users
    } catch (err) {
        console.log(err)
    }
}
</script>

<style scoped>
    .router-link-active {
        border-left: 0;
    }
</style>
