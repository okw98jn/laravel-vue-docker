<script setup lang="ts">
import { PlusIcon } from '@heroicons/vue/24/solid'
import PageLayout from '@/components/PageLayout.vue';
import { useStore } from '@/store';
import { computed, type ComputedRef } from 'vue';
import { type Survey } from '@/types/Survey';
import SurveyListItem from '@/components/SurveyListItem.vue';

const store = useStore();
const surveys: ComputedRef<Survey[]> = computed(() => store.surveys.data);
store.getSurveys(store);

const deleteSurvey = (survey: Survey): void => {
	if (confirm('本当に削除しますか？')) {
		store.deleteSurvey(survey.id)
		.then(() => {
			store.getSurveys(store);
		})
	}
};
</script>

<template>
	<PageLayout>
		<template v-slot:header>
			<div class="flex justify-between items-center">
				<h1 class="text-3xl font-bold tracking-tight text-gray-900">Surveys</h1>
				<RouterLink :to="{ name: 'SurveyCreate' }"
					class="py-2 px-3 text-white bg-emerald-500 rounded-md hover:bg-emerald-600">
					<PlusIcon class="h-4 w-4 -mt-1 inline-block" />
					アンケート登録
				</RouterLink>
			</div>
		</template>
		<div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
			<SurveyListItem v-for="survey in surveys" :key="survey.id" :survey="survey"
				@delete-survey="deleteSurvey(survey)" />
		</div>
	</PageLayout>
</template>
