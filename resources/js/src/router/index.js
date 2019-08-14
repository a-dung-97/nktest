import Vue from 'vue'
import VueRouter from 'vue-router'

// Containers

import DefaultContainer from '../containers/DefaultContainer';
import Login from '../views/pages/Login'
import admin from './role/admin';
import student from './role/student';
import teacher from './role/teacher';
import Page403 from '../views/pages/Page403.vue';
import Page404 from '../views/pages/Page404.vue';
import ChangePassword from '../views/pages/ChangePassword.vue';
import Account from '../views/pages/Account.vue';
Vue.use(VueRouter);
const routes = [
    {
        path: '/',
        redirect: 'login'
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: {
            auth: false,
        }
    },
    {
        path: '/admin',
        redirect: '/admin/home',
        name: 'Admin',
        component: DefaultContainer,
        children: admin,
        meta: {
            auth: true,
            role: 'admin'
        }
    },
    {
        path: '/teacher',
        redirect: '/teacher/home',
        name: 'Teacher',
        component: DefaultContainer,
        children: teacher,
        meta: {
            auth: true,
            role: 'teacher'
        }
    },
    {
        path: '/student',
        redirect: '/student/home',
        name: 'Student',
        component: DefaultContainer,
        children: student,
        meta: {
            auth: true,
            role: 'student'
        }
    },
    {
        path: '/403',
        component: Page403
    },
    {
        path: '/404',
        component: Page404
    },
    {
        path: '*',
        component: Page404
    },
    {
        path: '/account/info',
        name: 'Thông tin tài khoản',
        component: Account,
        meta: {
            auth: true,
            role: null,
        }
    },

]
const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'open active',
    scrollBehavior: () => ({ y: 0 }),
    routes
})
export default router
