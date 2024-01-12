<template>
  <div class="interact" id="mainpart">
    <!-- 這個id是為了換頁滑動 -->
    <div class="titleAll">
      <interactBtn
        @click="showQuiz"
        :quiz1="$t(quizz)"
        class="titleChangeBtn"
        @mouseenter="onMouseEnter(1)"
        @mouseleave="onMouseLeave(1)"
        :class="{ changeHoverColor: isHover }"
      ></interactBtn>
      <interactBtn
        @click="showLaba"
        :laba1="$t(labaa)"
        class="titleChangeBtn"
        @mouseenter="onMouseEnter(2)"
        @mouseleave="onMouseLeave(2)"
        :class="{ changeHoverColor: isHover2 }"
      ></interactBtn>
      <!-- <span >問卷</span>
      <span >拉霸</span> -->
    </div>
    <div class="mainpart" >
      <quiz2 v-if="isQuiz"></quiz2>
      <laba v-if="isLaba"></laba>
    </div>
    <!-- <button @click="this.$route.path('../')"></button> -->
    <div class="deco">
      <memAreaBG></memAreaBG>
    </div>
  </div>
</template>
<script>
import quiz2 from "../components/quiz2.vue";
import laba from "../components/laba.vue";
import interactBtn from "../components/interactBtn.vue";
import memAreaBG from "../components/memAreaBG.vue";

export default {
  name: "product",
  data() {
    return {
      alreadyHoverColor: "#ccc",
      isHover: true,
      isHover2: false,
      isQuiz: true,
      isLaba: false,
      quizz: "問卷",
      labaa: "拉霸",
    };
  },
  props: {},
  components: {
    laba,
    quiz2,
    interactBtn,
    memAreaBG,
  },
  computed: {},
  watch: {},
  methods: {
    onMouseLeave(idx) {
      if (idx == 1 && !this.isQuiz) {
        this.isHover = false;
      } else if (idx == 2 && !this.isLaba) {
        this.isHover2 = false;
      }
    },
    onMouseEnter(idx) {
      if (idx == 1) {
        this.isHover = true;
      } else {
        this.isHover2 = true;
      }
    },
    showQuiz() {
      this.isQuiz = true;
      this.isLaba = false;
      this.$store.state.questionPic = true;

      this.isHover2 = false;
    },
    showLaba() {
      this.isQuiz = false;
      this.isLaba = true;
      this.isHover = false;
      this.isHover2 = true;
    },
  },
  mounted() {},
};
</script>
<style lang="scss" scoped>
*{
  background-color: #1D3D5B;
}
.body{
  background-color: #1D3D5B;
}
.interact {
  position: relative;
  overflow: hidden;
  .titleAll {
    z-index: 50;
    // border: 1px red solid;
    background-color: #1d3d5b;
    display: flex;
    justify-content: center;
    align-items: center;
    span {
      border: 1px black solid;
      padding: 10px;
      cursor: pointer;
    }
    .titleChangeBtn {
      margin: 15px;
    }
    .changeHoverColor {
      background-color: #1fb0cb;
    }
  }
  .mainpart {
    // display: flex;
    background-color: #1D3D5B;
  }
  .deco {
    background-color: #1d3d5b;
    z-index: 0;
    width: 100%;
    position: absolute;
    top: 70%;
    left: 0;
  }
}

@media screen and (max-width: 414px){
  .deco{
    display: none;
  }
}
</style>
