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
                    @click="showFormInsert('Thêm giáo viên')"
                >
                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm giáo viên
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
                <b-button
                    size="sm"
                    @click="showFormUpdate(row.item, $event.target,'Chỉnh sửa giáo viên')"
                    class="btn btn-info"
                >
                    <i class="fa fa-pencil-square" aria-hidden="true"></i> Chỉnh sửa
                </b-button>
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
                <b-form-group label="Họ tên">
                    <b-form-input
                        id="name"
                        name="name"
                        type="text"
                        class="form-control"
                        v-model="$v.form.name.$model"
                        placeholder="Nhập tên giáo viên"
                        :state="$v.form.name.$dirty ? !$v.form.name.$error : null"
                    />
                    <b-form-invalid-feedback
                        v-if="!$v.form.name.required"
                    >Bạn chưa nhập tên giáo viên</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Ngày sinh">
                    <b-form-input
                        id="birthday"
                        name="birthday"
                        type="date"
                        class="form-control"
                        v-model="$v.form.birthday.$model"
                        :state="$v.form.birthday.$dirty ? !$v.form.birthday.$error : null"
                    />
                    <b-form-invalid-feedback
                        v-if="!$v.form.birthday.required"
                    >Bạn chưa nhập ngày sinh</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Giới tính">
                    <b-form-radio-group
                        v-model="$v.form.gender.$model"
                        :state="$v.form.gender.$dirty ? !$v.form.gender.$error : null"
                        :options="[{text:'Nam',value:1},{text:'Nữ',value:0}]"
                        name="radio-inline"
                    ></b-form-radio-group>
                    <b-form-invalid-feedback v-if="!$v.form.gender.required">Bạn chưa chọn giới tính</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Môn học">
                    <b-form-select
                        v-model="$v.form.subject.$model"
                        :state="$v.form.subject.$dirty ? !$v.form.subject.$error : null"
                        :options="options"
                    ></b-form-select>
                    <b-form-invalid-feedback v-if="!$v.form.subject.required">Bạn chưa chọn môn học</b-form-invalid-feedback>
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
            name: {
                required
            },
            birthday: {
                required
            },
            gender: {
                required
            },
            subject: {
                required
            }
        }
    },
    data() {
        return {
            form: { id: "", name: "", birthday: "", gender: "", subject: "" },
            sortBy: "last_name",
            fields: [
                {
                    key: "id",
                    label: "ID",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "name",
                    label: "Họ tên",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "birthday",
                    label: "Ngày sinh",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "gender",
                    label: "Giới tính",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "email",
                    label: "Email",
                    sortable: false,
                    class: "text-center"
                },
                {
                    key: "subject",
                    label: "Môn học",
                    sortable: true,
                    class: "text-center"
                },
                { key: "actions", label: "Hành động", class: "text-center" }
            ],
            path: {
                post: "/admin/teachers",
                put: "/admin/teachers/",
                get: "/admin/teachers/",
                delete: "/admin/teachers/"
            },
            options: [
                { value: null, text: "Hãy chọn môn học" },
                { value: "Toán", text: "Toán" },
                { value: "Vật lý", text: "Vật lý" },
                { value: "Hoá học", text: "Hoá học" }
            ]
        };
    },

    methods: {}
};
</script>

<style>
</style>
