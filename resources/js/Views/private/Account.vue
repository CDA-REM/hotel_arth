<template>
    <div v-if="user" class="account__container">
        <h1>Mon compte</h1>
        <div class="account__container--user-infos p-5">
            <h2>Mes informations personnelles</h2>
            <div v-if="user" class="account__container--user-infos--left">
                <div class="card md:card-side bg-base-100 shadow-xl border">
                    <div class="user-infos__avatar flex items-center justify-center ml-5">
                        <figure>
                            <img :src="user.avatar_url" alt="Mon avatar">
                        </figure>
                    </div>
                    <div class="card-body user-infos__text flex flex-wrap flex-row justify-between">
                        <div>
                            <h2 class="card-title">{{ user.firstname }} {{ user.lastname }}</h2>
                            <p>{{ personalAddress.address }}</p>
                            <p>{{ personalAddress.zip_code }} {{ personalAddress.city }}</p>
                            <p>{{ user.phone }}</p>
                            <p>{{ user.email }}</p>
                        </div>
                        <div
                            class="card-actions justify-end account__container--user-infos--left--buttons flex flex-col">
                            <button class="btn__yellow--outline flex justify-start w-full gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                                Modifier mes informations
                            </button>
                            <button class="btn__yellow--outline flex flex-wrap justify-start w-full gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                                Modifier mon mot de passe
                            </button>
                            <button class="btn__darkblue--outline flex flex-wrap justify-start w-full gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>

                                Supprimer mon compte
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <p>Aucune information à afficher</p>
            </div>
        </div>
        <div class="account__container--user-reservation-history p-5">
            <h2>Mon historique de réservations</h2>
            <div class="overflow-x-auto">
                <table class="table mx-auto">
                    <!-- head -->
                    <thead>
                    <tr>
                        <th>
                            <label>
                                <input type="checkbox" class="checkbox" />
                            </label>
                        </th>
                        <th>Name</th>
                        <th>Job</th>
                        <th>Favorite Color</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row 1 -->
                    <tr>
                        <th>
                            <label>
                                <input type="checkbox" class="checkbox" />
                            </label>
                        </th>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle w-12 h-12">
                                        <img src="/tailwind-css-component-profile-2@56w.png" alt="Avatar Tailwind CSS Component" />
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold">Hart Hagerty</div>
                                    <div class="text-sm opacity-50">United States</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            Zemlak, Daniel and Leannon
                            <br/>
                            <span class="badge badge-ghost badge-sm">Desktop Support Technician</span>
                        </td>
                        <td>Purple</td>
                        <th>
                            <button class="btn btn-ghost btn-xs">details</button>
                        </th>
                    </tr>
                    <!-- row 2 -->
                    <tr>
                        <th>
                            <label>
                                <input type="checkbox" class="checkbox" />
                            </label>
                        </th>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle w-12 h-12">
                                        <img src="/tailwind-css-component-profile-3@56w.png" alt="Avatar Tailwind CSS Component" />
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold">Brice Swyre</div>
                                    <div class="text-sm opacity-50">China</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            Carroll Group
                            <br/>
                            <span class="badge badge-ghost badge-sm">Tax Accountant</span>
                        </td>
                        <td>Red</td>
                        <th>
                            <button class="btn btn-ghost btn-xs">details</button>
                        </th>
                    </tr>
                    <!-- row 3 -->
                    <tr>
                        <th>
                            <label>
                                <input type="checkbox" class="checkbox" />
                            </label>
                        </th>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle w-12 h-12">
                                        <img src="/tailwind-css-component-profile-4@56w.png" alt="Avatar Tailwind CSS Component" />
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold">Marjy Ferencz</div>
                                    <div class="text-sm opacity-50">Russia</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            Rowe-Schoen
                            <br/>
                            <span class="badge badge-ghost badge-sm">Office Assistant I</span>
                        </td>
                        <td>Crimson</td>
                        <th>
                            <button class="btn btn-ghost btn-xs">details</button>
                        </th>
                    </tr>
                    <!-- row 4 -->
                    <tr>
                        <th>
                            <label>
                                <input type="checkbox" class="checkbox" />
                            </label>
                        </th>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle w-12 h-12">
                                        <img src="/tailwind-css-component-profile-5@56w.png" alt="Avatar Tailwind CSS Component" />
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold">Yancy Tear</div>
                                    <div class="text-sm opacity-50">Brazil</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            Wyman-Ledner
                            <br/>
                            <span class="badge badge-ghost badge-sm">Community Outreach Specialist</span>
                        </td>
                        <td>Indigo</td>
                        <th>
                            <button class="btn btn-ghost btn-xs">details</button>
                        </th>
                    </tr>
                    </tbody>
                    <!-- foot -->
                    <tfoot>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Job</th>
                        <th>Favorite Color</th>
                        <th></th>
                    </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent} from 'vue'
import {useUserStore} from '../../../stores/userStore'

export default defineComponent({
    name: "userAccount",
    setup() {
        const userStore = useUserStore();
        return { userStore }
    },
    data() {
        return {
            user: null,
            personalAddress: null,
        }
    },
    computed: {
        userId() {
            return this.user.id
        }
    },
    methods: {
        getUser() {
            this.user = this.userStore.user
        },
        getPersonalAddress() {
            return this.personalAddress = JSON.parse(this.userStore.user.personal_address)
        }
    },
    async mounted() {
        await this.getUser()
        await this.getPersonalAddress()
    },
})
</script>

<style scoped>
.card {
    background-color: white;
}

.card-title {
    @apply my-0
}

.table {
    color: #fff;
    /*TODO - bug background-color: white !important; is not working*/
    background-color: white !important;
    @apply w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden
}
</style>
