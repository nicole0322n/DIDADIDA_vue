<template>
  <div class="controlResult" v-if="title1">
    <div class="resultPic">
      <img
        :src="imgSrc1"
        alt=""
        class="isOpacity"
        :class="{ notOpacity: finalShow1 }"
      /> 
    </div>
    <div class="resultPost">
      <div class="isOpacity postTitle" :class="{ notOpacity: finalShow1 }">
        {{ title1 }}是您的幸運星
      </div>
      <div class="isOpacity postText" :class="{ notOpacity: finalShow1 }">
        {{ post1 }}
      </div>
      <div
        class="isOpacity postPoint"
        :class="{ notOpacity: finalShow1 }"
        v-if="this.$store.state.userName"
      >
        您共獲得{{ point1 }}點紅利點數!
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      imgSrcGet: "",
      imgSrcArr: [
        
        "../../public/all_images/laba/bluewhale.jpg",
        "../../public/all_images/laba/bluewhale.jpg",
        "../../public/all_images/laba/jellyfish.jpg",
        "../../public/all_images/laba/dolphin.jpg",
        "../../public/all_images/laba/sailfish.jpg",
        "../../public/all_images/laba/whiteshark.jpg",
      ],
    };
  },
  props: ["imgSrc1", "title1", "post1", "point1", "finalShow1"],
  methods: {
    updateLabaScore() {
      this.$store.commit("setLabaScore", this.labaScore);
    },
  },
  mounted() {
    window.addEventListener("load", this.updateLabaScore);
  },
  beforeDestroy() {
    window.removeEventListener("load", this.updateLabaScore);
  },
  computed: {
    labaScore() {
      return parseInt(this.point1);
    },
    getSrc() {
      //   if (this.point1 == "15") {
      //     return this.imgSrcArr[0];
      //   }
      //   return this.point1 == "15"
      //     ? (this.imgSrcGet = this.imgSrcArr[0])
      //     : this.point1 == "30"
      //     ? (this.imgSrcGet = this.imgSrcArr[1])
      //     : this.point1 == "50"
      //     ? (this.imgSrcGet = this.imgSrcArr[2])
      //     : this.point1 == "5"
      //     ? (this.imgSrcGet = this.imgSrcArr[3])
      //     : "";
    },
  },
  components: {},
};
</script>
<style scoped lang="scss">
.controlResult {
  // background-color: #fff;
  background: linear-gradient(45deg,#1D3D5B ,#1D3D5B,#3F91AB,);
  width: 65%;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px #1fb0cb solid;
  border-radius: 10px;
  color: white;
  margin: 50px 0px;
  padding: 20px;
  .isOpacity {
    opacity: 0;
    transition: 1s;
  }
  .notOpacity {
    opacity: 1;
    transition: 1s;
  }
  .resultPic {
    width: 150px;
    height: 150px;
    img {
      border-radius: 50%;
      width: 100%;
    }

    // === rwd === //
    @media screen and (max-width: 768px) {
      display: none;
    }
  }
  .resultPost {
    // border: 1px red solid;
    padding: 0 25px;

    .postTitle {
      font-size: map-get($fontSizes, "h4");
      font-weight: bold;
      margin: 10px 0px;
    }
    .postText {
      letter-spacing: 1px;
      margin-bottom: 15px;
    }
    .postPoint {
      color: rgb(215, 79, 79);
      font-size: map-get($fontSizes, "span");
    }
  }
}
@media screen and (max-width: 414px){
  .controlResult{
    width: 100%;
  }
}
</style>
