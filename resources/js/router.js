import Vue from 'vue'
import Router from 'vue-router'
import login from './components/pages/login'
import registration from './components/pages/registration'


Vue.use(Router)

const routes = [
    {
        path:'/login',
        component: login,
    },
    {
        path:'/registration',
        component: registration,
    },
]

export default new Router({
    mode:'history',
    routes,
})