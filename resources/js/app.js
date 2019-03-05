
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.states = require('./states.json');
window.countries = require('./countries.json');
window.Vue = require('vue');
import VueStripeCheckout from 'vue-stripe-checkout';

Vue.use(VueStripeCheckout, process.env.MIX_STRIPE_PUBLIC_KEY);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Set up an events bus
 */
window.Bus = new Vue();
/**
 * Registering a Vue Global Mixin
 */
Vue.mixin({
    computed: {
        states() {
            return window.states;
        },
        countries() {
            return window.countries;
        },
        Bus() {
            return window.Bus;
        }
    }
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});