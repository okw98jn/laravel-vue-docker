<script setup lang="ts">
import type { Survey } from '@/types/Survey';
import { PencilIcon, TrashIcon } from '@heroicons/vue/24/solid';

type Props = {
    survey: Survey
}
const { survey } = defineProps<Props>()

const emit = defineEmits<{
    deleteSurvey: [Survey],
}>();

</script>

<template>
    <div class="flex flex-col py-4 px-6 shadow-md bg-white hover:bg-green-50 h-[470px]">
        <img :src="survey.image_url" alt="" class="w-full h-48 object-cover">
        <h4 class="mt-4 text-lg font-bold">{{ survey.title }}</h4>
        <div v-html="survey.description" class="overflow-hidden flex-1"></div>
        <div class="flex justify-between items-center mt-3">
            <RouterLink :to="{ name: 'SurveyView', params: { id: survey.id } }"
                class="flex py-2 px-4 border border-transparent text-sm rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <PencilIcon class="h-5 w-5 mr-2" />
                編集
            </RouterLink>
            <button v-if="survey.id" type="button" @click="emit('deleteSurvey', survey)"
                class="h-8 w-8 flex items-center justify-center rounded-full border border-transparent text-sm text-red-500 focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <TrashIcon class="h-5 w-5 -mt-1 inline-block" />
            </button>
        </div>
    </div>
</template>