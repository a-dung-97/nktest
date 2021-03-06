export default {
    items: [
        {
            name: 'Trang chủ',
            url: '/teacher/home',
            icon: 'fas fa-home',
        },
        {
            name: 'Lớp học',
            url: '/teacher/classrooms',
            icon: 'fas fa-users',
        },
        {
            name: 'Quản lý câu hỏi',
            url: '/teacher/questions',
            icon: 'fa fa-question',
            children: [
                {
                    name: 'Ngân hàng câu hỏi',
                    url: '/teacher/questions',
                    icon: ' fas fa-database'
                },
                {
                    name: 'Tạo mới câu hỏi',
                    url: '/teacher/create-question',
                    icon: ' fas fa-plus'
                }
            ]
        },
        {
            name: 'Quản lý đề thi',
            url: '/teacher/exams',
            icon: 'fas fa-book-open',
            children: [
                {
                    name: 'Danh sách đề thi',
                    url: '/teacher/exams',
                    icon: ' fas fa-list'
                },
                {
                    name: 'Sinh đề tự động',
                    url: '/teacher/create-exam',
                    icon: ' fas fa-plus'
                }
            ]
        },
        {
            name: 'Quản lý kỳ thi',
            url: '/teacher/tests',
            icon: 'fas fa-book-reader',
        },
        {
            name: 'Bài tập',
            url: '/teacher/homeworks',
            icon: 'fas fa-book',
        },
    ],
}