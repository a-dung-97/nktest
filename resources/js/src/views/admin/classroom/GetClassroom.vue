<template>
    <div>
        <transition name="create-student" enter-active-class="animated bounceInRight">
            <div class="container-fluid" v-if="!insert">
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
                        <ExportToExcel
                            class="btn btn-primary float-right"
                            style="cursor:pointer"
                            :data="items"
                            :fields="json_fields"
                            worksheet="Danh sách học sinh"
                            name="student.xls"
                        >
                            <i class="fa fa-file-excel-o" aria-hidden="true"></i> Xuất Excel
                        </ExportToExcel>
                        <b-button
                            variant="primary"
                            class="float-right mr-2"
                            @click="showFormInsert('Thêm học sinh')"
                        >
                            <i class="fa fa-plus" aria-hidden="true"></i> Thêm học sinh
                        </b-button>
                        <b-button
                            variant="primary"
                            class="float-right mr-2"
                            @click="insert=!insert"
                            :disabled="this.items.length>0"
                        >
                            <i class="fa fa-plus" aria-hidden="true"></i> Thêm học sinh từ Excel
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
                            @click="showFormUpdate(row.item, $event.target,'Chỉnh sửa học sinh')"
                            class="btn btn-info"
                        >
                            <i class="fa fa-pencil-square" aria-hidden="true"></i> Chỉnh sửa
                        </b-button>
                        <b-button
                            @click="deleteContent(row.item.id)"
                            size="sm"
                            class="btn btn-danger"
                        >
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
                                placeholder="Nhập tên học sinh"
                                :state="$v.form.name.$dirty ? !$v.form.name.$error : null"
                            />
                            <b-form-invalid-feedback
                                v-if="!$v.form.name.required"
                            >Bạn chưa nhập tên học sinh</b-form-invalid-feedback>
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
                            <b-form-invalid-feedback
                                v-if="!$v.form.gender.required"
                            >Bạn chưa chọn giới tính</b-form-invalid-feedback>
                        </b-form-group>
                    </b-form>
                </b-modal>
            </div>

            <CreateMultiStudent v-else @hide="insert=false" @getData="getData" />
        </transition>
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";
import { myTableMixin } from "../../../mixin/table";
import ExportToExcel from "vue-json-excel";
import CreateMultiStudent from "../../../components/CreateMultiStudent";
export default {
    mixins: [validationMixin, myTableMixin],
    components: { CreateMultiStudent, ExportToExcel },
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
            }
        }
    },
    data() {
        return {
            form: { id: "", name: "", birthday: "", gender: "" },
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
                { key: "actions", label: "Hành động", class: "text-center" }
            ],
            //method: "",
            path: {
                post: "/admin/classrooms/" + this.$route.params.id,
                put: "/admin/students/",
                get: "/admin/classrooms/",
                delete: "/admin/students/"
            },
            insert: false,
            json_fields: {
                MSHS: "id",
                "Họ tên": "name",
                "Ngày sinh": "birthday",
                "Giới tính": {
                    field: "gender",
                    callback: value => {
                        return value ? "Nam" : "Nữ";
                    }
                },
                Email: "email"
            }
        };
    },

    methods: {
        insertContent() {
            axios
                .post(this.path.post, { students: [this.form] })
                .then(result => {
                    // this.items[pos].name = this.form.name;
                    this.$swal.fire({
                        type: "success",
                        title: "Thêm thành công",
                        showConfirmButton: false,
                        timer: 1500
                        //toast: true
                    });
                    this.getData();
                })
                .catch(err => {
                    console.log(err.response.data);
                    // this.$swal.fire({
                    //     type: "error",
                    //     title: "Thêm thất bại",
                    //     showConfirmButton: false,
                    //     timer: 1500
                    // });
                });
        }
    }
};
</script>

<style>
</style>
