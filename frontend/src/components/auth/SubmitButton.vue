<script setup lang="ts">
import { LockClosedIcon } from '@heroicons/vue/24/solid'

type Props = {
    text: string;
}
const { text } = defineProps<Props>();
</script>

<template>
    <button type="submit"
        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
        </span>
        {{ text }}
    </button>
</template>