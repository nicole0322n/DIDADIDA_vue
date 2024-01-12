<template>
  <path1 v-if="!this.$store.state.chooseFrontBack"></path1>
  <header1
    v-if="
      !$route.meta.hideApp &&
      $store.state.chooseFrontBack &&
      $route.path !== '/path'
    "
  ></header1>
  <wave
    v-if="
      !$route.meta.hideApp &&
      !$route.meta.hideWave &&
      $route.path !== '/path' &&
      $store.state.chooseFrontBack
    "
  ></wave>
  <helper
    v-if="
      !$route.meta.hideApp &&
      $store.state.chooseFrontBack &&
      $route.path !== '/path'
    "
  ></helper>
  <login v-if="!$route.meta.hideApp && $store.state.chooseFrontBack"></login>

  <!-- 
  <nav>
    <router-link to="/?aa=123">Home</router-link> |
    <router-link to="/about">About</router-link>
  </nav> -->
  <router-view v-if="this.$store.state.chooseFrontBack" />
  <!-- <button @click="loginAPI">商品目錄</button>
  <button @click="loginAPI2">登入</button> -->
  <footer1
    v-if="
      !$route.meta.hideApp &&
      this.$store.state.chooseFrontBack &&
      $route.path !== '/path'
    "
  ></footer1>
  <span id="firstPage"></span>
</template>

<style lang="scss" scoped>
// @import "~@/assets/scss/base/variables.scss";
//區域使用範例

.demo-logo {
  width: 50px;

  img {
    width: 100%;
  }
}

.colorcolor {
  color: $privecolor;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>

<script>
import header1 from "@/components/header.vue";
import footer1 from "@/components/footer.vue";
import wave from "@/components/wave.vue";
import login from "@/components/login.vue";
import helper from "@/components/helper.vue";
import path1 from "@/views/Path.vue";
export default {
  data() {
    return {
      breadcrumbList: [
        {
          title: "面包屑",
        },
      ],
      apiKey: "1f6646a3927d488d95974940231609",
      showHeader: true,
      // showWave: false,
    };
  },
  watch: {},

  components: {
    header1,
    footer1,
    wave,
    login,
    helper,
    path1,
  },
  mounted() {
    // this.$router.push("/?section=hide");
  },
  watch: {
    "$route.query"(nVal, oVal) {
      console.log("新的值", nVal.section);
      console.log("舊的值", oVal.section);

      // if (nVal.section !== "hide") {
      //   this.showWave = true;
      // } else {
      //   this.showWave = false;
      // }
    },
  },
  computed: {
    showWave() {
      return this.$route.name !== "home";
    },
  },
  methods: {
    loginAPI() {
      console.log("login");
      // https://tibamef2e.com/cgd103/g1/api/getProducts.php?order=prod_name&limit=9&page=1
      fetch(
        "https://tibamef2e.com/cgd103/g1/api/getProducts.php?order=prod_name&limit=9&page=1"
      )
        .then((res) => res.json())
        .then((json) => console.log(json));
    },
    loginAPI2() {
      // console.log("login2");
      // [post]前台登入
      // https://tibamef2e.com/cgd103/g1/api/getConfirmMember.php
      // mem_account : charmy101@gmail.com
      // mem_psw : 1"
      let input = {
        mem_account: "charmy101@gmail.com",
        mem_psw: "charmy101",
      };
      fetch(
        `${this.$store.state.loginURL}/getConfirmMember.php`,
        // "https://tibamef2e.com/cgd103/g1/api/getConfirmMember.php"
        {
          method: "POST",
          // body: new URLSearchParams(input),
          body: new URLSearchParams({
            mem_account: "charmy101@gmail.com",
            mem_psw: "charmy101",
          }),
        }
      )
        .then((res) => res.json())
        .then((json) => console.log(json));
    },
  },
};
</script>
