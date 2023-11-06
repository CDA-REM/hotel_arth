<template>
    <div class="section__navbar">
        <select name="lang"
                v-model="lang"
                @change="switchLocale(lang)"
                class="navbar__button appearance-none bg-white text-2xl"
                aria-label="Menu déroulant pour changer la langue du site">
            <option
                v-for="flag in flags"
                :value="flag.value"
                :alt="flag.image.alt"
                class="navbar__flag"
                :class="flag.value"
            >
                {{ flag.text }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    name: "LanguagesToggleButton.vue",
    data() {
        return {
            lang: "",
            isFrench: true,
            flags: [
                {
                    name: 'Français',
                    image: {
                        source: '/storage/pictures/flag-french.jpg',
                        alt: "Français"
                    },
                    value: 'fr',
                    text: '🇫🇷'
                },
                {
                    name: 'English',
                    image: {
                        source: '/storage/pictures/flag-english.jpg',
                        alt: "English"
                    },
                    value: 'en',
                    text: '🇬🇧'
                }
            ]
        }
    },
    computed: {
        url() {
            return url
        },
        /**
         * Check if the current language is selected.
         *
         * @return {boolean} Whether the current language is selected.
         */
        isSelected() {
            return this.lang === localStorage.lang
        }
    },
    methods: {
        /**
         * Switches the locale of the application and reloads the page.
         *
         * @param {type} paramName - description of parameter
         * @return {type} description of return value
         */
        switchLocale() {
            this.$i18n.locale = this.lang
            localStorage.lang = this.lang
            window.location.reload();
        }
    },
    mounted() {
        this.lang = localStorage.lang || 'fr';
    }
}
</script>

<style scoped>
.section__navbar {
    /*@apply w-1/12;*/
}

.navbar__button {
    @apply px-0 py-0;
}

.navbar__flag {
    @apply mt-0 max-h-5 h-auto;
    background-size: contain; /* Pour ajuster la taille de l'image dans l'option */
    background-repeat: no-repeat;
}

.fr {
    background-image: url("/storage/pictures/flag-french.jpg");
}

.en {
    background-image: url("/storage/pictures/flag-english.jpg");
}
</style>
