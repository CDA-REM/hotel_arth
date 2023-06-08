<template>
    <div class="section__navbar">
        <select name="lang" v-model="lang" @change="switchLocale(lang)"
                class="navbar__button appearance-none bg-white text-2xl"
                aria-label="Menu déroulant pour changer la langue du site">
            <option value="fr" :alt=french.image.alt>🇫🇷</option>
            <option value="en" :alt=english.image.alt>🇬🇧</option>
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
            french:
                {
                    name: 'Français',
                    image: {
                        source: '/storage/pictures/flag-french.jpg',
                        alt: "Drapeau Français"
                    },
                },
            english: {
                name: 'English',
                image: {
                    source: '/storage/pictures/flag-english.jpg',
                    alt: "British Flag"
                },
            }
        }
    },
    computed: {
        isSelected() {
            return this.lang == localStorage.lang
        }
    },
    methods: {
        // ...mapActions(useLangStore, ['switchLocale'])

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
.navbar__button{
    @apply px-0 py-0;
}

.navbar__flag {
    @apply mt-0 max-h-5 h-auto;
}
.navbar__flag--french {
    /*@apply ;*/
}

.navbar__flag--english {
    /*@apply ;*/
}
</style>
