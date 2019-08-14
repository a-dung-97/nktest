const StudentHome = () => import(/* webpackChunkName: "student" */'../../views/student/StudentHome.vue')
const GetTests = () => import(/* webpackChunkName: "student" */'../../views/student/GetTests.vue')
const GetTest = () => import(/* webpackChunkName: "student" */'../../views/student/GetTest.vue')
const Homework = () => import(/* webpackChunkName: "student" */'../../views/student/Homework.vue')
const GetTestResults = () => import(/* webpackChunkName: "student" */'../../views/student/GetTestResults.vue')
export default [
    {
        path: 'home',
        name: 'Trang chủ học sinh',
        component: StudentHome,
        meta: {
            auth: true,
            role: 'student'
        },

    },
    {
        path: 'tests',
        name: 'Kì thi',
        component: GetTests,
        meta: {
            auth: true,
            role: 'student'
        },

    },
    {
        path: 'tests/:id',
        name: 'Làm bài thi',
        component: GetTest,
        meta: {
            auth: true,
            role: 'student'
        },
        // beforeRouteLeave(to, from, next) {
        //     console.log('Hello');
        // },
        // beforeRouteEnter(to, from, next) {
        //     window.confirm('Hello')
        // }

    },
    {
        path: 'scores',
        name: 'Kết quả thi',
        component: GetTestResults,
        meta: {
            auth: true,
            role: 'student'
        },
    },
    {
        path: 'homework',
        name: 'Bài tập',
        component: Homework,
        meta: {
            auth: true,
            role: 'student'
        },
    },
]