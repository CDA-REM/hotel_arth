import axios from 'axios';
import moment from 'moment';

// Function to get availability
export async function getAvailability(checkinDate, checkoutDate) {
    try {
        const formattedCheckinDate = formatDateForRequest(checkinDate);
        const formattedCheckoutDate = formatDateForRequest(checkoutDate);

        const response = await axios.get(`api/reservations/availability/?started_date=${formattedCheckinDate}&end_date=${formattedCheckoutDate}`);

        if (response.status === 200 || response.status === 201) {
            return response.data;
        }
    } catch (error) {
        handleErrorResponse(error);
        throw error;
    }
}

// Function to calculate the number of days
export function calculateNumberOfDays(checkinDate, checkoutDate) {
    if (checkinDate && checkoutDate) {
        const checkinDateObj = new Date(moment(checkinDate, "DD MM YYYY"));
        const checkoutDateObj = new Date(moment(checkoutDate, "DD MM YYYY"));
        return moment(checkoutDateObj).diff(moment(checkinDateObj), 'days');
    }
}

// Function to format date for the recap
export function formatDateForRecap(input) {
    if (input) {
        return input.toLocaleDateString(this.globalStore.getLocale);
    }
    return new Date();
}

// Function to format date for the request
export function formatDateForRequest(date) {
    return date ? moment(date).format('YYYY-MM-DD') : '';
}

// Function to handle error response
function handleErrorResponse(error) {
    if (error.response) {
        // The request was made and the server responded with a status code
        console.log(`Erreur : ${error}`);
    }
}

// Export other helper functions if needed...
