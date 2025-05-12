<!-- // ✅ File: src/views/frontend/Home.vu -->
<template>
  <div>
    <HeroSection />
    <ClientsSection />
    <FeaturesSection />
    <StatsSection />
  </div>
</template>

<script setup>
import HeroSection from './components/HeroSection.vue'
import ClientsSection from './components/ClientsSection.vue'
import FeaturesSection from './components/FeaturesSection.vue'
import StatsSection from './components/StatsSection.vue'
</script>
