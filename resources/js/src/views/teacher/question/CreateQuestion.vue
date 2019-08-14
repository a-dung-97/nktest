<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary">Tạo mới câu hỏi</div>
            <div class="card-body">
                <b-form>
                    <b-form-group label="Nội dung">
                        <ckeditor :editor="editor" v-model="$v.form.content.$model"></ckeditor>
                        <div class="ckeditor-invalid-feedback" v-if="$v.form.$dirty">
                            <span v-if="!$v.form.content.required">Bạn chưa nhập nội dung câu hỏi</span>
                        </div>
                    </b-form-group>
                    <b-form-group label="Đáp án A">
                        <ckeditor :editor="editor" v-model="$v.form.answers['A'].$model"></ckeditor>
                        <div class="ckeditor-invalid-feedback" v-if="$v.form.$dirty">
                            <span v-if="!$v.form.answers['A'].required">Bạn chưa nhập đáp án</span>
                        </div>
                    </b-form-group>
                    <b-form-group label="Đáp án B">
                        <ckeditor :editor="editor" v-model="$v.form.answers['B'].$model"></ckeditor>
                        <div class="ckeditor-invalid-feedback" v-if="$v.form.$dirty">
                            <span v-if="!$v.form.answers['B'].required">Bạn chưa nhập đáp án</span>
                        </div>
                    </b-form-group>
                    <b-form-group label="Đáp án C">
                        <ckeditor :editor="editor" v-model="$v.form.answers['C'].$model"></ckeditor>
                        <div class="ckeditor-invalid-feedback" v-if="$v.form.$dirty">
                            <span v-if="!$v.form.answers['C'].required">Bạn chưa nhập đáp án</span>
                        </div>
                    </b-form-group>
                    <b-form-group label="Đáp án D">
                        <ckeditor :editor="editor" v-model="$v.form.answers['D'].$model"></ckeditor>
                        <div class="ckeditor-invalid-feedback" v-if="$v.form.$dirty">
                            <span v-if="!$v.form.answers['D'].required">Bạn chưa nhập đáp án</span>
                        </div>
                    </b-form-group>

                    <b-form-group label="Đáp án đúng">
                        <b-form-radio-group
                            v-model="$v.form.true_answer.$model"
                            :options="answerOptions"
                            :state="$v.form.true_answer.$dirty ? !$v.form.true_answer.$error : null"
                        ></b-form-radio-group>
                        <b-form-invalid-feedback
                            v-if="!$v.form.true_answer.required"
                        >Bạn chưa chọn level</b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group label="Mức độ">
                        <b-form-radio-group
                            v-model="$v.form.level.$model"
                            :options="levelOptions"
                            :state="$v.form.level.$dirty ? !$v.form.level.$error : null"
                        ></b-form-radio-group>
                        <b-form-invalid-feedback v-if="!$v.form.level.required">Bạn chưa chọn level</b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group label="Môn học">
                        <b-form-radio-group
                            v-model="$v.form.subject_id.$model"
                            :options="subjectOptions"
                            :state="$v.form.subject_id.$dirty ? !$v.form.subject_id.$error : null"
                            @change="getTopics($event)"
                        ></b-form-radio-group>
                        <b-form-invalid-feedback
                            v-if="!$v.form.true_answer.required"
                        >Bạn chưa chọn môn học</b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group label="Chủ đề">
                        <b-form-select
                            v-model="$v.form.topic_id.$model"
                            :state="$v.form.topic_id.$dirty ? !$v.form.topic_id.$error : null"
                            :options="topicOptions"
                        ></b-form-select>

                        <b-form-invalid-feedback
                            v-if="$v.form.$dirty?!$v.form.topic_id.required:false"
                        >Bạn chưa chọn chủ đề</b-form-invalid-feedback>
                    </b-form-group>
                </b-form>
                <button type="button" @click="postQuestion" class="btn btn-primary">Thêm câu hỏi</button>
                <!-- <button type="button" @click="reset" class="btn btn-primary">Reset</button> -->
            </div>
        </div>
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";
import CKEditor from "@ckeditor/ckeditor5-vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic/build/ckeditor";
import VueMathjax from "../../../components/MathJax";
export default {
    components: { ckeditor: CKEditor.component },
    mixins: [validationMixin],
    validations: {
        form: {
            content: {
                required
            },
            level: {
                required
            },
            answers: {
                A: {
                    required
                },
                B: {
                    required
                },
                C: {
                    required
                },
                D: {
                    required
                }
            },
            true_answer: {
                required
            },
            subject_id: {
                required
            },
            topic_id: {
                required
            }
        }
    },
    data() {
        return {
            form: {
                id: "",
                content: "",
                level: "",
                answers: {
                    A: "",
                    B: "",
                    C: "",
                    D: ""
                },
                true_answer: "",
                topic_id: null,
                subject_id: ""
            },
            fields: [
                {
                    key: "id",
                    label: "ID",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "content",
                    label: "Nội dung",
                    sortable: true,
                    class: "w-50"
                },
                {
                    key: "level",
                    label: "Mức độ",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "created_at",
                    label: "Ngày tạo",
                    sortable: true,
                    class: "text-center"
                },
                { key: "actions", label: "Hành động", class: "text-center" }
            ],
            path: {
                put: "/teacher/questions/",
                get: "/teacher/questions/topics/",
                delete: "/teacher/questions/"
            },
            editor: ClassicEditor,
            levelOptions: [
                { text: "Dễ", value: "Dễ" },
                { text: "Trung bình", value: "Trung bình" },
                { text: "Khó", value: "Khó" }
            ],
            answerOptions: [
                { text: "A", value: "A" },
                { text: "B", value: "B" },
                { text: "C", value: "C" },
                { text: "D", value: "D" }
            ],
            subjectOptions: [],
            topicOptions: [{ text: "Hãy chọn chủ đề", value: null }]
        };
    },
    created() {
        this.getSubjects();
        console.log(this.$v.form.topic_id.required);
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
        async getTopics(e) {
            try {
                let topics = await axios.get("/teacher/count-subject/" + e);
                this.topicOptions = [];
                topics.data.data.forEach(obj => {
                    this.topicOptions.push({
                        text: obj.name,
                        value: obj.id
                    });
                });
            } catch (error) {
                console.log(error);
            }
        },
        async postQuestion() {
            this.$v.form.$touch();
            if (this.$v.form.$anyError) {
                this.error = true;
                return;
            }
            // delete this.form["subject_id"];
            console.log(this.form);
            try {
                let data = await axios.post("/teacher/questions", this.form);
                this.$swal.fire({
                    type: "success",
                    title: "Thêm thành công",
                    showConfirmButton: false,
                    timer: 1500
                    //toast: true
                });
                this.resetForm();
            } catch (error) {
                console.log(error.response.data);
            }
        },
        resetForm() {
            for (let field in this.form) {
                if (this.form[field] instanceof Object) {
                    for (let answer in this.form[field]) {
                        this.form[field][answer] = "";
                    }
                } else {
                    this.form[field] = "";
                    console.log("ok");
                }
            }
            setTimeout(() => this.$v.form.$reset(), 0);
        }
    }
};
</script>

<style>
</style>
