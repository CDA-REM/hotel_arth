

export const handleResponse = (response) => {
    if (typeof response.data.errors !== 'undefined'){
        throw response.data.errors
    } else{
        return response.data.user
    }
}
