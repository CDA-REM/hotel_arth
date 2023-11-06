import { defineStore } from 'pinia';
import axios from 'axios';
import router from "../js/router";

export const useUserStore = defineStore('user', {
    state: () =>({
        // token: localStorage.getItem('token'),
        user: null,
        logged: localStorage.getItem('isLogged'),
    }),
    getters: {
        //
    },
    actions: {
        /**
         * Loads the user data from the API and updates the user state.
         *
         * @return {Promise<void>} A promise that resolves when the user data is loaded.
         */
        async loadUser(){
            this.errors = []
            await axios.get('api/users/me')
                .then((response) => {
                    this.user = response.data.user
                    console.log(this.user)
                })
                .catch((error) => {
                    if(error.response.status === 401 ){
                        localStorage.removeItem('isLogged')
                    }

                })
        },

        /**
         * Logs out the user by sending a POST request to the 'api/logout' endpoint.
         * Removes the 'isLogged' item from the local storage.
         * Sets the user to null.
         * Redirects the user to the 'landingPage' route.
         *
         * @return {Promise} A promise that resolves when the logout process is complete.
         */
        async logout(){
            await axios.post('api/logout')
            localStorage.removeItem('isLogged')
            this.user = null
            await router.push({name: 'landingPage'});
        }

}
})
