<template>
  <div v-if="loading && this.$store.state.showLoadingOnce">
    <LoadingBox />
  </div>
  <div v-else>
    <div>
      <div class="index">
        <!-- banner + open time ------------------------------------------ -->
        <div class="banner">
          <Carousel autoplay autoplay-speed="4800" dots="none" v-model="value" loop>
            <CarouselItem v-for="i in bannerAll" :key="i.banner_pic">
              <div class="demo-carousel">
                <img :src="i.banner_pic" alt="" />
              </div>
            </CarouselItem>
          </Carousel>
          <p>
            <blingText></blingText>
          </p>
          <lightCircle>
            <template v-slot:circle>
              <div class="open">
                <span>{{ $t("營業時間") }}</span>
                <span id="dropdrop">09:00-17:00</span>
                <!-- 這個id是為了換頁滑動 -->
                <svg x="0px" y="0px" width="200px" height="15px" viewBox="0 0 399.6 15.9">
                  <polyline class="op_line"
                    points="0.1,5.5 58,15.4 118.4,5.5 189.2,5.5 258.7,10.4 368.3,0.5 399.5,7.9 " />
                </svg>
                <span>{{ $t("最後入場") }}</span>
                <span>16:00</span>
              </div>
            </template>
          </lightCircle>
        </div>

        <!-- 今日入園人數 ------------------------------------------ -->
        <div class="entrance">
          <h3Title>
            <template v-slot:h3>
              <h3>{{ $t("今日入園人數") }}</h3>
            </template>
          </h3Title>
          <div class="drop">
            <div class="wave water"></div>
            <div class="wave water"></div>
          </div>
          <p>{{ visitorCount }}{{ $t("人") }}</p>
          <div class="deco turtle">
            <img src="../../public/all_images/deco/deco_turtle.png" alt="" />
          </div>
          <div class="deco fishes">
            <img src="../../public/all_images/deco/deco_fishes.png" alt="" />
          </div>
          <paoPao></paoPao>
        </div>

        <!-- 營業資訊 ------------------------------------------ -->

        <h3Title>
          <template v-slot:h3>
            <h3>{{ $t("票價資訊") }}</h3>
          </template>
        </h3Title>
        <ticketPrice></ticketPrice>
        <router-link to="/ticket"><button>{{ $t("立即購票") }}</button></router-link>

        <!-- 交通指南 ------------------------------------------ -->
        <h3Title>
          <template v-slot:h3>
            <h3>{{ $t("交通指南") }}</h3>
          </template>
        </h3Title>
        <div class="map">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14468.996712784081!2d121.2250227!3d24.9576355!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x346823ea50c732a5%3A0x1b5e6ee66e9fec49!2z57ev6IKyVGliYU1l6ZmE6Kit5Lit5aOi6IG36KiT5Lit5b-D!5e0!3m2!1szh-TW!2stw!4v1690272123794!5m2!1szh-TW!2stw"
            style="border: 0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
          </iframe>
          <div class="text">
            <div class="address">
              <span>{{ $t("地址") }}</span>
              <p>{{ $t("海洋市深海區珊瑚一街404號") }}</p>
            </div>
            <div class="car">
              <span>{{ $t("交通") }}</span>
              <div class="way" v-for="car in car" :key="car.name">
                <p>{{ $t(car.name) }}</p>
                <p>{{ $t(car.content) }}</p>
              </div>
            </div>
          </div>
          <div class="deco">
            <img src="../../public/all_images/deco/deco_fishes.png" alt="" />
          </div>
          <div class="paopao">
            <paoPao_n></paoPao_n>
          </div>
        </div>
        <div class="deco star">
          <img src="../../public/all_images/index/deco_index_star.png" alt="" />
        </div>

        <!-- 熱賣商品 ------------------------------------------ -->
        <h3Title>
          <template v-slot:h3>
            <h3>{{ $t("熱賣商品") }}</h3>
          </template>
        </h3Title>
        <div class="product">
          <div class="item" v-for="(i, index) in prodHomeSlice" :key="index">
            <div class="image">
              <router-link to="/product">
                <img :src="`${this.$store.state.chooseImgSrc}/all_images/product/${i.prod_img}`" alt="" /></router-link>
            </div>
            <div class="content">
              <div class="nub">0{{ index + 1 }}</div>

              <router-link to="/product">
                <h4>{{ i.prod_name }}</h4>
                <div class="text">{{ i.prod_info }}</div>
              </router-link>
              <span>NT$ {{ i.prod_price }}</span>
            </div>

            <div class="paopao">
              <paoPao_n></paoPao_n>
            </div>
          </div>

          <div class="deco shark">
            <img src="../../public/all_images/index/deco_index_shark.png" alt="" />
          </div>
          <div class="deco whale">
            <img src="../../public/all_images/index/deco_index_whale.png" alt="" />
          </div>
        </div>
        <router-link to="/product"><button>{{ $t("更多商品") }}</button></router-link>

        <!-- 活動倒數 ------------------------------------------ -->
        <h3Title>
          <template v-slot:h3>
            <h3>{{ $t("活動倒數") }}</h3>
          </template>
        </h3Title>
        <div class="active">
          <div class="card" v-for="(i, index) in activeAll" :key="i.active_title">
            <div class="item">
              <div class="image">
                <img :src="i.active_img" alt="" />
              </div>
              <div class="text">
                <span class="date">活動時間 : {{ i.active_star }}至{{ i.active_end }}</span>
                <p class="title">{{ i.active_title }}</p>
                <p class="self">{{ i.active_content }}</p>
              </div>
            </div>
            <div class="day">
              <span>倒數</span>
              <span>{{ i.countDown }}</span>
              <span>天</span>
            </div>
          </div>
        </div>

        <!-- 視覺互動 ------------------------------------------ -->

        <div class="game">
          <visual></visual>
        </div>

        <div class="gameBar">
          <div class="rangeCover">
            <input type="range" v-model="lightChang" min="0" max="100" class="slider" />
            <label for="range" id="display">\ 亮度調整{{ lightChang }}% /</label>
          </div>
        </div>
        <div class="gamePhone">
          <div class="square" :style="{ opacity: `${lightChang}%` }"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import visual from "../components/visualGame.vue";
import LoadingBox from "../components/loading.vue";
import h3Title from "../components/h3TitleComponent.vue";
import lightCircle from "../components/lightCircle.vue";
import blingText from "../components/blingText.vue";
import ticketPrice from "../components/ticketPrice.vue";
import paoPao from "../components/paoPao.vue";
import paoPao_n from "../components/paoPao_normal.vue";
import axios from "axios";
// import carousel from 'vue-owl-carousel';

export default {
  name: "HomeView",
  data() {
    return {
      resetVisual: false,
      loading: true,
      animationDuration: 4200,
      value: 0,
      lightChang: 0,
      products: [
        // {
        //   src: require("../assets/images/index_p1.png"),
        //   alt: "index_image1",
        //   nub: "01",
        //   name: "海豚娃娃",
        //   text: "由DIDADIDA深海區最有名的傑尼海龜為造型。",
        //   price: "NT 500",
        // },
        // {
        //   src: require("../assets/images/index_p2.png"),
        //   alt: "index_image2",
        //   nub: "02",
        //   name: "海豚抱枕",
        //   text: "由DIDADIDA深海區最有名的傑尼海龜為造型。",
        //   price: "NT 300",
        // },
        // {
        //   src: require("../assets/images/index_p3.png"),
        //   alt: "index_image3",
        //   nub: "03",
        //   name: "人魚吊飾",
        //   text: "由DIDADIDA深海區最有名的傑尼海龜為造型。",
        //   price: "NT 200",
        // },
      ],
      car: [
        {
          name: "自行開車",
          content: "請於國道10號，海洋交流道下，左轉直行珊瑚一街",
        },
        { name: "搭乘公車", content: "請於海洋市區，搭乘海洋路線777公車" },
        {
          name: "搭乘捷運",
          content: "請搭乘海洋線，於滴答滴答站下車，2號出口",
        },
      ],
      bannerAll: [],
      activeAll: [],
      visitorCount: 0,
      prodHomeSlice: [{ prod_id: 1 }],
      prodHome: [],
    };
  },
  computed: {},
  methods: {},
  components: {
    visual,
    LoadingBox: LoadingBox,
    h3Title,
    lightCircle,
    blingText,
    ticketPrice,
    paoPao,
    paoPao_n,
    // carousel,
  },
  mounted() {
    fetch(`${this.$store.state.APIurl}visitorCount.php`)
      .then(function (response) {
        return response.json();
      })
      .then((data) => {
        const currentDate = new Date();
        console.log(data);
        for (let i = 0; i < data.length; i++) {
          const ticDate = new Date(data[i].tic_date);
          if (
            ticDate.toDateString() === currentDate.toDateString() &&
            data[i].tic_state == "已使用"
          ) {
            this.visitorCount++;
            this.$store.state.visitCount = this.visitorCount;
          }
        }
      });
    setTimeout(() => {
      this.loading = false;
      this.$store.state.showLoadingOnce = false;
    }, this.animationDuration);

    setTimeout(() => {
      this.resetVisual = true;
    }, this.animationDuration + 300);

    // banner接後台
    fetch(`${this.$store.state.APIurl}homePicMg.php`)
      .then(function (response) {
        console.log(response);
        return response.json();
      })

      .then((myJson) => {
        console.log(myJson);
        for (let i = 0; i < myJson.length; i++) {
          myJson[
            i
          ].banner_pic = `${this.$store.state.chooseImgSrc}all_images/banner/${myJson[i].banner_pic}`;
          // :src="`${this.$store.state.chooseImgSrc}/all_images/product/${selectedProduct.prod_img}`
          myJson[i].isDis = true;
        }
        console.log(myJson);
        this.bannerAll = myJson;
      });

    fetch(`${this.$store.state.APIurl}prodHome.php`)
      .then(function (response) {
        return response.json();
      })
      .then((myJson) => {
        // Log the entire response for debugging
        console.log(myJson);

        // Extract SPECICFIC three items ( through indexes) from myJson
        this.prodHomeSlice = myJson.slice(6, 9);
      })
      .catch((error) => {
        console.error("Error:", error);
      });

    // active接後台
    fetch(`${this.$store.state.APIurl}activeSelectFront.php`)
      .then(function (response) {
        console.log(response);
        return response.json();
      })

      .then((myJson) => {
        for (let i = 0; i < myJson.length; i++) {
          myJson[
            i
          ].active_img = `${this.$store.state.chooseImgSrc}/all_images/active/${myJson[i].active_img}`; // 改路徑
          const today = new Date(); // 抓今天日期
          const targetDate = new Date(myJson[i].active_star); // 把純字串變成日期的屬性

          // 计算日期差异的毫秒数
          const timeDiff = targetDate - today; // 未來 - 今天 = 剩餘幾天

          // 计算剩余天数（将毫秒数转换为天数）
          // key:countDown    = 無條件捨去(日期差異) / 毫秒  * 分 * 時 * 天)
          myJson[i].countDown = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
        }
        // console.log(myJson)
        this.activeAll = myJson; //  myJson: 資料庫抓回來的資料
      });
  },
  watch: {
    lightChang(newlightChang) {
      let range = document.querySelector('input[type="range"]');
      let display = document.getElementById("display");
      let rangeWidth = range.offsetWidth; // 使用 offsetWidth 获取 input[type="range"] 元素的宽度
      let min = parseInt(range.min);
      let max = parseInt(range.max);
      let rangeValue = ((newlightChang - min) / (max - min)) * rangeWidth; // 计算滑块的位置
      display.style.left = `${rangeValue}px`;
    },
  },
};
</script>

<style lang="scss" scoped>
.index {
  background-color: map-get($colors, "bgc");
  // background-color: #9fabb1;
  width: 100%;

  h3 {
    @include h3Title();
  }

  .gamePhone,
  .gameBar {
    display: none;
  }

  button {
    display: block;
    margin: 30px auto 80px;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: none;
    color: map-get($colors, "maincolor");
    font-size: 18px;
    background-color: map-get($colors, "h2Blue");
    cursor: pointer;

    box-shadow: 0 0 0 0 rgba(map-get($colors, "h2Blue"), 0.5);
    animation: pulse 1.5s infinite;
  }

  @keyframes pulse {
    0% {
      transform: scale(0.9);
    }

    70% {
      transform: scale(1);
      box-shadow: 0 0 0 30px rgba(map-get($colors, "h2Blue"), 0);
    }

    100% {
      transform: scale(0.9);
      box-shadow: 0 0 0 0 rgba(map-get($colors, "h2Blue"), 0);
    }
  }

  button:hover {
    animation: none;
    box-shadow: inset 0 0 20px map-get($colors, "h2Blue");
  }

  // banner ---------------------------------------------
  .banner {
    width: 100%;
    height: 90vh;

    img {
      max-width: 1920px;
      width: 100%;
    }

    p {
      font-size: 50px;
      color: map-get($colors, "light");
      text-align: center;
      line-height: 80vh;
    }

    // 營業時間 ---------------------------------------------
    .open {
      width: 250px;
      height: 250px;
      border-radius: 50%;
      position: relative;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      z-index: 3;

      svg polyline {
        fill: none;
      }

      .op_line {
        stroke: #9fbdce;
        stroke-width: 3;
        stroke-linecap: round;
        stroke-dasharray: 10, 15;
        stroke-dashoffset: 3;
      }

      span {
        display: block;
        color: map-get($colors, "light");
        font-size: 27px;
      }
    }
  }

  // 今日入園人數 ---------------------------------------------
  .entrance {
    max-width: 1200px;
    width: 100%;
    margin: -100px auto 0;
    position: relative;

    .drop {
      margin: 80px auto;
      width: 250px;
      height: 250px;
      border-radius: 50%;
      border: 10px solid #68769a;
      background-color: #eee;
      border-top-right-radius: 0;
      transform: rotate(-45deg);

      position: relative;
      overflow: hidden;

      .wave {
        transform: rotate(45deg);
        position: absolute;
        bottom: 0px;
        left: 0;
        right: 0;
        width: 100%;
        height: 100px;
        background: url(../../public/all_images/wave.png);
        background-size: 500px 100px;
      }

      .wave.water {
        animation: wave 9s linear infinite;
        animation-delay: 0s;
        margin: 0 -55px;
        opacity: 1;
      }

      .wave.water:nth-child(2) {
        animation: wave 9s linear infinite;
        opacity: 0.6;
        animation-delay: -3s;
        bottom: 12px;
      }

      @keyframes wave {
        0% {
          background-position-x: 0;
        }

        100% {
          background-position-x: 1000px;
        }
      }
    }

    p {
      position: absolute;
      text-align: center;
      font-size: 75px;
      top: 50%;
      left: 0;
      right: 0;
    }

    .deco {
      position: absolute;
      opacity: 0.5;
    }

    .deco.turtle {
      bottom: -140px;
      left: 10px;

      img {
        width: 150%;
      }
    }

    .deco.fishes {
      bottom: -100px;
      right: 30px;

      img {
        width: 120%;
      }
    }
  }

  // 交通指南 ---------------------------------------------
  .map {
    max-width: 1200px;
    width: 100%;
    margin: 0 auto 100px;
    display: flex;
    position: relative;

    iframe {
      width: 60%;
      height: 350px;
      margin-right: 30px;
    }

    .text {
      width: 40%;

      span {
        font-weight: 800;
        display: block;
        background-color: map-get($colors, "secondary");
        color: #eee;
        border-radius: 3px;
        padding: 5px 10px;
        margin: 10px 0;
      }

      .way {
        margin: 20px 0;

        p {
          width: fit-content;

          :first-child {
            font-weight: 800;
            border-bottom: 3px solid map-get($colors, "h2Blue");
            margin-bottom: 5px;
          }

          :last-child {
            margin-bottom: 20px;
          }
        }
      }
    }

    .deco {
      position: absolute;
      top: -200px;
      left: -100px;

      img {
        width: 90%;
        vertical-align: top;
        transform: scaleX(-1);
      }
    }
  }

  // 熱銷商品 ---------------------------------------------
  .product {
    max-width: 1920px;
    margin: auto;
    position: relative;
    overflow: clip;

    .item:nth-child(2) {
      flex-direction: row-reverse;
      text-align: right;
    }

    .item:nth-child(2) .nub {
      margin-left: auto;
    }

    .item {
      max-width: 960px;
      position: relative;
      z-index: 2;
      margin: auto;
      display: flex;
      color: map-get($colors, "mainColor");

      .image {
        margin: 0 50px;
        width: 100%;
        background-color: #eee;
        border-radius: 60% 65% 65% 55%;
      }

      .image img {
        vertical-align: top;
        width: 100%;
      }

      .content {
        margin: auto 0;

        .nub {
          border-bottom: 1px solid map-get($colors, "mainColor");
          font-size: 50px;
          line-height: 1.2;
          width: 55px;
        }

        a {
          color: map-get($colors, "mainColor");
          transition: 0.3s;

          h4 {
            font-size: 20px;
            padding-top: 15px;
          }
        }

        a:hover {
          color: map-get($colors, "hoverColor");
          transition: 0.3s;
        }

        span {
          font-size: 18px;
          line-height: 4;
        }
      }

      .paopao {
        margin-left: 100px;
        margin-right: 100px;
      }
    }

    .deco {
      overflow: clip;
      position: absolute;
      z-index: 1;
    }

    .shark {
      top: 400px;
      left: -10%;
    }

    .whale {
      bottom: -250px;
      right: -20%;
    }
  }

  .deco.star {
    overflow: clip;
    position: absolute;
    top: 110rem;
    right: 0;

    img {
      position: relative;
      left: 50%;
    }
  }

  // 活動倒數 ---------------------------------------------
  .active {
    max-width: 1200px;
    width: 100%;
    margin: 0px auto 100px;

    .item {
      width: 100%;
      height: 230px;
      display: flex;
      background-color: map-get($colors, "secondary");
      border-radius: 10px;
      overflow: hidden;
      // background-image: url(../assets/images/openActive.png);
      // background-repeat: no-repeat;

      .image {
        width: 50%;
        position: relative;
      }

      .image::after {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        border-right: 50px solid #68769a;
        border-bottom: 200px solid #68769a;
        border-top: 200px solid transparent;
        border-left: 50px solid transparent;
      }

      .image img {
        width: 100%;
        height: 100%;
        vertical-align: top;
        object-fit: cover;
      }

      .text {
        width: 50%;
        margin: auto;
        color: map-get($colors, "light");
        text-align: center;
        background-color: #9fbdce;
        background: linear-gradient(80deg, transparent 75px, #68769a 0);

        .date {
          display: block;
          padding-bottom: 25px;
          color: map-get($colors, "mainColor");
        }

        .title {
          font-size: 30px;
        }

        .self {
          font-size: 18px;

          span {
            font-size: 35px;
          }
        }
      }
    }

    .card {
      position: relative;
      margin-bottom: 70px;
    }

    .day {
      position: absolute;
      top: -25px;
      right: -20px;
      width: 110px;
      height: 110px;
      text-align: center;
      background-color: map-get($colors, "light");
      border-radius: 50%;
      padding: 17px 0;

      span {
        line-height: 0.9;
      }
    }

    .day>span:first-child {
      display: block;
    }

    .day>span:nth-child(2) {
      font-size: 80px;
      font-family: "Franklin Gothic Medium", "Arial Narrow", Arial, sans-serif;
    }
  }

  // -- RWD --------------------------------------
  @media screen and (max-width: 768px) {
    .deco {
      display: none;
    }

    //暫時拿掉
    .ticket {
      max-width: 90%;
    }

    .map {
      max-width: 90%;
      flex-wrap: wrap;
      margin: 0 auto 60px;

      iframe {
        width: 100%;
        margin: auto;
      }

      .text {
        width: 100%;
        margin-top: 30px;
      }
    }

    .active {
      max-width: 90%;

      .day {
        width: 90px;
        height: 90px;
        top: -25px;
        right: -20px;
      }

      .text {
        padding-right: 15px;
      }

      .day>span:nth-child(2) {
        font-size: 60px;
      }
    }
  }

  @media screen and (max-width: 415px) {

    .deco,
    .all-circle {
      display: none;
    }

    .banner {
      height: 40vh;
      overflow: hidden;

      img {
        width: 300%;
      }

      p {
        font-size: 35px;
      }
    }

    .entrance {
      margin: 0px auto;
    }

    .map {
      .paopao {
        display: none;
      }
    }

    .product {
      padding: 1px;
      margin: 0 auto;
      // border: 1px solid rgb(26, 16, 97);

      .item:nth-child(2) {
        text-align: left;
      }

      .item {
        flex-wrap: wrap;

        .image {
          width: 100%;

          img {
            width: 100%;
          }
        }

        .content {
          width: 80%;
          margin: 10px auto 35px;
          text-align: center;

          .text {
            text-align: justify;
          }

          .nub {
            // margin: auto;
            position: absolute;
            top: 0;
            left: 50px;
          }

          span {
            line-height: 2.5;
          }
        }
      }

      button {
        margin: 0 auto 50px;
      }
    }

    .active {
      width: 90%;

      .item {
        height: auto;
        flex-wrap: wrap;

        .image {
          width: 100%;
          height: 20vh;
        }

        .image::after {
          border: 0;
        }

        .text {
          width: 90%;
          margin-bottom: 25px;

          .date {
            padding: 15px;
          }

          .title {
            font-size: 25px;
          }

          .self {
            font-size: 15px;

            span {
              font-size: 25px;
            }
          }
        }
      }

      .day {
        top: -25px;
        right: -15px;
        width: 90px;
        height: 90px;
      }
    }

    .game {
      display: none;
    }

    .gameBar {
      display: flex;
      justify-content: center;
      margin: auto;
      // position: relative;

      .rangeCover {
        position: relative;
      }

      input {
        position: relative;
        display: flex;
        margin: 20px auto;
        background-color: map-get($colors, "h2Blue");

        &::before {
          position: absolute;
          content: "Light";
          font-size: 10px;
          top: -5px;
          left: -40px;
        }

        &::after {
          position: absolute;
          content: "Dark";
          font-size: 10px;
          top: -5px;
          right: -40px;
        }
      }

      input[type="range"]::-webkit-slider-thumb {
        appearance: none;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: map-get($colors, "mainColor");
        box-shadow: map-get($colors, "hoverColor") 0 0 10px;
      }

      .slider {
        appearance: none;
        width: 10rem;
        height: 0.25rem;
        outline: none;
        border-radius: 0.25rem;
      }

      label {
        position: absolute;
        top: -30px;
        padding: 5px;
        border-radius: 5px;
        color: #68769a;
        background-color: map-get($colors, "light");
        width: max-content;
        transform: translateX(-45%);
        // white-space: nowrap;

        &::after {
          position: absolute;
          bottom: -20px;
          left: 40%;
          content: "";
          border-top: 10px solid #eee;
          border-right: 10px solid transparent;
          border-bottom: 10px solid transparent;
          border-left: 10px solid transparent;
        }
      }
    }

    .gamePhone {
      display: flex;
      flex-wrap: wrap;
      height: 50vh;
      background-image: url(../../public/all_images/index/gamePhone.jpg);
      background-size: cover;
      background-position: center;

      .square {
        width: 100%;
        height: 100%;
        background-color: rgb(0, 0, 0);
      }
    }
  }
}
</style>
