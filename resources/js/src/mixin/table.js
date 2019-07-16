export const myTableMixin = {
    data() {
        return {
            items: [],
            totalRows: 1,
            currentPage: 1,
            perPage: 10,
            emptyText: "Không có bản ghi nào được tìm thấy",
            emptyFilteredText: "Không có kết quả phù hợp với từ khoá tìm kiếm",
            filter: null,
            method: "",
            sortBy: '',
            sortDesc: false,
            infoModal: {
                id: "info-modal",
                title: "",
                content: {}
            },
            method: "",
            path: {
                post: "",
                put: "",
                get: "",
                delete: ""
            }
        }
    },
    created() {
        this.getData()
    },
    computed: {
        sortOptions() {
            // Create an options list from our fields
            return this.fields
                .filter(f => f.sortable)
                .map(f => {
                    return { text: f.label, value: f.key };
                });
        }
    },
    methods: {
        showFormUpdate(item, button, title) {

            this.method = 'put';
            this.infoModal.title = title;
            this.form.id = item.id;
            //console.log(this.form);
            for (let field in this.form) {
                this.form[field] = item[field]
            }
            // console.log(this.form);
            // // this.infoModal.content = item;

            this.$root.$emit("bv::show::modal", this.infoModal.id, button);
            this.$v.form.$reset();
            // this.$v.form.$reset;
        },
        showFormInsert(title) {
            this.method = "post";
            for (let field in this.form) {
                this.form[field] = ''
            }
            this.infoModal.title = title;
            this.$bvModal.show(this.infoModal.id);
            this.$v.form.$reset();
            console.log(this.form);
            // // this.infoModal.content = item;
            // this.$root.$emit("bv::show::modal", this.infoModal.id, button);
        },
        resetInfoModal() {
            this.infoModal.title = "";
            this.infoModal.content = "";
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        submit() {
            this.$v.form.$touch();
            if (this.$v.form.$anyError) {
                return;
            }
            if (this.method == 'put')
                this.updateContent();
            else if (this.method == 'post') this.insertContent()
            this.$nextTick(() => {
                this.$refs.modal.hide();

            });
        },
        getPosition(id) {
            return this.items.findIndex(
                (value, index, array) =>
                    value["id"] == id
            );
        },
        deleteContent(id) {
            this.$swal
                .fire({
                    title: "Bạn chắc chắn?",
                    text: "Bạn không thể phục hồi nếu xoá!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Xoá!"
                })
                .then(result => {
                    if (result.value) {
                        axios
                            .delete(this.path.delete + id)
                            .then(result => {
                                this.$swal.fire({
                                    type: "success",
                                    title: "Xoá thành công",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                this.items.splice(this.getPosition(id), 1);
                            })
                            .catch(err => {
                                console.log(err);
                                this.$swal.fire({
                                    type: "error",
                                    title: "Xoá thất bại",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            });
                        console.log(result);
                    }
                });
        },
        updateContent() {
            axios
                .put(this.path.put + this.form.id, this.form)
                .then(result => {
                    let pos = this.getPosition(this.form.id);
                    for (let field in this.form) {
                        this.items[pos][field] = this.form[field];
                    }
                    // this.items[pos].name = this.form.name;
                    this.$swal.fire({
                        type: "success",
                        title: "Cập nhật thành công",
                        showConfirmButton: false,
                        timer: 1500
                        //toast: true
                    });
                })
                .catch(err => {
                    this.$swal.fire({
                        type: "error",
                        title: "Cập nhật thất bại",
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
        },
        insertContent() {

            console.log('ok');
            console.log(this.form);
            console.log(this.path.post);
            axios
                .post(this.path.post, this.form)
                .then(result => {
                    // this.items[pos].name = this.form.name;
                    this.$swal.fire({
                        type: "success",
                        title: "Thêm thành công",
                        showConfirmButton: false,
                        timer: 1500
                        //toast: true
                    });
                    //console.log(result.data);
                    this.getData();
                })
                .catch(err => {
                    //console.log(err.response.data);
                    this.$swal.fire({
                        type: "error",
                        title: "Mục bạn muốn thêm đã tồn tại",
                        showConfirmButton: false,
                        timer: 2000
                    });
                });
        },
        // showInfo(fields) {
        //     this.form.id = this.infoModal.content.id;
        //     fields.forEach(field => this.form[field] = this.infoModal.content[field])
        // }
        //insertContent()
        async getData() {
            try {
                let param = this.$route.params.id || ''
                let data = await axios
                    .get(this.path.get + param)
                //console.log(data.data.data);
                this.items = data.data.data;
                this.totalRows = this.items.length;
            } catch (err) {
                console.log(err);
            }
        }
    },
}