import Vue from 'vue'
import Router from 'vue-router'
import login from './components/pages/login'
import registration from './components/pages/registration'
import eventsAdmin from './components/pages/admin/eventsAdmin'
import events from './components/pages/events'


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
    {
        path:'/admin/events',
        component: eventsAdmin,
    },
    {
        path:'/',
        component: events,
    },

]

export default new Router({
    mode:'history',
    routes,
})