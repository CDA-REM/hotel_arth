<!--Les balises span sont celles de Daisy UI : NE PAS RETIRER LES BALISES SPAN : class CSS Daisy UI -->
<template>
    <!--   START - navigation breadcrumb-->
    <nav class="flex" aria-label="Breadcrumb" id="form-breadcrumb">
        <ul class="inline-flex items-center space-x-1 md:space-x-3">
            <!--            <li class="inline-flex items-center ml-6">-->
            <!--                <router-link :to="{ name: 'landingPage'}"-->
            <!--                             class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">-->
            <!--                    {{ $t(('breadcrumb.home')) }}-->
            <!--                </router-link>-->
            <!--            </li>-->
            <!--            <li> > </li>-->
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
    <form ref="reservationForm"  @submit.prevent="submitBooking" class="flex flex-col mx-4">
        <div class="form-control w-full max-w-md mx-auto my-12">
            <!-- START - Vue Reservation -->
            <fieldset class="checkAvailability__section" id="checkAvailability"
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
                            :format="formateDateForDatePicker"
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
                            :format="formateDateForDatePicker"
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
                    <img v-if="formReservation.roomCategory === 'classic'" :src="roomsImg.classic.src" :alt="roomsImg.classic.altFr">
                    <img v-else-if="formReservation.roomCategory === 'luxury'" :src="roomsImg.luxury.src" :alt="roomsImg.classic.altFr">
                    <img v-else-if="formReservation.roomCategory === 'royal'" :src="roomsImg.royal.src" :alt="roomsImg.classic.altFr">
<!--                </div>-->

                <label for="numberOfPeople" class="label">
                    <span class="label-text">{{ $t('reservation.numberOfPeople') }}</span>
                </label>
                <input type="number"
                        id="numberOfPeople"
                        name="numberOfPeople"
                        min="1"
                        max="10"
                        class="w-full max-w-md"
                        v-model="formReservation.numberOfPeople"
                        required
                        >

                <label for="numberOfRooms" class="label">
                    <span class="label-text">{{ $t('reservation.numberOfRooms') }}</span>
                </label>
                <input type="number"
                        id="numberOfRooms"
                        name="numberOfRooms"
                        :min="calculateMinNumberOfRooms"
                        :max="calculateMaxNumberOfRooms"
                        class="w-full max-w-md"
                        v-model="formReservation.numberOfRooms"
                        required>
                <p class="mt-6 text-center font-bold text-lg">{{ calculateRoomPrice }} € </p>
                <p class="text-center text-red-600 font-bold italic text-sm">{{ $t('reservation.totalPriceLegend')}}</p>
                <!-- START - Navigation Button -->
                <button type="button" @click="nextTab()" class="">
                    {{ $t('buttons.buttonBooking') }}
                </button>
                <!-- END - Navigation Button -->
            </fieldset>
            <!-- END - Vue Reservation -->

            <!-- START - Vue Options -->
            <fieldset class="options__section" id="selectOption" v-show="activeTab === 'selectOption'"
                      :disabled="activeTab === 'checkAvailability'">
                <legend>
                    <h1 class="option__heading">{{ $t(('options.title')) }}</h1>
                </legend>
                <!-- START - Recap -->
                <div class="option__heading--recap">
                    <p>{{ $t(('options.recapTitle')) }} <br>
                        {{ $t(('options.recapStartDate')) }}
                        {{ formateCheckinDate }}
                        {{ $t(('options.recapEndDate')) }}
                        {{ formateCheckoutDate }} <br>
                        {{ formReservation.numberOfRooms }} {{ $t(('options.recapRoom')) }}
                        {{ $t((`reservation.${formReservation.roomCategory}`))}},

                        {{ formReservation.numberOfPeople }} {{ $t(('options.recapPeople')) }}
                    </p>
                </div>
                <!-- END - Recap -->
                <p class="option__heading--help">{{ $t(('options.help')) }}</p>
                <!-- START - Options checkboxes -->
                <div class="form-control flex flex-row flex-wrap mx-4 my-2">
                    <input type="checkbox"
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
                <!-- START - Options price - TODO - Remove this section after validate result is the same as back-end's result -->
<!--                <p class="mt-6 text-center text-red-600 font-bold">{{ $t('options.totalAmountOfOptions') }}-->
<!--                    <span>{{ calculateOptionsPrice }}</span>-->
<!--                    <span> €</span>-->
<!--                </p>-->
                <!-- END - Options price -->

                <p class="mt-6 text-center text-red-600 font-bold">{{ $t('options.totalAmountOfStay') }}
                    <span class="font-bold">{{ calculateTotalPrice }} €</span>
                </p>
                <!-- START - Navigation button -->
                <button type="button" @click="nextTab()" class="bg-arth-green w-full mt-6 mb-8">
                    {{ $t('buttons.buttonOptions') }}
                </button>
                <!-- END - Navigation button -->
            </fieldset>
            <!-- END - Vue Options -->

            <!--            START - Vue Validation -->
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
                        <label for="lastname" class="label">
                            <span class="label-text">{{ $t('validation.lastname') }}</span>
                        </label>
                        <input type="text" id="lastname" name="lastname" placeholder=""
                               class="input input-bordered w-full max-w-md" v-model="formUser.lastname" required/>
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
                                {{ $t(('options.recapStartDate')) }} {{ formateCheckinDate }} {{
                                    $t(('options.recapEndDate'))
                                }} {{ formateCheckoutDate }} <br>
                                {{ formReservation.numberOfRooms }} {{ $t(('options.recapRoom')) }}  {{ $t((`reservation.${formReservation.roomCategory}`))}},
                                {{ formReservation.numberOfPeople }} {{ $t(('options.recapPeople')) }}
                            </p>
                            <p v-if="formReservation.formOptions.length" class="m-2">Options : </p>
                            <ul class="m-2">
                                <li v-for="(option) in formReservation.formOptions">{{ $t((`options.${option}`)) }}</li>
                            </ul>
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

export default {
    name: 'reservation',
    components: { VueDatePicker },
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
            formReservation : {
                started_date: null,
                end_date: null,
                roomCategory: null,
                numberOfRooms: null,
                numberOfPeople: null,
                formOptions: [],
                isTravelForWork: false,
                user_id: 1, // TODO - Fake Data - Remove this line when authentification will be implemented
                //user_id: "userStore.user.id" // TODO - Uncomment this line when it will be required
            },
            formUser : {
                id: 1, // TODO - Fake Data - Remove this line when authentification will be implemented
                // id: "userStore.user.id", // TODO - Uncomment this line when it will be required
                civility: "",
                firstname: "",
                lastname: "",
                email: "",
                phoneNumber: "",
                address: "",
                zipCode: "",
                city: "",
                companyName: null,
                companyAddress: null,
                companyZipCode: null,
                companyCity: null
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
            options: [1,2,3,4,5,6,7],
            allTabs: ["checkAvailability", "selectOption", "validateBooking"],
            activeTab: "checkAvailability",
            errors: [],
        }
    },
    computed: {
        // Calculate room price
        calculateRoomPrice() {
            let roomPrice = 0;
            let numberOfDays = this.calculateNumberOfDays();
            if (this.formReservation.numberOfRooms > 0) {
                roomPrice = (this.roomCategoriesStore.getRoomCategories.find(roomCategory => roomCategory.slug ===
                    this.formReservation.roomCategory).price) * this.formReservation.numberOfRooms * numberOfDays;
            }
            return roomPrice;
        },
        // Calculate options price
        calculateOptionsPrice() {
            let optionsPrice = 0;
            let numberOfDays = this.calculateNumberOfDays();

            if (this.formReservation.formOptions.length > 0) {
                this.formReservation.formOptions.forEach(option => {

                    if(option === "1" || option === "2" || option === "3" || option === "4" || option === "5") {
                        optionsPrice += (this.optionsStore.getOptions.find(element => element.id.toString() ===
                            option).price) * this.formReservation.numberOfPeople * numberOfDays;
                    }
                    if(option === "6") {
                        optionsPrice += (this.optionsStore.getOptions.find(element => element.id.toString() ===
                            option).price) * Math.ceil(numberOfDays/7) * this.formReservation.numberOfRooms;
                    }
                    if(option === "7") {
                        optionsPrice += (this.optionsStore.getOptions.find(element => element.id.toString() === option).price);
                    }
                });
            }
            return optionsPrice;
        },
        // Calculate total price of reservation
        calculateTotalPrice() {
            return this.calculateRoomPrice + this.calculateOptionsPrice;
        },
        // Calculate Minimum number of rooms depending on number of people
        calculateMinNumberOfRooms() {
            const numberOfPeople = this.formReservation.numberOfPeople;
            let minNumberOfRooms = 1;
            let numberOfBeds = minNumberOfRooms * 3;

            if (numberOfPeople > (numberOfBeds)) {
                return minNumberOfRooms = Math.ceil(numberOfPeople/3);
            } else {
                return minNumberOfRooms;
            }
        },
        // Define maximum number of rooms depending on number of people
        calculateMaxNumberOfRooms() {
            if(this.formReservation.numberOfPeople > 0) {
                return this.formReservation.numberOfPeople;
            }
        },
        // Calculate minimum date of checkout depending on checkin date
        calculateMinCheckoutDate() {
            if (this.formReservation.started_date) {
                const checkinDate = new Date(moment(this.formReservation.started_date, "DD MM YYYY"));
                const checkOutDate = new Date(moment(checkinDate).add(1, 'days'));
                return checkOutDate;

            }
        },
        // This method is only for component display
        formateDateForDatePicker() {
            return this.globalStore.getLocale === 'fr' ? 'dd/MM/yyyy' : 'MM/dd/yyyy'
        },
        // Formate checkin date for recap
        formateCheckinDate() {
            if (this.formReservation.started_date) {
                return this.formateDateForRecap(this.formReservation.started_date);
            }
        },
        // Formate checkin date for recap
        formateCheckoutDate() {
            if (this.formReservation.end_date) {
            return this.formateDateForRecap(this.formReservation.end_date);
            }
        },
    },
    methods: {
        //useUserStore, //TODO - Uncomment this line if needed
        useGlobalStore,
        calculateNumberOfDays() {
            if (this.formReservation.started_date && this.formReservation.end_date) {
                const checkinDate = new Date(moment(this.formReservation.started_date, "DD MM YYYY"));
                const checkoutDate = new Date(moment(this.formReservation.end_date, "DD MM YYYY"));
                const numberOfDays = moment(checkoutDate).diff(moment(checkinDate), 'days');
                return numberOfDays;
            }
        },
        // This methods is called by the computed properties formateChekinDate() and formateCheckoutDate
        formateDateForRecap(input) {
            if (input) {
                return input = input.toLocaleDateString(this.globalStore.getLocale)
            }
            return new Date
        },
        // This method formate date to match required format for request. It's called at sumbit
        formateCheckinDateForRequest () {
            if (this.formReservation.started_date) {
                return this.formReservation.started_date = moment(this.formReservation.started_date).format('YYYY-MM-DD');
            }
        },
        // This method formate date to match required format for request. It's called at sumbit
        formateCheckoutDateForRequest () {
            if (this.formReservation.end_date) {
                return this.formReservation.end_date = moment(this.formReservation.end_date).format('YYYY-MM-DD');
            }
        },
        setActiveTab(tabRef) {
            if (this.$refs.reservationForm.reportValidity()) {
                this.activeTab = tabRef;
            }
        },
        nextTab() {
            if (
                this.activeTab !== "validateBooking" &&
                this.$refs.reservationForm.reportValidity()
            ) {
                this.activeTab = this.allTabs[this.allTabs.indexOf(this.activeTab) + 1];
            }
        },
        /*prevTab() {
            if (this.activeTab !== "checkAvailability") {
                this.activeTab = this.allTabs[this.allTabs.indexOf(this.activeTab) - 1];
            }
        },*/
        resetForm() {
            this.$refs.reservationForm.reset();
        },
        // Send request to create reservation
        async submitBooking() {
            this.formateCheckinDateForRequest();
            this.formateCheckoutDateForRequest();

            if (this.$refs.reservationForm.reportValidity()) {
                const config = {
                    headers: {
                        Accept: ["application/json"],
                        "Content-Type": ["application/json"],
                        //withCredentials: true,
                    },
                    auth: {
                        // TODO - Ajouter le cookie utilisateur ? ;
                    },
                };
            await axios
                .post(
                    "api/reservations/create",
                    {
                                ...this.formReservation,
                            }, config
                )
                .then(
                    (response) => {
                            if (response.status === 200 || response.status === 201) {
                                console.debug("response code: " + response.status);
                                this.resetForm();
                                return router.push("/reservation-confirmation");
                            } else {
                                this.errors.push(
                                    "Une erreur s'est produite lors de l'enregistrement de votre réservation : " +
                                    (response?.data?.message || " Erreur inconnue")
                                );
                            }
                        },
                )
                .catch((error) => {
                    if (error.response) {
                        // The request was made and the server responded with a status code
                        // that falls out of the range of 2xx
                        console.log('1')
                        console.log(error.response.data);
                        console.log(error.response.status);
                        console.log(error.response.headers);
                    } else if (error.request) {
                        // The request was made but no response was received
                        // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                        // http.ClientRequest in node.js
                        console.log('2')
                        console.log(error.request);
                    } else {
                        // Something happened in setting up the request that triggered an Error
                        console.log('3')
                        console.log('Error', error.message);
                    }
                    console.log(error.config);
                    this.errors.push(
                            "Une erreur s'est produite lors de l'enregistrement de votre réservation : " +
                        (error?.response?.data?.message || " Erreur inconnue")
                    );
                });

            // await axios.post('api/users/update', {...this.formUser, _method: 'put' }, config)
            //             .then(
            //                 (response) => {
            //                     if (response.status === 200 || response.status === 201) {
            //                         console.log(this.form);
            //                         console.debug("response code: " + response.status);
            //                         this.resetForm();
            //                         return router.push("/reservation-confirmation");
            //
            //                     } else {
            //                         this.errors.push(
            //                             "Une erreur s'est produite lors de l'enregistrement de l'utilisateur : " +
            //                             (response?.data?.message || " Erreur inconnue")
            //                         );
            //                     }
            //                 }
            // ).catch((error) => { if (error.response) {
            //         // The request was made and the server responded with a status code
            //         // that falls out of the range of 2xx
            //         console.log('Server error out of 2xx')
            //         console.log("response data error : ", error.response.data);
            //         console.log("response data status : ", error.response.status);
            //         console.log("response data headers : ",error.response.headers);
            //     } else if (error.request) {
            //         // The request was made but no response was received
            //         // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
            //         // http.ClientRequest in node.js
            //         console.log('No response was received to your request.')
            //         console.log("error.request : ", error.request);
            //     } else {
            //         // Something happened in setting up the request that triggered an Error
            //         console.log('3')
            //         console.log('An error occured : ', error.message);
            //     }
            //     console.log(error.config);
            //     this.errors.push(
            //         "Une erreur s'est produite lors de l'enregistrement de votre réservation : " +
            //         (error?.response?.data?.message || " Erreur inconnue")
            //     );
            // });
            }
        },
    },
    mounted() {
        //
    }
}
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

