import Vue from 'vue'
import Router from 'vue-router'
import login from './components/pages/login'
import registration from './components/pages/registration'
import eventsAdmin from './components/pages/admin/eventsAdmin'
import events from './components/pages/events'
import notAuthorized from './components/pages/notAuthorized'
import tagsAdmin from './components/pages/admin/tagsAdmin'


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
        path:'/',
        component: events,
    },
    {
        path:'/admin/events',
        component: eventsAdmin,
    },
    {
        path:'/admin/tags',
        component: tagsAdmin,
    },
    {
        path:'/not-authorized',
        component: notAuthorized,
    },

]

export default new Router({
    mode:'history',
    routes,
})