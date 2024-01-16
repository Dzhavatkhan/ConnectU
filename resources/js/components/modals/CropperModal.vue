<template>
    <div class="fixed lg:max-w-[35%] lg:max-h-[80%] lg:m-auto flex flex-col inset-0 z-30 bg-grey lg:rounded-xl">
        <div @click="$emit('closeModal')" class="absolute lg:-right-24 lg:w-max max-lg:inset-x-0 p-2 lg:p-4 bg-light-black lg:bg-grey lg:rounded-lg">
            <svg viewBox="0 0 18 18" fill="none" class="w-[25px] lg:w-10 m-auto">
                <path d="M15.072 17.3952L9.26367 11.5868L3.4553 17.3952C3.1472 17.7033 2.72933 17.8764 2.29362 17.8764C1.8579 17.8764 1.44004 17.7033 1.13194 17.3952C0.823848 17.0871 0.650761 16.6692 0.650761 16.2335C0.650761 15.7978 0.823849 15.3799 1.13194 15.0718L6.94032 9.26346L1.13194 3.45508C0.823848 3.14698 0.650762 2.72912 0.650762 2.2934C0.650762 1.85769 0.823848 1.43982 1.13194 1.13173C1.44004 0.823633 1.85791 0.650547 2.29362 0.650547C2.72933 0.650547 3.1472 0.823633 3.45529 1.13173L9.26367 6.94011L15.072 1.13173C15.3801 0.823633 15.798 0.650546 16.2337 0.650546C16.6694 0.650546 17.0873 0.823632 17.3954 1.13173C17.7035 1.43982 17.8766 1.85769 17.8766 2.2934C17.8766 2.72912 17.7035 3.14698 17.3954 3.45508L11.587 9.26346L17.3954 15.0718C17.7035 15.3799 17.8766 15.7978 17.8766 16.2335C17.8766 16.6692 17.7035 17.0871 17.3954 17.3952C17.0873 17.7033 16.6694 17.8764 16.2337 17.8764C15.798 17.8764 15.3801 17.7033 15.072 17.3952Z" class="fill-grey lg:fill-white" />
            </svg>
        </div>

        <div class="flex flex-col h-full px-3 pb-8 lg:p-10 max-lg:pt-16">
            <div class="text-center text-2xl lg:text-5xl text-white">
                Загрузка аватара
            </div>

            <form class="mt-6 lg:mt-[50px] flex flex-col gap-4 lg:gap-10 font-display overflow-auto">
                <input id="avatar" type="file" ref="fileInput" @change="getUploadedImage" class="hidden">

                <label for="avatar" class="block relative z-10 py-2 lg:py-4 lg:text-3xl text-center bg-white rounded-lg lg:rounded-xl cursor-pointer">
                    Загрузить аватар

                    <svg viewBox="0 0 20 26" fill="none" class="w-[14px] lg:w-5 inline-block ml-2 lg:ml-4">
                        <path d="M2.85716 12.9999L10 20.2221M10 20.2221L17.1429 12.9999M10 20.2221V1.44434M1.42859 24.5554H18.5714" stroke="black" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </label>

                <div class="mt-4 grow overflow-hidden flex justify-center items-center">
                    <Cropper
                        ref="cropper"
                        :src="uploadedImage"
                        :stencil-component="CircleStencil"
                        :stencil-props="{
                            minAspectRatioProp: minAspectRatioProp.width/minAspectRatioProp.height,
                            maxAspectRatioProp: maxAspectRatioProp.width/maxAspectRatioProp.height
                        }"
                    ></Cropper>
                </div>
            </form>

            <div v-if="uploadedImage" @click="crop" class="mt-8 lg:mt-[60px] p-2 lg:py-5 text-center lg:text-3xl text-grey bg-white rounded-lg">
                Сохранить
            </div>
        </div>
    </div>
</template>

<script setup>
    import { reactive, ref, defineEmits, defineProps } from 'vue';
    import { CircleStencil, Cropper } from 'vue-advanced-cropper'
    import 'vue-advanced-cropper/dist/style.css';

    let emit = defineEmits(['croppedImageData', 'closeModal'])

    defineProps(reactive({
        minAspectRatioProp: Object,
        maxAspectRatioProp: Object
    }))
    // let loadFile = (e) => {
    //     console.log(e.target)
    //     e.target.previousElementSibling.innerHTML = 'Выбран файл: ' + e.target.files[0].name
    // }

    let fileInput = ref(null)
    let cropper = ref(null)
    let uploadedImage = ref(null)

    let croppedImageData = {
        file: null,
        imageUrl: null,
        height: null,
        width: null,
        left: null,
        top: null,
    }

    let getUploadedImage = (e) => {
        const file = e.target.files[0]
        uploadedImage.value = URL.createObjectURL(file)

        console.log(uploadedImage.value)
    }

    const crop = () => {
        const { coordinates, canvas } = cropper.value.getResult()

        croppedImageData.file = fileInput.value.files[0]
        croppedImageData.imageUrl = canvas.toDataURL()
        croppedImageData.width = coordinates.width
        croppedImageData.height = coordinates.height
        croppedImageData.left = coordinates.left
        croppedImageData.top = coordinates.top

        emit('croppedImageData', croppedImageData)
        emit('closeModal')
    }
</script>
