const GetClassrooms = () => import(/* webpackChunkName: "admin" */'../../views/admin/classroom/GetClassrooms.vue')
const GetClassroom = () => import(/* webpackChunkName: "admin" */'../../views/admin/classroom/GetClassroom.vue')
const GetSubjects = () => import(/* webpackChunkName: "admin" */'../../views/admin/subject/GetSubjects.vue')
const GetSubject = () => import(/* webpackChunkName: "admin" */'../../views/admin/subject/GetSubject.vue')
const GetTeachers = () => import(/* webpackChunkName: "admin" */'../../views/admin/teacher/GetTeachers.vue')
const GetAssignment = () => import(/* webpackChunkName: "admin" */'../../views/admin/assignment/GetAssignment.vue')
const AdminHome = () => import(/* webpackChunkName: "admin" */'../../views/admin/AdminHome.vue')
export default [
    {
        path: 'home',
        name: 'Trang chủ quản trị viên',
        component: AdminHome,
        meta: {
            auth: true,
            role: 'admin'
        }
    },
    {
        path: 'classrooms',
        name: 'Danh sách lớp học',
        component: GetClassrooms,

        meta: {
            auth: true,
            role: 'admin'
        }
    },
    {
        path: 'classrooms/:id',
        name: 'Danh sách học sinh',
        component: GetClassroom,
        meta: {
            auth: true,
            role: 'admin'
        },

    },
    {
        path: 'subjects',
        name: 'Danh sách môn học',
        component: GetSubjects,

        meta: {
            auth: true,
            role: 'admin'
        }
    },
    {
        path: 'subjects/:id',
        name: 'Danh sách chủ đề',
        component: GetSubject,
        meta: {
            auth: true,
            role: 'admin'
        },
    },
    {
        path: 'teachers',
        name: 'Danh sách giáo viên',
        component: GetTeachers,

        meta: {
            auth: true,
            role: 'admin'
        }
    },
    {
        path: 'assignment',
        name: 'Danh sách phân công lớp',
        component: GetAssignment,
        meta: {
            auth: true,
            role: 'admin'
        },
    },
    // {
    //     path: 'account',
    //     name: 'Tài khoản',
    //     component: GetSubjects,

    //     meta: {
    //         auth: true,
    //         role: 'admin'
    //     }
    // },


]