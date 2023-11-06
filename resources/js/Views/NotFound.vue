<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "NotFound"
})
</script>

<template>
    <div class="not-found__container flex flex-col justify-content-center align-items-center mx-auto w-8/12">
        <h1 class="mb-6">Page demandée inconnue</h1>
        <p class="text-center">
            Oops, nous n'avons pas trouvé cette page.
        </p>
        <p class="text-center">
            Essayez de retourner à la page d'accueil.
        </p>
        <router-link :to="{ name: 'landingPage' }" class="mx-auto my-16">
            <button class="btn__darkblue--outline">{{ $t('buttons.buttonGoBackToHome')}}</button>
        </router-link>
    </div>
</template>

<style scoped>
</style>
