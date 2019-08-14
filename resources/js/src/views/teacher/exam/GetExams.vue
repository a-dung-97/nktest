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
                    @click="showFormUpdate(row.item, $event.target,'Chỉnh sửa đề thi')"
                    class="btn btn-info"
                >Chỉnh sửa</b-button>
                <b-button @click="deleteContent(row.item.id)" size="sm" class="btn btn-danger">Xoá</b-button>
                <router-link
                    tag="button"
                    class="btn btn-info btn-sm"
                    :to="'/teacher/exams/'+row.item.id"
                >Xem câu hỏi</router-link>
                <b-button
                    size="sm"
                    @click="getTopicName(row.item.conditions);row.toggleDetails()"
                >{{ row.detailsShowing ? 'Ẩn' : 'Hiện' }}</b-button>
            </template>
            <template slot="row-details" slot-scope="row">
                <b-card>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Chủ đề</th>
                                <th>Dễ</th>
                                <th>Khó</th>
                                <th>Trung bình</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(condition,key) in row.item.conditions" :key="key">
                                <td>{{ condition.id }}</td>
                                <td>{{ condition.easy }}</td>
                                <td>{{ condition.medium }}</td>
                                <td>{{ condition.hard }}</td>
                            </tr>
                        </tbody>
                    </table>
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
                <b-form-group label="Tên đề thi">
                    <b-form-input
                        id="name"
                        name="name"
                        type="text"
                        class="form-control"
                        v-model="$v.form.name.$model"
                        placeholder="Nhập tên đề thi"
                        :state="$v.form.name.$dirty ? !$v.form.name.$error : null"
                    />
                    <b-form-invalid-feedback v-if="!$v.form.name.required">Bạn chưa nhập tên đề thi</b-form-invalid-feedback>
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
            }
        }
    },
    data() {
        return {
            form: { id: "", name: "" },
            fields: [
                {
                    key: "id",
                    label: "ID",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "name",
                    label: "Tên đề thi",
                    sortable: true,
                    class: "text-center w-50"
                },
                {
                    key: "subject",
                    label: "Môn học",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "questions_count",
                    label: "Số câu",
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
                put: "/teacher/exams/",
                get: "/teacher/exams/",
                delete: "/teacher/exams/"
            }
        };
    },
    methods: {
        getTopicName(conditions) {
            if (conditions[0]["id"].length > 3) return;
            conditions.forEach(condition => {
                axios
                    .get("/teacher/topic-name/" + condition["id"])
                    .then(result => {
                        console.log(result.data);
                        condition["id"] = result.data;
                        console.log(condition["id"]);
                    })
                    .catch(err => {
                        console.log(err.response.data);
                    });
            });
        }
    }
};
</script>

<style>
</style>
