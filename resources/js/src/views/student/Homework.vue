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
    </div>
    <!-- <CreateMultiStudent /> -->
</template>

<script>
import { myTableMixin } from "../../mixin/table";

export default {
    mixins: [myTableMixin],
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
                    key: "title",
                    label: "Tên bài tập",
                    sortable: true,
                    class: "text-center w-40"
                },
                {
                    key: "teacher",
                    label: "Giáo viên",
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
                get: "/student/homeworks"
            }
        };
    },
    methods: {}
};
</script>

<style>
</style>
