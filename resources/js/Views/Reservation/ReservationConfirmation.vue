<template>
    <nav class="flex" aria-label="Breadcrumb" id="form-breadcrumb">
        <div class="breadcrumbs">
            <ul>
                <li>
                    <router-link :to="{ name: 'landingPage' }">{{ $t(('breadcrumb.home')) }}</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'reservationConfirmation' }" class="active">{{ $t(('breadcrumb.thankYou')) }}</router-link>
                </li>
            </ul>
        </div>
    </nav>

    <div class="booking__confirmation--container max-w-md min-h-100 mx-auto px-2">
        <h1>{{ $t('confirmation.title') }}</h1>

        <div class="booking__confirmation--recap"><!--TODO - Fake data, for text implement data from DB-->
            <p class="booking__confirmation--subtitle">{{ $t(('confirmation.subtitle')) }}</p>
            <p>{{ $t(('confirmation.sentenceWithReservationNumber')) }}</p>
            <p>{{ $t(('confirmation.sentenceWithMessageForEmail')) }}</p>
        </div>

        <router-link :to="{ name: 'landingPage' }">
            <button>{{ $t('buttons.buttonGoBackToHome')}}</button>
        </router-link>
    </div>
</template>

<script>
import landingPage from "../LandingPage/LandingPage.vue";

export default {
    name: "ReservationConfirmation",
    methods: {
        landingPage() {
            return landingPage
        }
    }
}
</script>

<style scoped>

button {
    @apply bg-arth-green w-full mt-6 mb-8;
}

nav .breadcrumbs {
    @apply text-base max-w-xs;
}

ul {
    @apply inline-flex items-center space-x-1 md:space-x-3;
}

li {
    @apply inline-flex items-center ml-6 ;
}

.active {
    @apply font-bold;
}

.booking__confirmation--container > h1 {
 @apply mt-12
}

.booking__confirmation--recap {
    @apply flex flex-col justify-center bg-arth-light-blue mx-auto mt-12 py-3 px-4 text-center min-w-min max-w-5xl min-h-[40vh];
}

.booking__confirmation--subtitle {
    @apply text-2xl;
}

p {
    @apply text-xl m-2;
}
</style>
