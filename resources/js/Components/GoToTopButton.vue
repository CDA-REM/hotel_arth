<template>
    <router-link to="#header">
        <button type="button" :class="{ 'scrolled__page': scrolledPage}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0l-6.75 6.75M12 4.5l6.75 6.75" />
            </svg>


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
        /**
         * Updates the scroll position and sets the `scrolledPage` flag accordingly.
         *
         * @return {void} This function does not return a value.
         */
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
        border-radius: 100%;
        width: 50px;
        height: 50px;
        text-align: center;
        visibility: hidden;

        @apply bg-arth-green hover:bg-arth-light-blue border-arth-green focus:outline-none focus:ring-4 font-bold
        rounded-full text-sm  text-center text-black px-3 py-2;
    }

    .scrolled__page {
        visibility: initial;
    }

    svg {
        text-align: center;
    }

</style>
