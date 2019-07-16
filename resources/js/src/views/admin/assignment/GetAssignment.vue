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
                        <i class="fa fa-refresh" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
            <div class="col-md-8">
                <b-button
                    variant="primary"
                    class="float-right mr-2"
                    @click="showFormInsert('Thêm phân công')"
                >
                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm phân công
                </b-button>
            </div>
        </div>

        <b-table
            show-empty
            stacked="md"
            :empty-text="emptyText"
            :empty-filtered-text="emptyFilteredText"
            :sort-by.sync="sortBy"
            :sort-desc.sync="sortDesc"
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
            <template slot="gender" slot-scope="row">{{ row.value ? 'Nam' : 'Nữ' }}</template>
            <template slot="actions" slot-scope="row">
                <b-button @click="deleteContent(row.item.id)" size="sm" class="btn btn-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i> Xoá
                </b-button>
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
            @ok.prevent="submit"
        >
            <template slot="modal-ok">{{ method=='post'?'Thêm':'Chỉnh sửa' }}</template>
            <template slot="modal-cancel">Huỷ bỏ</template>
            <b-form @submit.stop.prevent="submit">
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
                <b-form-group label="Môn học">
                    <b-form-select
                        v-model="$v.form.subject_id.$model"
                        :state="$v.form.subject_id.$dirty ? !$v.form.subject_id.$error : null"
                        :options="options.subjects"
                        @change="getTeacher($event)"
                    ></b-form-select>
                    <b-form-invalid-feedback
                        v-if="!$v.form.subject_id.required"
                    >Bạn chưa chọn môn học</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Giáo viên">
                    <b-form-select
                        v-model="$v.form.teacher_id.$model"
                        :state="$v.form.teacher_id.$dirty ? !$v.form.teacher_id.$error : null"
                        :options="options.teachers"
                    ></b-form-select>
                    <b-form-invalid-feedback
                        v-if="!$v.form.teacher_id.required"
                    >Bạn chưa chọn giáo viên</b-form-invalid-feedback>
                </b-form-group>
            </b-form>
        </b-modal>
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";
import { myTableMixin } from "../../../mixin/table";
export default {
    mixins: [validationMixin, myTableMixin],
    validations: {
        form: {
            classroom_id: {
                required
            },
            subject_id: {
                required
            },
            teacher_id: {
                required
            }
        }
    },
    data() {
        return {
            form: {
                id: "",
                classroom_id: "",
                subject_id: "",
                teacher_id: ""
            },
            sortBy: "last_name",
            fields: [
                {
                    key: "id",
                    label: "ID",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "classroom",
                    label: "Lớp",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "subject",
                    label: "Môn học",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "teacher",
                    label: "Giáo viên",
                    sortable: true,
                    class: "text-center"
                },
                { key: "actions", label: "Hành động", class: "text-center" }
            ],
            path: {
                post: "/admin/assignment",
                put: "/admin/assignment/",
                get: "/admin/assignment/",
                delete: "/admin/assignment/"
            },
            options: {
                classrooms: [],
                subjects: [],
                teachers: []
            }
        };
    },
    methods: {
        async getOptions(path, objs) {
            try {
                let data = await axios.get(path);
                console.log("ok");
                data.data.data.forEach(obj => {
                    this.options[objs].push({
                        text: obj.name,
                        value: obj.id
                    });
                });
                console.log("ok");
            } catch (error) {
                console.log(error);
            }
        },
        showFormInsert(title) {
            this.method = "post";
            for (let field in this.form) {
                this.form[field] = "";
            }
            if (this.options.classrooms.length == 0) {
                this.getOptions("/admin/classrooms", "classrooms");
                this.getOptions("/admin/subjects", "subjects");
            }
            this.infoModal.title = title;
            this.$bvModal.show(this.infoModal.id);
            this.$v.form.$reset();
            console.log(this.form);
            // // this.infoModal.content = item;
            // this.$root.$emit("bv::show::modal", this.infoModal.id, button);
        },
        getTeacher(e) {
            this.getOptions("/admin/teachers?subject=" + e, "teachers");
        }
    }
};
</script>

<style>
</style>
