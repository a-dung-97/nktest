<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <form class="form-inline">
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
                </form>
            </div>
            <div class="col-md-8">
                <b-button
                    variant="primary"
                    class="float-right mr-2"
                    @click="showFormInsert('Thêm bài tập')"
                >
                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm bài tập
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
                    @click="showFormUpdate(row.item, $event.target,'Chỉnh sửa bài tập')"
                    class="btn btn-info"
                >Chỉnh sửa</b-button>
                <b-button class="btn btn-danger" size="sm" @click="deleteContent(row.item.id)">Xoá</b-button>
                <b-button
                    size="sm"
                    @click="row.toggleDetails"
                >{{ row.detailsShowing ? 'Ẩn' : 'Hiện' }}</b-button>
            </template>
            <template slot="row-details" slot-scope="row">
                <div class="card">
                    <div class="card-body" v-html="row.item.content"></div>
                </div>
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
        <!-- Info modal -->
        <b-modal
            ref="modal"
            :id="infoModal.id"
            centered
            :title="infoModal.title"
            header-bg-variant="info"
            header-text-variant="light"
            size="lg"
            @ok.prevent="submit"
        >
            <template slot="modal-ok">{{ method=='post'?'Thêm':'Chỉnh sửa' }}</template>
            <template slot="modal-cancel">Huỷ bỏ</template>
            <b-form @submit.stop.prevent="submit">
                <b-form-group label="Tên bài tập">
                    <b-form-input
                        type="text"
                        class="form-control"
                        v-model="$v.form.title.$model"
                        placeholder="Nhập tên bài tập"
                        :state="$v.form.title.$dirty ? !$v.form.title.$error : null"
                    />
                    <b-form-invalid-feedback
                        v-if="!$v.form.title.required"
                    >Bạn chưa nhập tên bài tập</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Nội dung">
                    <ckeditor :editor="editor" v-model="$v.form.content.$model"></ckeditor>
                    <div class="ckeditor-invalid-feedback" v-if="$v.form.$dirty">
                        <span v-if="!$v.form.content.required">Bạn chưa nhập nội dung câu hỏi</span>
                    </div>
                </b-form-group>
                <b-form-group label="Lớp học">
                    <b-form-select
                        v-model="$v.form.classroom_id.$model"
                        :state="$v.form.classroom_id.$dirty ? !$v.form.classroom_id.$error : null"
                        :options="options.classrooms"
                    ></b-form-select>
                    <b-form-invalid-feedback
                        v-if="!$v.form.classroom_id.required"
                    >Bạn chưa chọn lớp học</b-form-invalid-feedback>
                </b-form-group>
            </b-form>
        </b-modal>
    </div>
    <!-- <CreateMultiStudent /> -->
</template>

<script>
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";
import { myTableMixin } from "../../../mixin/table";
import CKEditor from "@ckeditor/ckeditor5-vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic/build/ckeditor";

export default {
    mixins: [validationMixin, myTableMixin],
    components: { ckeditor: CKEditor.component },
    validations: {
        form: {
            title: {
                required
            },
            content: {
                required
            },
            classroom_id: {
                required
            }
        }
    },
    data() {
        return {
            options: {
                classrooms: []
            },
            form: { id: "", title: "", content: "", classroom_id: "" },
            editor: ClassicEditor,
            fields: [
                {
                    key: "id",
                    label: "ID",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "title",
                    label: "Tên bài tập",
                    sortable: true,
                    class: "text-center w-40"
                },
                {
                    key: "classroom.name",
                    label: "Lớp học",
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
            //method: "",
            path: {
                post: "/teacher/homeworks",
                put: "/teacher/homeworks/",
                get: "/teacher/homeworks/",
                delete: "/teacher/homeworks/"
            }
        };
    },
    created() {
        this.getOptions("classrooms");
    },
    methods: {
        async getOptions(objs) {
            try {
                let data = await axios.get("/teacher/" + objs);
                data.data.data.forEach(obj => {
                    this.options[objs].push({
                        text: obj.name,
                        value: obj.id
                    });
                });
            } catch (error) {
                console.log(error);
            }
        }
    }
};
</script>

<style>
</style>
