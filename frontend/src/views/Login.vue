<script setup lang="ts">
import { useStore } from '@/store';
import { useRouter } from 'vue-router';
import type { UserLogin } from '@/types/User';
import { ref, type Ref } from 'vue';
import Header from '@/components/auth/Header.vue';
import ErrorMessage from '@/components/auth/ErrorMessage.vue';
import SubmitButton from '@/components/auth/SubmitButton.vue';
import InputItem from '@/components/auth/InputItem.vue';

const store = useStore();
const router = useRouter();
const errorMsg: Ref<string> = ref('');
const user: UserLogin = {
	email: '',
	password: '',
	remember: false
};

const login = (e: Event): void => {
	e.preventDefault();
	store.login(store, user)
		.then(() => {
			router.push({
				name: 'Dashboard'
			});
		})
		.catch((err) => {
			errorMsg.value = err.response.data.error;
		})
}
</script>

<template>
	<Header title="Sign in" sub-title="新規登録" route-name="Register" />
	<form class="mt-8 space-y-6" @submit="login">
		<ErrorMessage :error-msg="errorMsg" @clear-error="errorMsg = ''" />
		<input type="hidden" name="remember" value="true" />
		<div class="rounded-md shadow-sm ">
			<InputItem name="email" label="メールアドレス" type="email" autocomplete="email" placeholder="メールアドレス"
				v-model="user.email" />
			<InputItem name="password" label="パスワード" type="password" autocomplete="current-password" placeholder="パスワード"
				v-model="user.password" />
		</div>

		<div class="flex items-center justify-between">
			<div class="flex items-center">
				<input id="remember-me" name="remember-me" type="checkbox" v-model="user.remember"
					class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
				<label for="remember-me" class="ml-2 block text-sm text-gray-900">
					ログイン状態を保存する
				</label>
			</div>
		</div>
		<div>
			<SubmitButton text="ログイン" />
		</div>
	</form>
</template>