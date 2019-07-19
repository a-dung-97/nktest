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
                </b-form>
                <button type="button" class="btn btn-primary">Thêm câu hỏi</button>
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
                true_answer: ""
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
                { text: "Dễ", value: "1" },
                { text: "Trung bình", value: "2" },
                { text: "Khó", value: "3" }
            ],
            answerOptions: [
                { text: "A", value: "A" },
                { text: "B", value: "B" },
                { text: "C", value: "C" },
                { text: "D", value: "D" }
            ]
        };
    }
};
</script>

<style>
</style>
