<template>
    <div class="w-full">
        <input :type="inputType" :placeholder="placeholder" v-model="inputComputed" :class="'w-full lg:py-2 lg:text-3xl text-white placeholder:text-white border-light-grey border-b bg-inherit focus:outline-none ' + stylesInput">
        <div v-if="error" class="text-red-500 text-sm lg:text-2xl">{{ error }}</div>
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
