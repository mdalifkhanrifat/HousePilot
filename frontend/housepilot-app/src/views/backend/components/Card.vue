<template>
  <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
    <div class="p-4 md:p-5">
      <div class="flex items-center gap-x-2">
        <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">{{ title }}</p>
      </div>
      <div class="mt-1 flex items-center gap-x-2">
        <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">{{ value }}</h3>
        <span v-if="percentage" class="flex items-center gap-x-1 text-green-600">
          <svg class="inline-block size-4 self-center" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="22 7 13.5 15.5 8.5 10.5 2 17" />
            <polyline points="16 7 22 7 22 13" />
          </svg>
          <span class="inline-block text-sm">{{ percentage }}</span>
        </span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: true
    },
    value: {
      type: String,
      required: true
    },
    percentage: {
      type: String,
      default: null
    }
  }
}
</script>

<style scoped>
/* Add any additional styles here if needed */
</style>