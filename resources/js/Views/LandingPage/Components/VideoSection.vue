<template>
    <section class="section__video"> <!-- BEM Syntax for classes -->
        <div class="section__video-content">
            <div class="section__video-text">
                <h2 class="video__h2">{{ presentationVideo.title }}</h2>
                <h3 class="video__h3">{{ presentationVideo.description }}</h3>
            </div>

            <video class="video__media" :src="presentationVideo.video_url" controls preload="auto">
                <p>Vidéo de Denys Gromov: https://www.pexels.com/fr-fr/video/assiette-salade-sain-bois-5223106/</p>
                <p>Votre navigateur ne prend pas en charge les vidéos HTML5.</p>
            </video>
        </div>
        <router-link :to="{ name: 'reservation' }" class="self-center">
            <button class="video__button-reservation">
                {{ $t("buttons.reservation") }}
            </button>
        </router-link>
    </section>


</template>

<script>

export default {
    name: "VideoSection.vue",
    data() {
        return {
            presentationVideo: {}
        }
    },
    async mounted() {
        const response = await axios.get('api/home/presentation_video');
        this.presentationVideo = {...response.data['data']};
    }
}
</script>

<style scoped>
    .section__video {
        @apply flex flex-col my-6 lg:mb-10;
    }

    .section__video-content {
        @apply flex flex-col lg:flex-row-reverse my-3 justify-around my-6;
    }
    .video__h2 {
        @apply mx-4 ;
    }

    .video__h3 {
        @apply text-xl mx-4 ;
    }

    .section__video-text {
        @apply flex flex-col align-middle justify-center;
    }

    .video__media {
        @apply w-max w-full aspect-video;
        max-height: 400px;
    }

    .video__button-reservation {
        @apply my-10 hover:bg-arth-grey
    }

</style>
