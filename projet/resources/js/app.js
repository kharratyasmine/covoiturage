import { createApp } from 'vue';
import { createRouter, createWebHashHistory } from "vue-router";
import { routes } from "./route";
import 'bootstrap/dist/css/bootstrap.min.css'
import PrimeVue from 'primevue/config';
import 'primevue/resources/themes/lara-light-green/theme.css'
import "@fortawesome/fontawesome-free/css/all.css";

import App from './App.vue'
let app = createApp(App)
const router = createRouter({
    history: createWebHashHistory(),
    routes: routes,
})
app.use(router).use(PrimeVue);
app.mount("#app")
router.beforeEach(async (to, from, next) => {
    if (to.matched.some(record => record.meta.isAuth)) {
        let token = localStorage.getItem('token');
        if (!token) {
            next("/login");
        } else {
            console.log(token);
            next();
        }
    } else {
        next();
    }
});