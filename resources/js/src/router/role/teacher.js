const TeacherHome = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/TeacherHome.vue')
const GetClassrooms = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/classroom/GetClassrooms.vue')
const GetClassroom = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/classroom/GetClassroom.vue')
const QuestionDashboard = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/question/QuestionDashboard.vue')
const GetQuestions = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/question/GetQuestions.vue')
const CreateQuestion = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/question/CreateQuestion.vue')
const GetExams = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/exam/GetExams.vue')
const CreateExam = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/exam/CreateExam.vue')
const GetExamQuestions = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/exam/GetExamQuestions.vue')
const GetTests = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/test/GetTests.vue')
const GetTest = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/test/GetTest.vue')
const GetHomework = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/homework/GetHomework.vue')
const GetHomeworks = () => import(/* webpackChunkName: "teacher" */'../../views/teacher/homework/GetHomeworks.vue')
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
    {
        path: 'exams',
        name: 'Danh sách đề thi',
        component: GetExams,
        meta: {
            auth: true,
            role: 'teacher'
        }
    },
    {
        path: 'exams/:id',
        name: 'Chi tiết đề thi',
        component: GetExamQuestions,
        meta: {
            auth: true,
            role: 'teacher'
        }
    },
    {
        path: 'create-exam',
        name: 'Sinh đề tự động',
        component: CreateExam,
        meta: {
            auth: true,
            role: 'teacher'
        }
    },
    {
        path: 'tests',
        name: 'Danh sách kì thi',
        component: GetTests,
        meta: {
            auth: true,
            role: 'teacher'
        }
    },
    {
        path: 'tests/:id',
        name: 'Chi tiết kì thi',
        component: GetTest,
        meta: {
            auth: true,
            role: 'teacher'
        }
    },
    {
        path: 'homeworks',
        name: 'Danh sách bài tập',
        component: GetHomeworks,
        meta: {
            auth: true,
            role: 'teacher'
        }
    },
    {
        path: 'homeworks/:id',
        name: 'Chi tiết bài tập',
        component: GetHomework,
        meta: {
            auth: true,
            role: 'teacher'
        }
    },
]