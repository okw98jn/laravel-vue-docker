<script setup lang="ts">
type Props = {
    name: string;
    label: string;
    type: 'text' | 'email' | 'password';
    autocomplete: string;
    placeholder: string;
}
const { name, type, autocomplete, placeholder } = defineProps<Props>();
const model = defineModel<string>()
</script>

<template>
    <div class="mb-2">
        <label :for="name" class="sr-only">{{ label }}</label>
        <input :id="name" :name="name" :type="type" :autocomplete="autocomplete" v-model="model"
            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
            :placeholder="placeholder" />
    </div>
</template>