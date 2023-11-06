<template>
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
</template>

<script>
export default {
    props: {
        activeTab: {
            type: String,
            required: true,
        },
    },
    methods: {
        /**
         * Sets the active tab.
         *
         * @param {type} tab - The tab to set as active.
         * @return {void}
         */
        setActiveTab(tab) {
            this.$emit('update:activeTab', tab);
        },
        /**
         * Moves to the next tab if the active tab is not "validateBooking" and the reservation form is valid.
         *
         * @return {void}
         */
        nextTab() {
            if (
                this.activeTab !== "validateBooking" &&
                this.$refs.reservationForm.reportValidity()
            ) {
                this.activeTab = this.allTabs[this.allTabs.indexOf(this.activeTab) + 1];
            }
        },
    },
};
</script>

