<template>
        <div class="review__card card">
            <div class="review__card--header">
                <figure>
                    <img :src="review.user.avatar" class="card__header--img" alt="user_avatar" />
                </figure>
                <div class="card__header--text">
                    <div class="header__text--rating" v-if="review.rating == '1'">
                        <img :src="image.full.source" :alt="image.full.alt">
                        <img :src="image.empty.source" :alt="image.empty.alt">
                        <img :src="image.empty.source" :alt="image.empty.alt">
                        <img :src="image.empty.source" :alt="image.empty.alt">
                        <img :src="image.empty.source" :alt="image.empty.alt">
                    </div>
                    <div class="header__text--rating" v-if="review.rating == '2'">
                        <img :src="image.full.source" :alt="image.full.alt">
                        <img :src="image.full.source" :alt="image.full.alt">
                        <img :src="image.empty.source" :alt="image.empty.alt">
                        <img :src="image.empty.source" :alt="image.empty.alt">
                        <img :src="image.empty.source" :alt="image.empty.alt">
                    </div>
                    <div class="header__text--rating" v-if="review.rating == '3'">
                        <img :src="image.full.source" :alt="image.full.alt">
                        <img :src="image.full.source" :alt="image.full.alt">
                        <img :src="image.full.source" :alt="image.full.alt">
                        <img :src="image.empty.source" :alt="image.empty.alt">
                        <img :src="image.empty.source" :alt="image.empty.alt">
                    </div>
                    <div class="header__text--rating" v-if="review.rating == '4'">
                        <img :src="image.full.source" :alt="image.full.alt">
                        <img :src="image.full.source" :alt="image.full.alt">
                        <img :src="image.full.source" :alt="image.full.alt">
                        <img :src="image.full.source" :alt="image.full.alt">
                        <img :src="image.empty.source" :alt="image.empty.alt">
                    </div>
                    <div class="header__text--rating" v-if="review.rating == '5'">
                        <img :src="image.full.source" :alt="image.full.alt">
                        <img :src="image.full.source" :alt="image.full.alt">
                        <img :src="image.full.source" :alt="image.full.alt">
                        <img :src="image.full.source" :alt="image.full.alt">
                        <img :src="image.full.source" :alt="image.full.alt">
                    </div>
                    <p>{{ review.user.firstname }} {{ review.user.lastname }}</p>
                </div>
            </div>
            <div class="card-body">
                <h3 class="card-title">
                    {{ review.title }}
                </h3>
                <p>{{ formatDate }}</p>
                <blockquote>{{  review.body }}</blockquote>
                <div class="card-actions justify-end">
                    <div class="badge"><p>{{ $t('reviews.badge') }}</p></div>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    data() {
        return {
            reviews: {},
            image: {
                full: {
                    source: "storage/pictures/Star_full.png",
                    alt: "",
                },
                empty: {
                    source: "storage/pictures/Star_empty.png",
                    alt: "",
                }
            }
        }
    },
    props:{
        review: {
            type: Object,
            default: () => {}
        }
    },
    methods: {
        //
    },
    computed: {
        formatDate() {
            const date = new Date(this.review.created_at)
            return date.toLocaleDateString()
        }
    },
    mounted() {
        // console.log(this.review)
    }
}
</script>

<style scoped>
    .review__card {
        @apply w-11/12 h-full bg-base-100 shadow-xl mx-auto my-8 border border-arth-yellow bg-white
    }

    .review__card--header {
        @apply flex justify-between pt-6 px-8 space-x-10
    }

    .card__header--img{
        @apply h-4/5 w-auto
    }

    .card__header--text {
        @apply flex flex-col justify-items-center justify-evenly
    }

    .card__header--text>p {
        @apply mt-0 mb-3 text-xl
    }

    .header__text--rating {
        @apply flex
    }

    .card-body {
        @apply pt-0 h-max text-black
    }

    .card-title {
        @apply text-2xl font-bold
    }

    .badge {
        @apply  border border-arth-yellow bg-white m-2 p-4  text-black
    }

    .badge>p {
        /*@apply */
    }
</style>
