<template>
    <section class="section__news" id="news">
        <h2 class="my-10 py-10">{{ $t("news.heading") }}</h2>
        <div class="flex justify-center">
            <!--        <div class="w-2/12 flex items-center">-->
            <!--            <div class="w-2/12 flex items-center">Prev</div>-->
            <!--        </div>-->

            <div id="sliderContainer" >
                <div id="slider" class="flex flex-col md:flex-row w-full">
                    <div class="w-94 md:w-96 p-5"
                         v-for="newsArticle in news" :key="newsArticle.id">
                        <NewsCard class="border border-arth-dark-blue border-2 p-5"
                                  :newsArticle="newsArticle"/>
                    </div>
                </div>
            </div>
        </div>
<!--        <div class="w-2/12 flex items-center">-->
<!--            Next-->
<!--        </div>-->
    </section>
</template>

<script>
import NewsCard from "./NewsCard";
    export default {
        name: 'News',
        components: { NewsCard },
        data() {
            return {
                news: []
            }
        },
        async mounted() {
            const response = await axios.get('api/home/news');
            this.news.push(...response.data);
        }
    }
</script>

<style scoped>
.section__news {
    @apply mx-auto my-10 py-10
}
</style>
