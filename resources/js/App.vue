<template>
    <header>
        <nav-bar-header />
    </header>

    <main>
        <section class="max-lg:p-3 lg:px-72 mt-2 lg:mt-48 mb-16">
            <div class="relative container m-auto">
                <div class="flex justify-between lg:mt-10 lg:gap-20">
                    <nav-bar-aside />
                    <router-view/>
                </div>
            </div>
        </section>
    </main>
</template>

<script setup>
import Swal from "sweetalert2"
import NavBarAside from './components/structure/NavBarAside.vue';
import NavBarHeader from './components/structure/NavBarHeader.vue';
</script>
