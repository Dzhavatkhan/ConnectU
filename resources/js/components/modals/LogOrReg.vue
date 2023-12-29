<template>
    <div v-if="!idOpenModal" class="fixed lg:max-w-[35%] lg:max-h-[80%] lg:m-auto flex flex-col inset-0 z-10 bg-grey lg:rounded-xl">
        <div class="flex flex-col gap-4 h-full px-3 pb-8 lg:p-10 max-lg:pt-16">
            <div @click="toggleModal(1)" class="flex justify-center items-center gap-3 lg:gap-6 border-white border p-2 lg:p-4 lg:text-3xl text-white rounded-lg lg:rounded-xl">
                Вход
            </div>

            <div @click="toggleModal(2)" class="flex justify-center items-center gap-3 lg:gap-6 border-white border p-2 lg:p-4 lg:text-3xl text-white rounded-lg lg:rounded-xl">
                Регистрация
            </div>
        </div>
    </div>

    <SignInModal v-if="modals[0].visible" @closeModal="toggleModal(1, true)" />
    <SignUpModal v-if="modals[1].visible" @closeModal="toggleModal(2, true)" />

    <Cover  />

</template>

<script setup>
import { ref } from 'vue';
import TextInput from '../reusable/TextInput.vue';
import CroppedImage from '../reusable/CroppedImage.vue';
import CropperModal from '../modals/CropperModal.vue';
import axios from 'axios';
import { useUserStore } from '@/store/user-store';
import Cover from '../reusable/Cover.vue';
import SignInModal from './SignInModal.vue';
import SignUpModal from './SignUpModal.vue';

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
