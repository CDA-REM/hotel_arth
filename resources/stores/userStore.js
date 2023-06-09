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
        async loadUser(){
            this.errors = []
            await axios.get('api/users/me')
                .then((response) => {
                    this.user = response.data.user
                })
                .catch((error) => {
                    if(error.response.status === 401 ){
                        localStorage.removeItem('isLogged')
                    }

                })
        },

        async logout(){
            await axios.post('api/logout')
            localStorage.removeItem('isLogged')
            this.user = null
            await router.push({name: 'landingPage'});
        }

}
})
