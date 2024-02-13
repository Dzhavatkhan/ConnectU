<template>
    <div v-if="!idOpenModal && userStore.id" class="absolute max-lg:inset-x-0 z-10 lg:right-0 lg:text-2xl px-3 lg:p-10 py-6  bg-light-black rounded-b-xl">
        <div @click="toggleModal(3)" class=" py-3 lg:py-4 lg:px-8 text-white text-center border-white border rounded-lg transition-all duration-100 hover:bg-white hover:text-light-black cursor-pointer">Создать категорию</div>

        <div @click="toggleModal(4)" class="mt-5 lg:mt-7 py-3 lg:py-4 lg:px-8 text-white text-center border-white border rounded-lg transition-all duration-100 hover:bg-white hover:text-light-black cursor-pointer">Обновить категорию</div>

        <div @click="toggleModal(5)" class="mt-5 lg:mt-7 py-3 lg:py-4 lg:px-8 text-white text-center border-white border rounded-lg transition-all duration-100 hover:bg-white hover:text-light-black cursor-pointer">Удалить категорию</div>

        <router-link to="/profile/setting" class="mt-5 lg:mt-7 block py-3 lg:py-4 lg:px-5 text-white text-center border-white transition-all duration-100 hover:bg-white hover:text-light-black border rounded-lg">Настройки</router-link>

        <div @click="logout()" class="mt-5 lg:mt-7 py-3 lg:py-4 lg:px-8 text-white text-center border-white border rounded-lg transition-all duration-100 hover:bg-white hover:text-light-black cursor-pointer">Выйти</div>
    </div>

    <SignInModal v-if="modals[0].visible" @closeModal="toggleModal(1, true)" />
    <SignUpModal v-if="modals[1].visible" @closeModal="toggleModal(2, true)" />

    <CreateCategory v-if="modals[2].visible" @closeModal="toggleModal(3, true)"/>
    <UpdateCategory v-if="modals[3].visible" @closeModal="toggleModal(4, true)"/>
    <DeleteCategory v-if="modals[4].visible" @closeModal="toggleModal(5, true)"/>

    <Cover @click="idOpenModal ? toggleModal(idOpenModal, true) : $emit('closeModal')" :stylesInput="idOpenModal ? 'inset-y-0' : ''" />
</template>

<script setup>
import { ref } from 'vue';
import Cover from '../reusable/Cover.vue';
import SignInModal from './SignInModal.vue';
import SignUpModal from './SignUpModal.vue';
import { useUserStore } from '@/store/user-store';
import axios from 'axios';
import CreateCategory from './CreateCategory.vue';
import UpdateCategory from './UpdateCategory.vue';
import DeleteCategory from './DeleteCategory.vue';
import Swal from "sweetalert2"
const userStore = useUserStore()

let idOpenModal = ref(0)

let modals = ref([
    {
        id: 1,
        name: 'signIn',
        visible: false
    },
    {
        id: 2,
        name: 'signUp',
        visible: false
    },
    {
        id: 3,
        name: 'create',
        visible: false
    },
    {
        id: 4,
        name: 'update',
        visible: false
    },
    {
        id: 5,
        name: 'delete',
        visible: false
    }
])

function toggleModal(id, isClose) {
    if (!isClose) {
        if (idOpenModal.value = 0) {
            modals.value[idOpenModal.value - 1].visible = false
        }

        modals.value[id - 1].visible = true
        idOpenModal.value = id
    } else {
        modals.value[id - 1].visible = false
        idOpenModal.value = 0
    }
}

let logout = async() => {
    try {
        let res = await axios('http://127.0.0.1:8000/api/logout', {
            headers :
                {
                Authorization: `Bearer ${userStore.token}`,
                }
        });

        userStore.clearUser()

        console.log(res)
    } catch (err) {
        Swal.fire({
            title: "Ошибка",
            icon: "error",
            text: Error,
            position: "bottom-end",
            color: "dark",
            timer: 2000,
            showConfirmButton: false,
        })
    }
}
</script>
