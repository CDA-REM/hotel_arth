
require('./bootstrap');
import {createApp} from 'vue';
import App from './App.vue';
import {createPinia} from "pinia";
import router from "./router";
import { createI18n } from "vue-i18n";
import {translations} from "../translations/translations";
import axios from 'axios';

export const i18n = createI18n({
    locale: localStorage.lang || 'fr',
    messages: translations
})

createApp(App)
    .use(router)
    .use(createPinia())
    .use(i18n)
    .mount('#app')

// Configuration Axios
axios.defaults.withCredentials = true;
axios.defaults.baseURL = process.env.BASE_URL;
// Axios interceptor modifies HTTP header before the request is sent back to Laravel
axios.interceptors.request.use(
    function (config) {
        config.headers['Accept-Language'] = localStorage.lang;
        return config;
    },
    function (error) {
        return Promise.reject(error);
    }
);

