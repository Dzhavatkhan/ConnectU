<template>
    <div class="fixed flex flex-col inset-0 z-10 bg-grey">
        <div @click="$emit('closeModal')" class="absolute inset-x-0 p-2 bg-light-black">
            <svg width="25" viewBox="0 0 18 18" fill="none" class="m-auto">
                <path d="M15.072 17.3952L9.26367 11.5868L3.4553 17.3952C3.1472 17.7033 2.72933 17.8764 2.29362 17.8764C1.8579 17.8764 1.44004 17.7033 1.13194 17.3952C0.823848 17.0871 0.650761 16.6692 0.650761 16.2335C0.650761 15.7978 0.823849 15.3799 1.13194 15.0718L6.94032 9.26346L1.13194 3.45508C0.823848 3.14698 0.650762 2.72912 0.650762 2.2934C0.650762 1.85769 0.823848 1.43982 1.13194 1.13173C1.44004 0.823633 1.85791 0.650547 2.29362 0.650547C2.72933 0.650547 3.1472 0.823633 3.45529 1.13173L9.26367 6.94011L15.072 1.13173C15.3801 0.823633 15.798 0.650546 16.2337 0.650546C16.6694 0.650546 17.0873 0.823632 17.3954 1.13173C17.7035 1.43982 17.8766 1.85769 17.8766 2.2934C17.8766 2.72912 17.7035 3.14698 17.3954 3.45508L11.587 9.26346L17.3954 15.0718C17.7035 15.3799 17.8766 15.7978 17.8766 16.2335C17.8766 16.6692 17.7035 17.0871 17.3954 17.3952C17.0873 17.7033 16.6694 17.8764 16.2337 17.8764C15.798 17.8764 15.3801 17.7033 15.072 17.3952Z" fill="#535353"/>
            </svg>
        </div>

        <div class="flex flex-col h-full p-3 pt-16">
            <div class="text-center text-2xl text-white">
                Регистрация
            </div>

            <form class="mt-6 flex flex-col gap-5 font-display overflow-auto">
                <TextInput
                    placeholder="Имя"
                    v-model:input="name"
                />

                <TextInput
                    placeholder="Фамилия"
                    v-model:input="surname"
                />

                <TextInput
                    placeholder="Логин"
                    v-model:input="login"
                />

                <TextInput
                    placeholder="E-mail"
                    v-model:input="email"
                />

                <TextInput
                    placeholder="Пароль"
                    v-model:input="password"
                />

                <TextInput
                    placeholder="Подтверждение пароля"
                />

                <div class="flex justify-center gap-3 border-white border p-2 text-white rounded-lg">
                    <span>
                        Интересные темы
                    </span>

                    <svg width="17" viewBox="0 0 50 26" fill="none">
                        <path d="M46.5295 0.582918L24.9978 21.3046L3.46612 0.582918C3.08142 0.211941 2.56499 0.00425292 2.02723 0.00425292C1.48946 0.00425292 0.973036 0.211941 0.588336 0.582918C0.402065 0.763102 0.254083 0.978169 0.15306 1.21553C0.0520356 1.45288 0 1.70776 0 1.96522C0 2.22268 0.0520356 2.47755 0.15306 2.7149C0.254083 2.95226 0.402065 3.16733 0.588336 3.34751L23.4943 25.3962C23.8965 25.7833 24.4361 26 24.9978 26C25.5595 26 26.099 25.7833 26.5013 25.3962L49.4073 3.35177C49.5948 3.17145 49.7439 2.95585 49.8457 2.71771C49.9476 2.47957 50 2.2237 50 1.96522C50 1.70673 49.9476 1.45086 49.8457 1.21272C49.7439 0.974578 49.5948 0.758983 49.4073 0.578663C49.0226 0.207686 48.5061 0 47.9684 0C47.4306 0 46.9142 0.207686 46.5295 0.578663V0.582918Z" fill="white"/>
                    </svg>
                </div>

                <div class="flex justify-center gap-3 border-white border p-2 text-white rounded-lg">
                    <span>
                        Загрузить аватар
                    </span>

                    <svg width="17" viewBox="0 0 40 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 31.0588V35.5294C2 36.7151 2.47411 37.8522 3.31802 38.6906C4.16193 39.529 5.30653 40 6.5 40H33.5C34.6935 40 35.8381 39.529 36.682 38.6906C37.5259 37.8522 38 36.7151 38 35.5294V31.0588M8.75 17.6471L20 28.8235M20 28.8235L31.25 17.6471M20 28.8235V2" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                </div>
            </form>

            <div class="mt-7 p-2 text-center text-grey bg-white rounded-lg">
                Зарегистрироваться
            </div>

            <div class="flex gap-2 text-[12px] leading-4 text-white mt-4 font-display">
                <input type="checkbox" class="">
                <div>Согласие на обработку персональных данных</div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import TextInput from '../reusable/TextInput.vue';

let name = ref(null)
let surname = ref(null)
let login = ref(null)
let email = ref(null)
let password = ref(null)

</script>