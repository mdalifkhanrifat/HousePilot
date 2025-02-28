<template>
    <div>
        <NavbarComponent />
        <router-view></router-view>
        <FooterComponent />
    </div>
</template>

<script setup>
import NavbarComponent from '../frontend/NavbarComponent.vue';
import FooterComponent from '../frontend/FooterComponent.vue';
</script>
