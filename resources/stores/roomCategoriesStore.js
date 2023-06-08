import { defineStore } from 'pinia'

export const useRoomCategoriesStore = defineStore('roomCategories',{

    state: () =>({
        roomCategories: [
            {
            slug: 'classic',
            price: 70,
            },
            {
            slug: 'luxury',
            price: 140,
            }, {
            slug: 'royal',
            price: 280,
            }
        ]
    }),
    getters: {
        getRoomCategories: (state) => state.roomCategories,
    },
    actions: {
        //
    }
})
