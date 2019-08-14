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
            <template slot="content" slot-scope="row">
                <vue-mathjax :input="row.value"></vue-mathjax>
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
                                <vue-mathjax :input="`<b>${key}. </b>`+answer"></vue-mathjax>
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
    </div>
</template>

<script>
import { myTableMixin } from "../../../mixin/table";
import VueMathjax from "../../../components/MathJax";
export default {
    mixins: [myTableMixin],
    components: { "vue-mathjax": VueMathjax },
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
                    key: "topic",
                    label: "Chủ đề",
                    sortable: true,
                    class: "text-center"
                }
            ],
            path: {
                get: "/teacher/exams/"
            }
        };
    }
};
</script>

<style>
</style>
