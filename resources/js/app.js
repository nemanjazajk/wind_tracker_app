require('./bootstrap');
window.Vue = require('vue');

import store from "./store"
import VueFormulate from '@braid/vue-formulate'
import 'vue2-timepicker/dist/VueTimepicker.css'
import VueRouter from 'vue-router';
import routes from './routes';

Vue.use(VueFormulate);
Vue.use(VueRouter);

const app = new Vue({
    store,
    router: new VueRouter(routes),
    el: '#app',
    mounted() {
        store.dispatch('getUser')
        store.dispatch('tableStats')
        store.dispatch('getGraphVal')
        store.dispatch('getDisabled')
        setInterval(()=>{
           store.dispatch('tableStats')
        },5000) 
    }
});
