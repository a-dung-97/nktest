<template>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <h6 class="mt-5" v-if="tests.length==0">Bạn chưa có kì thi nào sắp diễn ra</h6>
            <div class="col-md-5" v-for="(test) in tests" :key="test.id">
                <div class="card">
                    <div class="card-header bg-primary">{{ test.name }}</div>
                    <div class="card-body">
                        <p class="card-text">
                            <b>Thời gian bắt đầu:</b>
                            {{ test.start_at }}
                        </p>
                        <p class="card-text">
                            <b>Thời gian làm bài:</b>
                            {{ test.time }}
                        </p>
                        <router-link
                            tag="button"
                            class="btn btn-secondary btn-block"
                            :disabled="test.distance>0||test.isFinished"
                            @click="startCountdown"
                            :ref="'btn-'+test.id"
                            :to="'tests/'+test.id"
                        >
                            <countdown
                                :time="test.distance"
                                @end="activeTest(test.id)"
                                :transform="transform"
                                v-if="test.distance>=0"
                                :ref="'countdown-'+test.id"
                            >
                                <template
                                    slot-scope="props"
                                >{{ props.totalDays }}:{{ props.hours }}:{{ props.minutes }}:{{ props.seconds }}</template>
                            </countdown>
                            <span :ref="'span-'+test.id" v-show="test.distance<0">Bắt đầu thi</span>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import countdown from "@chenfengyuan/vue-countdown";
export default {
    components: { countdown },
    data() {
        return {
            status: {},
            counting: true,
            tests: []
        };
    },
    methods: {
        startCountdown: function() {
            this.counting = true;
        },
        handleCountdownEnd: function() {
            this.counting = false;
        },
        handleCountdownProgress(data) {
            //console.log(data.seconds);
        },
        async getTests() {
            let tests = await axios.get("/student/tests");
            this.tests = tests.data.data;
            this.tests.forEach(test => {
                test["distance"] = new Date(test.start_at) - new Date();
                this.status[test.id] = true;
                console.log(test);
                console.log(this.status);
            });
        },
        transform(props) {
            Object.entries(props).forEach(([key, value]) => {
                // Adds leading zero
                const digits = value < 10 ? `0${value}` : value;

                // uses singular form when the value is less than 2

                props[key] = `${digits}`;
            });

            return props;
        },
        activeTest(id) {
            console.log(this.$refs["span-" + id]);
            this.$refs["btn-" + id][0].$el.disabled = false;
            this.$refs["countdown-" + id][0].$el.classList.add("d-none");
            this.$refs["span-" + id][0].classList.add("d-inline");
        }
    },
    created() {
        this.getTests();
    }
};
</script>

<style>
</style>
