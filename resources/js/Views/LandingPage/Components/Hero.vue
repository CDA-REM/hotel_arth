<template>
    <section :style="image" class="flex flex-col bg-cover bg-center h-screen p-24 justify-evenly items-center lg:mb-20 ">
        <div>
            <h1 class="text-white lg:text-6xl">{{hero.title}}</h1>
            <h2 class="text-white mt-4 font-semibold  lg:text-3xl">{{hero.subtitle}}</h2>
        </div>
        <router-link :to="{ name: 'reservation' }" class="self-center">
            <button class="border-arth-light-blue justify-center font-tinos text-arth-dark-blue hover:bg-arth-light-blue mb-16">{{
                    $t("buttons.reservation") }}
            </button>
        </router-link>

    </section>

</template>

<script>
    export default {
        async mounted() {
            const userLocale = navigator.languages && navigator.languages.length ? navigator.languages[0] : navigator.language;
            const response = await axios.get('api/home/hero', {
                headers: {
                    "Accept-Language": userLocale
                }
            }
        );
            this.hero = {...response.data};
            this.image = {backgroundImage:`url(${this.hero.media_url})`}
        },
        data() {
            return {
                hero: {},
                image: {},
            }
        }
    }
</script>
