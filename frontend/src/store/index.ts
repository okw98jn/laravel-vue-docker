import type { User, UserLogin, UserRegister } from "@/types/User";
import { defineStore } from "pinia"
import axiosClient from "@/axios";

type UserState = {
    user: {
        data: User;
        token: string | null;
    };
};

export const useStore = defineStore({
    id: "app",
    state: (): UserState => ({
        user: {
            data: {
                name: '',
                email: '',
                imageUrl: ''
            },
            token: sessionStorage.getItem('TOKEN'),
        },
    }),
    getters: {},
    actions: {
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
