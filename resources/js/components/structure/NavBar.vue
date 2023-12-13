<template>
    <nav class="p-3 bg-light-black">
        <div class="container m-auto">
            <div class="flex justify-between items-center">
                <div>
                    <svg width="50" viewBox="0 0 134 118" fill="none">
                        <g clip-path="url(#clip0_3_344)">
                            <path d="M84.6572 2.41492C99.6933 6.80149 117.786 19.0691 121.778 36.7688C124.959 50.8547 116.082 54.5254 117.13 72.4467C118.607 97.7888 137.516 110.278 133.021 116.267C128.141 122.767 107.947 105.249 74.4841 104.88C47.384 104.585 31.9007 115.756 25.73 108.164C19.0895 99.9935 35.5012 85.1973 28.8833 68.759C22.4862 52.8662 2.27011 54.622 0.413248 43.0362C-1.77197 29.3821 24.2128 14.1314 38.5865 8.07428C49.2465 3.58543 65.3752 -3.21035 84.6572 2.41492Z" fill="white" stroke="white" stroke-miterlimit="10"/>
                            <path d="M88.45 62.35C88.45 77.8 81.375 85.525 67.225 85.525C52.875 85.525 45.7 77.8 45.7 62.35V39.175C45.7 36.875 46.425 35.1 47.875 33.85C49.325 32.6 51.025 31.975 52.975 31.975C54.975 31.975 56.675 32.6 58.075 33.85C59.525 35.1 60.25 36.875 60.25 39.175V64.6C60.25 68.9 62.525 71.05 67.075 71.05C71.625 71.05 73.9 68.9 73.9 64.6V39.175C73.9 38.025 74.1 37 74.5 36.1C74.9 35.2 75.425 34.45 76.075 33.85C76.725 33.25 77.475 32.8 78.325 32.5C79.225 32.15 80.15 31.975 81.1 31.975C83.1 31.975 84.825 32.6 86.275 33.85C87.725 35.1 88.45 36.875 88.45 39.175V62.35Z" fill="#303031"/>
                            <path d="M95.6117 94.3545C99.0791 94.3545 101.89 91.5333 101.89 88.0531C101.89 84.5729 99.0791 81.7516 95.6117 81.7516C92.1444 81.7516 89.3335 84.5729 89.3335 88.0531C89.3335 91.5333 92.1444 94.3545 95.6117 94.3545Z" fill="#303031"/>
                            <path d="M108.372 102.679C111.023 102.679 113.173 100.521 113.173 97.8603C113.173 95.1992 111.023 93.0419 108.372 93.0419C105.721 93.0419 103.571 95.1992 103.571 97.8603C103.571 100.521 105.721 102.679 108.372 102.679Z" fill="#303031"/>
                            <path d="M119.055 109.372C120.896 109.372 122.389 107.874 122.389 106.026C122.389 104.177 120.896 102.679 119.055 102.679C117.213 102.679 115.72 104.177 115.72 106.026C115.72 107.874 117.213 109.372 119.055 109.372Z" fill="#303031"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_3_344">
                                <rect width="134" height="118" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                </div>

                <div class="flex ">
                    <div class="w-[72px] leading-5 text-white">С Новым годом!</div>
                    <img src="../../../../public/icons/free-icon-christmas-tree-2276457.png" alt="" class="w-10">
                </div>

                <div class="flex items-center gap-5">
                    <div @click="toggleModal(1)">
                        <svg width="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.6667 21.6667L27 27M3 13.6667C3 16.4956 4.12381 19.2088 6.12419 21.2091C8.12458 23.2095 10.8377 24.3333 13.6667 24.3333C16.4956 24.3333 19.2088 23.2095 21.2091 21.2091C23.2095 19.2088 24.3333 16.4956 24.3333 13.6667C24.3333 10.8377 23.2095 8.12458 21.2091 6.12419C19.2088 4.12381 16.4956 3 13.6667 3C10.8377 3 8.12458 4.12381 6.12419 6.12419C4.12381 8.12458 3 10.8377 3 13.6667Z" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <div @click="modals[1].visible ? toggleModal(2, true) : toggleModal(2)" class="py-[6px] px-2 bg-white rounded-md">
                        <svg width="24" viewBox="0 0 33 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.4999 18.6999C21.6637 18.6999 25.8498 14.5138 25.8498 9.34996C25.8498 4.18612 21.6637 0 16.4999 0C11.336 0 7.1499 4.18612 7.1499 9.34996C7.1499 14.5138 11.336 18.6999 16.4999 18.6999Z" fill="#373737"/>
                            <path d="M16.5 20.9C7.38732 20.9 0 28.2874 0 37.3999C0 39.83 1.96999 41.7999 4.40002 41.7999H28.6C31.03 41.7999 33 39.83 33 37.3999C32.9999 28.2874 25.6126 20.9 16.5 20.9Z" fill="#373737"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <SearchModal v-if="modals[0].visible" @closeModal="toggleModal(1, true)" />
        <UserModal v-if="modals[1].visible" />
        <Cover v-if="idOpenModal" />
    </nav>
</template>

<script setup>
import { ref } from 'vue'
import Cover from '../reusable/Cover.vue'
import SearchModal from '../modals/SearchModal.vue';
import UserModal from '../modals/UserModal.vue';

let idOpenModal = ref(0);

let modals = ref([
    {
        id: 1,
        name: 'search',
        visible: false
    },
    {
        id: 2,
        name: 'user',
        visible: false
    }
])

function toggleModal(id, isClose) {
    if (!isClose) {
        if (idOpenModal.value) {
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
