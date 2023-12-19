<template>
    <div class="w-full">
        <textarea :type="inputType" :placeholder="placeholder" v-model="inputComputed" :class="'flex h-72 w-full p-2 lg:py-2 lg:text-3xl text-white placeholder:text-white border-light-grey  rounded-md bg-light-black focus:outline-none ' + stylesInput"></textarea>
        <div class="text-red-500 text-sm lg:text-2xl">{{ error }}</div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits, toRefs, computed } from 'vue'

let emit = defineEmits(['update:input'])

let props = defineProps([
    'inputType', 'input', 'error', 'placeholder', 'stylesInput'
])

let { inputType, input, error, placeholder, stylesInput } = toRefs(props)

let inputComputed = computed({
    get: () => input.value,
    set: (value) => {
        emit('update:input', value)
    }
})
</script>
