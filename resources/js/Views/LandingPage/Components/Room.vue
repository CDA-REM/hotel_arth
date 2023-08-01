<template>
    <div
        class="flex flex-col m-6 p-4 border-arth-dark-blue border-2 lg:flex-row lg:border-none lg:p-0 lg:m-0 lg:justify-around bg-white"
        :class="(room.id == 2) ? 'lg:flex-row-reverse' : ''">
        <div class="lg:basis-2/3">
            <img :src="room.media_url" :alt="room.media_alt"/>
        </div>

        <div class="flex flex-col p-8 justify-around lg:basis-1/3">
            <h2>{{room.title}}</h2>
            <p class="text-justify">{{room.description}}</p>
            <button v-if="room.id == 1" class="btn__yellow--outline">{{ $t("buttons.discover") }}</button>
            <button v-if="room.id == 2" class="btn__lightblue--outline">{{ $t("buttons.discover") }}</button>
            <button v-if="room.id == 3" class="btn__darkblue--outline">{{ $t("buttons.discover") }}</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Room',
        props: ['room']
    }
</script>

<style scoped>

button {
    @apply mt-6 lg:mt-0
}

</style>
