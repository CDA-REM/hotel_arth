<template>
    <header id="header">
        <Popover class="section__navbar absolute w-full bg-white" :class="isHomeView() ? 'absolute' : 'relative'">
            <div class="mx-auto max-w-8xl px-4 sm:px-6">
                <div
                    class="flex items-center justify-between border-b-2 border-gray-100 py-2 lg:justify-start md:space-x-10 z-2"
                    aria-label="Barre de navigation">
                    <div class="flex justify-start">
                        <router-link :to="{ name: 'landingPage'}">
                            <span class="sr-only">Hotel Arth</span>
                            <img class="h-20 w-auto" src="/storage/pictures/Logo.png" alt="Hotel Arth"
                                 aria-label="link" tabindex="0" role="link" aria-description="Retourner
                        à la page d'accueil"/>
                        </router-link>
                    </div>
                    <!-- START - Open button for small and medium devices -->
                    <div class="-my-2 -mr-2 lg:hidden">
                        <PopoverButton
                            class="inline-flex items-center justify-center rounded-md bg-white mt-0 p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-arth-dark-blue">
                            <span class="sr-only">Open menu</span>
                            <Bars3Icon class="h-6 w-6" aria-hidden="true" />
                        </PopoverButton>
                    </div>
                    <!-- STOP - Open button for small and medium devices -->

                    <!-- START - Nav links for large devices -->
                    <PopoverGroup as="nav" v-if="isHomeView()" class="hidden space-x-6 lg:space-x-10 lg:flex items-center ml-0"
                                  aria-label="Barre de navigation">
                        <router-link to="#rooms" class="font-medium text-gray-500 hover:text-gray-900">
                            {{$t("navbar.rooms")}}
                        </router-link>
                        <router-link to="#advantages" class="font-medium text-gray-500 hover:text-gray-900">
                            {{ $t("navbar.advantages")}}
                        </router-link>
                        <router-link to="#reviews" class="font-medium text-gray-500 hover:text-gray-900">
                            {{ $t("navbar.reviews") }}
                        </router-link>
                        <router-link to="#news" class="font-medium text-gray-500 hover:text-gray-900">
                            {{  $t("navbar.news") }}
                        </router-link>
                    </PopoverGroup>
                    <!-- STOP - Nav links for large devices -->

                    <!-- START - CTA toogle languages and Reservation-->
                    <div class="hidden items-center justify-end gap-10 md:gap-4 xl:gap-10 lg:flex lg:flex-1 lg:w-0"
                         role="Changer la langue du site">
                        <LanguagesToggleButton/>

                        <!-- START - login or logout button-->
                        <!-- START - Login button-->
                        <router-link :to="{ name: 'login' }" v-if="!store.user"
                                     class="inline-flex items-center justify-center whitespace-nowrap border border-arth-dark-blue px-6 py-2 shadow-sm hover:bg-arth-dark-blue hover:text-white"
                        >
                            {{ $t("buttons.connect")}}
                        </router-link>
                        <!-- STOP - Login button-->
                        <!-- START - account and logout dropdown -->
                        <div class="dropdown" v-else>
                            <label tabindex="0" class="inline-flex items-center justify-center cursor-pointer whitespace-nowrap border border-arth-dark-blue px-6 py-2 shadow-sm hover:bg-arth-dark-blue hover:text-white"
                            >{{ $t("buttons.profile")}}</label>
                            <ul tabindex="0" class="dropdown-content menu  bg-arth-light-blue w-48">
                                <li><a class="hover:bg-arth-grey">{{ $t("buttons.account")}}</a></li>
                                <li>
                                    <a @click="store.logout()" href="/" class="hover:bg-arth-grey">{{ $t("buttons.logout")}}</a>
                                </li>
                            </ul>
                        </div>
                        <!-- STOP - account and logout dropdown -->
                        <!-- Start- Book button-->
                        <router-link :to="{ name: 'reservation' }">
                            <button class="inline-flex items-center justify-center whitespace-nowrap border
                        border-arth-dark-blue px-8 py-2 shadow-sm hover:bg-arth-dark-blue hover:text-white"
                            >
                                {{ $t("buttons.reservation") }}
                            </button>
                        </router-link>
                    </div>
                    <!-- END - CTA toogle languages and Reservation-->
                </div>
            </div>
            <!-- START - Display for small and medium devices -->
            <transition enter-active-class="duration-200 ease-out" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="duration-100 ease-in" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                <PopoverPanel focus
                              class="absolute inset-x-0 top-0 origin-top-right transform p-2 transition lg:hidden z-20">
                    <div class="divide-y-2 divide-gray-50 rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                        <div class="px-5 pt-5 pb-6">
                            <div class="flex items-center justify-between">
                                <router-link :to="{ name: 'landingPage' }">
                                    <div>
                                        <img class="h-20 w-auto" src="/storage/pictures/Logo.svg" alt="Hôtel Arth" />
                                    </div>
                                </router-link>
                                <div>
                                    <LanguagesToggleButton />
                                </div>
                                <div class="-mr-2">
                                    <PopoverButton
                                        class="inline-flex items-center justify-center rounded-md bg-white mt-0 p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-arth-dark-blue">
                                        <span class="sr-only">Close menu</span>
                                        <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                                    </PopoverButton>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6 py-6 px-5">
                            <!-- START - Link to landing page section for small devices -->
                            <div v-if="isHomeView()" class="grid grid-cols-2 gap-y-4 gap-x-8">
                                <router-link to="#rooms" class="font-medium text-gray-900 hover:text-gray-700">
                                    {{ $t("navbar.rooms") }}
                                </router-link>
                                <router-link to="#advantages" class="font-medium text-gray-900 hover:text-gray-700">
                                    {{ $t("navbar.advantages") }}
                                </router-link>
                                <router-link to="#reviews" class="font-medium text-gray-900 hover:text-gray-700">
                                    {{ $t("navbar.reviews") }}
                                </router-link>
                                <router-link to="#news" class="font-medium text-gray-900 hover:text-gray-700">
                                    {{  $t("navbar.news") }}
                                </router-link>
                                <!-- STOP - Link to landing page section for small devices -->
                            </div>
                            <div>
                                <router-link :to="{ name: 'reservation' }"
                                             class="flex w-full items-center justify-center border border-transparent bg-arth-dark-blue hover:bg-white hover:text-black hover:border-arth-dark-blue my-6 px-4 py-2 font-medium text-white shadow-sm">
                                    {{ $t("buttons.reservation")}}
                                </router-link>

                                <!--                                START - Sign up and login buttons -->
                                <div v-if="!store.user">
                                    <router-link :to="{ name: 'signUp'}"
                                                 class="flex w-full items-center justify-center border border-arth-dark-blue bg-white hover:border-transparent hover:bg-arth-light-blue my-6 px-4 py-2 font-medium text-arth-dark-blue shadow-sm">
                                        {{ $t("buttons.signUp")}}
                                    </router-link>
                                    <p class="mt-6 text-center font-medium text-gray-500">
                                        {{ $t("navbar.alreadyHaveAccount") }}
                                        {{ ' ' }}
                                        <router-link :to="{ name: 'login' }"
                                                     class="text-arth-dark-blue hover:font-bold">{{$t("buttons.connect")}}
                                        </router-link>
                                    </p>
                                </div>
                                <!--                                STOP - Sign up and login buttons -->
                                <!-- START - Profile and logout buttons -->
                                <div v-if="store.user">
                                    <router-link :to="{ name: '' }"
                                                 class="flex w-full items-center justify-center border border-arth-dark-blue bg-white hover:border-transparent hover:bg-arth-light-blue my-6 px-4 py-2 font-medium text-arth-dark-blue shadow-sm">
                                        {{ $t("buttons.profile")}}
                                    </router-link>
                                </div>
                                <router-link
                                    v-if="store.user"
                                    :to="{ name: 'landingPage' }"
                                    @click="store.logout()"
                                    class="flex w-full mt-6 text-center text-black font-medium  items-center justify-center whitespace-nowrap border border-arth-light-blue px-6 py-2 shadow-sm hover:bg-arth-light-blue"
                                >{{$t("buttons.logout")}}
                                </router-link>
                                <!-- STOP - Profile and logout buttons -->
                            </div>
                        </div>
                    </div>
                </PopoverPanel>
            </transition>
            <!-- STOP - Display for small and medium devices -->
        </Popover>
        <GoToTopButton />
    </header>
</template>

<script>
import { Popover, PopoverButton, PopoverGroup, PopoverPanel } from '@headlessui/vue'
import {
    Bars3Icon,
    BookmarkSquareIcon,
    CalendarIcon,
    ChartBarIcon,
    CursorArrowRaysIcon,
    LifebuoyIcon,
    PhoneIcon,
    PlayIcon,
    ShieldCheckIcon,
    Squares2X2Icon,
    XMarkIcon,
} from '@heroicons/vue/24/outline'
import { ChevronDownIcon } from '@heroicons/vue/20/solid'
import LanguagesToggleButton from "./LanguagesToggleButton"
import { useUserStore } from '../../stores/userStore'
import landingPage from "../Views/LandingPage/LandingPage.vue";
import GoToTopButton from "./GoToTopButton.vue";


export default {
    name: "NavBar.vue",
    components: {
        LanguagesToggleButton,
        Popover,
        PopoverButton,
        PopoverGroup,
        PopoverPanel,
        Bars3Icon,
        BookmarkSquareIcon,
        CalendarIcon,
        ChartBarIcon,
        CursorArrowRaysIcon,
        LifebuoyIcon,
        PhoneIcon,
        PlayIcon,
        ShieldCheckIcon,
        Squares2X2Icon,
        XMarkIcon,
        ChevronDownIcon,
        GoToTopButton,
    },
    setup() {
        const store = useUserStore();
        return { store }
    },
    data() {
        return {


        }
    },
    methods: {
        isHomeView() {
            return this.$router.currentRoute.value.name === 'landingPage';
        },
    }
}
</script>

<style scoped>
.section__navbar{
    /*    */
}
</style>
