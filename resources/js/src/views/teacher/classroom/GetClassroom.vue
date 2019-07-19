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
                <ExportToExcel
                    class="btn btn-primary float-right"
                    style="cursor:pointer"
                    :data="items"
                    :fields="json_fields"
                    worksheet="Danh sách học sinh"
                    name="student.xls"
                >
                    <i class="fas fa-file-excel" aria-hidden="true"></i> Xuất Excel
                </ExportToExcel>
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
</template>

<script>
import { myTableMixin } from "../../../mixin/table";
import ExportToExcel from "vue-json-excel";

export default {
    mixins: [myTableMixin],
    components: { ExportToExcel },

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
                }
            ],
            //method: "",
            path: {
                get: "/classrooms/"
            },

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
    }
};
</script>

<style>
</style>
