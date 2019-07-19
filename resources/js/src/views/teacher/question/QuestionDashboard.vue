<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary">
                    <div class="card-body" v-for="subject in subjects" :key="subject.id">
                        <h4 class="card-title">{{ subject.name }}</h4>
                        <p class="card-text">
                            <span>{{ subject.topics_count }} chủ đề</span>
                            <span class="float-right">{{ subject.questions_count }} câu hỏi</span>
                        </p>
                        <button
                            @click="getSubjectDetail(subject.id)"
                            class="btn btn-outline-info text-white"
                        >Xem chi tiết</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <b-table
                    v-if="showTable"
                    show-empty
                    stacked="md"
                    :items="items"
                    :fields="fields"
                    bordered
                    hover
                    head-variant="light"
                >
                    <template slot="actions" slot-scope="row">
                        <router-link
                            tag="button"
                            :to="'/teacher/questions/'+row.item.id"
                            class="btn btn-primary"
                        >Xem danh sách</router-link>
                    </template>
                </b-table>
            </div>
        </div>
        <Loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true" />
    </div>
</template>

<script>
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
export default {
    components: { Loading },
    data() {
        return {
            subjects: [],
            isLoading: false,
            showTable: false,
            items: [],
            fields: [
                {
                    key: "id",
                    label: "ID",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "name",
                    label: "Tên chủ đề",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "easy",
                    label: "Dễ",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "medium",
                    label: "Khó",
                    sortable: true,
                    class: "text-center"
                },
                {
                    key: "hard",
                    label: "Trung bình",
                    sortable: true,
                    class: "text-center"
                },
                { key: "actions", label: "Hành động", class: "text-center" }
            ]
        };
    },
    methods: {
        async getSubjects() {
            try {
                let subjects = await axios.get("/teacher/count-subject");
                this.subjects = subjects.data;
            } catch (error) {
                console.log(error);
            }
        },
        async getSubjectDetail(id) {
            this.isLoading = true;
            try {
                let subjectDetail = await axios.get(
                    "/teacher/count-subject/" + id
                );
                this.items = subjectDetail.data.data;
                this.isLoading = false;
                this.showTable = true;
            } catch (error) {
                console.log(error);
                this.isLoading = false;
            }
        }
    },
    created() {
        this.getSubjects();
    }
};
</script>

<style>
</style>
