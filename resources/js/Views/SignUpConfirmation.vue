<script>
import landingPage from "./LandingPage/LandingPage.vue";
export default {
    name: "signUpConfirmation",
    methods: {
        landingPage() {
            return landingPage
        }
    }
}
</script>

<template>
    <div class="signup__confirmation--container max-w-md min-h-100 mx-auto px-2">
        <h1>{{ $t('signUpConfirmation.title') }}</h1>

        <div class="signup__confirmation--recap"><!--TODO - Fake data, for text implement data from DB-->
            <p class="signup__confirmation--subtitle">{{ $t(('signUpConfirmation.subtitle')) }}</p>
            <p>{{ $t(('signUpConfirmation.sentence1')) }}</p>
            <p>{{ $t(('signUpConfirmation.sentence2')) }}</p>
        </div>

        <router-link :to="{ name: 'reservation' }">
            <button class="btn__darkblue">{{ $t('buttons.reservation')}}</button>
        </router-link>

        <router-link :to="{ name: 'landingPage' }">
            <button class="btn__darkblue--outline">
                {{ $t('buttons.buttonGoBackToHome')}}
            </button>
        </router-link>
    </div>
</template>

<style scoped>
button {
    @apply w-full my-6;
}

ul {
    @apply inline-flex items-center space-x-1 md:space-x-3;
}

li {
    @apply inline-flex items-center ml-6 ;
}

.signup__confirmation--container > h1 {
    @apply mt-12
}

.signup__confirmation--recap {
    @apply flex flex-col justify-center bg-arth-light-blue mx-auto mt-12 py-3 px-4 text-center min-w-min max-w-5xl min-h-[40vh];
}

.signup__confirmation--subtitle {
    @apply text-2xl;
}

p {
    @apply text-xl m-2;
}
</style>
