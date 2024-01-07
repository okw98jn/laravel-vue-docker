import { createRouter, createWebHistory } from 'vue-router'
import { useStore } from '@/store'
import DefaultLayout from '@/components/DefaultLayout.vue'
import Dashboard from '@/views/Dashboard.vue'
import Surveys from '@/views/Surveys.vue'
import AuthLayout from '@/components/auth/AuthLayout.vue'
import Login from '@/views/Login.vue'
import Register from '@/views/Register.vue'
import SurveyView from '@/views/SurveyView.vue'

const routes = [
	{
		path: '/',
		redirect: '/dashboard',
		component: DefaultLayout,
		meta: { requiresAuth: true },
		children: [
			{ path: '/dashboard', name: 'Dashboard', component: Dashboard },
			{ path: '/surveys', name: 'Surveys', component: Surveys },
			{ path: '/surveys/create', name: 'SurveyCreate', component: SurveyView },
			{ path: '/surveys/:id', name: 'SurveyView', component: SurveyView },
		]
	},
	{
		path: '/auth',
		redirect: '/login',
		name: 'Auth',
		component: AuthLayout,
		meta: { isGuest: true },
		children: [
			{ path: '/login', name: 'Login', component: Login },
			{ path: '/register', name: 'Register', component: Register },
		]
	},
]

const router = createRouter({
	history: createWebHistory(),
	routes,
});

router.beforeEach((to, from, next) => {
	const store = useStore();
	if (to.meta.requiresAuth && !store.user.token) {
		next({ name: 'Login' })
	} else if (store.user.token && (to.meta.isGuest)) {
		next({ name: 'Dashboard' })
	} else {
		next()
	}
})

export default router
