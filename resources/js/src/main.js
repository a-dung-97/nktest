// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import 'core-js/es6/promise'
import 'core-js/es6/string'
import 'core-js/es7/array'
// import cssVars from 'css-vars-ponyfill'
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import App from './App.vue'
import router from './router'
import User from './/helpers/User'

// main.js
import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);
window.User = User
// todo
// cssVars()

router.beforeEach((to, from, next) => {
    if (to.meta.auth === false) {
        if (User.loggedIn()) {
            next({

                path: User.redirectByRole()
            })
        }
        else next()
    }
    else if (to.meta.auth === true) {
        if (User.loggedIn()) {
            if (to.meta.role === User.role() || to.meta.role == null) {
                next()
            }
            else {
                next({
                    path: '/403'
                })
            }
        }
        else next({
            path: '/login',
            query: { redirect: to.fullPath }
        })
    }
    else next()

})
Vue.use(BootstrapVue)

/* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    render: h => h(App)
})
