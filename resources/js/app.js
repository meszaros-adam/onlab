require('./bootstrap')
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'bootstrap-icons/font/bootstrap-icons.css'
import router from './router'
import store from './store'
import common from './common'

Vue.use(BootstrapVue)
Vue.mixin(common)
Vue.component('mainapp', require('./components/mainapp.vue').default)

const app = new Vue({
    el:'#app',
    router,
    store,
})