<script setup lang="ts">
import { PlusIcon, TrashIcon } from '@heroicons/vue/24/solid'
import {v4 as uuidv4} from 'uuid';
import { ref, computed } from "vue";
import type { Question, QuestionOption } from "@/types/Survey";
import { useStore } from '@/store';

type Props = {
    question: Question;
    index: number;
}
const { question, index } = defineProps<Props>();

const emit = defineEmits<{
    change: [void],
    addQuestion: [number],
    deleteQuestion: [Question],
}>();

const store = useStore();
const questionTypes = computed(() => store.questionTypes);
const model = ref({ ...question });

const upperCaseFirst = (str: string): string => {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

// 質問が選択肢を持つべきかどうかを判断する関数
const shouldHaveOptions = (): boolean => {
    return ['select', 'radio', 'checkbox'].includes(model.value.type);
}

const getOptions = (): QuestionOption[] | undefined => {
    return model.value.data.options;
}
const setOptions = (options: QuestionOption[]): void => {
    model.value.data.options = options;
}

const addOption = (): void => {
    setOptions([
        ...getOptions() || [],
        { uuid: uuidv4(), text: '' }
    ]);
    dataChange();
}

const removeOption = (option: QuestionOption): void => {
    setOptions(getOptions()?.filter((opt) => opt !== option) || []);
    dataChange();
}

const typeChange = (): void => {
    if (!shouldHaveOptions()) {
        setOptions(getOptions() || []);
    }
    dataChange();
}

const dataChange = (): void => {
    const data = JSON.parse(JSON.stringify(model.value.data));
    if (!shouldHaveOptions()) {
        delete data.data.options;
    }
    emit('change', data);
}

const addQuestion = (): void => {
    emit('addQuestion', index + 1);
}

const deleteQuestion = (): void => {
    emit('deleteQuestion', question);
}
</script>

<template>
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-bold">
            {{ index + 1 }}. {{ model.question }}
        </h3>
        <div class="flex items-center">
            <button type="button" @click="addQuestion()"
                class="flex items-center text-sm py-1 px-3 mr-2 rounded-md text-white bg-gray-600 hover:bg-gray-700">
                <PlusIcon class="h-4 w-4 mr-2" />
                追加
            </button>
            <button type="button" @click="deleteQuestion()"
                class="flex items-center text-sm py-1 px-3 rounded-md border border-transparent text-red-500 hover:border-red-600">
                <TrashIcon class="h-4 w-4 mr-2" />
                削除
            </button>
        </div>
    </div>
    <div class="grid gap-3 grid-cols-12">
        <div class="mt-3 col-span-9">
            <label :for="'question_text' + model.data" class="block text-sm font-medium text-gray-700">
                質問文
            </label>
            <input type="text" :name="'question_text_' + model.data" v-model="model.question" @change="dataChange"
                :id="'question_text_' + model.data"
                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>
        <div class="mt-3 col-span-3">
            <label for="question_type" class="block text-sm font-medium text-gray-700">
                種類を選択してください
            </label>
            <select name="question_type" id="question_type" v-model="model.type" @change="typeChange"
                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option v-for="type in questionTypes ?? {}" :key="type" :value="type">
                    {{ upperCaseFirst(type) }}
                </option>
            </select>
        </div>
    </div>
    <div class="mt-3 col-span-9">
        <label :for="'question_description_' + model.id" class="block text-sm font-medium text-gray-700">
            説明
        </label>
        <textarea :name="'question_description_' + model.id" :id="'question_description_' + model.id"
            v-model="model.description" @change="dataChange"
            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </textarea>
    </div>
    <div>
        <div v-if="shouldHaveOptions()" class="mt-2">
            <h4 class="text-sm font-semibold mb-1 flex justify-between items-center">
                選択肢
                <button type="button" @click="addOption()"
                    class="flex items-center text-xs py-1 px-2 rounded-md text-white bg-gray-600 hover:bg-gray-700">
                    <PlusIcon class="h-4 w-4 mr-2" />
                    選択肢を追加
                </button>
            </h4>
            <div v-if="!model.data.options?.length" class="text-xs text-gray-600 text-center py-3">
                選択肢は登録されていません
            </div>
            <div v-for="(option, index) in model.data.options" :key="option.uuid" class="flex items-center mb-1">
                <span class="w-6 text-sm">{{ index + 1 }}.</span>
                <input type="text" v-model="option.text" @change="dataChange"
                    class="w-full rounded-sm py-1 px-2 text-sm border border-gray-300 focus:border-indigo-500">
                <button type="button" @click="removeOption(option)"
                    class="h-6 w-6 ml-2 rounded-full flex items-center justify-center border border-transparent transition-colors hover:border-red-100">
                    <TrashIcon class="h-4 w-4 text-red-500" />
                </button>
            </div>
        </div>
    </div>
    <hr class="my-4">
</template>