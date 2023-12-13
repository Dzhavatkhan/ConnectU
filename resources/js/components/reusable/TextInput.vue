<template>
    <div>
        <input :type="inputType" :placeholder="placeholder" v-model="inputComputed" class="w-full text-white placeholder:text-white border-light-grey border-b bg-inherit focus:outline-none">
        <div>{{ error }}</div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits, toRefs, computed } from 'vue'

let emit = defineEmits(['update:input'])

let props = defineProps([
    'inputType', 'input', 'error', 'placeholder'
])

let { inputType, input, error, placeholder } = toRefs(props)

let inputComputed = computed({
    get: () => input.value,
    set: (value) => {
        emit('update:input', value)
    }
})
</script>
