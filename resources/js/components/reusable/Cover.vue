<template>
    <div :class="'absolute inset-0 bg-zinc-800/90 ' + stylesInput"></div>
</template>

<script setup>
import { defineProps, toRefs } from 'vue'

let props = defineProps(['stylesInput'])

let { stylesInput } = toRefs(props)
</script>
