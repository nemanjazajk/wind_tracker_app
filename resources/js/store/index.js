import Vuex from 'vuex';
import Vue from 'vue';
import wind from './modules/Wind';

// Load Vuex
Vue.use(Vuex);

// Create store
export default new Vuex.Store({
  modules: {
    wind
  }
});