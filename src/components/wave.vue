<template>
  <div class="banner_pic" :style="{ backgroundImage: `url(${banner_pic})` }">
    <div class="bannerTitle">
      <h1>{{ h1Name }}</h1>
      <h2>{{ h2Name }}</h2>
    </div>
    <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28"
      preserveAspectRatio="none" shape-rendering="auto">
      <defs>
        <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v30h-355z"></path>
      </defs>
      <g class="parallax">
        <use xlink:href="#gentle-wave" x="48" y="0" :fill="waveColor1" />
        <use xlink:href="#gentle-wave" x="48" y="3" :fill="waveColor2" />
        <use xlink:href="#gentle-wave" x="48" y="7" :fill="waveColor3" />
      </g>
    </svg>
  </div>
</template>

<script>
export default {
  name: "son",
  data() {
    return {
      h1Title: "",
      h2Title: "",
      // waveColor1: "rgba(255,255,255,0.6)",
      // waveColor2: "rgba(70, 130, 191,0.7)",
      // waveColor3: "#fff",
    };
  },
  computed: {
    waveColor1() {
      return "rgba(255,255,255,0.6)";
    },
    waveColor2() {
      return "rgba(70, 130, 191,0.7)";
    },
    waveColor3() {
      return this.$route.path === "/about" ? "#68769a" : (this.$route.path === "/interact" ? "#1D3D5B" : "#fff");
    },
    h1Name() {
      return this.$route.path == "/product"
        ? "周邊商品"
        : this.$route.path == "/explore"
          ? "探索海洋生物"
          : this.$route.path == "/news"
            ? "最新消息"
            : this.$route.path == "/about"
              ? "關於我們"
              : this.$route.path == "/member"
                ? "會員中心"
                : this.$route.path == "/guide"
                  ? "園區導覽"
                  : this.$route.path == "/interact"
                    ? "互動遊戲"
                    : this.$route.path == "/faq"
                      ? "常見問答"
                      : this.$route.path == "/shoppingcart"
                        ? "購物車"
                        : this.$route.path == "/ticket"
                          ? "購買票券"
                          : "";
    },
    h2Name() {
      return this.$route.path == "/product"
        ? "Products"
        : this.$route.path == "/explore"
          ? "Explore"
          : this.$route.path == "/news"
            ? "News"
            : this.$route.path == "/about"
              ? "AboutUs"
              : this.$route.path == "/member"
                ? "Member"
                : this.$route.path == "/guide"
                  ? "Guide"
                  : this.$route.path == "/interact"
                    ? "Interaction"
                    : this.$route.path == "/faq"
                      ? "FAQs"
                      : this.$route.path == "/shoppingcart"
                        ? "Cart"
                        : this.$route.path == "/ticket"
                          ? "Tickets"
                          : "";
    },
    // waveColor3() {
    //   return this.$route.path == "/about" ? "#333" : "#fff";
    // },
    banner_pic() {
      return this.$route.path == "/product"
        ? `${this.$store.state.chooseImgSrc}/all_images/banner/products.jpg`
        : // ? "/all_images/cenote-280252_1920.jpg"
        this.$route.path == "/explore"
          ? `${this.$store.state.chooseImgSrc}/all_images/banner/explore.jpg`
          : // ? "/all_images/cenote-280252_1920.jpg"
          this.$route.path == "/news"
            ? `${this.$store.state.chooseImgSrc}/all_images/banner/news_banner.jpg`
            : // ? "/all_images/banner/news_banner.jpg"
            this.$route.path == "/about"
              ? `${this.$store.state.chooseImgSrc}/all_images/banner/about.jpg`
              : // ? "/all_images/banner/about.jpg"
              this.$route.path == "/member"
                ? `${this.$store.state.chooseImgSrc}/all_images/banner/mem_center.jpg`
                : // ? "/all_images/cenote-280252_1920.jpg"
                this.$route.path == "/guide"
                  ? `${this.$store.state.chooseImgSrc}/all_images/banner/guide_banner.jpg`
                  : // ? "/all_images/banner/guide_banner.jpg"
                  this.$route.path == "/interact"
                    ? `${this.$store.state.chooseImgSrc}/all_images/banner/interact_banner.jpg`
                    : // ? "/all_images/cenote-280252_1920.jpg"
                    this.$route.path == "/faq"
                      ? `${this.$store.state.chooseImgSrc}/all_images/banner/faq.jpg`
                      : // ? "/all_images/cenote-280252_1920.jpg"
                      this.$route.path == "/shoppingcart"
                        ? `${this.$store.state.chooseImgSrc}/all_images/banner/cart.jpg`
                        : // ? "/all_images/cenote-280252_1920.jpg"
                        this.$route.path == "/ticket"
                          ? `${this.$store.state.chooseImgSrc}/all_images/banner/tickets.jpg`
                          : // ? "/all_images/cenote-280252_1920.jpg"
                          "";
    },
  },

  // watch: {
  //   "$route.path"(nVal, oVal) {
  //     console.log(nVal);
  //     console.log(oVal);
  //     if (nVal == "/about" || nVal == "/explore") {
  //       this.waveColor3 = "rgba(255,255,255,0)";
  //     } else {
  //       this.waveColor3 = "#fff";
  //     }
  //   },
  // },
  mounted() {
    // if (this.$route.path == "/about") {
    //   this.waveColor3 = "#68769a";
    // }
    // this.setWaveColors();
  },

};
</script>
<style scoped lang="scss">
// .parallax use {
//   &:nth-child(1) {
//     fill: rgba(255,255,255,0.6);
//   }

//   &:nth-child(2) {
//     fill: rgba(70, 130, 191,0.7);
//   }

//   &:nth-child(3) {
//     fill: #fff;
//   }
// }

.banner_pic {
  height: 90vh;
  position: relative;
  background-position: center;
  background-size: cover;
  display: flex;
  justify-content: center;
  align-items: center;

  .bannerTitle {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    color: map-get($colors, "light");


    h1 {
      border-bottom: 1px solid map-get($colors, "light");
      font-size: map-get($fontSizes, "h2");
      letter-spacing: 2px;
    }



    h2 {
      font-size: map-get($fontSizes, "h3");
      letter-spacing: 2px;
    }
  }
}

.waves {
  position: absolute;
  bottom: 0;
  width: 100%;
  height: 15%;
  vertical-align: top;
}

/* Animation */

.parallax>use {
  animation: move-forever 20s cubic-bezier(0.55, 0.6, 0.59, 0.5) infinite;
}

.parallax>use:nth-child(1) {
  animation-delay: -2s;
  animation-duration: 15s;
}

.parallax>use:nth-child(2) {
  animation-delay: -4s;
  animation-duration: 10s;
}

.parallax>use:nth-child(3) {
  animation-delay: -6s;
  animation-duration: 18s;
}

@keyframes move-forever {
  0% {
    transform: translate(-90px, 0);
  }

  100% {
    transform: translate(85px, 0);
  }
}

@media (max-width: 768px) {
  .waves {
    height: 40px;
    min-height: 40px;
  }
}
</style>
