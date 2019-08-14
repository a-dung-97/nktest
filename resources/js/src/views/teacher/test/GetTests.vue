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
                    <p class="text-muted pt-2 pl-3">Tìm được {{ totalRows }} kết quả</p>
                </form>
            </div>
            <div class="col-md-8">
                <b-button
                    variant="primary"
                    class="float-right"
                    @click="showFormInsert('Tạo kỳ thi')"
                >
                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm kỳ thi
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
            <template slot="actions" slot-scope="row">
                <b-button
                    size="sm"
                    @click="showFormUpdate(row.item, $event.target,'Chỉnh sửa kì thi')"
                    class="btn btn-info"
                    v-if="row.item.status=='Sắp diễn ra'"
                >Chỉnh sửa</b-button>
                <b-button
                    v-if="row.item.status=='Sắp diễn ra'"
                    @click="deleteContent(row.item.id)"
                    size="sm"
                    class="btn btn-danger"
                >Xoá</b-button>
                <router-link
                    tag="button"
                    class="btn btn-info btn-sm"
                    :to="'/teacher/tests/'+row.item.id"
                    v-if="row.item.status=='Kết thúc'"
                >Xem kết quả</router-link>
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
                <b-form-group label="Tên bài thi">
                    <b-form-input
                        id="name"
                        name="name"
                        type="text"
                        class="form-control"
                        v-model="$v.form.name.$model"
                        placeholder="Nhập tên kỳ thi"
                        :state="$v.form.name.$dirty ? !$v.form.name.$error : null"
                    />
                    <b-form-invalid-feedback v-if="!$v.form.name.required">Bạn chưa nhập tên kỳ thi</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Thời gian(phút)">
                    <b-form-input
                        type="number"
                        @keypress.prevent
                        v-model="$v.form.time.$model"
                        min="1"
                        :state="$v.form.time.$dirty ? !$v.form.time.$error : null"
                        placeholder="Nhập thời gian thi"
                    />
                    <b-form-invalid-feedback
                        v-if="!$v.form.time.required"
                    >Bạn chưa nhập thời gian thi</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Ngày thi">
                    <b-form-input
                        type="datetime-local"
                        v-model="$v.form.start_at.$model"
                        :state="$v.form.start_at.$dirty ? !$v.form.start_at.$error : null"
                    />
                    <b-form-invalid-feedback
                        v-if="!$v.form.start_at.required"
                    >Bạn chưa nhập ngày thi</b-form-invalid-feedback>
                    <b-form-invalid-feedback
                        v-if="!$v.form.start_at.validDate"
                    >Thời gian thi phải lớn hơn thời gian hiện tại tối thiểu 30 phút</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Lớp thi">
                    <b-form-select
                        v-model="$v.form.classroom_id.$model"
                        :state="$v.form.classroom_id.$dirty ? !$v.form.classroom_id.$error : null"
                        :options="options.classrooms"
                    ></b-form-select>
                    <b-form-invalid-feedback
                        v-if="!$v.form.classroom_id.required"
                    >Bạn chưa chọn lớp học</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Đề thi">
                    <b-form-select
                        v-model="$v.form.exam_id.$model"
                        :state="$v.form.exam_id.$dirty ? !$v.form.exam_id.$error : null"
                        :options="options.exams"
                    ></b-form-select>
                    <b-form-invalid-feedback v-if="!$v.form.exam_id.required">Bạn chưa chọn đề thi</b-form-invalid-feedback>
                </b-form-group>
            </b-form>
        </b-modal>
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required, minValue } from "vuelidate/lib/validators";
import { myTableMixin } from "../../../mixin/table";
const validDate = value => {
    let input = new Date(value);
    let now = new Date();
    return input >= now.setMinutes(now.getMinutes() + 30);
};
export default {
    mixins: [validationMixin, myTableMixin],
    validations: {
        form: {
            name: {
                required
            },
            time: {
                required
            },
            start_at: {
                required,
                validDate
            },
            classroom_id: {
                required
            },
            exam_id: {
                required
            }
        }
    },
    data() {
        return {
            form: {
                id: "",
                name: "",
                time: "",
                start_at: "",
                classroom_id: "",
                exam_id: ""
            },
            fields: [
                {
                    key: "id",
                    label: "ID",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "name",
                    label: "Tên bài thi",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "time",
                    label: "Thời gian",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "start_at",
                    label: "Bắt đầu",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "classroom.name",
                    label: "Lớp học",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "exam_id",
                    label: "Mã đề thi",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "status",
                    label: "Trạng thái",
                    sortable: true,
                    class: "text-center"
                },
                { key: "actions", label: "Hành động", class: "text-center" }
            ],
            options: {
                exams: [],
                classrooms: []
            },
            //method: "",
            path: {
                post: "/teacher/tests",
                put: "/teacher/tests/",
                get: "/teacher/tests",
                delete: "/teacher/tests/"
            }
        };
    },
    created() {
        this.getOptions("classrooms");
        this.getOptions("exams");
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
        },
        showFormUpdate(item, button, title) {
            this.method = "put";
            this.infoModal.title = title;
            this.form.id = item.id;
            //console.log(this.form);
            for (let field in this.form) {
                if (field == "classroom_id")
                    this.form[field] = item["classroom"].id;
                else this.form[field] = item[field];
            }
            console.log(this.form);
            // // this.infoModal.content = item;

            this.$root.$emit("bv::show::modal", this.infoModal.id, button);
            this.$v.form.$reset();
            // this.$v.form.$reset;
        }
    }
};
</script>

<style>
</style>
