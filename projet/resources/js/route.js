import Accueil from './components/accueil.vue';
import contact from './components/contact.vue';
import Services from './components/Services.vue';
import About from './components/About.vue'

import viewclient from './components/client/viewclient.vue'
import addclient from './components/client/addclient.vue'
import editclient from './components/client/editclient.vue'

import viewdriver from './components/driver/viewdriver.vue'
import adddriver from './components/driver/adddriver.vue'
import editdriver from './components/driver/editdriver.vue'

import viewreservation from './components/reservation/viewreservation.vue'
import addreservation from './components/reservation/addreservation.vue'
import editreservation from './components/reservation/editreservation.vue'

import viewride from './components/ride/viewride.vue'
import addride from './components/ride/addride.vue'
import editride from './components/ride/editride.vue'

import viewvehicle from './components/vehicle/viewvehicle.vue'
import addvehicle from './components/vehicle/addvehicle.vue'
import editvehicle from './components/vehicle/editvehicle.vue'

import Login from './components/authentification/login.vue'
import Register from './components/authentification/register.vue'
import Dashboard from './components/admin/dashboard.vue'

import Payment from './components/Payment.vue';
import rideform from './components/rideform.vue'
import reservationform from './components/reservationform.vue'
export const routes = [
    {
        name: 'accueil',
        path: '/',
        component: Accueil,
        meta:{isAuth:true}
        
    },
    {
        name: 'contact',
        path: '/contact',
        component: contact
    },
    {
        name: "Services",
        path: "/Services",
        component: Services
    },
    {
        name: "About",
        path: "/About",
        component: About
    },
    {
        name: "viewclient",
        path: "/client",
        component: viewclient,
        meta:{isAuth:true}
    },
    {
        name: "addclient",
        path: "/addclient",
        component: addclient
    },
    {
        name: "editclient",
        path: "/editclient",
        component: editclient
    },

    {
        name: "viewdriver",
        path: "/driver",
        component: viewdriver,
        meta:{isAuth:true}
    },
    {
        name: "adddriver",
        path: "/adddriver",
        component: adddriver
    },
    {
        name: "editdriver",
        path: "/editdriver",
        component: editdriver
    },

    {
        name: "viewreservation",
        path: "/reservation",
        component: viewreservation,
        meta:{isAuth:true}
    },
    {
        name: "addreservation",
        path: "/addreservation",
        component: addreservation
    },
    {
        name: "editreservation",
        path: "/editreservation",
        component: editreservation
    },

    {
        name: "viewride",
        path: "/ride",
        component: viewride,
        meta:{isAuth:true}
    },
    {
        name: "addride",
        path: "/addride",
        component: addride
    },
    {
        name: "editride",
        path: "/editride",
        component: editride
    },

    {
        name: "viewvehicle",
        path: "/vehicle",
        component: viewvehicle,
        meta:{isAuth:true}
    },
    {
        name: "addvehicle",
        path: "/addvehicle",
        component: addvehicle
    },
    {
        name: "editvehicle",
        path: "/editvehicle",
        component: editvehicle
    },
    {
        name: "login",
        path: "/login",
        component: Login,
        },
        {
        name: "register",
        path: "/register",
        component: Register,
        },
        {
        
        name: "dashboard",
        path: '/dashboard',
        component: Dashboard,
        
        },
        {
            path:'/payment',
            name:'Payment',
            component:Payment,
            props: true,
            },
            {
                name: "rideform",
                path: "/rideform",
                component: rideform
            },
            {
                name: "reservationform",
                path: "/reservationform/:rideId",
                component: reservationform,
                props: true,
            },

];