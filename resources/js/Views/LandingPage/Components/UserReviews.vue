<template>
    <section class="section__reviews" id="reviews">
        <h2 class="reviews__title">{{ $t("reviews.heading") }}</h2>
        <div class="reviews__cards" >
            <div v-for="review in reviews" :key="review.id" v-show="review.is_displayed === 1 && review.id <= 3">
                <UserReviewItem :review="review"/>
            </div>
        </div>
        <button class="section__reviews--CTA-SeeMore btn__yellow--outline" @click="isHidden = !isHidden">{{ $t("buttons.more")
            }}</button>
        <div class="reviews__cards" v-if="!isHidden" >
            <div v-for="review in reviews" :key="review.id" v-show="review.is_displayed === 1 && review.id > 3 &&
            review.id < 7">
                <UserReviewItem :review="review"/>
            </div>
        </div>
        <div class="p-12 flex justify-center">
            <router-link :to="{ name: 'reservation' }"
                         class="btn__darkblue--outline mx-auto justify-center items-center font-tinos font-bold cursor-pointer self-center mt-0">
                <button class="">{{
                        $t("buttons.reservation")
                    }}</button>
            </router-link>
        </div>
    </section>
</template>

<script>
import UserReviewItem from "./UserReviewItem";
export default {
    // name: "UserReview.vue",
    components: {
        UserReviewItem
    },
    data() {
        return {
            reviews: [],
            isHidden: true,
        }
    },
    methods: {
        //
    },
    async mounted() {
        const response = await axios.get('api/home/reviews');
        this.reviews.push(...response.data['data']);
    }
}
</script>

<style scoped>
.section__reviews {
    @apply flex flex-col mx-auto my-10 py-10 md:bg-arth-light-blue
}

.reviews__cards {
    @apply md:grid md:grid-cols-2 lg:grid lg:grid-cols-3 gap-4 mx-auto
}

.section__reviews--CTA-SeeMore {
    @apply mt-16
}

</style>
