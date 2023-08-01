import { reactive} from 'vue';

const authStore = {
    state: reactive({
        rememberMe: false,
    }),
    setRememberMe(value) {
        authStore.state.rememberMe = value;
    },
};

export default authStore;

