require('./bootstrap')
import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'bootstrap-icons/font/bootstrap-icons.css'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import router from './router'
import store from './store'
import common from './common'
import Multiselect from 'vue-multiselect'

Vue.use(Toast)
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.mixin(common)
Vue.component('mainapp', require('./components/mainapp.vue').default)

const app = new Vue({
    el:'#app',
    router,
    store,
})