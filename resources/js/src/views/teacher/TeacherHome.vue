<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 text-center">
                <img src="/img/index2.jpg" width="100%" class="img-thumbnail img-fluid" alt />
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-xl-3 col-sm-6 py-2">
                <div class="card bg-success text-white">
                    <div class="card-body bg-success">
                        <div class="rotate">
                            <i class="fa fa-users fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">Lớp học</h6>
                        <h1 class="display-4">{{ amount.classrooms }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 py-2">
                <div class="card text-white bg-info">
                    <div class="card-body bg-info">
                        <div class="rotate">
                            <i class="fa fa-list fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">Ngân hàng câu hỏi</h6>
                        <h1 class="display-4">{{ amount.questions }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 py-2">
                <div class="card text-white bg-danger">
                    <div class="card-body bg-danger">
                        <div class="rotate">
                            <i class="fas fa-book-open fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">Đề thi</h6>
                        <h1 class="display-4">{{ amount.exams }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 py-2">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="rotate">
                            <i class="fa fa-book-reader fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">Kỳ thi</h6>
                        <h1 class="display-4">{{ amount.tests }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            amount: {
                classrooms: 0,
                questions: 0,
                exams: 0,
                tests: 0
            }
        };
    },
    created() {
        this.getTotalAmountOfAll();
    },
    methods: {
        async getTotalAmountOfAll() {
            try {
                let data = await axios("/teacher/amount").then();
                this.amount = data.data;
            } catch (error) {
                console.log(error);
            }
        }
    }
};
</script>

<style>
</style>
