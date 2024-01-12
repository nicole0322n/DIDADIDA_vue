<template>
    <div class="search">
        <input type="search" :placeholder="txt" v-model="searchInput">
        <i class="fa-solid fa-magnifying-glass"></i>
    </div>
</template>
<script>
export default {
    data() {
        return {
            searchInput: ""
        };
    },
    props: {
        txt: String
    },
    methods: {
        handleSearch(e) {
            console.log(e.target.value)
            this.searchInput = e.target.value
        },
    },
    watch: {
        searchInput(newValue, oldValue) {
            // 在这里可以处理选项变化的逻辑
            console.log("新选项：", newValue);
            console.log("this.searchInput", this.searchInput);
            this.$emit("transferSearch", this.searchInput);
        },
    },
};
</script>

<style scoped lang="scss">
.search {
    position: relative;
    width: 25%;

    input[type="search"] {
        border: 1px solid #494f50;
        border-radius: 5px;
        padding: 0.2rem;
        outline: none;
        width: 100%;
        letter-spacing: 0.1em;
        transition: all .3s;
        &:focus{
            color: #494f50;
            background-color: rgba(230, 234, 243, 0.861);
            border: #62a8ed 1.5px solid;
        }
    }

    input[type="search"]:focus~i{
        color: #4e584c;
    }

    i {
        color: #c3beb8;
        position: absolute;
        right: 4px;
        top: 5.5px;
        font-size: 1.2rem;
    }
}
</style>