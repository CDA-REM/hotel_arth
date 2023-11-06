<template>
    <div class="alert" v-if="errors.length">
        <div v-for="error in errors" :key="error.index">{{ error }}</div>
    </div>
</template>

<script>
export default {
    props: {
        errors: {
            type: Array,
            required: true,
        },
    },
};
</script>

<style>
/* Add your custom styles for the alert component here */
.alert {
    @apply w-96 justify-center p-4 mx-auto mb-6
    text-red-600 text-base font-bold
    border-2 border-red-600 rounded-md bg-transparent;
}

</style>

