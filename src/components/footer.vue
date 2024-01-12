<template>
  <footer id="footer">
    <div class="footer_wrap">
      <!-- 關於我們 -->
      <div class="footer_item">
        <h3>{{ $t(footerTitle.about) }}</h3>
        <ul>
          <li v-for="about in footer_aboutArray" :key="about">
            <router-link :to="about.link">{{ $t(about.name) }}</router-link>
          </li>
        </ul>
      </div>
      <!-- 最新消息 -->
      <div class="footer_item">
        <h3><router-link to="/news">{{ $t(footerTitle.news) }}</router-link></h3>
      </div>
      <!-- 探索海洋生物 -->
      <div class="footer_item">
        <h3><router-link to="/explore">{{ $t(footerTitle.animal) }}</router-link></h3>
        <ul>
          <li v-for="animal in footer_animalArray" :key="animal">
            <router-link :to="animal.link" @click="changePageMove(animal.name)">{{ $t(animal.name) }}</router-link>
          </li>
        </ul>
      </div>
      <!-- DIDA購物 -->
      <div class="footer_item">
        <h3>{{ $t(footerTitle.buy) }}</h3>
        <ul>
          <li v-for="buy in footer_buyArray" :key="buy">
            <router-link :to="buy.link">{{ $t(buy.name) }}</router-link>
          </li>
        </ul>
      </div>
      <!-- 社群媒體 -->
      <div class="footer_item">
        <h3>{{ $t(footerTitle.media) }}</h3>
        <div>
          <span v-for="media in footer_mediaArray" :key="media"><router-link :to="media.link"><i :class="media.class"
                :style="media.style"></i></router-link></span>
        </div>
      </div>
      <!-- 裝飾 -->
      <div class="deco-right">
        <img src="../../public/all_images/deco/deco_fish.png" alt="" />
      </div>
      <div class="deco-left">
        <img src="../../public/all_images/deco/deco_coral.png" alt="" />
      </div>
    </div>
    <div class="copyright">
      <p>{{$t('本網站為緯育TibaMe_前端設計工程師班CHD103學員專題成果作品,本平台僅供學習、展示之用。若有抵觸有關著作權, 或有第三人主張侵害智慧財產權等情事, 均由學員負法律上責任, 緯育公司概不負責。若有侵權疑慮, 您可以私訊')}} <a href="https://www.facebook.com/TibaMe">{{$t('[緯育]')}}</a>{{$t(', 後續會由專人協助處理。')}}</p>
    </div>
  </footer>
</template>

<script>
// @ is an alias to /src
import HelloWorld from "@/components/HelloWorld.vue";

export default {
  name: "HomeView",
  components: {
    HelloWorld,
  },
  data() {
    return {
      footerTitle: {
        about: "關於DIDA",
        news: "最新消息",
        animal: "探索海洋生物",
        buy: "DIDA商城",
        media: "社群媒體",
      },
      footer_aboutArray: [
      { link: "/about", name: "關於我們" },
        { link: "/faq", name: "常見問答" },
        { link: "/guide", name: "園區導覽" },
        { link: "/interact", name: "互動遊戲" },
      ],
      footer_animalArray: [
        { link: "#", name: "表層海洋帶" },
        { link: "#", name: "中層海洋帶" },
        { link: "#", name: "深層海洋帶" },
        { link: "#", name: "深淵層海洋帶" },
        { link: "#", name: "超深淵層海洋帶" },
      ],
      footer_buyArray: [
        { link: "/product", name: "DIDA購物" },
        { link: "/ticket", name: "DIDA購票" },
      ],
      footer_mediaArray: [
        {
          link: "#",
          class: "fa-brands fa-square-facebook",
          style: "color: #eeeeee",
        },
        { link: "#", class: "fa-brands fa-instagram", style: "color: #eeeeee" },
        { link: "#", class: "fa-brands fa-youtube", style: "color: #eeeeee" },
      ],
    };
  },
  methods: {
    changePageMove(name) {
      if (name == "表層海洋帶") {
        // this.$router.push({ path: '/product', query: { article: 'footer' } });
        this.$router.push({ path: "/explore", query: { article: "one" } });
        setTimeout(() => {
          // 获取滚动目标元素
          const target = document.getElementById("one");

          // 滚动到目标元素
          if (target) {
            target.scrollIntoView({ behavior: "smooth" });
          }
        }, 100);
      } else if (name == "中層海洋帶") {
        this.$router.push({ path: "/explore", query: { article: "two" } });
        setTimeout(() => {
          // 获取滚动目标元素
          const target = document.getElementById("two");

          // 滚动到目标元素
          if (target) {
            target.scrollIntoView({ behavior: "smooth" });
          }
        }, 100);
      } else if (name == "深層海洋帶") {
        this.$router.push({ path: "/explore", query: { article: "three" } });
        setTimeout(() => {
          // 获取滚动目标元素
          const target = document.getElementById("three");

          // 滚动到目标元素
          if (target) {
            target.scrollIntoView({ behavior: "smooth" });
          }
        }, 100);
      } else if (name == "深淵層海洋帶") {
        this.$router.push({ path: "/explore", query: { article: "four" } });
        setTimeout(() => {
          // 获取滚动目标元素
          const target = document.getElementById("four");

          // 滚动到目标元素
          if (target) {
            target.scrollIntoView({ behavior: "smooth" });
          }
        }, 100);
      } else if (name == "超深淵層海洋帶") {
        this.$router.push({ path: "/explore", query: { article: "five" } });
        setTimeout(() => {
          // 获取滚动目标元素
          const target = document.getElementById("five");

          // 滚动到目标元素
          if (target) {
            target.scrollIntoView({ behavior: "smooth" });
          }
        }, 100);
      }
    },
  },
};
</script>
<style scoped lang="scss">
// @import "~@/assets/scss/base/reset.scss";

footer {
  width: 100%;
  padding: 190px 0;
  background-color: map-get($colors, "mainColor");
  position: relative;

  .footer_wrap {
    max-width: 960px;
    width: 100%;
    margin: 0 auto 35px;
    display: flex;
    justify-content: space-between;
    overflow: hidden;

    h3 {
      color: #eee;
      margin: 55px 0 25px;
      font-size: map-get($fontSizes, "nav");
    }

    a {
      color: #eee;
      text-decoration: none;
      transition: 0.3s;
    }

    a:hover {
      color: map-get($colors, hoverColor);
      transition: 0.3s;
    }

    li {
      margin: 10px 0;
    }
  }

  p {
    width: 100%;
    max-width: 960px;
    color: #eee;
    margin: auto;
    font-size: map-get($fontSizes, "mini");
    line-height: 1.5;
    text-align: center;
    padding: 0 0 25px;
    a{
      text-decoration: none;
      color: map-get($colors, 'QRbtn');
    }
  }

  .footer_item {
    span {
      margin-right: 8px;
      font-size: 17px;
    }
  }

  .deco-right {
    position: absolute;
    bottom: 0;
    right: 0;

    img {
      vertical-align: bottom;
      width: 200px;
    }
  }

  .deco-left {
    position: absolute;
    bottom: 0;
    left: 0;

    img {
      vertical-align: bottom;
      width: 170px;
    }
  }

  @media screen and (max-width: 768px) {
    
  
    .footer_wrap {
        width: 100%;
        flex-wrap: wrap;
        justify-content: center;
      h3{
        margin: auto;
      }
        .footer_item{
          margin: 1em 0;
          width: 50%;
          text-align: center;
          &:nth-of-type(5){
            width: 100%;
            span{
              width: 100%;
              font-size: 30px;
              margin: 0 0.5em;
            }
          }
        }
      }
  }
}
</style>
