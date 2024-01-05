import axios from "axios";
import { useStore } from "./store";

const axiosClient = axios.create({
    baseURL: "http://localhost:8000/api",
});

axiosClient.interceptors.request.use(config => {
    const store = useStore();
    config.headers.Authorization = `Bearer ${store.user.token}`;
    return config;
})
export default axiosClient;