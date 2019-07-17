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
            <template slot="row-details" slot-scope="row">
                <b-card>
                    <ul>
                        <ul class="list-group">
                            <li
                                :class="{'list-group-item':true, 'list-group-item-primary':row.item.true_answer===key}"
                                v-for="(answer,key) in row.item.answers"
                                :key="key"
                            >
                                <b>{{ key+': ' }}</b>
                                {{ answer }}
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
        <!-- Info modal -->
        <!-- <b-modal
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
                <b-form-group label="Tên chủ đề">
                    <b-form-input
                        id="name"
                        name="name"
                        type="text"
                        class="form-control"
                        aria-describedby="name-feedback"
                        v-model="$v.form.name.$model"
                        placeholder="Nhập tên chủ đề"
                        :state="$v.form.name.$dirty ? !$v.form.name.$error : null"
                    />
                    <b-form-invalid-feedback v-if="!$v.form.name.required">Bạn chưa nhập tên chủ đề</b-form-invalid-feedback>
                </b-form-group>
            </b-form>
        </b-modal>-->
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";
import { myTableMixin } from "../../../mixin/table";
export default {
    mixins: [validationMixin, myTableMixin],
    data() {
        return {
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
                post: "/teacher/count-subject/" + this.$route.params.id,
                put: "/admin/topics/",
                get: "/teacher/questions/topics/",
                delete: "/admin/topics/"
            }
        };
    },
    created() {
        console.log(this.items.length);
    }
};
</script>

<style>
</style>
