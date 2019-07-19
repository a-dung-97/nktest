const TeacherHome = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/TeacherHome.vue')
const GetClassrooms = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/classroom/GetClassrooms.vue')
const GetClassroom = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/classroom/GetClassroom.vue')
const QuestionDashboard = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/question/QuestionDashboard.vue')
const GetQuestions = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/question/GetQuestions.vue')
const CreateQuestion = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/question/CreateQuestion.vue')
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
        name: 'Danh sách lớp đang giảng dạy',
        component: GetClassrooms,
        meta: {
            auth: true,
            role: 'teacher'
        }
    },
    {
        path: 'classrooms/:id',
        name: 'Danh sách học sinh lớp đang giảng dạy',
        component: GetClassroom,
        meta: {
            auth: true,
            role: 'teacher'
        }
    },
    {
        path: 'questions',
        name: 'Ngân hàng câu hỏi',
        component: QuestionDashboard,
        meta: {
            auth: true,
            role: 'teacher'
        }
    },
    {
        path: 'questions/topics/:id',
        name: 'Danh sách câu hỏi',
        component: GetQuestions,
        meta: {
            auth: true,
            role: 'teacher'
        }
    },
    {
        path: 'create-question',
        name: 'Tạo mới câu hỏi',
        component: CreateQuestion,
        meta: {
            auth: true,
            role: 'teacher'
        }
    },
]