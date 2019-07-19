<template>
    <div v-html="input" class="editor-output" ref="mathJaxEl"></div>
</template>

<script>
export default {
    props: ["input"],
    watch: {
        input: _.debounce(function(e) {
            this.$nextTick(function() {
                MathJax.Hub.Queue(["Typeset", MathJax.Hub, "editor-output"]);
            });
        }, 300)
    },
    mounted() {
        MathJax.Hub.Queue(["Typeset", MathJax.Hub, this.$refs.mathJaxEl]);
    }
};
</script>

<style>
.editor-output img {
    display: block;
    margin: auto;
}
.editor-output p {
    display: inline;
}
</style>
