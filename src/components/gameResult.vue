<template>
  <div class="resultAll">
    <div class="imgDiv">
      <img :src="require('../../public/all_images/dr.dolphin.png')" alt="" />
    </div>
    <div class="finalAnsAll">
      <div class="ansTitle">{{$t('恭喜完成問卷!')}}</div>
      <div class="getPoint" v-if="this.$store.state.userName">
        您共獲得{{ this.$store.state.quizScore }}點紅利點數!
      </div>
      <div></div>
    </div>
    <router-link to="/member" class="toPoint" v-if="this.$store.state.userName"
      >我的紅利點數 >
    </router-link>
  </div>
</template>

<script>
export default {
  name: "gameResult",
  data() {
    return {};
  },
  mounted() {},
  methods: {},
  computed: {},
};
</script>
<style scoped lang="scss">
.resultAll {
  @include LQ;
  display: flex;
  border: 3px dashed #a7cbec;
  // background-color: rgb(10,10,10,0.2);
  padding: 40px;
  border-radius: 5px;
  justify-content: center;
  align-items: center;
  position: relative;
  .imgDiv {
    width: 100px;
    height: 100px;
    margin-right: 20px;
    // background-color: aqua;
    img {
      width: 100%;
    }
  }
  .finalAnsAll {
    margin-left: 50px;
    .ansTitle {
      font-size: map-get($fontSizes, "h4");
      font-weight: 700;
    }
    .getPoint {
      font-size: map-get($fontSizes, "p");
    }
  }
  .toPoint {
    position: absolute;
    bottom: 10px;
    right: 20px;
  }
}
@media screen and (max-width: 414px) {
    .resultAll {
      flex-direction: row; /* 在小屏幕下保持横向排列 */
      
      width: 100%;
    }

    .imgDiv {
      display: none;
    }

    .finalAnsAll {
      margin:auto  0;
      flex-direction: row;
    .ansTitle{
      width: 180px;
    }
    .getPoint{
      width: 200px;
      margin-right: 20px;
    }
    .toPoint {
      position: static; /* 在小屏幕下取消绝对定位 */
      margin-top: 10px;
      margin: auto;
    }
  }
  }
  
</style>
