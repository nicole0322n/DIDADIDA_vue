<template>
    <div>
        <select name="" id="" v-model="selectedState">
            <option v-for="(item, index) in stateSelect" :key="index" :value="item.value">{{ item.option }}</option>
        </select>
    </div>
</template>
    
<script>
export default {
    data() {
        return {
            stateSelect: [{ option: "狀態", value: "" }, { option: "上架", value: "1" }, { option: "下架", value: "0" }],
            selectedState: "",
        };
    },
    emits: ["state"],
    watch: {
        selectedState(newValue, oldValue) {
            this.$emit("state", this.selectedState);
        },
    },
};
</script>
    
<style scoped lang="scss">
 select{
      border: none;
      outline: none;
      font-size: 14px;
      cursor: pointer;
      background-color: transparent;
      color: #515a6e;
    }
</style>
    