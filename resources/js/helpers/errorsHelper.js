/**
 * Adds a new error message with timestamp to the errors table
 * @param error
 * @param message
 * @return { void }
 */
export const addError = (error, message) => {
    const errors = [];
    const timestamp = new Date().toLocaleString();
    const errorMessageWithTimestamp = `${message} ${error}, Horodatage : ${timestamp} `;

    errors.push(errorMessageWithTimestamp);
    console.error(errors);
}
