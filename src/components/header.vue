<template>
  <div class="header">
    <div class="wrap" :style="{
      'background-color': headerColor,
      top: 0,
      left: 0,
      'z-index': 8,
      width: '100%',
    }">
      <!-- logo -->

      <!-- this.checkLogoPic = false; -->
      <div :class="{ logo: !checkLogoPic, logoChange: checkLogoPic }">
        <router-link to="/" v-if="!checkLogoPic"><img :src="`${this.$store.state.chooseImgSrc}/all_images/logo_all.svg`"
            alt="" /></router-link>
        <router-link to="/" v-if="checkLogoPic"><img :src="`${this.$store.state.chooseImgSrc}/all_images/logo_half.svg`"
            alt="" /></router-link>
      </div>

      <nav class="main-nav" :style="{ color: markColor }">
        <!-- 關於我們 -->
        <div class="main-menu">
          <router-link to="/about">{{ $t(menuTitle.about) }}</router-link>
          <ul class="sub-menu">
            <li v-for="aboutSub in aboutSub" key="aboutSub">
              <router-link :to="aboutSub.link">{{
                $t(aboutSub.name)
              }}</router-link>
            </li>
          </ul>
        </div>

        <!-- 最新消息 -->
        <div class="main-menu">
          <router-link to="/news">{{ $t(menuTitle.news) }}</router-link>
        </div>

        <!-- 探索海洋生物 -->
        <div class="main-menu">
          <router-link to="/explore">{{ $t(menuTitle.animal) }}</router-link>
          <ul class="sub-menu">
            <li v-for="animalSub in animalSub" key="animalSub">
              <router-link :to="animalSub.link" @click="changePageMove(animalSub.name)">{{ $t(animalSub.name)
              }}</router-link>
            </li>
          </ul>
        </div>

        <!-- DIDA商城 -->
        <div class="main-menu">
          <a>{{ $t(menuTitle.buy) }}</a>
          <ul class="sub-menu">
            <li v-for="buySub in buySub" key="buySub">
              <router-link :to="buySub.link">{{ $t(buySub.name) }}</router-link>
            </li>
          </ul>
        </div>

        <!-- 會員登入 -->
        <div class="icons">
          <span>
            <i @click="this.$store.state.storeShowLogin = true" v-if="!this.$store.state.userName"
              class="fa-solid fa-user" style="color: #eee"></i>
            <div v-if="this.$store.state.userName" @click="this.$router.push('./member')" style="color: #eee"
              class="name">
              {{ this.$store.state.userName }}
            </div>
            <span v-if="this.$store.state.userName" @click="logOutAPI()" class="logOutBtn">{{ $t('登出') }}</span>
          </span>

          <!-- 購物車 -->
          <router-link to="/shoppingcart" class="cart"><i class="fa-solid fa-cart-shopping" style="color: #eee"></i>
            <span class="cart-count" v-if="this.$store.state.userName">{{ cartItemCount }}</span></router-link>
        </div>
        <!-- 語言切換 -->
        <div class="select">
          <select v-model="selectedLanguage" @change="changeLanguage">
            <option value="zh-TW">繁體中文</option>
            <option value="en">English</option>
            <!-- 添加其他支持的語言選項 -->
          </select>
          <span><i class="fa-solid fa-chevron-down" style="color: #eeeeee"></i></span>
        </div>
      </nav>
      <!-- 手機menu -->

      <div class="rwd_menu">
        <span class="rwd_member">
          <i @click="this.$store.state.storeShowLogin = true" v-if="!this.$store.state.userName" class="fa-solid fa-user"
            style="color: #eee"></i>
          <div v-if="this.$store.state.userName" @click="this.$router.push('./member')" style="color: #eee" class="name">
            {{ this.$store.state.userName }}
          </div>
          <span v-if="this.$store.state.userName" @click="logOutAPI()" class="logOutBtn">登出</span>
        </span>
        <div class="navigation">
          <input type="checkbox" class="navigation__checkbox" id="nav-toggle" />
          <label for="nav-toggle" class="navigation__button">
            <span class="navigation__icon" aria-label="toggle navigation menu"></span>
          </label>
          <div class="navigation__background"></div>

          <nav class="navigation__nav" role="navigation">
            <ul class="navigation__list">
              <div class="btn_wrap">
                <div class="icons">
                  <!-- 購物車 -->
                  <router-link class="cart" to="/shoppingcart" @click="closeMobileMenu"><i
                      class="fa-solid fa-cart-shopping" style="color: #eee"></i><span class="cart-count"
                      v-if="this.$store.state.userName">{{ cartItemCount
                      }}</span>
                  </router-link>
                </div>
                <div class="select">
                  <select v-model="selectedLanguage" @change="changeLanguage">
                    <option value="zh-TW">繁體中文</option>
                    <option value="en">English</option>
                    <!-- 添加其他支持的語言選項 -->
                  </select>
                  <span><i class="fa-solid fa-chevron-down" style="color: #eeeeee"></i></span>
                </div>
              </div>
              <!-- 關於DIDA -->
              <li class="navigation__item">
                <a @click="toggleDropdown('about')">{{
                  $t(menuTitle.about)
                }}</a>
                <ul class="dropdown" v-if="showAboutDropdown">
                  <router-link to="/about" @click="closeMobileMenu">{{ $t('關於我們') }}</router-link>
                  <li v-for="aboutSub in aboutSub" key="aboutSub">
                    <router-link :to="aboutSub.link" @click="closeMobileMenu">{{
                      $t(aboutSub.name)
                    }}</router-link>
                  </li>
                </ul>
              </li>
              <!-- 最新消息 -->
              <li class="navigation__item">
                <router-link to="/news" @click="closeMobileMenu">{{
                  $t(menuTitle.news)
                }}</router-link>
              </li>
              <!-- 探索海洋 -->
              <li class="navigation__item">
                <router-link to="/explore" @click="closeMobileMenu">{{
                  $t(menuTitle.animal)
                }}</router-link>
              </li>
              <!-- 購物 -->
              <li class="navigation__item">
                <a @click="toggleDropdown('buy')">{{ $t(menuTitle.buy) }}</a>
                <ul class="dropdown" v-if="showBuyDropdown">
                  <li v-for="buySub in buySub" key="buySub">
                    <router-link :to="buySub.link" @click="closeMobileMenu">{{
                      $t(buySub.name)
                    }}</router-link>
                  </li>
                </ul>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src

export default {
  name: "HomeView",
  components: {},
  data() {
    return {
      markColor: "#eee",
      checkLogoPic: false,
      headerColor: "rgba(35, 45, 71, 0)",
      headerPosition: "relative",
      showAboutDropdown: false,
      showBuyDropdown: false,
      // markColor: '#333',
      menuTitle: {
        about: "關於DIDA",
        news: "最新消息",
        animal: "探索海洋生物",
        buy: "DIDA商城",
      },
      aboutSub: [
        //  { link: "/about", name: "關於我們" },
        { link: "/faq", name: "常見問答" },
        { link: "/guide", name: "園區導覽" },
        { link: "/interact", name: "互動遊戲" },
      ],
      animalSub: [
        { link: "/#", name: "表層海洋帶" },
        { link: "/#", name: "中層海洋帶" },
        { link: "/#", name: "深層海洋帶" },
        { link: "/#", name: "深淵層海洋帶" },
        { link: "/#", name: "超深淵層海洋帶" },
      ],
      buySub: [
        { link: "/product", name: "DIDA購物" },
        { link: "/ticket", name: "DIDA購票" },
      ],
      icon: [
        {
          link: "#",
          eAlt: "會員登入icon",
          imgSrc: '<i class="fa-solid fa-user" style="color: #eeeeee;"></i>',
        },
        {
          link: "#",
          eAlt: "購物車icon",
          imgSrc:
            '<i class="fa-solid fa-cart-shopping" style="color: #eeeeee;"></i>',
        },
      ],
      selectedLanguage: "zh-TW", // 默認語言
      // language: [
      //   {
      //     option: "繁體中文",
      //   },
      //   {
      //     option: "英文",
      //   },
      // ],
    };
  },
  watch: {
    "$route.query"(nVal, oVal) {
      //   console.log(nVal);
    },
  },
  mounted() {
    window.addEventListener("scroll", this.handleScroll);
  },
  beforeDestroy() {
    window.removeEventListener("scroll", this.handleScroll);
  },
  computed: {
    cartItemCount() {
      return this.$store.getters.cartItemCount;
    },
  },
  methods: {
    haederMark(name) {
      if (name == "最新消息") {
        this.markColor = "#57a3f3";
      } else {
        this.markColor = "#eee";
      }
    },
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
    logOutAPI() {
      fetch("https://tibamef2e.com/cgd103/g1/api/postMemberLogout.php")
        .then((res) => res.json())
        .then((json) => console.log(json));
      this.$store.state.userName = "";
      this.$store.state.shoppingCart = [];
      this.$store.state.favoList = [];
      this.$store.state.ticketList = [];
      this.$store.state.totalScorePoint = 0;

      if (this.$route.path == "/member") {
        this.$router.push("/");
      }
    },
    handleScroll(event) {
      // console.log(event);
      // console.log(window.scrollY);
      if (window.scrollY == 0) {
        this.headerColor = "rgba(35, 45, 71, 0)";
        this.checkLogoPic = false;
      } else {
        this.headerColor = "rgba(35, 45, 71, 1)";
        this.checkLogoPic = true;
      }
    },
    toggleDropdown(menuType) {
      // 根據不同的子選單類型來判斷是否展開或收起
      if (menuType === "about") {
        this.showAboutDropdown = !this.showAboutDropdown;
        // 如果展開about子選單，則收起buy子選單
        this.showBuyDropdown = false;
      } else if (menuType === "buy") {
        this.showBuyDropdown = !this.showBuyDropdown;
        // 如果展開buy子選單，則收起about子選單
        this.showAboutDropdown = false;
      }
    },
    closeMobileMenu() {
      const checkbox = document.getElementById("nav-toggle");
      if (checkbox) {
        checkbox.checked = false;
      }
      this.showAboutDropdown = false;
      this.showBuyDropdown = false;
    },
    changeLanguage() {
      // 使用i18n的setLocale方法来切换语言
      this.$i18n.locale = this.selectedLanguage;
    },
    // toFooter(){
    //     this.$router.push({ path: '/product', query: { article: 'footer' } });
    //     this.$router.push({path:'/', query:{section : 'footer' }})
    // }
  },
};
</script>
<style scoped lang="scss">
// @import "~@/assets/scss/base/reset.scss";

.wrap {
  display: flex;
  max-width: 100vw;
  justify-content: space-between;
  padding: 10px 20px;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 3;
  transition: 1s;

  // logo 樣式
  .logoChange {
    width: 50px;
    transition: 1s;

    img {
      vertical-align: top;
      width: 100%;
    }
  }

  .logo {
    width: 80px;
    transition: 1s;

    img {
      vertical-align: top;
      width: 100%;
    }
  }

  // 選單樣式
  .main-nav {
    display: flex;
    justify-content: center;
    align-items: center;

    select {
      @include selectBtn;
    }
  }

  .main-nav a {
    line-height: 1.8;
    padding: 10px;
    text-decoration: none;
    color: white;
    font-size: map-get($fontSizes, "nav");
  }

  .main-menu {
    position: relative;
    margin: 0 10px;
    display: flex;
    justify-content: center;
  }

  .main-menu a.router-link-exact-active {
    color: #b6e3d8;
  }

  // 子選單樣式
  .sub-menu {
    visibility: hidden;
    text-align: center;
    position: absolute;
    top: 40px;
    padding: 10px 0;
    background-color: rgba(101, 101, 101, 0.6);
    backdrop-filter: blur(3px);
    border-radius: 2px;
    transform: translateY(-1em);
    transition: all 0.3s ease-in-out 0s, visibility 0s linear 0.3s,
      z-index 0s linear 0.01s;

    li:nth-child(4) {
      width: 140px;
      // width: fit-content;
    }
  }

  .main-menu:hover .sub-menu {
    visibility: visible;
    transform: translateY(0%);
    transition-delay: 0s, 0s, 0.3s;
  }

  .sub-menu a:hover {
    color: map-get($colors, hoverColor);
  }
}

.wrap.show {
  background-color: map-get($colors, mainColor);
}

select {
  background-color: #fff;
  border: none;
  border-radius: 20px;
  padding: 10px;
  font-size: map-get($fontSizes, "p");
  cursor: pointer;
  /* background-image:url(imgs/Vector.png) ;
              background-position: right center; */
  /* appearance: none; */
  /* -moz-appearance: none; */
  width: 150px;
}

.icons {
  cursor: pointer;

  .name {
    display: inline-block;
    margin-right: 10px;
    border-bottom: 1px solid #eee;
  }

  .name:hover {
    color: map-get($colors, "hoverColor");
    border-bottom: 1px solid map-get($colors, "hoverColor");
  }

  span {
    .logOutBtn {
      // border: 1px red solid;
      color: white;
    }
  }
}

.select {
  @include btnWidth;

  span {
    @include btnSpan;
  }
}

/* 滑鼠懸停時的樣式 */
select:hover {
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}

/* 選擇狀態的樣式 */
select:focus {
  outline: none;
  border: 2px solid map-get($colors, hoverColor);
}

/* 下拉選項樣式 */
option {
  background-color: #2c3e50;
  color: #eee;
}

/* 選擇的下拉選項樣式 */
option:checked {
  background-color: map-get($colors, hoverColor);
  color: #fff;
}

.rwd_menu {
  display: none;
}

.cart {
  position: relative;

  .cart-count {
    position: absolute;
    top: -8px;
    right: -8px;
    background-color: rgb(231, 61, 61);
    color: #fff;
    border-radius: 50%;
    padding: 2px 7px;
    font-size: 12px;
  }
}

@media screen and (max-width: 767px) {
  .wrap {
    .main-nav {
      display: none;
    }

    .btn_wrap {
      width: 75%;
      margin: auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-direction: row-reverse;
      margin-bottom: 2rem;

      .icons {
        font-size: map-get($fontSizes, "div");
        width: 20%;

        i {
          font-size: 1.4rem;
        }
      }

      select {
        @include selectBtn;
      }

      /* Remove IE arrow */
      select::-ms-expand {
        display: none;
      }

      /* Custom Select wrapper */
      .select {
        @include btnWidth;

        span {
          @include btnSpan;
        }
      }

      option {
        background-color: #2c3e50;
      }
    }

    .rwd_menu {
      width: 80%;
      display: flex;
      align-items: start;
      justify-content: end;

      .rwd_member {
        height: 100%;
        display: flex;
        align-items: center;
        margin-right: 1rem;
        cursor: pointer;

        .name {
          margin: 0 1rem;
          border-bottom: 1px solid #fff;
        }

        .logOutBtn {
          color: #fdfdfd;
          margin-right: 0.5rem;
        }

        i {
          width: 100%;
          font-size: 1.3rem;
          margin-right: 1.3rem;
        }
      }

      .navigation {
        height: 100%;
        display: flex;
        position: relative;
        z-index: 7;
      }

      .navigation__checkbox {
        display: none;
      }

      .navigation__button {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        border-radius: 50%;
        z-index: 8;
        cursor: pointer;

        span {
          display: inline-block;
        }
      }

      .navigation__background {
        position: absolute;
        max-height: 100vh;
        max-width: 100vw;
        inset: 0;
        opacity: 0;
        border-radius: 50%;
        background: map-get($colors, "mainColor");
        z-index: 4;
        transition: all 0.8s cubic-bezier(0.86, 0, 0.07, 1);
      }

      .navigation__nav {
        position: fixed;
        inset: 0;
        max-width: 100%;
        max-height: 100%;
        opacity: 0;
        visibility: hidden;
        z-index: 4;
        transition: all 1s cubic-bezier(0.68, -0.55, 0.265, 1.55) -0.2s;
      }

      .navigation__list {
        position: relative;
        text-align: center;
        top: 15%;
        width: 100%;
        height: 85%;
      }

      .navigation__item {
        margin: 1.5rem 0;
        padding: 0.5rem 0;
        position: relative;

        a {
          display: inline-block;
          width: 100%;
          text-decoration: none;
          color: map-get($colors, "light");
          font-size: map-get($fontSizes, "h5");
          font-weight: 600;
        }

        .dropdown {
          position: absolute;
          width: 90%;
          top: 120%;
          left: 5%;
          margin: auto;
          background-color: map-get($colors, "h2Blue");
          border-radius: 2rem;
          transform: translateY(-1em);
          transition: all 0.3s ease-in-out 0s, visibility 0s linear 0.3s;
          z-index: 2;

          >li {
            margin: 1rem 0;
          }

          a {
            width: 100%;
            font-size: map-get($fontSizes, "div");
            color: map-get($colors, "dark");
          }
        }
      }

      // menu字
      .navigation__link:link,
      .navigation__link:visited {
        display: inline-block;
        padding: 1rem 2rem;
        text-transform: uppercase;
        color: map-get($colors, "light");
        font-size: 2.4rem;
        text-decoration: none;
        transition: all 0.2s;
      }

      // menu字

      .navigation__checkbox:checked~.navigation__background {
        transform: scale(80);
        opacity: 1;
      }

      .navigation__checkbox:checked~.navigation__nav {
        width: 100%;
        visibility: visible;
        opacity: 1;
      }

      .navigation__icon {
        position: relative;
        margin: auto;

        &::before {
          top: -0.7rem;
        }

        &::after {
          top: 0.7rem;
        }
      }

      .navigation__icon,
      .navigation__icon::before,
      .navigation__icon::after {
        height: 100%;
        width: 2rem;
        height: 2px;
        background-color: #eef6f7;
      }

      .navigation__icon::before,
      .navigation__icon::after {
        content: "";
        position: absolute;
        left: 0;
        transition: all 200ms;
      }

      //menu叉叉
      .navigation__checkbox:checked+.navigation__button .navigation__icon {
        background-color: transparent;
        box-shadow: none;
      }

      .navigation__checkbox:checked+.navigation__button .navigation__icon::before {
        top: 0;
        transform: rotate(135deg);
      }

      .navigation__checkbox:checked+.navigation__button .navigation__icon::after {
        top: 0;
        transform: rotate(-135deg);
      }
    }
  }
}

@media screen and (max-width: 415px) {
  .wrap .logo {
    transition: 1s;

    img {
      width: 60%;
    }
  }

  .cart {
    .cart-count {
      top: -15px;
      right: -15px;
    }
  }
}
</style>
