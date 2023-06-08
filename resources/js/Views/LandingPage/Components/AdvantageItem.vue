<template>
    <div tabindex="0" class="collapse collapse-arrow px-4 py-2 md:hidden">
        <input type="checkbox" class="peer" />
        <div
            class="collapse-title px-6 lg:pr-9 bg-arth-light-blue md:bg-white text-black-content peer-checked:arth-light-blue peer-checked:text-black-content">
            <div class="flex flex-row justify-between items-center md:flex-col">
                <div class="lg:mb-4 w-1/4 md:w-full h-14">
                    <img class="m-auto"
                         :src="advantage.icon_url"
                         :alt="advantage.icon_alt"
                    >
                </div>
                <div class="w-3/4 md:w-full ">
                    <p class="text-center align-middle pr-3 ">{{ advantage.title }}</p>
                </div>
            </div>
        </div>
        <div class="collapse-content md:cursor-default md:max-h-full bg-white text-black-content peer-checked:bg-white peer-checked:text-black-content">
            <p class="text-center pt-8">{{ advantage.description }}</p>
        </div>
    </div>

    <div class="px-4 py-2 hidden md:block">
        <div
            class="px-6 lg:pr-9 text-black-content">
            <div class="flex flex-row justify-between items-center md:flex-col">
                <div class="lg:mb-4 md:w-full h-14">
                    <img class="m-auto" :src="advantage.icon_url" alt="">
                </div>
                <div class="md:w-full ">
                    <p class="text-center align-middle ">{{ advantage.title }}</p>
                </div>
            </div>
        </div>
        <div class="md:cursor-default md:max-h-full bg-white text-black-content">
            <p class="text-center pt-8">{{ advantage.description }}</p>
        </div>
    </div>
</template>


<script>
    export default{
        props:{
            advantage: {
                type: Object,
                default: () => {}
            }
        },
        mounted() {
            //
        }
    }
</script>

