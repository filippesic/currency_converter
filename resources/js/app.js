require('./bootstrap');

import {createApp} from 'vue';
import App from './vue/App.vue';

const app = createApp({
    components: {
        App
    }
});

app.mount('#app');
