<!--Les balises <span></span> sont celles de Daisy UI : NE PAS RETIRER LES BALISES SPAN : class CSS Daisy UI -->
<template>
    <!--   START - navigation breadcrumb-->
    <nav class="flex" aria-label="Breadcrumb" id="form-breadcrumb">
        <ul class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center ml-6">
                <button @click="setActiveTab('checkAvailability')"
                        :class="{ active: activeTab === 'checkAvailability' }"
                        id="nav--button"
                >
                    {{ $t(('breadcrumb.reservation')) }}
                </button>
            </li>
            <li> ></li>
            <li class="inline-flex items-center ml-6">
                <button @click="setActiveTab('selectOption')"
                        :class="{ active: activeTab === 'selectOption' } "
                        id="nav--button"
                >
                    {{ $t(('breadcrumb.options')) }}
                </button>
            </li>
            <li> ></li>
            <li class="inline-flex items-center ml-6">
                <button @click="setActiveTab('validateBooking')"
                        :class="{ active: activeTab === 'validateBooking' } "
                        id="nav--button"
                >
                    {{ $t(('breadcrumb.validation')) }}
                </button>
            </li>
        </ul>
    </nav>
    <!--   END - navigation breadcrumb -->
    <!-- START - Reservation form -->
    <form ref="reservationForm" @submit.prevent="submitBooking" class="flex flex-col mx-4">
        <div class="form-control w-full max-w-md mx-auto my-12">
            <!-- START - Vue Reservation -->
            <fieldset
                class="checkAvailability__section"
                id="checkAvailability"
                v-show="activeTab === 'checkAvailability'">
                <legend>
                    <h1 class="reservation__heading">{{ $t(('reservation.title')) }}</h1>
                </legend>
                <div class="form-group flex justify-between gap-x-1">
                    <div class="flex-col ">
                        <label for="checkin" class="label">
                            <span class="label-text">{{ $t('reservation.arrival') }}</span>
                        </label>
                        <VueDatePicker
                            name="checkin"
                            v-model="formReservation.started_date"
                            uid="checkin"
                            close-on-scroll
                            auto-apply placeholder="Select Date"
                            required prevent-min-max-navigation
                            :locale="globalStore.getLocale"
                            :format="formatDateForDatePicker"
                            :format-locale="fr"
                            :min-date="new Date()"
                            :max-date="maxDate">
                        </VueDatePicker>
                    </div>
                    <div class="flex-col">
                        <label for="checkout" class="label">
                            <span class="label-text">{{ $t('reservation.departure') }}</span>
                        </label>
                        <VueDatePicker
                            name="checkout"
                            v-model="formReservation.end_date"
                            uid="checkout"
                            close-on-scroll
                            auto-apply placeholder="Select Date"
                            required prevent-min-max-navigation
                            :locale="globalStore.getLocale"
                            :format="formatDateForDatePicker"
                            :format-locale="fr"
                            :min-date="calculateMinCheckoutDate"
                            :max-date="maxDate">
                        </VueDatePicker>
                    </div>
                </div>

                <label for="roomCategory-select" class="label">
                    <span class="label-text">{{ $t('reservation.roomCategory') }}</span>
                </label>
                <select class="select select-bordered rounded-none" id="roomCategory-select" name="roomCategory"
                        v-model="formReservation.roomCategory" required>
                    <option disabled selected>{{ $t('reservation.selectInputHelp') }}</option>
                    <option value="classic">{{ $t('reservation.classic') }}</option>
                    <option value="luxury">{{ $t('reservation.luxury') }}</option>
                    <option value="royal">{{ $t('reservation.royal') }}</option>
                </select>
                <!--                <div v-if="form.roomCategory === 'classic'">-->
                <img
                    v-if="formReservation.roomCategory === 'classic'"
                    :src="roomsImg.classic.src"
                    :alt="roomsImg.classic.altFr">
                <img
                    v-else-if="formReservation.roomCategory === 'luxury'"
                    :src="roomsImg.luxury.src"
                    :alt="roomsImg.classic.altFr">
                <img
                    v-else-if="formReservation.roomCategory === 'royal'"
                    :src="roomsImg.royal.src"
                    :alt="roomsImg.classic.altFr">
                <!--                </div>-->

                <label for="numberOfPeople" class="label">
                    <span class="label-text">{{ $t('reservation.numberOfPeople') }}</span>
                </label>
                <input
                    type="number"
                    id="numberOfPeople"
                    name="numberOfPeople"
                    min="1"
                    max="96"
                    class="w-full max-w-md"
                    v-model="formReservation.numberOfPeople"
                    required
                >

                <label for="numberOfRooms" class="label">
                    <span class="label-text">{{ $t('reservation.numberOfRooms') }}</span>
                </label>
                <input
                    type="number"
                    id="numberOfRooms"
                    name="numberOfRooms"
                    :min="calculateMinNumberOfRooms"
                    :max="calculateMaxNumberOfRooms"
                    class="w-full max-w-md"
                    v-model="formReservation.numberOfRooms"
                    required>
                <p class="mt-6 text-center font-bold text-lg">{{ dynamicRoomPrice }}</p>
                <p class=" mt-6 text-center text-arth-dark-blue font-bold italic text-sm">{{ dynamicMessage }}</p>

                <!-- START - Navigation Button -->
                <button type="button" @click="nextTab()" class="btn__lightblue" :disabled="availabilityStatus === false">
                    {{ $t('buttons.buttonBooking') }}
                </button>
                <!-- END - Navigation Button -->
            </fieldset>
            <!-- END - Vue Reservation -->

            <!-- START - Vue Options -->
            <fieldset
                class="options__section"
                id="selectOption"
                v-show="activeTab === 'selectOption'"
                :disabled="activeTab === 'checkAvailability'">
                <legend>
                    <h1 class="option__heading">{{ $t(('options.title')) }}</h1>
                </legend>
                <!-- START - Recap -->
                <div class="option__heading--recap">
                    <p>{{ $t(('options.recapTitle')) }} <br>
                        {{ $t(('options.recapStartDate')) }}
                        {{ formatCheckinDate }}
                        {{ $t(('options.recapEndDate')) }}
                        {{ formatCheckoutDate }} <br>
                        {{ formReservation.numberOfRooms }} {{ $t(('options.recapRoom')) }}
                        {{ $t((`reservation.${formReservation.roomCategory}`)) }},

                        {{ formReservation.numberOfPeople }} {{ $t(('options.recapPeople')) }}
                    </p>
                </div>
                <!-- END - Recap -->
                <p class="option__heading--help">{{ $t(('options.help')) }}</p>
                <!-- START - Options checkboxes -->
                <div class="form-control flex flex-row flex-wrap mx-4 my-2">
                    <input
                        type="checkbox"
                        id="optionPetitDejeuner"
                        name="optionPetitDejeuner"
                        checked="checked"
                        class="checkbox checkbox-xs"
                        value="1"
                        v-model="formReservation.formOptions">
                    <label for="optionPetitDejeuner" class="label cursor-pointer ml-4">
                        <span class="label-text">{{ $t('options.1') }}</span>
                    </label>
                </div>
                <div class="form-control flex flex-row mx-4 my-2">
                    <input type="checkbox" id="optionMidi" name="optionMidi" class="checkbox checkbox-sm"
                           value="2"
                           v-model="formReservation.formOptions">
                    <label for="optionMidi" class="label cursor-pointer ml-4">
                        <span class="label-text">{{ $t('options.2') }}</span>
                    </label>
                </div>

                <div class="form-control flex flex-row mx-4 my-2">
                    <input type="checkbox" id="optionSoir" name="optionSoir" class="checkbox checkbox-sm"
                           value="3"
                           v-model="formReservation.formOptions">
                    <label for="optionSoir" class="label cursor-pointer ml-4">
                        <span class="label-text">{{ $t('options.3') }}</span>
                    </label>
                </div>
                <div class="form-control flex flex-row mx-4 my-2">

                    <input type="checkbox" id="optionMidiEtSoir" name="optionMidiEtSoir" class="checkbox checkbox-sm"
                           value="4"
                           v-model="formReservation.formOptions">
                    <label for="optionMidiEtSoir" class="label cursor-pointer ml-4">
                        <span class="label-text">{{ $t('options.4') }}</span>
                    </label>
                </div>

                <div class="form-control flex flex-row mx-4 my-2">
                    <input type="checkbox" id="optionPressing" name="optionPressing" class="checkbox checkbox-sm"
                           value="5"
                           v-model="formReservation.formOptions">
                    <label for="optionPressing" class="label cursor-pointer ml-4">
                        <span class="label-text">{{ $t('options.5') }}</span>
                    </label>

                </div>
                <div class="form-control flex flex-row mx-4 my-2">
                    <input type="checkbox" id="optionCanalPlus" name="optionCanalPlus" class="checkbox checkbox-sm"
                           value="6"
                           v-model="formReservation.formOptions">
                    <label for="optionCanalPlus" class="label cursor-pointer ml-4">
                        <span class="label-text">{{ $t('options.6') }}</span>
                    </label>

                </div>
                <div class="form-control flex flex-row mx-4 my-2">
                    <input type="checkbox" id="optionSwimmingPool" name="optionSwimmingPool"
                           class="checkbox checkbox-sm"
                           value="7"
                           v-model="formReservation.formOptions">
                    <label for="optionSwimmingPool" class="label cursor-pointer ml-4">
                        <span class="label-text">{{ $t('options.7') }}</span>
                    </label>
                </div>
                <!-- END - Options checkboxes -->
                <!-- START - Navigation button -->
                <button type="button" @click="nextTab()" class="btn__lightblue w-full mt-6 mb-8">
                    {{ $t('buttons.buttonOptions') }}
                </button>
                <!-- END - Navigation button -->
            </fieldset>
            <!-- END - Vue Options -->

            <!-- START - Vue Validation -->
            <fieldset class="validation__section" id="validateBooking" v-show="activeTab === 'validateBooking'"
                      :disabled="activeTab !== 'validateBooking'">
                <legend>
                    <h1 class="validation__heading">{{ $t(('breadcrumb.validation')) }}</h1>
                </legend>

                <h2>{{ $t('validation.customerInformationsTitle') }}</h2>
                <div class="form-group flex justify-start gap-x-1">
                    <div class="form-control">
                        <label for="madam" class="label cursor-pointer">
                            <input type="radio" name="civility" id="madam" class="radio radio-xs" value="madam"
                                   v-model="formUser.civility" required/>
                            <span class="label-text ml-2 mr-4">{{ $t('validation.madam') }}</span>
                        </label>
                    </div>
                    <div class="form-control">
                        <label for="mister" class="label cursor-pointer">
                            <input type="radio" name="civility" id="mister" class="radio radio-xs" value="mister"
                                   v-model="formUser.civility" required/>
                            <span class="label-text ml-2">{{ $t('validation.mister') }}</span>
                        </label>
                    </div>
                </div>

                <div class="flex flex-col">
                    <div class="form-control w-full">
                        <label for="name" class="label">
                            <span class="label-text">{{ $t('validation.name') }}</span>
                        </label>
                        <input type="text" id="name" name="name" placeholder=""
                               class="input input-bordered w-full max-w-md" v-model="formUser.name" required/>
                    </div>

                    <div class="form-control w-full">
                        <label for="firstname" class="label">
                            <span class="label-text">{{ $t('validation.firstname') }}</span>
                        </label>
                        <input type="text" id="firstname" name="firstname" placeholder=""
                               class="input input-bordered w-full max-w-md" v-model="formUser.firstname" required/>
                    </div>

                    <div class="form-control w-full">
                        <label for="email" class="label">
                            <span class="label-text">{{ $t('validation.email') }}</span>
                        </label>
                        <input type="email" id="email" name="email" placeholder=""
                               class="input input-bordered w-full max-w-md" v-model="formUser.email" required/>
                    </div>

                    <div class="form-control w-full">
                        <label for="phoneNumber" class="label">
                            <span class="label-text">{{ $t('validation.phoneNumber') }}</span>
                        </label>
                        <input type="tel" id="phoneNumber" name="phoneNumber" placeholder=""
                               class="input input-bordered w-full max-w-md"
                               v-model="formUser.phoneNumber" required/>
                    </div>

                    <div class="form-control w-full">
                        <label for="address" class="label">
                            <span class="label-text">{{ $t('validation.address') }}</span>
                        </label>
                        <input type="text" id="address" name="address" placeholder=""
                               class="input input-bordered w-full max-w-md" v-model="formUser.address" required/>
                    </div>

                    <div class="form-control w-full">
                        <label for="zipCode" class="label">
                            <span class="label-text">{{ $t('validation.zipCode') }}</span>
                        </label>
                        <input type="text" id="zipCode" name="zipCode" placeholder=""
                               class="input input-bordered w-full max-w-md" v-model="formUser.zipCode" required/>
                    </div>

                    <div class="form-control w-full">
                        <label for="city" class="label">
                            <span class="label-text">{{ $t('validation.city') }}</span>
                        </label>
                        <input type="text" id="city" name="city" placeholder=""
                               class="input input-bordered w-full max-w-md" v-model="formUser.city" required/>
                    </div>
                </div>

                <div class=" flex flex-col">
                    <div class="form-control">
                        <label for="isTravelForWork" class="label cursor-pointer">
                            <span class="label-text">{{ $t('validation.isTravelForWork') }}</span>
                            <input type="checkbox" id="isTravelForWork" name="isTravelForWork" class="checkbox"
                                   v-model="formReservation.isTravelForWork"
                            />
                        </label>
                    </div>

                    <div v-if="formReservation.isTravelForWork === true ">
                        <h2>{{ $t('validation.companyInformationsTitle') }}</h2>
                        <div class="form-control w-full">
                            <label for="companyName" class="label">
                                <span class="label-text">{{ $t('validation.companyName') }}</span>
                            </label>
                            <input type="text" id="companyName" name="companyName" placeholder=""
                                   class="input input-bordered w-full max-w-md"
                                   v-model="formUser.companyName"/>
                        </div>
                        <div class="form-control w-full">
                            <label for="companyAddress" class="label">
                                <span class="label-text">{{ $t('validation.companyAddress') }}</span>
                            </label>
                            <input type="text" id="companyAddress" name="companyAddress" placeholder=""
                                   class="input input-bordered w-full max-w-md"
                                   v-model="formUser.companyName"/>
                        </div>

                        <div class="form-control w-full">
                            <label for="companyZipCode" class="label">
                                <span class="label-text">{{ $t('validation.companyZipCode') }}</span>
                            </label>
                            <input type="text" id="companyZipCode" name="companyZipCode" placeholder=""
                                   class="input input-bordered w-full max-w-md" v-model="formUser.zipCode"/>
                        </div>

                        <div class="form-control w-full">
                            <label for="companyCity" class="label">
                                <span class="label-text">{{ $t('validation.companyCity') }}</span>
                            </label>
                            <input type="text" id="companyCity" name="companyCity" placeholder=""
                                   class="input input-bordered w-full max-w-md" v-model="formUser.city"/>
                        </div>
                    </div>

                    <div>
                        <h2>{{ $t('validation.recapTitle') }}</h2>

                        <div class="booking__validation--recap leading-6">
                            <p class="m-2">{{ $t(('options.recapTitle')) }} <br>
                                {{ $t(('options.recapStartDate')) }} {{ formatCheckinDate }} {{
                                    $t(('options.recapEndDate'))
                                }} {{ formatCheckoutDate }} <br>
                                {{ formReservation.numberOfRooms }} {{ $t(('options.recapRoom')) }}
                                {{ $t((`reservation.${formReservation.roomCategory}`)) }},
                                {{ formReservation.numberOfPeople }} {{ $t(('options.recapPeople')) }}
                            </p>
                            <p v-if="formReservation.formOptions.length" class="m-2">Options : </p>
                            <ul class="m-2">
                                <li v-for="(option) in formReservation.formOptions">{{ $t((`options.${option}`)) }}</li>
                            </ul>

                            <!-- START - Total price -->
                            <p class="mt-6 text-center font-bold">{{ $t('options.totalAmountOfStay') }}
                                <span class="font-bold">{{ calculateTotalPrice }} €</span>
                            </p>
                            <!-- END - Total price -->
                            <p class="mx-6 my-6 text-start">{{ $t('validation.annulationDelay') }}</p>
                        </div>
                    </div>
                </div>
                <!-- START - Submit Button -->
                <button @click="submitBooking" type="button" id="submit" class="submit">
                    {{ $t('buttons.buttonValidateAndGoToPayment') }}
                </button>
                <!-- END -Submit Button -->
            </fieldset>
            <!--            END - Vue Validation-->
        </div>
    </form>
    <!-- END - Reservation form -->

    <!-- START - Errors section -->
    <div class="alert" v-if="errors.length">
        <div v-for="error in errors" :key="error.index">{{ error }}</div>
    </div>
    <!-- END - Errors section -->
</template>

<script>
import {defineComponent} from "vue";
import {useUserStore} from "../../../stores/userStore";
import {useGlobalStore} from "../../../stores/globalStore";
import {useRoomCategoriesStore} from "../../../stores/roomCategoriesStore";
import {useOptionsStore} from "../../../stores/optionsStore";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import {enGB, fr} from 'date-fns/locale';
import moment from "moment";
import {computed} from "vue";
import {addMonths, getMonth, getYear} from 'date-fns';
import router from "../../router";
import axios from "axios";

export default defineComponent({
    name: 'reservation',
    components: {VueDatePicker},
    setup() {
        const userStore = useUserStore();
        const roomCategoriesStore = useRoomCategoriesStore();
        const optionsStore = useOptionsStore();
        const globalStore = useGlobalStore();
        const maxDate = computed(() => addMonths(new Date(getYear(new Date()), getMonth(new Date())), 6));
        return {userStore, roomCategoriesStore, optionsStore, globalStore, fr, enGB, maxDate};
    },
    data() {
        return {
            personalAddress: null,
            professionalAddress: null,
            formReservation: {
                started_date: null,
                end_date: null,
                roomCategory: null,
                numberOfRooms: null,
                numberOfPeople: null,
                formOptions: [],
                isTravelForWork: false,
            },
            formUser: {
                id: this.userStore.user.id,
                civility: this.userStore.user.civility || '',
                firstname: this.userStore.user.firstname || '',
                name: this.userStore.user.name || "",
                email: this.userStore.user.email || "",
                phoneNumber: this.userStore.user.phone || "",
                address: this.personalAddress ? this.personalAddress.address : "",
                zipCode: this.personalAddress ? this.personalAddress.zip_code : "",
                city: this.personalAddress ? this.personalAddress.city : "",
                companyName: this.personalAddress ? this.userStore.user.enterprise_name : "",
                companyAddress: this.professionalAddress ? this.professionalAddress.address : "",
                companyZipCode: this.professionalAddress ? this.professionalAddress.zip_code : "",
                companyCity: this.professionalAddress ? this.professionalAddress.city : "",
            },
            roomsImg: {
                classic: {
                    src: "storage/room_categories/arth_chambre_classique.jpeg",
                    altFr: "Chambre Classique",
                    altEn: " Classic Room",
                },
                luxury: {
                    src: "storage/room_categories/arth_chambre_luxe.jpeg",
                    altFr: "Chambre de luxe",
                    altEn: " Luxury  Room",
                },
                royal: {
                    src: "storage/room_categories/hotel-room-g512f9f1ee_1920.jpg",
                    altFr: "Suite Royale",
                    altEn: "Royal Suite",
                }
            },
            options: [1, 2, 3, 4, 5, 6, 7],
            allTabs: ["checkAvailability", "selectOption", "validateBooking"],
            activeTab: "checkAvailability",
            errors: [],
            isLoading: false,
            availabilityStatus: null,
            roomPrice: 0,
        }
    },
    computed: {

        /**
         * Calculates the room price based on the number of rooms and the number of days.
         *
         * @return {number} The calculated room price.
         */
        calculateRoomPrice() {
            let numberOfDays = this.calculateNumberOfDays(this.formReservation.started_date, this.formReservation.end_date);
            if (this.formReservation.numberOfRooms > 0) {
                this.roomPrice = (this.roomCategoriesStore.getRoomCategories.find(roomCategory => roomCategory.slug ===
                    this.formReservation.roomCategory).price) * this.formReservation.numberOfRooms * numberOfDays;
            }
            return this.roomPrice;
        },

        /**
         * Calculates the price of the options based on the form reservation and options store.
         *
         * @return {number} The total price of the options.
         */
        calculateOptionsPrice() {
            let optionsPrice = 0;
            let numberOfDays = this.calculateNumberOfDays(this.formReservation.started_date, this.formReservation.end_date);

            if (this.formReservation.formOptions.length > 0) {
                this.formReservation.formOptions.forEach(option => {

                    if (option === "1" || option === "2" || option === "3" || option === "4" || option === "5") {
                        optionsPrice += (this.optionsStore.getOptions.find(element => element.id.toString() ===
                            option).price) * this.formReservation.numberOfPeople * numberOfDays;
                    }
                    if (option === "6") {
                        optionsPrice += (this.optionsStore.getOptions.find(element => element.id.toString() ===
                            option).price) * Math.ceil(numberOfDays / 7) * this.formReservation.numberOfRooms;
                    }
                    if (option === "7") {
                        optionsPrice += (this.optionsStore.getOptions.find(element => element.id.toString() === option).price);
                    }
                });
            }
            return optionsPrice;
        },

        /**
         * Calculates the total price by adding the room price and options price.
         *
         * @return {number} The calculated total price.
         */
        calculateTotalPrice() {
            return this.calculateRoomPrice + this.calculateOptionsPrice;
        },

        /**
         * Calculates the minimum number of rooms required based on the number of people.
         *
         * @return {number} The minimum number of rooms required.
         */
        calculateMinNumberOfRooms() {
            const numberOfPeople = this.formReservation.numberOfPeople;
            let minNumberOfRooms = 1;
            let numberOfBeds = minNumberOfRooms * 3;

            if (numberOfPeople > (numberOfBeds)) {
                return minNumberOfRooms = Math.ceil(numberOfPeople / 3);
            } else {
                return minNumberOfRooms;
            }
        },

        /**
         * Calculates the maximum number of rooms based on the number of people in the reservation.
         *
         * @return {number} The maximum number of rooms.
         */
        calculateMaxNumberOfRooms() {
            if (this.formReservation.numberOfPeople > 0 && this.formReservation.numberOfPeople <= 96) {
                return this.formReservation.numberOfPeople;
            }
            if (this.formReservation.numberOfPeople > 96) {
                return 32;
            }
        },

        /**
         * Calculates the minimum checkout date based on the started date.
         *
         * @return {Date} The minimum checkout date.
         */
        calculateMinCheckoutDate() {
            if (this.formReservation.started_date) {
                const checkinDate = new Date(moment(this.formReservation.started_date, "DD MM YYYY"));
                const checkOutDate = new Date(moment(checkinDate).add(1, 'days'));
                return checkOutDate;

            }
        },

        /**
         * Formats the date for the date picker.
         * This method is only used for component display
         *
         * @return {string} The formatted date string.
         */
        formatDateForDatePicker() {
            return this.globalStore.getLocale === 'fr' ? 'dd/MM/yyyy' : 'MM/dd/yyyy'
        },

        /**
         * Formats the check-in date
         *
         * @return {type} The formatted check-in date.
         */
        formatCheckinDate() {
            if (this.formReservation.started_date) {
                return this.formatDateForRecap(this.formReservation.started_date);
            }
        },

        /**
         * Formats the checkout date
         *
         * @return {type} The formatted checkout date.
         */
        formatCheckoutDate() {
            if (this.formReservation.end_date) {
                return this.formatDateForRecap(this.formReservation.end_date);
            }
        },

        /**
         * Generates a dynamic message based on the values of `formReservation.numberOfRooms` and `availabilityStatus`.
         *
         * @return {string} The generated dynamic message.
         */
        dynamicMessage() {
            if (this.availabilityStatus === null) {
                return '';
            }

            if (this.formReservation.numberOfRooms > 0 && this.availabilityStatus) {
                return this.$t('reservation.totalPriceLegend');
            }

            if (this.formReservation.numberOfRooms > 0 && !this.availabilityStatus) {
                return this.$t('reservation.availabilityStatus');
            }
        },

        /**
         * Calculates the dynamic room price based on the availability status.
         *
         * @return {string} The calculated room price in €, or an empty string if the availability status is false.
         */
        dynamicRoomPrice() {
            if (!this.isLoading && this.availabilityStatus) {
                return this.calculateRoomPrice + " €";
            } else {
                return "";
            }
        },
    },
    watch: {
        'formReservation.numberOfRooms'() {
            if (this.formReservation.started_date && this.formReservation.end_date &&
                this.formReservation.roomCategory && this.formReservation.numberOfRooms && this.formReservation.numberOfPeople) {
                this.getAvailability();
            }
        },
        'formReservation.numberOfPeople'() {
            if (this.formReservation.started_date && this.formReservation.end_date &&
                this.formReservation.roomCategory && this.formReservation.numberOfRooms && this.formReservation.numberOfPeople) {
                this.getAvailability();
            }
        },
        'formReservation.roomCategory'() {
            if (this.formReservation.started_date && this.formReservation.end_date &&
                this.formReservation.roomCategory && this.formReservation.numberOfRooms && this.formReservation.numberOfPeople) {
                this.getAvailability();
            }
        },
        'formReservation.end_date'() {
            if (this.formReservation.started_date && this.formReservation.end_date &&
                this.formReservation.roomCategory && this.formReservation.numberOfRooms && this.formReservation.numberOfPeople) {
                this.getAvailability();
            }
        }
    },
    methods: {
        useGlobalStore,
        /**
         * Check if the number of available rooms with the selected style is sufficient.
         *
         * @param availableRooms
         * @param {number} selectedRoomStyle - The ID of the selected room style.
         * @param {number} numberOfRooms - The number of rooms chosen by the user.
         * @return {boolean} true if there are enough available rooms, false otherwise.
         */
        areAvailableRoomsSufficient(availableRooms, selectedRoomStyle, numberOfRooms) {
            const styleMatchedRooms = Object.values(availableRooms).filter(room => room.style === selectedRoomStyle);
            return styleMatchedRooms.length >= numberOfRooms;
        },
        /**
         * Retrieves availability data from the server.
         *
         * @return {Promise} A promise that resolves with the availability data.
         */
        async getAvailability() {
            await axios.get(`api/reservations/availability`, {
                params: {
                    started_date: this.formatDateForRequest(this.formReservation.started_date),
                    end_date: this.formatDateForRequest(this.formReservation.end_date),
                }
            })
                .then((response) => {
                    if (response.status === 200 || response.status === 201) {
                        const rooms = response.data;

                        let count = 0;
                        for (const key in rooms) {
                            if (rooms.hasOwnProperty(key)) {
                                count++;
                            }
                        }

                        if (count === 0) {
                            this.availabilityStatus = false;
                        } else {
                            this.availabilityStatus = this.areAvailableRoomsSufficient(rooms, this.formReservation.roomCategory, this.formReservation.numberOfRooms);
                            console.log("availabilityStatus:", this.availabilityStatus);
                        }
                    }
                })
                .catch((error) => {
                    if (error.response) {
                        this.errors.push('Une erreur est survenue',error?.response?.data?.message || " Erreur inconnue")
                        console.debug(`Erreur : ${error}`)
                    }
                });
        },

        /**
         * Calculates the number of days between the start and end dates of a reservation.
         *
         * @return {number} The number of days between the start and end dates.
        */
        calculateNumberOfDays(checkinDate, checkoutDate) {
            if (checkinDate && checkoutDate) {
                const checkinDateObj = new Date(moment(checkinDate, "DD MM YYYY"));
                const checkoutDateObj = new Date(moment(checkoutDate, "DD MM YYYY"));
                return moment(checkoutDateObj).diff(moment(checkinDateObj), 'days');
            }
        },

        /**
         * Formats the given date for the recap.
         * Called by the computed properties formatChekinDate() and formatCheckoutDate
         *
         * @param {Date} input - The date to be formatted.
         * @return {string} The formatted date.
         */
        formatDateForRecap(input) {
            const date = input
            return (date && !this.isLoading) ? date.toLocaleDateString(this.globalStore.getLocale) : '';
        },

        /**
         * Formats a date for request.
         *
         * @param {Date} - the date to be formatted
         * @return {String} the formatted date
         */
        formatDateForRequest(date) {
            return date ? moment(date).format('YYYY-MM-DD') : '';
        },

        /**
         * Formats the check-in date to match required format for the request.
         * It's called at submit.
         *
         * @return {string} The formatted check-in date in the format 'YYYY-MM-DD'.
         */
        formatCheckinDateForRequest() {
            if (this.formReservation.started_date) {
                return this.formReservation.started_date = moment(this.formReservation.started_date).format('YYYY-MM-DD');
            }
        },

        /**
         * Formats the checkout date to match required format for request.
         * It's called at sumbit
         *
         * @return {string} The formatted checkout date.
         */
        formatCheckoutDateForRequest() {
            if (this.formReservation.end_date) {
                return this.formReservation.end_date = moment(this.formReservation.end_date).format('YYYY-MM-DD');
            }
        },

        /**
         * Sets the active tab based on the given tab reference.
         *
         * @param {string} tabRef - The reference to the tab to set as active.
         * @return {void}
         */
        setActiveTab(tabRef) {
            if (this.$refs.reservationForm.reportValidity()) {
                this.activeTab = tabRef;
            }
        },

        /**
         * Moves to the next tab if the current tab is not "validateBooking" and the reservation form is valid.
         *
         * @return {void} description of return value
         */
        nextTab() {
            if (
                this.activeTab !== "validateBooking" &&
                this.$refs.reservationForm.reportValidity()
            ) {
                this.activeTab = this.allTabs[this.allTabs.indexOf(this.activeTab) + 1];
            }
        },

        /**
         * Resets the form.
         *
         * @return {void} description of return value
         */
        resetForm() {
            this.$refs.reservationForm.reset();
        },

        /**
         * Retrieves the personal address from the user's store and assigns it to the component's personalAddress property.
         *
         * @return {Object} The parsed personal address object.
         */
        getPersonalAddress() {
            return this.personalAddress = JSON.parse(this.userStore.user.personal_address)
        },

        /**
         * Retrieves the professional address from the user store.
         *
         * @return {Object|null} The professional address object, or null if it doesn't exist.
         */
        getProfessionalAddress() {
            if (this.userStore.user && this.userStore.user.professional_address) {
                return this.professionalAddress = JSON.parse(this.userStore.user.professional_address);
            } else {
                return null;
            }
        },

        /**
         * Submits the user information to the server.
         *
         * @return {Promise} A promise that resolves with the response from the server.
         */
        async submitUser() {
            axios.post('api/users/' + this.userStore.user.id + '/userInfos', {...this.formUser, _method: 'put'})
                .then(
                    (response) => {
                        if (response.status === 200 || response.status === 201) {
                            this.userStore.user = response.data.user;
                            this.userStore.user.personal_address = JSON.stringify(this.personalAddress.address);
                            this.userStore.user.professional_address = JSON.stringify(this.professionalAddress);
                            this.$router.push("/reservation-confirmation");
                            this.resetForm();
                        }
                    }
                )
                .catch((error) => {
                    this.errors.push(
                        "Une erreur s'est produite lors de l'enregistrement de vos informations utilisateur :  \n" + "Veuillez réessayer ou nous contacter si le problème persiste."
                    );
                });
        },

        /**
         * Submits the booking.
         *
         * @return {Promise} A promise that resolves when the booking is submitted.
         */
        async submitBooking() {
            this.isLoading = true
            this.formatCheckinDateForRequest();
            this.formatCheckoutDateForRequest();

            if (this.$refs.reservationForm.reportValidity()) {
                const config = {
                    headers: {
                        Accept: ["application/json"],
                        "Content-Type": ["application/json"],
                    },
                };

                await axios.post("api/reservations/create",
                    {...this.formReservation,},
                    config)
                    .then(
                        (response) => {
                            if (response.status === 200 || response.status === 201) {
                                this.submitUser();
                            }
                        }
                    )
                    .catch((error) => {
                        this.errors = [];
                        this.errors.push(
                            "Une erreur s'est produite lors de l'enregistrement de votre réservation : \n" + " Veuillez réessayer ou nous contacter si le problème persiste."
                        );
                    });
            }
        },
    },
    async mounted() {
        await this.getPersonalAddress();
        await this.getProfessionalAddress();
    },
})
</script>

<style scoped>

.alert {
    @apply w-96 justify-center p-4 mx-auto mb-6
    text-red-600 text-base font-bold
    border border-2 border-red-600 rounded-md bg-transparent;
}

form,
label,
span.label-text,
input,
select {
    @apply text-black;
}

legend {
    @apply w-full;
}

form button {
    @apply bg-arth-green w-full mt-6 mb-8;
}

form input,
form select {
    @apply rounded-sm bg-white;
}

fieldset {
    @apply mx-0;
}

label {
    @apply mt-4;
}

.validation__section {
//margin: 0;
}

.select {
    @apply m-0 w-full;
}

#nav--button {
    border: none;
    @apply pl-2 pr-2 font-normal border-0;
}

.active {
    @apply font-bold !important;
}

.reservation__heading,
.option__heading,
.validation__heading {
    @apply mb-8
}

.option__heading--recap,
.booking__validation--recap {
    @apply bg-arth-light-blue mx-auto mt-12 py-3 px-4 text-center
}

.option__heading--help {
    @apply mt-12 mb-6 text-center font-montserrat
}

.option__heading--recap {
    @apply px-4
}

.options__section label {
    @apply mt-0;
}
</style>
