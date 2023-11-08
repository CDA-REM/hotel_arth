<template>
    <div v-if="user" class="account__container">
        <h1>Mon compte</h1>
        <div class="account__container--user-infos p-5">
            <h2>Mes informations personnelles</h2>
            <div class="account__container--user-infos--left">
                <div class="card md:card-side bg-base-100 shadow-xl border">
                    <div class="avatar user-infos__avatar flex items-center justify-center ml-5 mt-5">
                        <figure class="w-24 rounded">
                            <img :src="user.avatar_url" alt="Mon avatar" />
                        </figure>
                    </div>
                    <div class="card-body user-infos__text flex flex-wrap flex-row justify-between">
                        <div v-if="user" >
                            <h2 class="card-title">{{ user.firstname }} {{ user.name }}</h2>
                            <p>
                                {{ personalAddress ? personalAddress.address : 'Adresse non disponible' }}
                            </p>
                            <p>
                                {{ personalAddress ? `${personalAddress.zip_code} ${personalAddress.city}` : 'Adresse non disponible' }}
                            </p>
                            <p>{{ user.phone }}</p>
                            <p>{{ user.email }}</p>
                        </div>
                        <div
                            v-if="user"
                            class="card-actions justify-end account__container--user-infos--left--buttons flex flex-col"
                        >
                            <button class="btn__yellow--outline flex justify-start w-full gap-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"
                                    />
                                </svg>
                                Modifier mes informations
                            </button>
                            <button class="btn__yellow--outline flex flex-wrap justify-start w-full gap-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"
                                    />
                                </svg>
                                Modifier mon mot de passe
                            </button>
                            <button class="btn__darkblue--outline flex flex-wrap justify-start w-full gap-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                                    />
                                </svg>

                                Supprimer mon compte
                            </button>
                        </div>
                        <div v-else>
                            <p>Aucune information à afficher</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="account__container--user-infos-pro p-5">
            <h2>Mes informations professionnelles</h2>
            <div class="card md:card-side bg-base-100 shadow-xl border">
                <div class="avatar user-infos__company-avatar flex items-center justify-center ml-5 mt-5">
                    <figure class="w-24 rounded">
                        <img src="/storage/pictures/avatar-company.jpg" alt="Avatar de l'entreprise" />
                    </figure>
                </div>
                <div class="card-body user-infos__text flex flex-wrap flex-row justify-between">
                    <div v-if="user.enterprise_name" >
                        <h2 class="card-title">{{ user.enterprise_name }} </h2>
                        <p>
                            {{ professionalAddress ? professionalAddress.address : 'Adresse non disponible' }}
                        </p>
                        <p>
                            {{ professionalAddress ? `${professionalAddress.zip_code} ${professionalAddress.city}` : 'Adresse non disponible' }}
                        </p>
                    </div>
                    <div
                        v-if="user.enterprise_name"
                        class="card-actions justify-end account__container--user-infos--left--buttons flex flex-col"
                    >
                        <button class="btn__yellow--outline flex justify-start w-full gap-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-6 h-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"
                                />
                            </svg>
                            Modifier mes informations
                        </button>
                    </div>
                    <div v-else>
                        <p>Aucune information à afficher</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="account__container--user-reservation-history p-5">
            <h2>Mon historique de réservations</h2>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <!-- head -->
                    <thead>
                    <tr>
                        <th>Numéro de réservation</th>
                        <th>Dates du séjour</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row 1 -->
                    <tr>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="font-bold">765432</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            du 11/10/2023 au 12/10/2023
                        </td>
                        <th>
                            <button class="btn btn-ghost btn-xs">details</button>
                        </th>
                    </tr>
                    <!-- row 2 -->
                    <tr>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="font-bold">654321</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            du 01/09/2023 au 03/10/2023
                        </td>
                        <th>
                            <button class="btn btn-ghost btn-xs">details</button>
                        </th>
                    </tr>
                    <!-- row 3 -->
                    <tr>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="font-bold">123456</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            du 16/08/2023 au 20/08/2023
                        </td>
                        <th>
                            <button class="btn btn-ghost btn-xs">details</button>
                        </th>
                    </tr>
                    <!-- row 4 -->
                    <tr>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="font-bold">483219</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            du 23/05/2023 au 25/05/2023
                        </td>
                        <th>
                            <button class="btn btn-ghost btn-xs">details</button>
                        </th>
                    </tr>
                    </tbody>
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
            professionalAddress: null,
        }
    },
    computed: {
        /**
         * Retrieves the user ID.
         *
         * @return {number} The user ID.
         */
        userId() {
            return this.user.id
        }
    },
    methods: {
        /**
         * Retrieves the user from the user store and assigns it to the 'user' property.
         *
         * @return {object}
         */
        getUser() {
            this.user = this.userStore.user
        },
        /**
         * Retrieves the personal address from the user store and assigns it to the 'personalAddress' property.
         *
         * @return {Object} The parsed personal address object.
         */
        getPersonalAddress() {
            return this.personalAddress = JSON.parse(this.userStore.user.personal_address)
        },
        /**
         * Retrieves the professional address from the user store and assigns it to the 'professionalAddress' property.
         *
         * @return {Object} The parsed professional address object.
         */
        getProfessionalAddress() {
            return this.professionalAddress = JSON.parse(this.userStore.user.professional_address)
        }
    },
    async mounted() {
        await this.getUser()
        await this.getPersonalAddress()
        await this.getProfessionalAddress()

        console.log(this.user)
        console.log(this.personalAddress)
        console.log(this.professionalAddress)
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

.account__container > div:nth-child(2),
.account__container > div:nth-child(3),
.account__container > div:nth-child(4) {
    @apply mx-auto;
    max-width: 1000px;
}

</style>
