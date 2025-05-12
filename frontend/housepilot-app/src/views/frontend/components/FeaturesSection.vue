<!-- // ✅ File: src/views/frontend/components/FeaturesSection.vue -->
<template>
  <section class="py-12 px-6">
    <h3 class="text-xl font-semibold text-center mb-4">Manage your entire community in a single system</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
      <div v-for="(feature, i) in features" :key="i" class="p-4 bg-white dark:bg-gray-800 rounded shadow">
        <h4 class="font-bold mb-2">{{ feature.title }}</h4>
        <p class="text-sm text-gray-600 dark:text-gray-300">{{ feature.desc }}</p>
      </div>
    </div>
  </section>
</template>

<script setup>
const features = [
  { title: 'Membership Organisations', desc: 'Full automation of renewals and payments.' },
  { title: 'National Associations', desc: 'Automation of renewals and tracking.' },
  { title: 'Clubs And Groups', desc: 'Efficient management for clubs and groups.' },
]
</script>