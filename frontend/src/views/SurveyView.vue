<script setup lang="ts">
import { v4 as uuidv4 } from 'uuid';
import { PlusIcon, TrashIcon } from '@heroicons/vue/24/solid'
import PageLayout from '@/components/PageLayout.vue';
import { useStore } from '@/store';
import type { Question, SurveyForm } from '@/types/Survey';
import { ref, watch, type Ref, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import QuestionEditor from '@/components/editor/QuestionEditor.vue';

const store = useStore();
const route = useRoute();
const router = useRouter();
const surveyLoading = computed(() => store.$state.currentSurvey.loading);

const model: Ref<SurveyForm> = ref({
	id: null,
	title: '',
	status: '',
	image: '',
	image_url: '',
	description: '',
	expire_date: '',
	questions: []
});

watch(
	() => store.$state.currentSurvey.data,
	(newVal, oldVal) => {
		model.value = {
			...JSON.parse(JSON.stringify(newVal)),
			status: newVal.status !== 'draft',
		};
	}
);

if (route.params.id) {
	store.getSurvey(store, Number(route.params.id));
}

const onImageChoose = (event: any): void => {
	const file = event.target.files[0];

	const reader = new FileReader();
	reader.onload = () => {
		if (typeof reader.result === 'string') {
			model.value.image = reader.result;
			model.value.image_url = reader.result;
		}
	};
	reader.readAsDataURL(file);
};

const addQuestion = (index: number = 0): void => {
	const newQuestion = {
		id: uuidv4(),
		type: 'text',
		question: '',
		description: '',
		data: {},
	}
	model.value.questions.splice(index, 0, newQuestion);
};

const deleteQuestion = (question: Question): void => {
	model.value.questions = model.value.questions.filter(
		(q) => q !== question
	);
};

const questionChange = (question: Question): void => {
	model.value.questions = model.value.questions.map((q) => {
		if (q.id === question.id) {
			return JSON.parse(JSON.stringify(question));
		}
		return q;
	});
};

const saveSurvey = (): void => {
	store.saveSurvey(store, model.value)
		.then((data: any) => {
			router.push({
				name: 'SurveyView',
				params: { id: data.data.id },
			});
		})
}

const deleteSurvey = (): void => {
	if (confirm('本当に削除しますか？') && model.value.id) {
		store.deleteSurvey(model.value.id)
			.then(() => {
				router.push({
					name: 'Surveys',
				});
			})
	}
}
</script>

<template>
	<PageLayout>
		<template v-slot:header>
			<div class="flex items-center justify-between">
				<h1 class="text-3xl font-bold text-gray-900">
					{{ route.params.id ? model.title : '新規登録' }}
				</h1>

				<button v-if="route.params.id" type="button" @click="deleteSurvey()"
					class="py-2 px-4 text-white bg-red-500 rounded-md hover:bg-red-600">
					<TrashIcon class="h-5 w-5 -mt-1 inline-block" />
					削除
				</button>
			</div>
		</template>
		<div v-if="surveyLoading" class="flex justify-center">Loading...</div>
		<form v-else @submit.prevent="saveSurvey">
			<div class="shadow sm:rounded-md sm:overflow-hidden">
				<div class="px-4 py-5 bg-white space-y-6 sm:p-6">
					<!-- image -->
					<div>
						<label class="block text-sm font-medium text-gray-700">
							画像
						</label>
						<div class="mt-1 flex items-center">
							<img v-if="model.image_url" :src="model.image_url" :alt="model.title"
								class="w-64 h-48 object-cover">
							<span v-else
								class="flex items-center justify-center h-12 w-12 rounded-full overflow-hidden bg-gray-100">
								<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"
									class="h-[80%] w-[80%] text-gray-300">
									<path fill-rule="evenodd" clip-rule="evenodd"
										d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" />
								</svg>
							</span>
							<button type="button"
								class="relative overflow-hidden ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
								<input type="file" @change="onImageChoose"
									class="absolute left-0 top-0 right-0 button-0 opacity-0 cursor-pointer">
								変更
							</button>
						</div>
					</div>
					<!-- title -->
					<div>
						<label for="title" class="block text-sm font-medium text-gray-700">
							タイトル
						</label>
						<input type="text" name="title" id="title" v-model="model.title" autocomplete="survey_title"
							class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
					</div>
					<!-- description -->
					<div>
						<label for="description" class="block text-sm font-medium text-gray-700">
							説明
						</label>
						<textarea name="description" id="description" rows="3" v-model="model.description"
							autocomplete="survey_description" placeholder="アンケート説明"
							class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">
						</textarea>
					</div>
					<!-- expire date -->
					<div>
						<label for="expire_date" class="block text-sm font-medium text-gray-700">
							有効期限
						</label>
						<input type="date" name="expire_date" id="expire_date" v-model="model.expire_date"
							class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
					</div>
					<!-- status -->
					<div class="flex items-start">
						<div class="flex items-center h-5">
							<input id="status" name="status" type="checkbox" v-model="model.status"
								class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
						</div>
						<div class="ml-3 text-sm">
							<label for="status" class="font-medium text-gray-700">
								公開する
							</label>
						</div>
					</div>
				</div>
				<div class="px-4 py-5 bg-white space-y-6 sm:p-6">
					<h3 class="text-2xl font-semibold flex items-center justify-between">
						質問
						<button type="button" @click="addQuestion()"
							class="flex items-center text-sm py-1 px-4 rounded-md text-white bg-gray-600 hover:bg-gray-700">
							<PlusIcon class="h-4 w-4 mr-2" />
							追加
						</button>
					</h3>
					<div v-if="!model.questions.length" class="text-center text-gray-600">
						質問は登録されていません
					</div>
					<div v-for="(question, index) in model.questions" :key="question.id">
						<QuestionEditor :question="question" :index="index" @change="questionChange"
							@addQuestion="addQuestion" @deleteQuestion="deleteQuestion" />
					</div>
				</div>
				<div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
					<button type="submit"
						class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
						保存
					</button>
				</div>
			</div>
		</form>
	</PageLayout>
</template>
