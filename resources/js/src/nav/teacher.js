export default {
    items: [
        {
            name: 'Trang chủ',
            url: '/teacher/home',
            icon: 'fa fa-user',
        },
        {
            name: 'Lớp học',
            url: '/teacher/classrooms',
            icon: 'fas fa-users',
        },
        {
            name: 'Ngân hàng câu hỏi',
            url: '/teacher/classrooms',
            icon: 'fa fa-question',
            children: [
                {
                    name: 'Tổng quan',
                    url: '/teacher/questions/dashboard',
                    icon: 'icon-arrow-right'
                },
                {
                    name: 'Thêm câu hỏi',
                    url: '/teacher/questions/create',
                    icon: 'icon-arrow-right'
                },
            ]
        },
        {
            name: 'Quản lý đề thi',
            url: '/teacher/exams',
            icon: 'fas fa-book-open',
        },
        {
            name: 'Quản lý kỳ thi',
            url: '/teacher/tests',
            icon: 'fas fa-book-reader',
        },
    ],
}