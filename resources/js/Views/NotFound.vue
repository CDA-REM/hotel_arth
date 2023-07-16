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
            Oops, we couldn't find that page. Try going
            <router-link to="/">home</router-link>
        </p>
    </div>
</template>

<style scoped>

</style>
