import { defineStore } from 'pinia'

export const useGlobalStore = defineStore({
    id: 'global',

    state: () =>({
        locale : localStorage.lang || 'fr',
    }),
    getters: {
        getLocale: (state) => state.locale,
    },
    actions: {
        //
    }
})
