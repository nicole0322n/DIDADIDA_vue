<template>
  <slot name="h3"></slot>
</template>

<script>
export default {
  name: "h3Title",
  data() {
    return {};
  },
  mounted() {},
  methods: {},
  computed: {},
};
</script>
<style lang="scss" scoped>
h3 {
  width: fit-content;
  margin: 0px auto;
  font-size: 200px;
  border-bottom: 3.5px solid #9fbdce;
}

h3::after {
  content: "";
  border: 2px solid #9fbdce;
  display: block;
  margin: 0 0 6px;
}
</style>
