<template>
    <section class="md:mt-20 flex flex-col lg:bg-arth-dark-blue flex-items-center" id="rooms">
        <h2 class="p-12 lg:text-white lg:font-semibold">{{ $t("rooms.heading") }}</h2>
         <div v-for="category in roomCategories" :key="category.id">
             <Room :room="category"/>
         </div>
        <div class="p-12 flex justify-center">
            <router-link :to="{ name: 'reservation' }" class="self-center">
                <button class="mt-0 hover:bg-arth-dark-blue hover:text-white">{{ $t("buttons.reservation") }}</button>
            </router-link>
        </div>
    </section>
</template>

<script>
import Room from './Room';

    export default {
        components: {Room},
        data() {
            return {
                roomCategories: []
            }
        },
        async mounted() {
            const response = await axios.get('/api/home/room_category');
            this.roomCategories.push(...response.data);
        }
    }
</script>
