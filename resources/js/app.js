require('./bootstrap')
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import "bootstrap-vue/dist/bootstrap-vue.css"
import router from './router'
import store from './store'

Vue.use(BootstrapVue)
Vue.component('mainapp', require('./components/mainapp.vue').default)

const app = new Vue({
    el:'#app',
    router,
    store,
})