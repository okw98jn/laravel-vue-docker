<script setup lang="ts">
type Props = {
    title: 'Sign in' | 'Sign up';
    subTitle: 'ログイン' | '新規登録';
    routeName: 'Login' | 'Register';
}
const { title, subTitle, routeName } = defineProps<Props>()
</script>

<template>
    <div>
        <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"
            alt="Workflow" />
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            {{ title }} to your account
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            {{ subTitle }}は
            <RouterLink :to="{ name: routeName }" class="font-medium text-indigo-600 hover:text-indigo-500">
                こちら
            </RouterLink>
        </p>
    </div>
</template>