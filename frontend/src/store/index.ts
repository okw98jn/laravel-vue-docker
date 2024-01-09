import type { UserLogin, UserRegister } from "@/types/User";
import { defineStore } from "pinia"
import axiosClient from "@/axios";
import type { Survey, SurveyForm } from "@/types/Survey";
import type { CurrentSurveyState, SurveyState, UserState } from "./type";

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
        currentSurvey: {
            loading: false,
            data: {
                id: 0,
                title: '',
                slug: '',
                status: '',
                image: '',
                description: '',
                created_at: '',
                updated_at: '',
                expire_date: '',
                questions: []
            },
        },
        surveys: {
            loading: false,
            data: [],
        },
        questionTypes: ["select", "checkbox", "radio", "text", "textarea"],
    }),
    getters: {},
    actions: {
        getSurvey: (state: CurrentSurveyState, id: number) => {
            state.currentSurvey.loading = true;
            return axiosClient.get(`/surveys/${id}`)
                .then((res) => {
                    state.currentSurvey.data = res.data.data;
                    state.currentSurvey.loading = false;
                    return res;
                })
                .catch((err) => {
                    state.currentSurvey.loading = false;
                    return err;
                });
        },
        saveSurvey: (state: CurrentSurveyState, survey: SurveyForm) => {
            delete survey.image_url;
            let response;
            if (survey.id) {
                response = axiosClient
                    .put(`/surveys/${survey.id}`, survey)
                    .then((res) => {
                        state.currentSurvey.data = res.data.data;
                        return res;
                    });
            } else {
                response = axiosClient
                    .post("/surveys", survey)
                    .then((res) => {
                        state.currentSurvey.data = res.data.data;
                        return res;
                    });
            }

            return response;
        },
        deleteSurvey: (id: number) => {
            return axiosClient.delete(`/surveys/${id}`);
        },
        getSurveys: (state: SurveyState) => {
            state.surveys.loading = true;
            return axiosClient.get("/surveys")
                .then((res) => {
                    state.surveys.data = res.data.data;
                    state.surveys.loading = false;
                    return res;
                })
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
