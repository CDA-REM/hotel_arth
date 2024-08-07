<!--Les balises span sont celles de Daisy UI : NE PAS RETIRER LES BALISES SPAN : class CSS Daisy UI -->
<template>
    <!--    navigation breadcrumb-->
    <nav class="flex " aria-label="Breadcrumb">
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
                        class="ml-1 text-sm font-medium md:ml-2 text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">{{ $t("breadcrumb.signUp")}}</span>
                </div>
            </li>
        </ol>
    </nav>
    <div class="signup__section">
        <h1 class="mt-8">{{ $t("signUp.title")}}</h1>
        <form ref="signUpForm">
            <div class="form-control w-full max-w-xs mx-auto mt-12 flex flex-col space-y-5">
                <div>
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="text" placeholder="Email" v-model="user.email" id="email" />
                    <p class="text-red-500 text-sm" v-for="email in errors.email">{{ email }}</p>
                </div>
                <div>
                    <label class="label">
                        <span class="label-text">{{ $t("signUp.password") }}</span>
                    </label>
                    <input type="password" placeholder="Password" v-model="user.password" id="password" autocomplete="off"/>
                    <p class="text-red-500 text-sm" v-for="password in errors.password">{{ password }}</p>
                </div>
                <div>
                    <label class="label">
                        <span class="label-text">{{ $t("signUp.confirmPassword") }}</span>
                    </label>
                    <input type="password" placeholder="Password confirmation" v-model="user.password_confirmation" id="password_confirmation" autocomplete="off" minlength="8"/>
                </div>
                <div class=" flex space-x-4 mt-4">
                    <span class="label-text">{{ $t("signUp.rememberToken") }}</span>
                    <input type="checkbox" class="w-4 h-4" v-model="rememberMe" id="remember_me" />
                </div>
                <p class="mt-6 text-center text-arth-dark-blue"><router-link :to="{ name: 'login'}">{{
                        $t('signUp.haveAccount') }}</router-link></p>
            </div>

            <div class="flex mx-auto mt-12 mb-8">
                <button @click="registerUserIfFormValid()" class="bg-arth-green hover:scale-105">{{ $t("signUp.button") }}</button>
            </div>
        </form>
    </div>
</template>

<script>

import { useUserStore } from '../../stores/userStore'
import {handleResponse} from "../utils/apiUtils";
import authStore from '../../stores/auth';

export default {
    name: 'signUp',

    setup() {
        const userStore = useUserStore();
        return { userStore }
    },
    data() {
        return {
            user:{
                email: '',
                password: '',
                password_confirmation: '',
                message_email:'',
                message_password: '',
                remember_token: '',
                token:''
            },
            errors: [],
            userIsRegistered: false,
            rememberMe: false,
        }
    },

    methods: {
        registerUserIfFormValid() {
            if (this.$refs.signUpForm.reportValidity()) {
                this.registerUser()
            }
        },
        /**
         * Enregistre un utilisateur et redirige vers la page de confirmation en cas de succès.
         *
         * Cette fonction effectue une requête d'inscription à l'API et, si l'inscription réussit, redirige l'utilisateur vers la page de confirmation.
         * En cas d'échec, l'utilisateur est redirigé vers la page précédemment prévue.
         *
         * @async
         * @return {Promise<void>}
         * @throws {Error[]} errors - Une liste d'erreurs en cas d'échec de l'inscription.
         */
        async registerUser() {
            this.errors = []

            this.$refs.signUpForm.reportValidity()

            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.post('api/register', this.user)
                this.userStore.user = handleResponse(response)
                this.userStore.isLogged = true
                authStore.setRememberMe(this.rememberMe);
                localStorage.setItem('isLogged', 'true')

                // Vérifier le statut de la réponse et rediriger l'utilisateur en conséquence
                if (this.userStore.user) {
                    this.$router.push({name: 'signUpConfirmation'}); // Rediriger vers la page 'signUpConfirmation'
                } else {
                    // Rediriger vers la page précédemment demandée
                    this.$router.push({name : 'landingPage'});
                }
            } catch (errors) {
                this.errors = errors
            }
        },
    }
}
</script>

<style scoped>
.signup__section {
    @apply w-11/12 sm:w-96 md:w-3/6 lg:w-4/12 mx-auto
}
</style>
