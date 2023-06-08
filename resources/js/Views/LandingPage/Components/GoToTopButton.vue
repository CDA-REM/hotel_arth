<template>
    <router-link to="#header">
        <button type="button" class="">
            <img :src="image.source" :alt="image.alt">
        </button>
    </router-link>

</template>

<script>
export default {
    name: "GoToTopButton",
    props: {
    },
    data() {
        return {
            image: {
                source: "storage/advantages/arrow-down.png",
                alt: "Retourner en haut de la page",
            }
        }
    }

}
</script>

<style scoped>
    button {
        position: fixed;
        bottom: 0.8rem;
        right: 0.8rem;
        z-index: 99;
        width: 70px;
        height: auto;
        text-align: center;

        @apply bg-arth-green hover:bg-arth-light-blue border-arth-green focus:outline-none focus:ring-4 font-medium rounded-full text-sm px-5 py-2.5 text-center;
    }

    img {
        transform: rotate(180deg);
        width: 40px;
        height: auto;
    }

</style>
