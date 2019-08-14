<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary">
                <span>{{ meta.name }}</span>
                <span class="float-right">{{ meta.classroom }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-primary">Phổ điểm</h3>
                        <bar-chart v-if="loaded" :chartData="chartData" />
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6">
                        <h3 class="text-primary">Thống kê</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-primary text-white">
                                    <div class="card-body bg-primary">
                                        <div class="rotate">
                                            <i class="fa fa-users fa-4x"></i>
                                        </div>
                                        <h6 class="text-uppercase">Học sinh</h6>
                                        <h1 class="display-4">{{ items.length }}</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-info text-white">
                                    <div class="card-body bg-info">
                                        <div class="rotate">
                                            <i class="fa fa-users fa-4x"></i>
                                        </div>
                                        <h6 class="text-uppercase">Điểm TB</h6>
                                        <h1 class="display-4">{{ statistics.avg }}</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-success text-white">
                                    <div class="card-body bg-success">
                                        <div class="rotate">
                                            <i class="fa fa-users fa-4x"></i>
                                        </div>
                                        <h6 class="text-uppercase">Điểm cao nhất</h6>
                                        <h1 class="display-4">{{ statistics.max }}</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-danger text-white">
                                    <div class="card-body bg-danger">
                                        <div class="rotate">
                                            <i class="fa fa-users fa-4x"></i>
                                        </div>
                                        <h6 class="text-uppercase">Điểm thấp nhất</h6>
                                        <h1 class="display-4">{{ statistics.min }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="text-primary">Bảng điểm</h3>
                        <div class="row">
                            <div class="col-md-8">
                                <form class="form-inline">
                                    <label
                                        class="sr-only"
                                        for="inlineFormInputGroupUsername2"
                                    >Tìm kiếm</label>
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
                            <div class="col-md-4">
                                <ExportToExcel
                                    class="btn btn-primary float-right"
                                    style="cursor:pointer"
                                    :data="items"
                                    :fields="json_fields"
                                    worksheet="Bảng điểm"
                                    name="scores.xls"
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
                        ></b-table>

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
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { myTableMixin } from "../../../mixin/table";
import ExportToExcel from "vue-json-excel";
import BarChart from "../../../components/BarChart";
export default {
    mixins: [myTableMixin],
    components: { ExportToExcel, BarChart },
    data() {
        return {
            fields: [
                {
                    key: "student_id",
                    label: "ID",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "student_name",
                    label: "Tên học sinh",
                    sortable: true,
                    class: "text-center w-50"
                },
                {
                    key: "result",
                    label: "Điểm",
                    sortable: true,
                    class: "text-center"
                }
            ],
            json_fields: {
                MSHS: "student_id",
                "Họ tên": "student_name",
                "Kết quả": "result"
            },
            statistics: {},
            meta: {},
            path: {
                get: "/teacher/tests/"
            },
            chartData: {
                labels: [],
                datasets: [
                    {
                        label: "Phổ điểm",
                        backgroundColor: "#f87979",
                        data: []
                    }
                ]
            },
            loaded: false
        };
    },
    methods: {
        getChartData(score_per_question, scores) {
            for (var score = 0; score <= 10; score += score_per_question) {
                let student_count = 0;
                scores.forEach(result => {
                    if (result.result == score) student_count++;
                });
                this.chartData.datasets[0].data.push(student_count);
                this.chartData.labels.push(score);
            }
        },
        async getData() {
            try {
                let param = this.$route.params.id || "";
                let data = await axios.get(this.path.get + param);
                //console.log(data.data.data);
                this.items = data.data.data;
                this.statistics = data.data.statistics;
                this.meta = data.data.meta;
                this.totalRows = this.items.length;
                this.getChartData(this.meta.score_per_question, this.items);
                setTimeout(() => (this.loaded = true), 500);
            } catch (err) {
                console.log(err);
            }
        }
    }
};
</script>

<style>
</style>
