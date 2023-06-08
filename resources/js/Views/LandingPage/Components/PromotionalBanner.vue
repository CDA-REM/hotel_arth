<template>
    <div class="bg-arth-light-blue md:h-40 sm:h-20 absolute inset-x-0 bottom-0"  :style="(close) ? 'display:none' : ''">
        <div class="banner-text">
            <div class="flex flex-wrap items-center justify-between">
                <div class="flex w-0 flex-1 items-center justify-around">
                    <p class="mx-4 mb-4 sm:mb-0 text-xl lg:text-2xl text-arth-dark-blue text-center">{{ promotionalBanner.text
                        }}</p>
                </div>
<!--                <div class="order-3 mt-2 w-full flex-shrink-0 sm:order-2 sm:mt-0 sm:w-auto">
                    <router-link :to="{ name: 'reservation' }">
                        <button class=" flex items-center justify-center bg-white text-arth-dark-blue hover:text-white
                         mt-0 border-arth-green hover:bg-arth-green">
                        {{ $t("buttons.reservation") }}
                        </button>
                    </router-link>
                </div>-->
                <div class="order-2 flex-shrink-0 sm:order-3 sm:ml-3">
                    <button type="button" @click='closeBanner' class="-mr-1 mt-0 flex rounded-md p-2 hover:bg-arth-green focus:outline-none focus:ring-2 focus:ring-white sm:-mr-2">
                        <span class="sr-only">Dismiss</span>
                        <XMarkIcon class="h-6 w-6 text-black" aria-hidden="true" />
                    </button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import { XMarkIcon } from '@heroicons/vue/24/outline'
    export default {
        name: "PromotionalBanner.vue",
        components: {
            XMarkIcon
        },
        data() {
            return {
                promotionalBanner: {},
                close: false
            }
        },
        async mounted() {
            const response = await axios.get('api/home/promotional_banner');
            this.promotionalBanner = {...response.data['data']};
        },
        methods: {
            closeBanner (){
                this.close = true
            }
        }

    }

</script>

<style scoped>
.banner-text{
    @apply mx-auto max-w-7xl py-3 px-3 sm:px-6 lg:px-8 sm:transform sm:translate-y-10;
}
</style>
