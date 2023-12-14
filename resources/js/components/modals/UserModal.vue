<template>
    <div class="absolute inset-x-0 px-3 py-6 bg-light-black">
        <div @click="toggleModal(1)" class="py-3 text-white text-center border-white border rounded-lg">Войти</div>

        <div @click="toggleModal(2)" class="mt-5 py-3 text-white text-center border-white border rounded-lg">Зарегистрироваться</div>
    </div>

    <SignInModal v-if="modals[0].visible" @closeModal="toggleModal(1, true)" />
    <SignUpModal v-if="modals[1].visible" @closeModal="toggleModal(2, true)" />

    <Cover v-if="idOpenModal" />
</template>

<script setup>
import { ref } from 'vue';
import Cover from '../reusable/Cover.vue';
import SignInModal from './SignInModal.vue';
import SignUpModal from './SignUpModal.vue';

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
</script>
