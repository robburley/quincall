/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

import VModal from 'vue-js-modal'
import {Datetime} from 'vue-datetime'
import Vue2Filters from 'vue2-filters'

window.Vue = require('vue')

Vue.use(require('vue-moment'))
Vue.use(VModal)
Vue.use(Vue2Filters)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('datetime', Datetime)
Vue.component('calls-report', require('./components/Reports/CallsReport.vue'))
Vue.component('productivity-report', require('./components/Reports/ProductivityReport.vue'))
Vue.component('status-report', require('./components/Reports/StatusReport.vue'))

Vue.component('agent-stats', require('./components/Stats/AgentStats.vue'))
Vue.component('stats', require('./components/Stats/Stats.vue'))

Vue.component('calls', require('./components/Calls.vue'))
Vue.component('dialler', require('./components/Dialler.vue'))
Vue.component('number', require('./components/Number.vue'))
Vue.component('numbers', require('./components/Numbers.vue'))
Vue.component('user', require('./components/User.vue'))
Vue.component('users', require('./components/Users.vue'))
Vue.component('user-missed-calls', require('./components/UserMissedCalls.vue'))
Vue.component('user-voicemails', require('./components/UserVoicemails.vue'))
Vue.component('from-time', require('./components/FromTime.vue'))

const app = new Vue({
    el: '#app',
})
