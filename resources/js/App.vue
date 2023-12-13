<template>
    <header>
        <nav-bar />
    </header>

    <main>
        <router-view/>
    </main>
</template>

<script setup>
import NavBar from './components/structure/NavBar.vue';
</script>
