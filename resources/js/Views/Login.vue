<!--Les balises span sont celles de Daisy UI : NE PAS RETIRER LES BALISES SPAN : class CSS Daisy UI -->
<template>
    <!--    navigation breadcrumb-->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center ml-6">
                <router-link :to="{ name: 'landingPage'}"
                             class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    {{ $t("breadcrumb.home")}}
                </router-link>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400"
                         fill="currentColor"
                         viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                              clip-rule="evenodd"></path></svg>
                    <span
                        class="ml-1 text-sm font-medium md:ml-2 text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">{{ $t("breadcrumb.login")}}</span>
                </div>
            </li>
        </ol>
    </nav>
    <div class="login__section">
        <h1>{{ $t("login.title")}}</h1>

        <form class="mt-12 mb-20">
            <div class="text-center text-red-500">{{ errors.error }}</div>
            <div class="form-control w-full max-w-xs mx-auto mt-5">
                <label class="label">
                    <span class="label-text">Email</span>
                </label>
                <input type="text" placeholder="Email" v-model="user.email" id="email" autocomplete="off"/>
                <span class="text-red-500 text-sm" v-for="email in errors.email">{{ email }}</span>
                <label class="label">
                    <span class="label-text">{{ $t("login.password") }}</span>
                </label>
                <input type="password" placeholder="Password" v-model="user.password" id="password" autocomplete="off"/>
                <span class="text-red-500 text-sm" v-for="password in errors.password">{{ password }}</span>
                <p class="mt-6 text-arth-dark-blue text-center"><router-link :to="{ name: 'signUp'}">{{
                        $t('login.dontHaveAccount')
                    }}</router-link></p>
            </div>

            <div class="flex mx-auto mt-6">
                <button @click="submitLogin()" class="bg-arth-green hover:scale-105">{{ $t("login.title") }}</button>
            </div>
        </form>


    </div>
</template>

<script>

import {useUserStore} from '../../stores/userStore'
import axios from "axios";
import {handleResponse} from "../utils/apiUtils";
import router from "../router";

export default {
    name: 'login',

    setup() {
        const userStore = useUserStore();
        return { userStore }
    },
    data() {
        return {
            user:{
                email: '',
                password: ''
            },
            errors: []
        }
    },
    methods: {
        async submitLogin() {
            this.errors = []

            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.post('api/login', this.user)
                this.userStore.user = handleResponse(response)
                this.userStore.isLogged = true
                localStorage.setItem('isLogged', 'true')
                await router.push({name: 'landingPage'})
            } catch (errors) {
                this.errors = errors
            }
        },


    }

}
</script>

<style scoped >
    .login__section {
        @apply w-11/12 sm:w-96 md:w-3/6 lg:w-4/12 mx-auto my-16
    }

    p, span {
        font-size: 16px;
    }
</style>
