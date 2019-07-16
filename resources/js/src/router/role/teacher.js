const TeacherHome = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/TeacherHome.vue')
const GetClassrooms = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/classroom/GetClassrooms.vue')
const GetClassroom = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/classroom/GetClassroom.vue')
const QuestionDashboard = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/quesion/QuestionDashboard.vue')
export default [
    {
        path: 'home',
        name: 'Trang chủ giáo viên',
        component: TeacherHome,
        meta: {
            auth: true,
            role: 'teacher'
        }
    },
    {
        path: 'classrooms',
        name: 'Danh sách lớp học',
        component: GetClassrooms,
        meta: {
            auth: true,
            role: 'teacher'
        }
    },
    {
        path: 'classrooms/:id',
        name: 'Danh sách lớp học',
        component: GetClassroom,
        meta: {
            auth: true,
            role: 'teacher'
        }
    },
    {
        path: 'questions/dashboard',
        name: 'Danh sách lớp học',
        component: QuestionDashboard,
        meta: {
            auth: true,
            role: 'teacher'
        }
    },
]