<template>
    <section>
        <vs-row vs-justify="center">
            <vs-col type="flex" vs-justify="center" vs-align="center" vs-w="4" vs-xs="12">
                <tweet :tweet-data="tweet" v-for="tweet in this.data" :key="tweet.id_str"></tweet>
            </vs-col>
        </vs-row>
    </section>
</template>

<script>
    export default {
        props: {
            data: {
                type: Array,
                default: null
            }
        },
        data: function () {
            return {

            }
        },
        created() {
            // console.log(this.data)
        }
    }
</script>

<style scoped>

</style>