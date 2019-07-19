<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <form class="form-inline d-flex">
                    <label class="sr-only" for="inlineFormInputGroupUsername2">Tìm kiếm</label>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </div>
                        </div>
                        <input
                            v-model="filter"
                            type="text"
                            class="form-control"
                            id="inlineFormInputGroupUsername2"
                            placeholder="Nhập để tìm kiếm"
                        />
                    </div>
                    <button
                        type="button"
                        :disabled="!filter"
                        @click="filter = ''"
                        class="btn btn-outline-info btn-sm mb-2"
                    >
                        <i class="fas fa-eraser" aria-hidden="true"></i>
                    </button>
                    <p class="text-muted pt-2 pl-3">Tìm được {{ totalRows }} kết quả</p>
                </form>
            </div>
            <div class="col-md-6">
                <b-button
                    variant="primary"
                    class="float-right"
                    @click="showFormInsert('Thêm câu hỏi')"
                >
                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm câu hỏi
                </b-button>
            </div>
        </div>
        <b-table
            show-empty
            :empty-text="emptyText"
            :empty-filtered-text="emptyFilteredText"
            stacked="md"
            :items="items"
            :fields="fields"
            :current-page="currentPage"
            :per-page="perPage"
            :filter="filter"
            @filtered="onFiltered"
            bordered
            hover
            head-variant="light"
        >
            <template slot="actions" slot-scope="row">
                <b-button
                    size="sm"
                    @click="showFormUpdate(row.item, $event.target,'Chỉnh sửa câu hỏi')"
                    class="btn btn-info"
                >
                    <i class="fa fa-pencil-square" aria-hidden="true"></i> Chỉnh sửa
                </b-button>
                <b-button class="btn btn-danger" size="sm" @click="deleteContent(row.item.id)">
                    <i class="fa fa-trash" aria-hidden="true"></i> Xoá
                </b-button>
                <b-button
                    size="sm"
                    @click="row.toggleDetails"
                >{{ row.detailsShowing ? 'Ẩn' : 'Hiện' }}</b-button>
            </template>

            <template
                slot="level"
                slot-scope="row"
            >{{ (row.value ==1)?'Dễ':(row.value==2?'Trung bình':'Khó') }}</template>
            <template slot="content" slot-scope="row">
                <vue-mathjax :input="row.value"></vue-mathjax>
            </template>
            <template slot="row-details" slot-scope="row">
                <b-card>
                    <ul>
                        <ul class="list-group">
                            <li
                                :class="{'list-group-item':true, 'list-group-item-primary':row.item.true_answer===key}"
                                v-for="(answer,key) in row.item.answers"
                                :key="key"
                            >
                                <vue-mathjax :input="`<b>${key}. </b>`+answer"></vue-mathjax>
                            </li>
                        </ul>
                    </ul>
                </b-card>
            </template>
        </b-table>

        <div class="row mt-4">
            <div class="col-md-6 offset-md-3">
                <b-pagination
                    class="justify-content-center"
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
                ></b-pagination>
            </div>
        </div>
        <!-- <button @click="editorData=editorChange">Change</button> -->
        <!-- Info modal -->
        <b-modal
            ref="modal"
            size="lg"
            :id="infoModal.id"
            centered
            scrollable
            :title="infoModal.title"
            header-bg-variant="info"
            header-text-variant="light"
            @ok.prevent="submit"
        >
            <template slot="modal-ok">{{ method=='post'?'Thêm':'Chỉnh sửa' }}</template>
            <template slot="modal-cancel">Huỷ bỏ</template>
            <b-form @submit.stop.prevent="submit">
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
        </b-modal>
        <!-- <vue-mathjax :input="formula"></vue-mathjax>
        <ckeditor :editor="editor" v-model="formula"></ckeditor>-->
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";
import { myTableMixin } from "../../../mixin/table";
import CKEditor from "@ckeditor/ckeditor5-vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic/build/ckeditor";
import VueMathjax from "../../../components/MathJax";
export default {
    mixins: [validationMixin, myTableMixin],
    components: { ckeditor: CKEditor.component, "vue-mathjax": VueMathjax },
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
    },

    methods: {}
};
</script>

<style>
.ckeditor-invalid-feedback {
    color: red;
    font-size: 12px;
}
</style>
