<script>
import { Bar } from "vue-chartjs";

export default {
    extends: Bar,
    props: ["chartData"],
    data: () => ({
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    }),

    mounted() {
        console.log(this.chartData);
        this.renderChart(this.chartData, this.options);
    },
    created() {
        console.log("Hello");
    }
};
</script>