<template>
  <div class="content" id="app">
    <div
      v-for="(item, index) in cardItems"
      :key="index"
      class="card"
      :id="'card' + index"
    >
      <div class="carousel">
        <!-- <Carousel v-model="item.value" arrow="never" dots="none" autoplay>
          <CarouselItem v-for="(imgSrc, index) in item.imgSrc" :key="index">
            <transition name="fade">
              <img :src="imgSrc" v-show="index === item.value" />
            </transition>
          </CarouselItem>
        </Carousel> -->
        <div class="imgBox">
          <div v-if="boxPic == 1" :key="1">
            <img
              :src="imgSrc"
              alt=""
              :key="index"
              v-for="(imgSrc, index) in item.imgSrc"
              :class="{
                disappearOpacity: boxOpactiy == 1,
                showOpacity: boxShowOpacity == 1,
              }"
            />
          </div>

          <div v-else-if="boxPic == 2" :key="2">
            <img
              :src="imgSrc"
              alt=""
              :key="index"
              v-for="(imgSrc, index) in item.imgSrc2"
              :style="{ opacity: fst }"
              :class="{
                disappearOpacity: boxOpactiy == 2,
                showOpacity: boxShowOpacity == 2,
              }"
            />
          </div>

          <div v-else-if="boxPic == 3" :key="3">
            <img
              :src="imgSrc"
              alt=""
              :key="index"
              v-for="(imgSrc, index) in item.imgSrc3"
              :style="{ opacity: fst }"
              :class="{
                disappearOpacity: boxOpactiy == 3,
                showOpacity: boxShowOpacity == 3,
              }"
            />
          </div>
        </div>
      </div>
      <div class="text">
        <h3>{{ $t(item.title) }}</h3>
        <p>{{ $t(item.description) }}</p>
      </div>
      <div class="bubble" v-if="item.bubble">
        <img src="../../public/all_images/about/bubble.png" alt="泡泡圖" />
      </div>
      <div class="whale" v-if="item.whale">
        <img src="../../public/all_images/about/whale.svg" alt="鯨魚小插件" />
      </div>
      <div class="star" v-if="item.star">
        <img src="../../public/all_images/about/star.svg" alt="海星小插件" />
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "AboutView",
  data() {
    return {
      fst: true,
      boxPic: 1,
      boxOpactiy: 0,
      boxShowOpacity: 1,
      cardItems: [
        {
          currentImageIndex: 0,
          value: 0,
          imgSrc: [
            require("../../public/all_images/about/about1.png"),
            // require("../../public/all_images/about/about1-2.png"),
            // require("../../public/all_images/about/about1-3.png"),
          ],
          imgSrc2: [require("../../public/all_images/about/about1-2.png")],
          imgSrc3: [require("../../public/all_images/about/about1-3.png")],
          altText: "關於我們第一張圖",
          title: "與海洋世界的美好相遇",
          description:
            "我們是一個致力於讓人們更深入了解海洋的環境與生態的地方。秉持著經營公共事業的嚴謹服務精神，以海洋為核心主題，融合休閒、娛樂、養生、教育、環保和文化等多元特質，成為頂級國際休閒勝地。",
          bubble: false,
          whale: false,
          star: false,
        },
        {
          value: 0,
          imgSrc: [
            require("../../public/all_images/about/about2.png"),
            // require("../../public/all_images/about/about2-2.png"),
            // require("../../public/all_images/about/about2-3.png"),
          ],
          imgSrc2: [require("../../public/all_images/about/about2-2.png")],
          imgSrc3: [require("../../public/all_images/about/about2-3.png")],
          altText: "關於我們第二張圖",
          title: "跨域合作的研究活動",
          description:
            "在這裡可以近距離觀察到令人驚嘆的海洋生物，探索海洋的奧秘。只有真正了解海洋的價值和重要性，才能夠更好的保護它。因此我們通過生動的展覽、互動體驗和教育活動，將海洋科學帶入您的生活中。您可以在這裡探索各種海洋生物、觸摸海洋的心跳，並參與各種互動體驗。",
          bubble: false,
          whale: true,
          star: false,
        },
        {
          value: 0,
          imgSrc: [
            require("../../public/all_images/about/about3.png"),
            // require("../../public/all_images/about/about3-2.png"),
            // require("../../public/all_images/about/about3-3.png"),
          ],
          imgSrc2: [require("../../public/all_images/about/about3-2.png")],
          imgSrc3: [require("../../public/all_images/about/about3-3.png")],
          altText: "關於我們第三張圖",
          title: "參與海洋保育計畫",
          description:
            "我們的目標不僅僅是提供娛樂，更是啟發人們保護我們的藍色星球，與環保組織合作，參與海洋保育計畫，並持續努力減少我們的環境足跡。希望通過我們的努力，能夠促進人們對海洋保護的關注，並鼓勵大家共同努力，為地球的未來做出貢獻。",
          bubble: true,
          whale: false,
          star: true,
        },
      ],
    };
  },
  computed: {
    currentImage() {
      return this.cardItems[0].imgSrc[this.currentImageIndex];
    },
  },
  mounted() {
    setTimeout(() => {
      this.boxOpactiy += 1;
    }, 1000);
    setInterval(() => {
      if (this.boxPic >= 3) {
        this.boxPic = 1;
      }
      this.boxPic += 1;
      setTimeout(() => {
        if (this.boxShowOpacity >= 3) {
          this.boxShowOpacity = 1;
        }
        this.boxShowOpacity += 1;
      }, 500);
      setTimeout(() => {
        if (this.boxOpactiy >= 3) {
          this.boxOpactiy = 1;
        }
        this.boxOpactiy += 1;
      }, 1500);
    }, 3000);
    // setInterval(() => {
    //   if (this.boxShowOpacity >= 3) {
    //     this.boxShowOpacity = 1;
    //   }
    //   this.boxShowOpacity += 1;
    //   setTimeout(() => {
    //     if (this.boxOpactiy >= 3) {
    //       this.boxOpactiy = 1;
    //     }
    //     this.boxOpactiy += 1;
    //   }, 2500);
    // }, 1500);
  },

  methods: {
    changeLanguage() {
      // 使用i18n的setLocale方法来切换语言
      this.$i18n.locale = this.selectedLanguage;
    },
  },
};
</script>

<style scoped lang="scss">
.imgBox {
  div {
    img {
      transition: opacity 1.5s;
      opacity: 0;
    }
    .disappearOpacity {
      opacity: 0 !important;
    }
    .showOpacity {
      opacity: 1;
    }
  }
}
.content {
  background-color: map-get($colors, "secondary");
  overflow: hidden;
}

.card {
  display: flex;
  flex-direction: row-reverse;
  justify-content: center;
  align-items: center;
  padding: 20px;
  margin-bottom: 10px;
}

.card h3 {
  margin: 0 auto;
}
.card:nth-child(2) {
  display: flex;
  flex-direction: row;
  position: relative;
}

.whale {
  width: 20%;
  position: absolute;
  bottom: -161px;
  left: -70px;
}

.bubble {
  position: absolute;
  bottom: -120px;
  left: 100px;
  // border:1px solid black;
}
.card .bubble img {
  width: 50%;
  animation: bubble-ani 8s linear both;
  // transform: translate(20px, 30px);
}
@keyframes bubble-ani {
  0% {
    transform: translateY(0%);
  }
  100% {
    transform: translateY(-100%);
  }
}

.card .text {
  color: white;
  padding: 90px 0px;
  line-height: 2;
  width: 60%;
  margin: 0px 15px;
}

/* 泡泡 */
.card .text img {
  width: 10%;
}

.card h3 {
  font-size: map-get($fontSizes, "h3");
}

.card p {
  font-size: map-get($fontSizes, "p");
  max-width: 500px;
  margin: auto;
}

.card img {
  width: 40%;
  // margin: 0 20px;
  /* border: 2px solid black; */
}

.card .img:nth-child(3) {
  transform: translateX(20px);
}

.star {
  width: 30%;
  // transform: translate(600px, 150px);
  transform: translate(1em, 120px);
}
@media screen and (max-width: 768px) {
  .card {
    flex-direction: column;
    padding: 20px;
  }
  .card h3 {
    font-size: map-get($fontSizes, "h4");
  }
  .bubble {
    position: absolute;
    width: 5%;
    bottom: -100px;
    left: 100px;
    // border:1px solid black;
  }

  .card .text {
    color: white;
    // padding: 40px;
    line-height: 2;
    width: 100%;
    align-items: center;
  }
  /* 泡泡 */
  .card .text img {
    width: 10%;
  }
  .card img {
    width: 80%;
    margin: 30px;
  }
  .card p {
    font-size: map-get($fontSizes, "p");
    width: 100%;
    margin: auto;
  }

  .card:nth-child(2) {
    flex-direction: column;
    position: relative;
  }
  .whale {
    display: none;
  }
  /* .bubble {
                position: absolute;
                top: 300px;
                right: 100px;
            } */
  .card .star img {
    width: 20%;
    margin: 30px;
    transform: translate(0px, -150px);
  }
}
.carousel {
  width: 40%;
  @media screen and (max-width: 768px) {
    width: 80%;
  }
  .ivu-carousel-item {
    width: 100%;
    img {
      width: 100%;
      margin: 0;
    }
  }
  .imgBox {
    width: 100%;
    img {
      width: 100%;
    }
  }
}
</style>
