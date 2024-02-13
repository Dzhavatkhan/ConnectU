<template>
    <div class="fixed lg:max-w-[35%] lg:max-h-[80%] lg:m-auto flex flex-col inset-0 z-40 bg-grey lg:rounded-xl">
        <div @click="$emit('closeModal')" class="absolute lg:-right-24 lg:w-max max-lg:inset-x-0 p-2 lg:p-4 bg-light-black lg:bg-grey lg:rounded-lg cursor-pointer">
            <svg viewBox="0 0 18 18" fill="none" class="w-[25px] lg:w-10 m-auto">
                <path d="M15.072 17.3952L9.26367 11.5868L3.4553 17.3952C3.1472 17.7033 2.72933 17.8764 2.29362 17.8764C1.8579 17.8764 1.44004 17.7033 1.13194 17.3952C0.823848 17.0871 0.650761 16.6692 0.650761 16.2335C0.650761 15.7978 0.823849 15.3799 1.13194 15.0718L6.94032 9.26346L1.13194 3.45508C0.823848 3.14698 0.650762 2.72912 0.650762 2.2934C0.650762 1.85769 0.823848 1.43982 1.13194 1.13173C1.44004 0.823633 1.85791 0.650547 2.29362 0.650547C2.72933 0.650547 3.1472 0.823633 3.45529 1.13173L9.26367 6.94011L15.072 1.13173C15.3801 0.823633 15.798 0.650546 16.2337 0.650546C16.6694 0.650546 17.0873 0.823632 17.3954 1.13173C17.7035 1.43982 17.8766 1.85769 17.8766 2.2934C17.8766 2.72912 17.7035 3.14698 17.3954 3.45508L11.587 9.26346L17.3954 15.0718C17.7035 15.3799 17.8766 15.7978 17.8766 16.2335C17.8766 16.6692 17.7035 17.0871 17.3954 17.3952C17.0873 17.7033 16.6694 17.8764 16.2337 17.8764C15.798 17.8764 15.3801 17.7033 15.072 17.3952Z" class="fill-grey lg:fill-white" />
            </svg>
        </div>

        <div class="flex flex-col h-full p-3 lg:p-10 max-lg:pt-16">
            <div class="text-center text-2xl lg:text-4xl text-white">
                <template v-if="post">
                    Реадактирование поста
                </template>

                <template v-else>
                    Создание поста
                </template>
            </div>

            <form class="mt-6 lg:mt-[50px] flex flex-col gap-5 lg:gap-10 font-display overflow-auto" enctype="multipart/form-data">
                <TextArea
                    placeholder="Расскажите что-нибудь..."
                    v-model:input="text"
                    :error="errors.text ? errors.text[0] : ''"
                />

                <div>
                    <div @click="(openCategories = !openCategories) && (openCategories ? getCategories() : '')" class="flex justify-center gap-4 p-2 lg:py-4 text-center lg:text-2xl text-white border-white border-2 rounded-lg cursor-pointer">
                        Выбор категорий

                        <svg viewBox="0 0 50 26" fill="none" class="w-[17px] lg:w-7">
                            <path d="M46.5295 0.582918L24.9978 21.3046L3.46612 0.582918C3.08142 0.211941 2.56499 0.00425292 2.02723 0.00425292C1.48946 0.00425292 0.973036 0.211941 0.588336 0.582918C0.402065 0.763102 0.254083 0.978169 0.15306 1.21553C0.0520356 1.45288 0 1.70776 0 1.96522C0 2.22268 0.0520356 2.47755 0.15306 2.7149C0.254083 2.95226 0.402065 3.16733 0.588336 3.34751L23.4943 25.3962C23.8965 25.7833 24.4361 26 24.9978 26C25.5595 26 26.099 25.7833 26.5013 25.3962L49.4073 3.35177C49.5948 3.17145 49.7439 2.95585 49.8457 2.71771C49.9476 2.47957 50 2.2237 50 1.96522C50 1.70673 49.9476 1.45086 49.8457 1.21272C49.7439 0.974578 49.5948 0.758983 49.4073 0.578663C49.0226 0.207686 48.5061 0 47.9684 0C47.4306 0 46.9142 0.207686 46.5295 0.578663V0.582918Z" fill="white"/>
                        </svg>
                    </div>

                    <div v-if="openCategories" class="mt-2 bg-white rounded-lg text-center">
                        <div v-for="category in categories" :key="category.id" @click="activeCategoriesPush(category)" class="relative flex justify-center items-center py-2 lg:text-2xl border-grey border-b-2 last:border-b-0 cursor-pointer">
                            {{ category.name }}

                            <svg v-if="activeCategoriesId.includes(category.id)" viewBox="0 0 20 17" fill="none" class="absolute right-5 w-3 lg:w-5">
                                <path d="M19 1L6.4 16L1 10.375" stroke="#8B8B8B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>

                    <div v-if="activeCategories.length" class="mt-5 flex flex-wrap gap-2">
                        <div v-for="category in activeCategories" :key="category.id" class="flex gap-2 lg:gap-3 p-2 border-white border-2 lg:text-2xl text-white rounded-md">
                            {{ category.name }}

                            <svg @click="activeCategoriesPush(category)" viewBox="0 0 18 18" fill="none" class="w-4 lg:w-6 m-auto cursor-pointer">
                                <path d="M15.072 17.3952L9.26367 11.5868L3.4553 17.3952C3.1472 17.7033 2.72933 17.8764 2.29362 17.8764C1.8579 17.8764 1.44004 17.7033 1.13194 17.3952C0.823848 17.0871 0.650761 16.6692 0.650761 16.2335C0.650761 15.7978 0.823849 15.3799 1.13194 15.0718L6.94032 9.26346L1.13194 3.45508C0.823848 3.14698 0.650762 2.72912 0.650762 2.2934C0.650762 1.85769 0.823848 1.43982 1.13194 1.13173C1.44004 0.823633 1.85791 0.650547 2.29362 0.650547C2.72933 0.650547 3.1472 0.823633 3.45529 1.13173L9.26367 6.94011L15.072 1.13173C15.3801 0.823633 15.798 0.650546 16.2337 0.650546C16.6694 0.650546 17.0873 0.823632 17.3954 1.13173C17.7035 1.43982 17.8766 1.85769 17.8766 2.2934C17.8766 2.72912 17.7035 3.14698 17.3954 3.45508L11.587 9.26346L17.3954 15.0718C17.7035 15.3799 17.8766 15.7978 17.8766 16.2335C17.8766 16.6692 17.7035 17.0871 17.3954 17.3952C17.0873 17.7033 16.6694 17.8764 16.2337 17.8764C15.798 17.8764 15.3801 17.7033 15.072 17.3952Z" class="fill-white" />
                            </svg>
                        </div>
                    </div>

                    <div v-if="errors.category_id" class="mt-2 text-red-500">
                        {{ errors.category_id[0] }}
                    </div>
                </div>

                <div class="relative">
                    <TextInput
                        placeholder="Добавить ссылку на видео"
                        v-model:input="link"
                        stylesInput="p-2 border-white border-2 rounded-lg"
                        :error="errors.link ? errors.link[0] : ''"
                    />

                    <div @click="addVideo" class="flex items-center p-2 absolute top-1 right-1 bottom-1 cursor-pointer bg-grey">
                        <svg v-if="link" viewBox="0 0 20 17" fill="none" class="w-6 lg:w-8">
                            <path d="M19 1L6.4 16L1 10.375" stroke="#8B8B8B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>


                <div class="">
                    <input id="img" type="file" ref="fileInput" @change="getUploadedImage" multiple class="hidden">

                    <label for="img" class="block relative z-10 py-2 lg:py-4 lg:text-2xl text-center bg-white rounded-lg lg:rounded-xl cursor-pointer">
                        Добавить фото

                        <svg viewBox="0 0 20 26" fill="none" class="w-[14px] lg:w-5 inline-block ml-2 lg:ml-4">
                            <path d="M2.85716 12.9999L10 20.2221M10 20.2221L17.1429 12.9999M10 20.2221V1.44434M1.42859 24.5554H18.5714" stroke="black" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </label>
                </div>

                <!-- <iframe src="https://rutube.ru/video/248f13df0be8ccec31485acea6b4926d/?r=plwd" frameborder="0"></iframe> -->
<!-- https://www.youtube.com/embed/_LiT7YQTX_o -->
                <iframe v-if="link" id="my-iframe" :src="link" title="как правильно вставить вилку в розетку" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

                <div v-for="video in viewVideosOrigin" :key="video" class="relative">
                    <iframe id="my-iframe" :src="video" title="как правильно вставить вилку в розетку" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    <svg @click="cancelAttachments(1, false, video)" viewBox="0 0 18 18" fill="none" class="w-6 lg:w-8 absolute top-0 right-0 cursor-pointer">
                        <path d="M15.072 17.3952L9.26367 11.5868L3.4553 17.3952C3.1472 17.7033 2.72933 17.8764 2.29362 17.8764C1.8579 17.8764 1.44004 17.7033 1.13194 17.3952C0.823848 17.0871 0.650761 16.6692 0.650761 16.2335C0.650761 15.7978 0.823849 15.3799 1.13194 15.0718L6.94032 9.26346L1.13194 3.45508C0.823848 3.14698 0.650762 2.72912 0.650762 2.2934C0.650762 1.85769 0.823848 1.43982 1.13194 1.13173C1.44004 0.823633 1.85791 0.650547 2.29362 0.650547C2.72933 0.650547 3.1472 0.823633 3.45529 1.13173L9.26367 6.94011L15.072 1.13173C15.3801 0.823633 15.798 0.650546 16.2337 0.650546C16.6694 0.650546 17.0873 0.823632 17.3954 1.13173C17.7035 1.43982 17.8766 1.85769 17.8766 2.2934C17.8766 2.72912 17.7035 3.14698 17.3954 3.45508L11.587 9.26346L17.3954 15.0718C17.7035 15.3799 17.8766 15.7978 17.8766 16.2335C17.8766 16.6692 17.7035 17.0871 17.3954 17.3952C17.0873 17.7033 16.6694 17.8764 16.2337 17.8764C15.798 17.8764 15.3801 17.7033 15.072 17.3952Z" class="fill-white" />
                    </svg>
                </div>

                <div v-for="video in viewVideos" :key="video" class="relative">
                    <iframe id="my-iframe" :src="video" title="как правильно вставить вилку в розетку" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    <svg @click="cancelAttachments(2, false, video)" viewBox="0 0 18 18" fill="none" class="w-6 lg:w-8 absolute top-0 right-0 cursor-pointer">
                        <path d="M15.072 17.3952L9.26367 11.5868L3.4553 17.3952C3.1472 17.7033 2.72933 17.8764 2.29362 17.8764C1.8579 17.8764 1.44004 17.7033 1.13194 17.3952C0.823848 17.0871 0.650761 16.6692 0.650761 16.2335C0.650761 15.7978 0.823849 15.3799 1.13194 15.0718L6.94032 9.26346L1.13194 3.45508C0.823848 3.14698 0.650762 2.72912 0.650762 2.2934C0.650762 1.85769 0.823848 1.43982 1.13194 1.13173C1.44004 0.823633 1.85791 0.650547 2.29362 0.650547C2.72933 0.650547 3.1472 0.823633 3.45529 1.13173L9.26367 6.94011L15.072 1.13173C15.3801 0.823633 15.798 0.650546 16.2337 0.650546C16.6694 0.650546 17.0873 0.823632 17.3954 1.13173C17.7035 1.43982 17.8766 1.85769 17.8766 2.2934C17.8766 2.72912 17.7035 3.14698 17.3954 3.45508L11.587 9.26346L17.3954 15.0718C17.7035 15.3799 17.8766 15.7978 17.8766 16.2335C17.8766 16.6692 17.7035 17.0871 17.3954 17.3952C17.0873 17.7033 16.6694 17.8764 16.2337 17.8764C15.798 17.8764 15.3801 17.7033 15.072 17.3952Z" class="fill-white" />
                    </svg>
                </div>

                <div v-for="img in viewImagesOrigin" :key="img" class="relative">
                    <img :src="'http://127.0.0.1:8000/images/attachments/' + img" alt="" class="w-full rounded-lg">
                    <svg @click="cancelAttachments(1, img)" viewBox="0 0 18 18" fill="none" class="w-6 lg:w-8 absolute top-0 right-0 cursor-pointer">
                        <path d="M15.072 17.3952L9.26367 11.5868L3.4553 17.3952C3.1472 17.7033 2.72933 17.8764 2.29362 17.8764C1.8579 17.8764 1.44004 17.7033 1.13194 17.3952C0.823848 17.0871 0.650761 16.6692 0.650761 16.2335C0.650761 15.7978 0.823849 15.3799 1.13194 15.0718L6.94032 9.26346L1.13194 3.45508C0.823848 3.14698 0.650762 2.72912 0.650762 2.2934C0.650762 1.85769 0.823848 1.43982 1.13194 1.13173C1.44004 0.823633 1.85791 0.650547 2.29362 0.650547C2.72933 0.650547 3.1472 0.823633 3.45529 1.13173L9.26367 6.94011L15.072 1.13173C15.3801 0.823633 15.798 0.650546 16.2337 0.650546C16.6694 0.650546 17.0873 0.823632 17.3954 1.13173C17.7035 1.43982 17.8766 1.85769 17.8766 2.2934C17.8766 2.72912 17.7035 3.14698 17.3954 3.45508L11.587 9.26346L17.3954 15.0718C17.7035 15.3799 17.8766 15.7978 17.8766 16.2335C17.8766 16.6692 17.7035 17.0871 17.3954 17.3952C17.0873 17.7033 16.6694 17.8764 16.2337 17.8764C15.798 17.8764 15.3801 17.7033 15.072 17.3952Z" class="fill-white" />
                    </svg>
                </div>

                <div v-for="img in viewImages" :key="img" class="relative">
                    <img :src="img" alt="" class="w-full rounded-lg">
                    <svg @click="cancelAttachments(2, img)" viewBox="0 0 18 18" fill="none" class="w-6 lg:w-8 absolute top-0 right-0 cursor-pointer">
                        <path d="M15.072 17.3952L9.26367 11.5868L3.4553 17.3952C3.1472 17.7033 2.72933 17.8764 2.29362 17.8764C1.8579 17.8764 1.44004 17.7033 1.13194 17.3952C0.823848 17.0871 0.650761 16.6692 0.650761 16.2335C0.650761 15.7978 0.823849 15.3799 1.13194 15.0718L6.94032 9.26346L1.13194 3.45508C0.823848 3.14698 0.650762 2.72912 0.650762 2.2934C0.650762 1.85769 0.823848 1.43982 1.13194 1.13173C1.44004 0.823633 1.85791 0.650547 2.29362 0.650547C2.72933 0.650547 3.1472 0.823633 3.45529 1.13173L9.26367 6.94011L15.072 1.13173C15.3801 0.823633 15.798 0.650546 16.2337 0.650546C16.6694 0.650546 17.0873 0.823632 17.3954 1.13173C17.7035 1.43982 17.8766 1.85769 17.8766 2.2934C17.8766 2.72912 17.7035 3.14698 17.3954 3.45508L11.587 9.26346L17.3954 15.0718C17.7035 15.3799 17.8766 15.7978 17.8766 16.2335C17.8766 16.6692 17.7035 17.0871 17.3954 17.3952C17.0873 17.7033 16.6694 17.8764 16.2337 17.8764C15.798 17.8764 15.3801 17.7033 15.072 17.3952Z" class="fill-white" />
                    </svg>
                </div>
            </form>

            <div v-if="!post" @click="sendPost()" class="cursor-pointer mt-5 lg:mt-16 p-2 lg:py-5 text-center lg:text-3xl text-grey bg-white rounded-lg">
                Опубликовать
            </div>

            <div v-else @click="editPost(post.id)" class="cursor-pointer mt-5 lg:mt-16 p-2 lg:py-5 text-center lg:text-3xl text-grey bg-white rounded-lg border-white border-[4px] transition-all duration-100 hover:bg-grey hover:text-white">
                Редактировать
            </div>
        </div>
    </div>

    <Cover @click="$emit('closeModal')" stylesInput="fixed z-20 top-0"/>
</template>

<script setup>
import { ref, defineProps, onMounted, toRefs, watch } from 'vue';
import axios from 'axios';
import { useUserStore } from '@/store/user-store';
import TextArea from '../reusable/TextArea.vue';
import TextInput from '../reusable/TextInput.vue';
import Cover from '../reusable/Cover.vue';

let props = defineProps(['post', 'categoriesRef', 'categoriesIdRef'])

let { post, categoriesRef, categoriesIdRef } = toRefs(props)

const userStore = useUserStore()

onMounted(() => {
    if (post.value) {
        console.log(post.value.text)
        getPostById()
    }
})


let text = ref(null)
let link = ref(null)
let categories = ref(null)
let activeCategories = ref(categoriesRef.value || [])
let viewVideos = ref([])
let viewVideosOrigin = ref([])
let deleteViewVideos = ref([])
let videosToPush = ref([])
watch(link, (newValue) => {
    if (newValue) {
        link.value = newValue.replace('youtu.be', 'www.youtube.com/embed')
        console.log(link.value)
    }
    console.log(link.value)


 })

let openCategories = ref(false)

let activeCategoriesId = ref(categoriesIdRef.value || [])
console.log(activeCategoriesId.value)
let uploadedImages = ref([])
let viewImages = ref([])
let viewImagesOrigin = ref([])
let deleteViewImages = ref([])
import eventBus from '@/eventBus';
import Swal from 'sweetalert2/dist/sweetalert2.js';
let getPostById = () => {
    try {
        text.value = post.value.text

        for (let index = 0; index < post.value.attachment.length; index++) {
            if (post.value.attachment[index].type == 'photo') {
                viewImagesOrigin.value.push(post.value.attachment[index].name)
            } else {
                viewVideosOrigin.value.push(post.value.attachment[index].name)
            }
        }

        // for (let index = 0; index < post.value.category.length; index++) {
        //     console.log(post.value.category[index].name);
        //     activeCategories.value.push({'name': post.value.category[index].name})
        //     activeCategoriesId.value.push(post.value.category[index].id)
        // }

        console.log(post.value)
        // activeCategories.value = post.categories
    } catch (err) {
        console.log(err)
    }
}

let getUploadedImage = (e) => {
    const files = e.target.files

    for (let index = 0; index < files.length; index++) {
        uploadedImages.value.push(files[index])
        viewImages.value.push(URL.createObjectURL(files[index]))
    }

    console.log(uploadedImages.value)
}

let addVideo = () => {
    viewVideos.value.push(link.value)
    link.value = null
}

let cancelAttachments = (number, img, video) => {
    if (number == 1) {
        if (img) {
            viewImagesOrigin.value.splice(viewImagesOrigin.value.indexOf(img), 1)
            deleteViewImages.value.push(img)
        } else if (video) {
            viewVideosOrigin.value.splice(viewVideosOrigin.value.indexOf(video), 1)
            deleteViewVideos.value.push(video)
        }
    } else {
        if (img) {
            viewImages.value.splice(viewImages.value.indexOf(img), 1)
        } else if (video) {
            viewVideos.value.splice(viewVideos.value.indexOf(video), 1)
        }
    }
    // for (let index = 0; index < viewImagesOrigin.value.length; index++) {
    //     if (viewImagesOrigin.value[index] == img) {
    //         console.log(deleteViewImages.value)
    //     }
    // }
    for (let index = 0; index < uploadedImages.value.length; index++) {
        console.log(img)
        if (uploadedImages.value[index].name == img) {
            uploadedImages.value.splice(index, 1)
        }
    }
}

let errors = ref([])

let getCategories = async() => {
    try {
        let res = await axios('http://127.0.0.1:8000/api/categories', {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
            }
        })

        categories.value = res.data.categories

        console.log(res)
    } catch (err) {
        console.log(err)
        // errors.value = err.response.data.errors
    }
}

let activeCategoriesPush = (category) => {
    console.log(category)
    try {
        if (category.category_id) {
            if (!activeCategoriesId.value.includes(category.category_id)) {
            activeCategories.value.push(category)

            activeCategoriesId.value.push(category.id)
            } else {
                activeCategories.value.splice(activeCategories.value.indexOf(category), 1)
                activeCategoriesId.value.splice(activeCategoriesId.value.indexOf(category.id), 1)
            }
        } else {
            if (!activeCategoriesId.value.includes(category.id)) {
            activeCategories.value.push(category)

            activeCategoriesId.value.push(category.id)
            } else {
                activeCategories.value.splice(activeCategories.value.indexOf(category), 1)
                activeCategoriesId.value.splice(activeCategoriesId.value.indexOf(category.id), 1)
            }
        }

    } catch (err) {
        console.log(err)
    }
}

let sendPost = async() => {

    let data = new FormData();

    data.append('text', text.value || '')
    // data.append('link', link.value || '')
    for (let index = 0; index < uploadedImages.value.length; index++) {
        data.append(`attachment${index}`, uploadedImages.value[index])
    }

    for (let index = 0; index < viewVideosOrigin.value.length; index++) {
        videosToPush.value.push(viewVideosOrigin.value[index])
    }

    for (let index = 0; index < viewVideos.value.length; index++) {
        videosToPush.value.push(viewVideos.value[index])
    }

    data.append(`videos`, videosToPush.value)
    console.log(uploadedImages.value)
    let cat = [];
    for (let category = 0; category < activeCategories.value.length; category++) {

        // data.append(`category_id${category}`, activeCategoriesId.value[category] || '')
        cat.push(activeCategoriesId.value[category])
        console.log(cat)
        data.append('category_id', cat || '')

    }
    // data.append('category_id', activeCategoriesId.value[0] || '')

    try {
        console.log(uploadedImages.value);
        let res = await axios.post('http://127.0.0.1:8000/api/posts/create', data, {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
                'Content-Type': 'multipart/form-data'
            }
        })

        console.log(res.data)
        eventBus.emit('addPost', '')
    } catch(err) {
        console.log(err)
        errors.value = err.response.data.errors
        Swal.fire({
        title: 'Ошибка',
        theme: "dark",
        text: err,
        position: "bottom-end",
        showConfirmButton: false,
        timer: 2500,
        icon: 'error',
        })
    }
}

let editPost = async(idPost) => {

    let data = new FormData();

    data.append('text', text.value || '')
    // data.append('link', link.value || '')
    for (let index = 0; index < uploadedImages.value.length; index++) {
        data.append(`attachment${index}`, uploadedImages.value[index])
    }

    for (let index = 0; index < viewVideosOrigin.value.length; index++) {
        videosToPush.value.push(viewVideosOrigin.value[index])
    }
    for (let index = 0; index < viewVideos.value.length; index++) {
        videosToPush.value.push(viewVideos.value[index])
    }

    data.append(`videos`, videosToPush.value)

    // if (viewImagesOrigin.value.length) {
    //     data.append('originAttachments', viewImagesOrigin.value)
    // }

    if (deleteViewImages.value.length) {
        data.append('deleteImages', deleteViewImages.value)
    }

    console.log(deleteViewImages.value);

    if (deleteViewVideos.value.length) {
        data.append('deleteVideos', deleteViewVideos.value)
    }

    console.log(uploadedImages.value)

    let cat = [];
    for (let category = 0; category < activeCategories.value.length; category++) {

        // data.append(`category_id${category}`, activeCategoriesId.value[category] || '')
        cat.push(activeCategoriesId.value[category])
        console.log(cat)
        data.append('categoryId', cat || '')

    }
    // data.append('category_id', activeCategoriesId.value[0] || '')

    try {
        console.log(uploadedImages.value);
        let res = await axios.post('http://127.0.0.1:8000/api/update/post/id' + idPost + '?_method=PUT', data, {
            headers:
            {
                Authorization: `Bearer ${userStore.token}`,
                'Content-Type': 'multipart/form-data'
            }
        })

        console.log(res.data)
        eventBus.emit('addPost', '')
    } catch(err) {
        console.log(err)
        errors.value = err.response.data.errors
        Swal.fire({
        title: 'Ошибка',
        theme: "dark",
        text: err,
        position: "bottom-end",
        showConfirmButton: false,
        timer: 2500,
        icon: 'error',
        })
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
