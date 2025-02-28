<template>
    <div>
        <SidebarComponent />
        <router-view></router-view>
    </div>
</template>

<script setup>
import SidebarComponent from '../backend/SidebarComponent.vue';
</script>
