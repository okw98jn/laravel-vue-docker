<script setup lang="ts">
import { LockClosedIcon } from '@heroicons/vue/24/solid'
import { useStore } from '@/store';
import { useRouter } from 'vue-router';
import type { UserRegister } from '@/types/User';
import Header from '@/components/auth/Header.vue';

const store = useStore();
const router = useRouter();

const user: UserRegister = {
	name: '',
	email: '',
	password: '',
	password_confirmation: '',
};

const register = (e: Event): void => {
	e.preventDefault();
	store.register(store, user)
		.then(() => {
			router.push({
				name: 'Dashboard'
			});
		})
}
</script>

<template>
	<Header title="Sign up" sub-title="ログイン" route-name="Login" />
	<form class="mt-8 space-y-6" @submit="register">
		<input type="hidden" name="remember" value="true" />
		<div class="rounded-md shadow-sm">
			<div class="mb-2">
				<label for="name" class="sr-only">名前</label>
				<input id="name" name="name" type="text" autocomplete="name" v-model="user.name"
					class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
					placeholder="名前" />
			</div>
			<div class="mb-2">
				<label for="email-address" class="sr-only">メールアドレス</label>
				<input id="email-address" name="email" type="email" autocomplete="email" v-model="user.email"
					class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
					placeholder="メールアドレス" />
			</div>
			<div class="mb-2">
				<label for="password" class="sr-only">パスワード</label>
				<input id="password" name="password" type="password" autocomplete="current-password" v-model="user.password"
					class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
					placeholder="パスワード" />
			</div>
			<div>
				<label for="password_confirmation" class="sr-only">パスワード確認</label>
				<input id="password_confirmation" name="password_confirmation" type="password"
					autocomplete="current-password_confirmation" v-model="user.password_confirmation"
					class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
					placeholder="パスワード確認" />
			</div>
		</div>
		<div>
			<button type="submit"
				class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
				<span class="absolute left-0 inset-y-0 flex items-center pl-3">
					<LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
				</span>
				新規登録
			</button>
		</div>
	</form>
</template>