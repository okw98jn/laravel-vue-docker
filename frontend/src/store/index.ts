import type { User } from "@/types/User";
import { defineStore } from "pinia"

type UserState = {
    user: {
        data: User;
        token: number | null;
    };
};

export const useStore = defineStore({
    id: "app",
    state: (): UserState => ({
        user: {
            data: {
                name: 'Tom Cook',
                email: 'tom@example.com',
                imageUrl:
                    'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            },
            token: 1,
        },
    }),
    getters: {},
    actions: {
        logout: (state: UserState) => {
            state.user.data = {
                name: '',
                email: '',
                imageUrl: ''
            };
            state.user.token = null;
        }
    },
})
