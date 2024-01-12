<template>
  <main class="path_main">
    <div class="path_container">
      <h1>DIDA DIDA</h1>
      <RouterLink to="/">
        <div class="front">
          <span>前台</span>
        </div>
      </RouterLink>
      <!-- 尚未建立 -->
      <RouterLink to="/backHome">
        <div class="back">
          <span>後台</span>
        </div>
      </RouterLink>
    </div>
  </main>
</template>

<script>
export default {
  components: {},
  data() {
    return {};
  },
  methods: {},
};
</script>

<style scoped lang="scss">
// @import "@/assets/sass/style.scss";
</style>
