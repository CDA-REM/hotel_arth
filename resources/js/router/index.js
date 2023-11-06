import {createRouter, createWebHashHistory, createWebHistory} from "vue-router";
import LandingPage from '../Views/LandingPage/LandingPage';
import ReservationConfirmation from "../Views/Reservation/ReservationConfirmation.vue";

const routes = [
    {
        path: '/',
        name: 'landingPage',
        component: LandingPage,
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('../Views/Login.vue'),
        meta: {
            name: 'login',
            noAuthRequired: true
        }
    },
    {
        path: '/signup',
        name: 'signUp',
        component: () => import('../Views/SignUp.vue'),
        meta: {
            name: 'signUp',
            noAuthRequired: true
        }
    },
    {
        path: '/reservation',
        name: 'reservation',
        meta: {
            name: 'reservation',
            requiresAuth: true
        },
        component: () => import('../Views/Reservation/Reservation.vue')
    },
    {
        path: '/reservation-confirmation',
        name: 'reservationConfirmation',
        component: ReservationConfirmation,
        meta: {
            name: 'reservationConfirmation',
            requiresAuth: true
        }
    },
    {
        path: '/mon-compte',
        name: 'userAccount',
        component: () => import('../Views/private/Account.vue'),
        meta: {
            name: 'userAccount',
            requiresAuth: true
        }
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'notFound',
        component: () => import('../Views/NotFound.vue')
    }
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (to.hash) {
            return {
                el: to.hash,
                behavior: 'smooth',
            }
        }
        return savedPosition || new Promise((resolve) => {
            setTimeout(() => resolve({top: 0, behavior: 'smooth'}), 300)
        })
    },
})

function checkIfUserIsAuthenticated() {
    return localStorage.isLogged === 'true'
}

// router.js (continued)
router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        // Check if the user is authenticated here
        const isAuthenticated = checkIfUserIsAuthenticated(); // You need to implement this function

        if (!isAuthenticated) {
            // Save the intended URL to session storage or as a query parameter
            sessionStorage.setItem('intendedURL', to.fullPath); // You can also use a query parameter instead of session storage
            next('/login');
        } else {
            next();
        }
    } else {
        next();
    }
});


export default router
