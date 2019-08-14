<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div
                        ref="clock"
                        class="card-header text-center bg-primary"
                        style="font-size:20px"
                    >
                        <countdown
                            :time="60*1000*time"
                            :transform="transform"
                            @progress="handleCountdownProgress"
                            @end="end"
                        >
                            <template
                                slot-scope="props"
                            >{{ props.totalMinutes }}:{{ props.seconds }}</template>
                        </countdown>
                    </div>
                    <div class="card-body">
                        <h4
                            class="card-title text-center"
                        >Kì thi cuối kì học kì I môn Toán 12 năm học 2020-2021</h4>
                        <div
                            class="questions-block"
                            v-for="block in Math.floor(questionsCount/10)"
                            :key="block"
                        >
                            <a
                                :ref="'status-'+(question+(block-1)*10)"
                                :href="'#question-'+(question+(block-1)*10)"
                                class="question-status"
                                v-for="question in 10"
                                :key="question"
                            >{{ question+(block-1)*10 }}</a>
                        </div>
                        <div class="questions-block" v-if="questionsCount%10">
                            <a
                                class="question-status done"
                                v-for="question in questionsCount%10"
                                :key="question"
                            >{{ question+questionsCount-questionsCount%10}}</a>
                        </div>
                        <button
                            type="button"
                            @click="submit"
                            class="btn btn-primary btn-block mt-4"
                        >Nộp bài</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card" style="margin-bottom:0px">
                    <!-- <div
                        class="card-header bg-primary"
                        style="font-size:20px"
                    >Kì thi cuối kì học kì I môn Toán 12 năm học 2020-2021</div>-->
                    <div class="card-body wrapper">
                        <div
                            class="question"
                            :id="'question'+'-'+ (index+1)"
                            v-for="(question, index) in questions"
                            :key="question.id"
                        >
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Câu {{ index+1 }}</h4>
                                    <VueMathjax :input="question.content"></VueMathjax>
                                    <b-form-group class="mt-3">
                                        <b-form-radio-group
                                            v-model="answers[question.id]"
                                            stacked
                                            @change="done(index+1)"
                                        >
                                            <b-form-radio
                                                v-for="(answer,key) in question.answers"
                                                :key="key"
                                                :value="key"
                                            >
                                                <VueMathjax :input="answer"></VueMathjax>
                                            </b-form-radio>
                                        </b-form-radio-group>
                                    </b-form-group>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueMathjax from "../../components/MathJax";
import countdown from "@chenfengyuan/vue-countdown";
export default {
    components: { VueMathjax, countdown },
    data() {
        return {
            questionsCount: 50,
            isTesting: true,
            time: 0,
            test: {},
            questions: [],
            answers: {}
        };
    },
    // beforeRouteEnter(to, from, next) {
    //     if (confirm("Bắt đầu bài thi?")) {
    //         next();
    //     }
    // },
    beforeRouteLeave(to, from, next) {
        // if (confirm("Kết thúc bài thi?")) {
        //     this.$emit("sidebar");
        //     next();
        // }
        if (this.isTesting) {
            this.$swal.fire({
                type: "error",
                title: "Không thể thoát ra khi đang làm bài thi"
            });

            next(false);
        } else {
            this.$emit("sidebar");
            next();
        }
    },
    created() {
        this.$emit("sidebar");
        window.onbeforeunload = event => {
            // Cancel the event as stated by the standard.
            event.preventDefault();
            // Chrome requires returnValue to be set.
            event.returnValue = "";
        };
        this.getTest();
    },
    methods: {
        handler(e) {
            e.preventDefault();
        },
        submit() {
            let count = 0;
            for (let x in this.answers) {
                if (this.answers[x] == "") count++;
            }
            this.$swal
                .fire({
                    title: "Bạn chắc chắn muốn nộp bài?",
                    text: "Bạn còn " + count + " câu hỏi chưa hoàn thành",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Nộp bài!",
                    cancelButtonText: "Hủy"
                })
                .then(result => {
                    if (result.value) {
                        console.log(this.answers);
                        axios
                            .post(
                                "/student/tests/" + this.$route.params.id,
                                this.answers
                            )
                            .then(result => {
                                // this.$swal.fire({
                                //     type: "info",
                                //     title: "Kết quả: " + result.data,
                                //     confirmButtonText: "Trở về trang chủ"
                                // });
                                this.isTesting = false;
                                this.$router.push("/student/scores");
                            })
                            .catch(err => {
                                console.log(err);
                            });
                    }
                });
        },

        async getTest() {
            let test = await axios.get(
                "/student/tests/" + this.$route.params.id
            );
            this.test = test.data.test;
            this.questions = test.data.data;
            this.questionsCount = Number(this.test.question_count);
            this.time = Number(this.test.time);

            this.questions.forEach(question => {
                this.answers[`${question.id}`] = "";
            });
            console.log(this.answers);
            console.log(this.test);
            console.log(this.questions);
        },
        done(index) {
            this.$refs["status-" + index][0].classList.add("done");
        },
        transform(props) {
            Object.entries(props).forEach(([key, value]) => {
                // Adds leading zero
                const digits = value < 10 ? `0${value}` : value;

                // uses singular form when the value is less than 2

                props[key] = `${digits}`;
            });

            return props;
        },
        handleCountdownProgress(data) {
            if (data.totalSeconds == 120) {
                this.$refs.clock.classList.add("text-warning");
                this.$swal.fire({
                    type: "warning",
                    title: "Sắp hết giờ",
                    text:
                        "Bạn còn 2 phút để làm bài. Hãy kiểm tra lại bài làm của mình!"
                });
            }
            if (data.totalSeconds == 100) {
                this.$refs.clock.classList.add("text-danger");
                this.$refs.clock.classList.add("font-weight-bold");
            }
        },
        end() {
            // axios
            //     .post("/student/tests/" + this.$route.params.id, this.answers)
            //     .then(result => {
            //         // this.$swal.fire({
            //         //     type: "info",
            //         //     title: "Kết quả: " + result.data,
            //         //     confirmButtonText: "Trở về trang chủ"
            //         // });
            //         this.isTesting = false;
            //         this.$router.push("/student/scores");
            //     })
            //     .catch(err => {
            //         console.log(err);
            //     });
        }
    }
};
</script>

<style scoped>
.question-status {
    display: inline-block;
    width: 25px;
    height: 25px;
    line-height: 25px;
    color: white;
    text-align: center;
    font-size: 12px;
    border-radius: 50%;
    background: #ff8a80;
    cursor: pointer;
    margin: 2px;
    /* margin-left: 10px; */
}
.wrapper {
    max-height: calc(100vh - 190px);
    overflow-y: scroll;
    scroll-behavior: smooth;
}
.questions-block {
    text-align: center;
    width: 100%;
    /* justify-content: space-around; */
    margin-bottom: 10px;
}
.done {
    background: #00e676;
}
::-webkit-scrollbar-track {
    box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    border-radius: 10px;
    background-color: #f5f5f5;
}

::-webkit-scrollbar {
    width: 12px;
    background-color: #f5f5f5;
}

::-webkit-scrollbar-thumb {
    border-radius: 10px;
    box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    background-color: #555;
}
</style>
