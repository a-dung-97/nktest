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
                    v-if="this.items.length"
                    variant="primary"
                    class="float-right"
                    @click="showFormInsert('Thêm môn học')"
                >
                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm môn học
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
                    @click="showFormUpdate(row.item, $event.target,'Chỉnh sửa môn học')"
                    class="btn btn-info"
                >
                    <i class="fa fa-pencil-square" aria-hidden="true"></i> Chỉnh sửa
                </b-button>
                <b-button class="btn btn-danger" size="sm" @click="deleteContent(row.item.id)">
                    <i class="fa fa-trash" aria-hidden="true"></i> Xoá
                </b-button>
                <router-link
                    :to="`/admin/subjects/${row.item.id}`"
                    tag="button"
                    class="btn btn-primary btn-sm"
                >
                    <i class="fa fa-list-ol" aria-hidden="true"></i> Xem chủ đề
                </router-link>
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
                <b-form-group label="Tên môn học">
                    <b-form-input
                        id="name"
                        name="name"
                        type="text"
                        class="form-control"
                        aria-describedby="name-feedback"
                        v-model="$v.form.name.$model"
                        placeholder="Nhập tên môn học"
                        :state="$v.form.name.$dirty ? !$v.form.name.$error : null"
                    />
                    <b-form-invalid-feedback v-if="!$v.form.name.required">Bạn chưa nhập tên môn học</b-form-invalid-feedback>
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
import CreateMultiStudent from "../../../components/CreateMultiStudent";
export default {
    mixins: [validationMixin, myTableMixin],
    components: { CreateMultiStudent },
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
                    label: "Tên môn học",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "topic_count",
                    label: "Số chủ đề",
                    sortable: true,
                    class: "text-center"
                },
                { key: "actions", label: "Hành động", class: "text-center" }
            ],
            //method: "",
            path: {
                post: "/admin/subjects",
                put: "/admin/subjects/",
                get: "/admin/subjects/",
                delete: "/admin/subjects/"
            }
        };
    },
    methods: {}
};
</script>

<style>
</style>
