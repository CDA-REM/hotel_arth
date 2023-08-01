<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "NotFound"
})
</script>

<template>
    <div class="not-found__container">
        <h1>Not Found</h1>
        <p>
            Oops, nous n'avons pas trouvé cette page. Essayez de retourner à la page d'accueil.
            <router-link to="/" class="btn__darkblue--outline">home</router-link>
        </p>
    </div>
</template>

<style scoped>

</style>
