<template>
  <div class="count">
    <input class="minus" value="-" @click="decrement" />
    <input v-model="value" type="number" />
    <input class="plus" value="+" @click="increment" />
  </div>
</template>

<script>
export default {
  data() {
    return {
      value: 0, // 输入框的值
    };
  },
  methods: {
    // 减少值
    decrement() {
      if (this.value > 0) {
        this.value -= 1;
      }
    },
    // 增加值
    increment() {
      this.value += 1;
    },
  },
};
</script>

<style scoped>
.input {
  width: 27px;
  border: 0;
  text-align: center;
  background-color: #96bacf;
  font-size: 16px;
  height: 27px;
}
.count {
  display: flex;
  height: fit-content;
}

.count > * {
  width: 30px;
  background-color: #96bacf;
  text-align: center;
  outline: none;
  border: none;
  /* padding: 0.5em; */
  width: 27px;
  overflow: hidden;
}

.count .btn {
  cursor: pointer;
}

.minus {
  border-radius: 1em 0 0 1em;
  width: 27px;
  border: 0;
  color: black;
  text-align: center;
  background-color: #96bacf;
  font-size: 15px;
  -moz-appearance: textfield;
}

.plus {
  border-radius: 0 1em 1em 0;
  width: 27px;
  border: 0;
  color: black;
  text-align: center;
  background-color: #96bacf;
  font-size: 15px;
  -moz-appearance: textfield;
}

input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type="number"] {
  /* firefox */
  -moz-appearance: textfield;
}
</style>
