<template>
  <header class="sticky top-0 inset-x-0 flex flex-wrap md:justify-start md:flex-nowrap z-48 w-full bg-white border-b border-gray-200 text-sm py-2.5 lg:ps-65 dark:bg-neutral-800 dark:border-neutral-700">
    <nav class="px-4 sm:px-6 flex basis-full items-center w-full mx-auto">
      <div class="me-5 lg:me-0 lg:hidden flex items-center">
        <a class="flex-none rounded-md text-xl inline-block font-semibold focus:outline-hidden focus:opacity-80" href="#" aria-label="Preline">
          <svg class="w-28 h-auto" width="116" height="32" viewBox="0 0 116 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- SVG Path Here -->
          </svg>
        </a>
      </div>
      <div class="w-full flex items-center justify-end ms-auto md:justify-between gap-x-1 md:gap-x-3">
        <SearchInput />
        <DarkModeToggle />
        <Dropdown /> <!-- এখানে Dropdown কম্পোনেন্ট যুক্ত করা হয়েছে -->
      </div>
    </nav>
  </header>
</template>

<script>
import SearchInput from './SearchInput.vue';
import DarkModeToggle from './DarkModeToggle.vue';
import Dropdown from './Dropdown.vue'; // Dropdown কম্পোনেন্ট আমদানি করা

export default {
  components: {
    SearchInput,
    DarkModeToggle,
    Dropdown // Dropdown কম্পোনেন্ট যুক্ত করা
  }
}
</script>