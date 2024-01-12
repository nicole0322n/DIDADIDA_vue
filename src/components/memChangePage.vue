<template>
    <div class="change_page">
        <button>下一頁</button>
    </div>
</template>

<script>
export default {
    name: "memChangePage",
    components: {

    },
    data() {
        return {

        }
    }
}
</script>

<style scoped lang="scss">
.change_page {
    text-align: center;
    margin-top: -50px;

    button {
        width: 80px;
        height: 30px;
        border: 0;
        border-radius: 5px;
        background-color: map-get($colors, 'h2Blue');
    }
}
</style>