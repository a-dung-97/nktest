<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary">Sinh đề tự động từ ngân hàng câu hỏi</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="text-center text-primary">Thông tin đề thi</h2>
                        <form action>
                            <h3>Đề thi</h3>
                            <b-form-group label="Tên đề thi" label-size="lg">
                                <b-form-input
                                    v-model="$v.form.exam.name.$model"
                                    :state="$v.form.exam.name.$dirty ? !$v.form.exam.name.$error : null"
                                ></b-form-input>
                                <b-form-invalid-feedback
                                    v-if="!$v.form.exam.name.required"
                                >Bạn chưa chọn tên đề thi</b-form-invalid-feedback>
                            </b-form-group>
                            <b-form-group label="Môn học" label-size="lg">
                                <b-form-radio-group
                                    v-model="$v.form.exam.subject_id.$model"
                                    :options="subjectOptions"
                                    :state="$v.form.exam.subject_id.$dirty ? !$v.form.exam.subject_id.$error : null"
                                    @change="getTopics($event);getQuestionRemainNotDuplication($event)"
                                ></b-form-radio-group>
                                <b-form-invalid-feedback
                                    v-if="!$v.form.exam.subject_id.required"
                                >Bạn chưa chọn môn học</b-form-invalid-feedback>
                            </b-form-group>
                            <b-form-group
                                label="Lặp lại câu hỏi trong đề thi khác?"
                                label-size="lg"
                            >
                                <b-form-radio-group
                                    v-model="$v.form.duplication.$model"
                                    :options="repeatOptions"
                                    :state="$v.form.duplication.$dirty ? !$v.form.duplication.$error : null"
                                ></b-form-radio-group>
                                <b-form-invalid-feedback
                                    v-if="!$v.form.duplication.required"
                                >Bạn chưa chọn một trong hai lựa chọn</b-form-invalid-feedback>
                            </b-form-group>
                        </form>
                    </div>
                    <transition enter-active-class="animated fadeInRight">
                        <div
                            class="col-sm-6"
                            v-if="$v.form.exam.subject_id.required&&$v.form.duplication.required"
                        >
                            <h2 class="text-center text-primary">Điều kiện sinh đề</h2>
                            <form>
                                <transition-group
                                    name="list-conditions"
                                    enter-active-class="animated bounceInRight"
                                    leave-active-class="animated bounceOutRight"
                                >
                                    <div
                                        v-for="(v, index) in $v.form.conditions.$each.$iter"
                                        :key="index"
                                    >
                                        <h3>Điều kiện {{ Number(index)+1 }}</h3>
                                        <b-form-group
                                            label="Chủ đề"
                                            label-size="lg"
                                            :description="(v.id.$model)?`Còn lại ${questionsRemainInfo[index].easy} câu dễ - ${questionsRemainInfo[index].medium} câu trung bình - ${questionsRemainInfo[index].hard} câu khó`:null"
                                        >
                                            <b-form-select
                                                :options="topicOptions"
                                                v-model="v.id.$model"
                                                :state="v.id.$dirty ? !v.id.$error : null"
                                                @change="showQuestionsRemain($event,index)"
                                            ></b-form-select>

                                            <b-form-invalid-feedback
                                                v-if="!v.id.required"
                                            >Bạn chưa chọn chủ đề</b-form-invalid-feedback>
                                        </b-form-group>
                                        <b-form-group label="Số câu dễ" label-size="lg">
                                            <b-form-input
                                                type="number"
                                                :max="questionsRemainInfo[index].easy"
                                                v-model="v.easy.$model"
                                                @keydown.prevent
                                                :state="v.easy.$dirty ? !v.easy.$error : null"
                                            ></b-form-input>
                                            <b-form-invalid-feedback
                                                v-if="!v.easy.required"
                                            >Bạn chưa chọn số câu dễ</b-form-invalid-feedback>
                                            <b-form-invalid-feedback
                                                v-if="!v.easy.minValue"
                                            >Số câu phải lớn hơn hoặc bằng 0</b-form-invalid-feedback>
                                        </b-form-group>
                                        <b-form-group label="Số câu trung bình" label-size="lg">
                                            <b-form-input
                                                v-model="v.medium.$model"
                                                type="number"
                                                @keydown.prevent
                                                :state="v.medium.$dirty ? !v.medium.$error : null"
                                            ></b-form-input>
                                            <b-form-invalid-feedback
                                                v-if="!v.medium.required"
                                            >Bạn chưa chọn số câu trung bình</b-form-invalid-feedback>
                                            <b-form-invalid-feedback
                                                v-if="!v.medium.minValue"
                                            >Số câu phải lớn hơn hoặc bằng 0</b-form-invalid-feedback>
                                        </b-form-group>
                                        <b-form-group label="Số câu khó" label-size="lg">
                                            <b-form-input
                                                v-model="v.hard.$model"
                                                type="number"
                                                @keydown.prevent
                                                :state="v.hard.$dirty ? !v.hard.$error : null"
                                            ></b-form-input>
                                            <b-form-invalid-feedback
                                                v-if="!v.hard.required"
                                            >Bạn chưa chọn số câu khó</b-form-invalid-feedback>
                                            <b-form-invalid-feedback
                                                v-if="!v.hard.minValue"
                                            >Số câu phải lớn hơn hoặc bằng 0</b-form-invalid-feedback>
                                        </b-form-group>
                                    </div>
                                </transition-group>

                                <button
                                    type="button"
                                    @click="form.conditions.push({id:'',easy:'',medium:'',hard:''});questionsRemainInfo.push({easy:0,medium:0,hard:0})"
                                    class="btn btn-primary mb-2"
                                >Thêm điều kiện</button>
                                <button
                                    type="button"
                                    :disabled="form.conditions.length==1"
                                    @click="form.conditions.pop()"
                                    class="btn btn-primary mb-2"
                                >Xóa điều kiện</button>
                                <button
                                    type="submit"
                                    @click.prevent="submit"
                                    class="btn btn-primary mb-2"
                                >Tạo đề thi</button>
                            </form>
                        </div>
                    </transition>
                </div>
            </div>
        </div>
        <Loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true" />
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required, minValue, maxValue } from "vuelidate/lib/validators";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
    mixins: [validationMixin],
    components: { Loading },
    validations: {
        form: {
            exam: {
                name: {
                    required
                },
                subject_id: {
                    required
                }
            },
            conditions: {
                required,
                $each: {
                    id: {
                        required,
                        minValue: minValue(0)
                    },
                    easy: {
                        required,
                        minValue: minValue(0),
                        maxValue: maxValue(18)
                    },
                    medium: {
                        required,
                        minValue
                    },
                    hard: {
                        required,
                        minValue: minValue(0)
                    }
                }
            },

            duplication: {
                required
            }
        }
    },
    data() {
        return {
            form: {
                exam: {
                    name: "",
                    subject_id: ""
                },
                conditions: [
                    {
                        id: "",
                        easy: "",
                        medium: "",
                        hard: ""
                    }
                ],
                duplication: ""
            },
            subjectOptions: [],
            topicOptions: [{ text: "Hãy chọn chủ đề", value: "" }],
            repeatOptions: [
                { text: "Có", value: true },
                { text: "Không", value: false }
            ],
            questionsRemainNotDuplication: [],
            questionsRemainInfo: [{ easy: 0, medium: 0, hard: 0 }],
            isLoading: false
        };
    },
    created() {
        this.getSubjects();
        console.log(this.$v.form.exam.subject_id.required);
    },
    methods: {
        async getSubjects() {
            try {
                let subjects = await axios.get("/teacher/count-subject");
                subjects.data.forEach(obj => {
                    this.subjectOptions.push({
                        text: obj.name,
                        value: obj.id
                    });
                });
            } catch (error) {
                console.log(error);
            }
        },
        submit() {
            this.$v.form.$touch();
            if (this.$v.form.$anyError) {
                console.log("error");
                return;
            }
            this.isLoading = true;
            this.createExam();
        },
        async getTopics(e) {
            try {
                let topics = await axios.get(
                    "/teacher/count-questions-remain/" + e
                );
                topics.data.data.forEach(obj => {
                    this.topicOptions.push({
                        text: obj.name,
                        value: obj.id,
                        easy: obj.easy,
                        medium: obj.medium,
                        hard: obj.hard
                    });
                });
            } catch (error) {
                console.log(error);
            }
        },
        async getQuestionRemainNotDuplication(e) {
            try {
                let topics = await axios.get("/teacher/count-subject/" + e);
                topics.data.data.forEach(obj => {
                    this.questionsRemainNotDuplication.push({
                        value: obj.id,
                        easy: obj.easy,
                        medium: obj.medium,
                        hard: obj.hard
                    });
                });
            } catch (error) {
                console.log(error);
            }
        },
        async createExam() {
            try {
                let data = axios.post("/teacher/exams", this.form);
                this.isLoading = false;
                this.$router.push("/teacher/exams");
            } catch (error) {
                console.log(error.response.data);
            }
        },
        showQuestionsRemain(e, index) {
            console.log(e);
            console.log(index);
            console.log(this.questionsRemainInfo[0]);
            if (!this.form.duplication) {
                var info = this.topicOptions.find(value => {
                    return value["value"] == e;
                });
            } else {
                var info = this.questionsRemainNotDuplication.find(value => {
                    return value["value"] == e;
                });
            }
            this.questionsRemainInfo[index].easy = info.easy;
            this.questionsRemainInfo[index].medium = info.medium;
            this.questionsRemainInfo[index].hard = info.hard;
        }
    }
};
</script>

<style>
</style>
