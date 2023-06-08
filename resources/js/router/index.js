import {createRouter, createWebHashHistory} from "vue-router";
import LandingPage from '../Views/LandingPage/LandingPage';
import Login from '../Views/Login';
import SignUp from '../Views/SignUp';
import Reservation from "../Views/Reservation/Reservation.vue";
import RoomCategories from "../Views/LandingPage/Components/RoomCategories.vue";
import Advantages from "../Views/LandingPage/Components/Advantages.vue";
import UserReviews from "../Views/LandingPage/Components/UserReviews.vue";
import News from "../Views/LandingPage/Components/News.vue";
import ReservationConfirmation from "../Views/Reservation/ReservationConfirmation.vue";

const routes = [
    {
        path: '/',
        name: 'landingPage',
        component: LandingPage
    },
    {
        path: '/rooms',
        name: 'roomCategories',
        component: RoomCategories
    },
    {
        path: '/advantages',
        name: 'advantages',
        component: Advantages
    },
    {
        path: '/reviews',
        name: 'userReviews',
        component: UserReviews
    },
    {
        path: '/news',
        name: 'news',
        component: News
    },


    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/signup',
        name: 'signUp',
        component: SignUp
    },
    {
        path: '/reservation',
        name: 'reservation',
        component: Reservation,
    },
    {
        path: '/reservation-confirmation',
        name: 'reservationConfirmation',
        component: ReservationConfirmation
    }
]

const router = createRouter({
    history: createWebHashHistory(process.env.BASE_URL),
    routes,
    scrollBehavior(to, from, savedPosition) {
        // if (savedPosition) {
        //     return savedPosition;
        // }
        if (to.hash) {
            return {
                el: to.hash,
                behavior: 'smooth',
            }
        }
        // return {x: 0, y: 0};
    },
})
export default router
