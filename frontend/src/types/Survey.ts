export type Survey = {
    id: number;
    title: string;
    slug: string;
    status: string;
    image: string;
    description: string;
    created_at: string;
    updated_at: string;
    expire_date: string;
    questions: Question[];
};

export type SurveyForm = {
    id: number | null;
    title: string;
    status: string;
    image: string;
    description: string;
    expire_date: string;
    questions: Question[];
};

export type Question = {
    id: number;
    type: string;
    question: string;
    description: string;
    data: QuestionData;
};

export type QuestionData = {
    options?: QuestionOption[];
};

export type QuestionOption = {
    uuid: string;
    text: string;
};