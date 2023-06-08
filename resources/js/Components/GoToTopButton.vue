<template>
    <router-link to="#header">
        <button type="button" :class="{ 'scrolled-page': scrolledPage}">
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
            },
            scrolledPage: null,
        }
    },
    mounted() {
        window.addEventListener("scroll", this.updateScroll);
    },
    methods: {
        updateScroll() {
            const scrollPosition = window.scrollY;
            if (scrollPosition > 50) {
                this.scrolledPage = true;
                return;
            }
            this.scrolledPage = false;
        },
    },
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
        visibility: hidden;

        @apply bg-arth-green hover:bg-arth-light-blue border-arth-green focus:outline-none focus:ring-4 font-medium rounded-full text-sm px-5 py-2.5 text-center;
    }

    .scrolled-page {
        visibility: initial;
    }

    img {
        transform: rotate(180deg);
        width: 40px;
        height: auto;
    }

</style>
