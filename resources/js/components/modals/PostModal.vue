<template>
    <div class="fixed lg:max-w-[35%] lg:max-h-[80%] lg:m-auto flex flex-col inset-0 z-40 bg-grey lg:rounded-xl">
        <div @click="$emit('closeModal')" class="absolute lg:-right-24 lg:w-max max-lg:inset-x-0 p-2 lg:p-4 bg-light-black lg:bg-grey lg:rounded-lg">
            <svg viewBox="0 0 18 18" fill="none" class="w-[25px] lg:w-10 m-auto">
                <path d="M15.072 17.3952L9.26367 11.5868L3.4553 17.3952C3.1472 17.7033 2.72933 17.8764 2.29362 17.8764C1.8579 17.8764 1.44004 17.7033 1.13194 17.3952C0.823848 17.0871 0.650761 16.6692 0.650761 16.2335C0.650761 15.7978 0.823849 15.3799 1.13194 15.0718L6.94032 9.26346L1.13194 3.45508C0.823848 3.14698 0.650762 2.72912 0.650762 2.2934C0.650762 1.85769 0.823848 1.43982 1.13194 1.13173C1.44004 0.823633 1.85791 0.650547 2.29362 0.650547C2.72933 0.650547 3.1472 0.823633 3.45529 1.13173L9.26367 6.94011L15.072 1.13173C15.3801 0.823633 15.798 0.650546 16.2337 0.650546C16.6694 0.650546 17.0873 0.823632 17.3954 1.13173C17.7035 1.43982 17.8766 1.85769 17.8766 2.2934C17.8766 2.72912 17.7035 3.14698 17.3954 3.45508L11.587 9.26346L17.3954 15.0718C17.7035 15.3799 17.8766 15.7978 17.8766 16.2335C17.8766 16.6692 17.7035 17.0871 17.3954 17.3952C17.0873 17.7033 16.6694 17.8764 16.2337 17.8764C15.798 17.8764 15.3801 17.7033 15.072 17.3952Z" class="fill-grey lg:fill-white" />
            </svg>
        </div>

        <div class="flex flex-col h-full p-3 lg:p-10 max-lg:pt-16">
            <div class="text-center text-2xl lg:text-5xl text-white">
                Создание поста
            </div>

            <form class="mt-6 lg:mt-[50px] flex flex-col gap-5 lg:gap-10 font-display overflow-auto">
                <TextArea
                    placeholder="Расскажите что-нибудь..."
                    v-model:input="post"
                    :error="errors.post ? errors.post[0] : ''"
                />

                <div>
                    <div @click="(openCategories = !openCategories) && (openCategories ? getCategories() : '')" class=" p-2 lg:py-5 text-center lg:text-3xl font-medium text-grey bg-white rounded-lg">
                        Выбор категорий
                    </div>

                    <div v-if="openCategories" class="mt-2 bg-white rounded-lg text-center">
                        <div v-for="category in categories" :key="category.id" @click="activeCategoriesPush(category)" class="relative flex justify-center items-center py-2 border-grey border-b-2 last:border-b-0">
                            {{ category.name }}

                            <svg v-if="activeCategoriesId.includes(category.id)" viewBox="0 0 20 17" fill="none" class="absolute right-5 w-3 lg:w-4">
                                <path d="M19 1L6.4 16L1 10.375" stroke="#8B8B8B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>

                    <div v-if="activeCategories.length" class="mt-7 flex flex-wrap gap-2">
                        <div v-for="category in activeCategories" :key="category.id" class="flex gap-2 p-2 border-white border-2 text-white rounded-md">
                            {{ category.name }}

                            <svg @click="activeCategoriesPush(category)" viewBox="0 0 18 18" fill="none" class="w-4 lg:w-10 m-auto">
                                <path d="M15.072 17.3952L9.26367 11.5868L3.4553 17.3952C3.1472 17.7033 2.72933 17.8764 2.29362 17.8764C1.8579 17.8764 1.44004 17.7033 1.13194 17.3952C0.823848 17.0871 0.650761 16.6692 0.650761 16.2335C0.650761 15.7978 0.823849 15.3799 1.13194 15.0718L6.94032 9.26346L1.13194 3.45508C0.823848 3.14698 0.650762 2.72912 0.650762 2.2934C0.650762 1.85769 0.823848 1.43982 1.13194 1.13173C1.44004 0.823633 1.85791 0.650547 2.29362 0.650547C2.72933 0.650547 3.1472 0.823633 3.45529 1.13173L9.26367 6.94011L15.072 1.13173C15.3801 0.823633 15.798 0.650546 16.2337 0.650546C16.6694 0.650546 17.0873 0.823632 17.3954 1.13173C17.7035 1.43982 17.8766 1.85769 17.8766 2.2934C17.8766 2.72912 17.7035 3.14698 17.3954 3.45508L11.587 9.26346L17.3954 15.0718C17.7035 15.3799 17.8766 15.7978 17.8766 16.2335C17.8766 16.6692 17.7035 17.0871 17.3954 17.3952C17.0873 17.7033 16.6694 17.8764 16.2337 17.8764C15.798 17.8764 15.3801 17.7033 15.072 17.3952Z" class="fill-white" />
                            </svg>
                        </div>
                    </div>
                </div>

                <TextInput 
                    placeholder="Добавить ссылку на видео"
                    stylesInput="p-2 border-2 rounded-lg"
                />

                <div class="">
                    <input id="img" type="file" ref="fileInput" @change="getUploadedImage" class="hidden">

                    <label for="img" class="block relative z-10 py-2 lg:py-4 lg:text-3xl text-center bg-white rounded-lg lg:rounded-xl">
                        Добавить фото

                        <svg viewBox="0 0 20 26" fill="none" class="w-[14px] lg:w-5 inline-block ml-2 lg:ml-4">
                            <path d="M2.85716 12.9999L10 20.2221M10 20.2221L17.1429 12.9999M10 20.2221V1.44434M1.42859 24.5554H18.5714" stroke="black" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </label>
                </div>

                <!-- <iframe src="https://rutube.ru/video/248f13df0be8ccec31485acea6b4926d/?r=plwd" frameborder="0"></iframe> -->

                <iframe id="my-iframe" height="1200" src="https://www.youtube.com/embed/MuGmbQ_2j88" title="как правильно вставить вилку в розетку" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

                <img v-for="img in  uploadedImages" :key="img" :src="img" alt="" class="rounded-lg">
            </form>

            <div @click="signIn()" class="mt-5 lg:mt-16 p-2 lg:py-5 text-center lg:text-3xl text-grey bg-white rounded-lg">
                Опубликовать
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useUserStore } from '@/store/user-store';
import TextArea from '../reusable/TextArea.vue';
import TextInput from '../reusable/TextInput.vue';

const userStore = useUserStore()

let openCategories = ref(false)

let post = ref(null)
let categories = ref(null)
let activeCategories = ref([])

let activeCategoriesId = ref([])

let uploadedImages = ref([])

let getUploadedImage = (e) => {
    const files = e.target.files

    for (let index = 0; index < files.length; index++) {
        uploadedImages.value.push(URL.createObjectURL(files[index]))
    }

    console.log(uploadedImages.value)
}

let errors = ref([])

let getCategories = async() => {
    try {
        let res = await axios('http://127.0.0.1:8000/api/categories')

        categories.value = res.data

        console.log(res)
    } catch (err) {
        console.log(err)
        // errors.value = err.response.data.errors
    }
}

let activeCategoriesPush = (category) => {
    try {
        if (!activeCategoriesId.value.includes(category.id)) {
            activeCategories.value.push(category)

            activeCategoriesId.value.push(category.id)
        } else {
            activeCategories.value.splice(activeCategories.value.indexOf(category), 1)
            activeCategoriesId.value.splice(activeCategoriesId.value.indexOf(category.id), 1)
        }
    } catch (err) {
        console.log(err)
    }
}

// document.querySelectorAll('iframe').forEach( item =>
//     console.log(item)
// )


// const iframe = document.getElementById('my-iframe');

// console.log(iframe)

// iframe.addEventListener('load', () => {
//   if (iframe.contentDocument) {
//     // The iframe has content
//   } else {
//     // The iframe is empty
//   }

//   if (iframe.contentWindow.document.readyState === 'complete') {
//     // The iframe has finished loading
//   } else {
//     // The iframe is still loading
//   }
// });
</script>
