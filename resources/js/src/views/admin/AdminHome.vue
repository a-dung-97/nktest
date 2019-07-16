<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 text-center">
                <img src="/img/index2.jpg" width="100%" class="img-thumbnail img-fluid" alt />
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-xl-3 col-sm-6 py-2">
                <div class="card bg-success text-white">
                    <div class="card-body bg-success">
                        <div class="rotate">
                            <i class="fa fa-users fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">Học sinh</h6>
                        <h1 class="display-4">{{ amount.students }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 py-2">
                <div class="card text-white bg-info">
                    <div class="card-body bg-info">
                        <div class="rotate">
                            <i class="fa fa-list fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">Lớp học</h6>
                        <h1 class="display-4">{{ amount.classrooms }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 py-2">
                <div class="card text-white bg-danger">
                    <div class="card-body bg-danger">
                        <div class="rotate">
                            <i class="fa fa fa-users fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">Giáo viên</h6>
                        <h1 class="display-4">{{ amount.teachers }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 py-2">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="rotate">
                            <i class="fa fa-book fa-4x"></i>
                        </div>
                        <h6 class="text-uppercase">Môn học</h6>
                        <h1 class="display-4">{{ amount.subjects }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="animated fadeIn">

	<b-row>
	  <b-col sm="6" lg="3">
		<b-card no-body class="bg-primary">
		  <b-card-body class="pb-0">
			<h4 class="mb-0">9.823</h4>
			<p>Members online</p>
		  </b-card-body>
		</b-card>
	  </b-col>
	  <b-col sm="6" lg="3">
		<b-card no-body class="bg-info">
		  <b-card-body class="pb-0">
			<b-dropdown class="float-right" variant="transparent p-0" right no-caret>
			  <template slot="button-content">
				<i class="icon-location-pin"></i>
			  </template>
			  <b-dropdown-item>Action</b-dropdown-item>
			  <b-dropdown-item>Another action</b-dropdown-item>
			  <b-dropdown-item>Something else here...</b-dropdown-item>
			  <b-dropdown-item disabled>Disabled action</b-dropdown-item>
			</b-dropdown>
			<h4 class="mb-0">9.823</h4>
			<p>Members online</p>
		  </b-card-body>
		</b-card>
	  </b-col>
	  <b-col sm="6" lg="3">
		<b-card no-body class="bg-warning">
		  <b-card-body class="pb-0">
			<b-dropdown class="float-right" variant="transparent p-0" right>
			  <template slot="button-content">
				<i class="icon-settings"></i>
			  </template>
			  <b-dropdown-item>Action</b-dropdown-item>
			  <b-dropdown-item>Another action</b-dropdown-item>
			  <b-dropdown-item>Something else here...</b-dropdown-item>
			  <b-dropdown-item disabled>Disabled action</b-dropdown-item>
			</b-dropdown>
			<h4 class="mb-0">9.823</h4>
			<p>Members online</p>
		  </b-card-body>
		  <card-line3-chart-example
			chartId="card-chart-03"
			class="chart-wrapper"
			style="height:70px;"
			height="70"
		  />
		</b-card>
	  </b-col>
	  <b-col sm="6" lg="3">
		<b-card no-body class="bg-danger">
		  <b-card-body class="pb-0">
			<h4 class="mb-0">9.823</h4>
			<p>Members online</p>
		  </b-card-body>
		</b-card>
	  </b-col>
	</b-row>
    </div>-->
</template>

<script>
export default {
    data() {
        return {
            amount: {
                students: 0,
                classrooms: 0,
                teachers: 0,
                subjects: 0
            }
        };
    },
    created() {
        axios
            .get("/admin/amount")
            .then(res => {
                this.amount = res.data;
            })
            .catch(err => {
                console.log(err.response.data);
            });
    }
};
</script>

<style>

</style>
