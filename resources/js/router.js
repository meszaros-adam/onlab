import Vue from 'vue'
import Router from 'vue-router'
import login from './components/pages/login'
import registration from './components/pages/registration'
import eventsAdmin from './components/pages/admin/eventsAdmin'
import events from './components/pages/events'
import notAuthorized from './components/pages/notAuthorized'
import tagsAdmin from './components/pages/admin/tagsAdmin'
import userAdmin from './components/pages/admin/userAdmin'
import registrationsAdmin from './components/pages/admin/registrationsAdmin'
import eventSingle from './components/pages/eventSingle'
import registrationsUser from './components/pages/user/registrationsUser'


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
        path:'/admin/users',
        component: userAdmin,
    },
    {
        path:'/admin/registrations',
        component: registrationsAdmin,
    },
    {
        path:'/event/:id',
        component: eventSingle,
        name: 'event'
    },
    {
        path:'/not-authorized',
        component: notAuthorized,
    },
    {
        path:'/user-registrations',
        component: registrationsUser,
    },

]

export default new Router({
    mode:'history',
    routes,
})