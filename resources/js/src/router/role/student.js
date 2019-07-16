
const StudentHome = () => import('../../views/student/StudentHome.vue')
export default [
    {
        path: 'home',
        name: 'Trang chủ',
        component: StudentHome,
        meta: {
            auth: true,
            role: 'student'
        },
    },
]