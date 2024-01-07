import type { User, UserLogin, UserRegister } from "@/types/User";
import { defineStore } from "pinia"
import axiosClient from "@/axios";
import type { Survey, SurveyForm } from "@/types/Survey";

type UserState = {
    user: {
        data: User;
        token: string | null;
    };
};

type SurveyState = {
    surveys: Survey[];
};

const tmpSurveys: Survey[] = [
    {
        id: 100,
        title: "test1",
        slug: "test-1",
        status: "draft",
        image: "https://picsum.photos/400/400",
        description: "test",
        created_at: "2023-01-06 14:00:00",
        updated_at: "2023-01-06 14:00:00",
        expire_date: "2023-01-09 14:00:00",
        questions: [
            {
                id: 1,
                type: 'select',
                question: "どこの国から来ましたか?",
                description: '',
                data: {
                    options: [
                        { uuid: '1reterter435435435', text: 'USA' },
                        { uuid: '1fdgdfgdfgbcbnnhhh', text: 'Canada' },
                        { uuid: '1gdfdf54hghgfbbfgg', text: 'Mexico' },
                    ]
                }
            },
            {
                id: 2,
                type: 'checkbox',
                question: "好きなプログラミング言語は?",
                description: '質問２説明文',
                data: {
                    options: [
                        { uuid: '2ghfhdfghdfhgfhgh5', text: 'JavaScrip' },
                        { uuid: '2we325rrgnhgfjhfgf', text: 'HTML + CSS' },
                        { uuid: '2h567yutyhtrhhnggf', text: 'PHP' },
                    ]
                }
            },
            {
                id: 3,
                type: 'checkbox',
                question: "PHPのフレームワークでおすすめは?",
                description: '質問3説明文',
                data: {
                    options: [
                        { uuid: '3hthu68ujgjgfhfghg', text: 'Laravel' },
                        { uuid: '3gfhfgbvcbcvngyhjr', text: 'Codeigniter' },
                        { uuid: '3hfgh657ytrhtgghgd', text: 'Symfony' },
                    ]
                }
            },
            {
                id: 4,
                type: 'radio',
                question: "使用しているLaravelのバージョンは?",
                description: '質問4説明文',
                data: {
                    options: [
                        { uuid: '4fdggdfdfgfgdfggfd', text: 'Laravel 7' },
                        { uuid: '4liuliukjhhjkjhhgh', text: 'Laravel 8' },
                        { uuid: '4tyryrtytrhfg6456g', text: 'Laravel 9' },
                        { uuid: '4gthjh65y65hghghgf', text: 'Laravel 10' },
                    ]
                }
            },
            {
                id: 5,
                type: 'checkbox',
                question: "PHPのフレームワークでおすすめは2?",
                description: '質問5説明文',
                data: {
                    options: [
                        { uuid: '5yuyghjgfhtrytyhgg', text: 'Laravel2' },
                        { uuid: '5tyrtng556ytryhgfh', text: 'Codeigniter2' },
                        { uuid: '5hrt45hewrfghhhtht', text: 'Symfony2' },
                    ]
                }
            },
            {
                id: 6,
                type: 'text',
                question: "好きなプログラミング言語は?",
                description: '',
                data: {}
            },
            {
                id: 7,
                type: 'textarea',
                question: "PHPのことをどう思っている?",
                description: '質問7説明文',
                data: {}
            },
        ]
    },
    {
        id: 200,
        title: "test2",
        slug: "test-2",
        status: "active",
        image: "https://picsum.photos/400/400",
        description: "test2description",
        created_at: "2023-01-06 14:00:00",
        updated_at: "2023-01-06 14:00:00",
        expire_date: "2023-01-09 14:00:00",
        questions: []
    },
    {
        id: 300,
        title: "test3",
        slug: "test-3",
        status: "active",
        image: "https://picsum.photos/400/400",
        description: "test3",
        created_at: "2023-01-06 14:00:00",
        updated_at: "2023-01-06 14:00:00",
        expire_date: "2023-01-09 14:00:00",
        questions: []
    },
    {
        id: 400,
        title: "test4",
        slug: "test-4",
        status: "active",
        image: "https://picsum.photos/400/400",
        description: "test4",
        created_at: "2023-01-06 14:00:00",
        updated_at: "2023-01-06 14:00:00",
        expire_date: "2023-01-09 14:00:00",
        questions: []
    },
];

export const useStore = defineStore({
    id: "app",
    state: () => ({
        user: {
            data: {
                name: '',
                email: '',
                imageUrl: ''
            },
            token: sessionStorage.getItem('TOKEN'),
        },
        surveys: [...tmpSurveys],
        questionTypes: ["select", "checkbox", "radio", "text", "textarea"],
    }),
    getters: {},
    actions: {
        saveSurvey: (state: SurveyState, survey: SurveyForm) => {
            delete survey.image_url;
            let response;
            if (survey.id) {
                response = axiosClient
                    .put(`/surveys/${survey.id}`, survey)
                    .then((res) => {
                        state.surveys = state.surveys.map((s) => {
                            if (s.id === survey.id) {
                                return res.data;
                            }
                            return s;
                        });
                        return res;
                    });
            } else {
                response = axiosClient
                    .post("/surveys", survey)
                    .then((res) => {
                        state.surveys = [...state.surveys, res.data];
                        return res;
                    });
            }

            return response;
        },
        register: (state: UserState, user: UserRegister) => {
            return axiosClient.post('/register', user)
                .then(({ data }) => {
                    state.user.token = data.token;
                    state.user.data = data.user;
                    sessionStorage.setItem('TOKEN', data.token);
                    return data;
                })
        },
        login: (state: UserState, user: UserLogin) => {
            return axiosClient.post('/login', user)
                .then(({ data }) => {
                    state.user.token = data.token;
                    state.user.data = data.user;
                    sessionStorage.setItem('TOKEN', data.token);
                    return data;
                })
        },
        logout: (state: UserState) => {
            return axiosClient.post('/logout')
                .then(response => {
                    state.user.data = {
                        name: '',
                        email: '',
                        imageUrl: ''
                    };
                    state.user.token = null;
                    sessionStorage.removeItem('TOKEN');
                    return response;
                })

        }
    },
})
