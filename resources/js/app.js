

require('./bootstrap');


import Vue from 'vue'

import { Form, HasError, AlertError } from 'vform'

window.Form = Form

import progressBar from 'vue-progressbar'
import { options } from './vueProgressBarOptions/progressBarOptions.js'
Vue.use(progressBar, options)
// Place the following into its own module file for easy import.

import Snotify, { SnotifyPosition } from 'vue-snotify'

const SnotifyOptions = {
  toast: {
    position: SnotifyPosition.rightTop
  }
}

Vue.use(Snotify, SnotifyOptions)

Vue.component('all-data', require('./components/all-data.vue').default);
Vue.component('pagination', require('./components/partial/pagiantion.vue').default);
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


const app = new Vue({
    el: '#app',
});
