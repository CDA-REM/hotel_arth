import { defineStore } from 'pinia'

export const useOptionsStore = defineStore('options',{

    state: () =>({
        options: [
            {
                id: 1,
                slug: 'breakfast',
                price: 9,
            },
            {
                id: 2,
                slug: 'lunch',
                price: 20,
            },
            {
                id: 3,
                slug: 'diner',
                price: 20,
            },
            {
                id: 4,
                slug: 'lunchAndDiner',
                price: 35,
            },
            {
                id: 5,
                slug: 'pressing',
                price: 30,
            },
            {
                id: 6,
                slug: 'canal+',
                price: 30,
            },
            {
                id: 7,
                slug: 'swimmingPool',
                price: 25,
            },
        ]
    }),
    getters: {
        getOptions: (state) => state.options,
    },
    actions: {
        //
    }
})
