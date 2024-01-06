<script setup lang="ts">
import { useStore } from '@/store';
import { useRouter } from 'vue-router';
import type { UserRegister } from '@/types/User';
import Header from '@/components/auth/Header.vue';
import SubmitButton from '@/components/auth/SubmitButton.vue';
import InputItem from '@/components/auth/InputItem.vue';

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
			<InputItem name="name" label="名前" type="text" autocomplete="name" placeholder="名前" v-model="user.name" />
			<InputItem name="email" label="メールアドレス" type="email" autocomplete="email" placeholder="メールアドレス"
				v-model="user.email" />
			<InputItem name="password" label="パスワード" type="password" autocomplete="current-password" placeholder="パスワード"
				v-model="user.password" />
			<InputItem name="password_confirmation" label="パスワード確認" type="password"
				autocomplete="current-password_confirmation" placeholder="パスワード確認" v-model="user.password_confirmation" />
		</div>
		<div>
			<SubmitButton text="新規登録" />
		</div>
	</form>
</template>