<template>
    <footer class="bg-arth-dark-blue ">
        <div class="flex flex-col px-10 max-w-6xl md:block mx-auto pt-5 pb-5">
            <router-link :to="{ name: 'landingPage'}" class="text-white text-center md:text-start font-poiret text-4xl py-3">
                Hôtel ARTH
            </router-link>

            <div class="max-w-6xl flex flex-col md:flex-row justify-around mx-auto md:mt-5"
                 aria-label="Barre de navigation"
                 role="navigation">
                <div class="flex flex-col" >
                    <div v-for="link in footer" :key="link.id">
                        <p><a v-if="link.column_number === '1'" role="link" tabindex="0">{{ link.entry_name }}</a></p>
                    </div>
                </div>
                <div class="flex flex-col" >
                    <div v-for="link in footer" :key="link.id">
                        <p><a v-if="link.column_number === '2'" role="link" tabindex="0">{{ link.entry_name }}</a></p>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div>
                        <p class="text-white">{{$t("footer.joinUs")}}</p>
                    </div>
                    <SocialMedia />
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
import SocialMedia from "../Views/LandingPage/Components/SocialMedia";
export default {
    components: {SocialMedia},
    data() {
        return {
            footer: {}
        }
    },
    async mounted() {
        const response = await axios.get('api/home/footer');
        this.footer = {...response.data['data']};
    },
    methods: {

    }
}
</script>

<style scoped>
    a{
        @apply text-white link link-hover;
    }
    p{
        @apply text-lg;
    }
</style>
