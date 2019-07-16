<template>
    <div class="container-fluid">
        <div class="card">
            <h5 class="card-header">Thêm học sinh vào lớp</h5>
            <div class="card-body">
                <UploadExcel :on-success="handleSuccess" :before-upload="beforeUpload" />
                <b-table
                    class="mt-5"
                    show-empty
                    stacked="md"
                    :fields="fields"
                    :items="items"
                    :current-page="currentPage"
                    :per-page="perPage"
                    bordered
                    empty-text="Không có bản ghi nào được tìm thấy"
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
                            :total-rows="rows"
                            :per-page="perPage"
                        ></b-pagination>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" @click="hide" class="btn btn-primary">Quay lại</button>

                <button
                    type="button"
                    @click="insertStudents"
                    class="btn btn-primary float-right"
                    :disabled="!this.items.length>0"
                >Lưu</button>
            </div>
        </div>
        <Loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true" />
    </div>
</template>

<script>
import UploadExcel from "./UploadExcel";
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
export default {
    //name: "UploadExcel",
    components: { UploadExcel, Loading },
    data() {
        return {
            items: [],
            currentPage: 1,
            perPage: 10,
            fields: [
                {
                    key: "id",
                    label: "STT",
                    class: "text-center"
                },
                {
                    key: "name",
                    label: "Họ tên",
                    class: "text-center"
                },
                {
                    key: "birthday",
                    label: "Ngày sinh",
                    class: "text-center"
                },
                {
                    key: "gender",
                    label: "Giới tính",
                    class: "text-center"
                }
            ],
            isLoading: false
        };
    },
    computed: {
        rows() {
            return this.items.length;
        }
    },
    methods: {
        beforeUpload(file) {
            const isLt1M = file.size / 1024 / 1024 < 1;
            if (isLt1M) {
                return true;
            }
            this.$swal.fire({
                type: "error",
                title: "Đã có lỗi xảy ra!",
                text: "File bạn upload quá dung lượng cho phép (1MB)"
            });
            return false;
        },
        handleSuccess(results) {
            this.items = results;
            //this.tableHeader = header;
            //console.log(this.items);
            //console.log(this.tableHeader);
        },
        hide() {
            this.$emit("hide");
        },
        insertStudents() {
            console.log({ students: this.items });
            this.isLoading = true;
            axios
                .post("/admin/classrooms/" + this.$route.params.id, {
                    students: this.items
                })
                .then(result => {
                    // this.items[pos].name = this.form.name;
                    console.log(result);
                    this.$swal.fire({
                        type: "success",
                        title: "Thêm thành công",
                        showConfirmButton: false,
                        timer: 1500
                        //toast: true
                    });
                    this.isLoading = false;
                    this.$emit("getData");
                    this.hide();
                })
                .catch(err => {
                    //console.log(err.response.data);
                    this.isLoading = false;
                    this.$swal.fire({
                        type: "error",
                        title: "Thêm thất bại",
                        text: "Hãy kiểm tra lại dữ liệu đầu vào",
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
        }
    }
};
</script>
