<template>
  <!-- 小幫手 -->
  <div class="helperAll">
    <button class="noselect" @click="top" ref="scrollTopButton" v-if="show">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="24"
        height="24"
        viewBox="0 0 24 24"
      >
        <path
          d="M0 16.67l2.829 2.83 9.175-9.339 9.167 9.339 2.829-2.83-11.996-12.17z"
        />
      </svg>
    </button>
    <div class="item" @click="moveShowText">
      <div class="circular">
        <svg viewBox="0 0 100 100">
          <path d="M 0,50 a 50,50 0 1,1 0,1 z" id="circle" />
          <text>
            <textPath href="#circle">DOCTER DIDA</textPath>
          </text>
        </svg>
      </div>
      <img :src="require('../../public/all_images/doctor dida.png')" alt="" />
    </div>
  </div>

  <div
    class="showWindow"
    :style="{ transform: showText ? 'translateX(0px)' : 'translateX(1000px)' }"
  >
    <div class="windowBtnAll">
      <!-- <div v-for="i in helperText">
        <div>{{ i.smart_que }}</div>
      </div> -->
      <div @click="moveAddress">園區地址</div>
      <div @click="moveWeatherMax">今日溫度</div>
      <div @click="moveMaxT">降雨機率</div>
      <div @click="moveClosed">{{ helperAsk1 }}</div>
      <div @click="moveBonus">{{ helperAsk2 }}</div>
      <div @click="moveVisitors">{{ helperAsk3 }}</div>
    </div>
    <div class="rspbox">
      <div
        class="sayHelloTxt"
        v-if="
          !(
            showAddress ||
            showWeatherMax ||
            showMaxT ||
            showClosed ||
            showBonus ||
            showVisitors
          )
        "
      >
        {{ sayHelloTxt }}
      </div>
      <div class="response" v-if="showAddress">
        地址 : {{ locationName }}中壢區復興路46號9樓
      </div>
      <div class="response" v-if="showWeatherMax">
        天氣現象 : {{ weatherWX }} 最高氣溫 : {{ weatherMaxT }}度
      </div>
      <div class="response" v-if="showMaxT">降雨機率 : {{ weatherPop }}%</div>
      <div class="response" v-if="showClosed">
        休館日為
        <span v-for="i in closedtime">{{ i }}, </span>也可至<router-link
          :to="checkdate.link"
          @click="changePageMove(checkdate.name)"
          >購票頁面</router-link
        >查看日曆喔!
      </div>
      <div class="response" v-if="showBonus">
        可至<router-link
          :to="interact.link"
          @click="changePageMove(interact.name)"
          >互動頁面</router-link
        >{{ bonus }}
      </div>
      <div class="response" v-if="showVisitors">
        參考<router-link :to="droper.link" @click="changePageMove(droper.name)"
          >首頁水滴</router-link
        >{{ visitors }}{{ this.$store.state.visitCount }}人喔~
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "helper",
  data() {
    return {
      // 桃園市
      locationName: "",
      //   天氣現象
      weatherWX: "",
      //   最高溫度
      weatherMaxT: 0,
      //   降雨機率
      weatherPop: 0,
      closedtime: "",
      bonus: "",
      visitors: "",
      showText: false,
      showAddress: false,
      showWeatherMax: false,
      showMaxT: false,
      showClosed: false,
      showBonus: false,
      showVisitors: false,
      sayHelloTxt: "",
      intervalId: "",
      helperAsk1: "",
      helperAsk2: "",
      helperAsk3: "",
      droper: { link: "/", name: "首頁水滴" },
      interact: { link: "/interact", name: "互動頁面" },
      checkdate: { link: "/ticket", name: "購票頁面" },
      show: false,
    };
  },
  created() {},
  mounted() {
    // fetch("http://localhost/dida_project/public/php/helperMg.php").then(
    //   async (rsp) => {
    //     this.helperText = await rsp.json();
    //   }
    // );
    fetch(`${this.$store.state.APIurl}helperMg.php`)
      // fetch("http://localhost/dida_project/public/php/helperMg.php")
      .then(function (response) {
        return response.json();
      })
      .then((myJson) => {
        this.helperAsk1 = myJson[0].smart_que;
        this.helperAsk2 = myJson[1].smart_que;
        this.helperAsk3 = myJson[2].smart_que;
        // this.closedtime = myJson[0].smart_ans;
        this.bonus = myJson[1].smart_ans;
        this.visitors = myJson[2].smart_ans;
      });
    fetch(`${this.$store.state.APIurl}helperCloseDaySelect.php`)
      // fetch("http://localhost/dida_project/public/php/helperMg.php")
      .then(function (response) {
        return response.json();
      })
      .then((data) => {
        this.closedtime = data;
        console.log("this.closedtime", this.closedtime);
        return this.closedtime;
      })
      .then((data) => {
        let catchDate = [];
        for (let i = 0; i < data.length; i++) {
          // console.log(this.closedtime[i].close_date);
          let [year, month, day] = data[i].close_date.split("-");
          catchDate.push({ month, day });
        }
        let resDate = [];
        for (let i = 0; i < catchDate.length; i++) {
          let x = `${catchDate[i].month}/${catchDate[i].day}`;
          resDate.push(x);
        }
        console.log(catchDate);
        this.closedtime = resDate;
      });
    fetch(
      "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-AA300EC1-31BA-465E-B669-6CA2C320A195"
    )
      .then(function (response) {
        return response.json();
      })
      .then((myJson) => {
        console.log(
          myJson.records.location[13].weatherElement[1].time[2].parameter
            .parameterName
        );
        this.weatherPop =
          myJson.records.location[13].weatherElement[1].time[2].parameter.parameterName;
        this.weatherMaxT =
          myJson.records.location[13].weatherElement[4].time[2].parameter.parameterName;
        this.weatherWX =
          myJson.records.location[13].weatherElement[0].time[2].parameter.parameterName;
        this.locationName = myJson.records.location[13].locationName;
      });

    window.addEventListener("scroll", this.scrollShow);
  },
  beforeDestroy() {
    window.removeEventListener("scroll", this.scrollShow);
  },
  methods: {
    moveShowText() {
      clearInterval(this.intervalId);
      this.showText = !this.showText;
      if (!this.showText) {
        this.sayHelloTxt = "";
      }
      this.showWeatherMax = false;
      this.showMaxT = false;
      this.showAddress = false;
      this.showClosed = false;
      let hello = ["您", "好", "今", "天", "想", "問", "點", "什", "麼", "?"];
      this.sayHelloTxt = ""; // 將文字重置為空字串
      this.intervalId = setInterval(() => {
        if (hello.length > 0) {
          this.sayHelloTxt += hello.shift();
        }
      }, 150);
    },
    moveAddress() {
      this.showWeatherMax = false;
      this.showMaxT = false;
      this.showAddress = true;
      this.showClosed = false;
      this.showBonus = false;
      this.showVisitors = false;
    },
    moveWeatherMax() {
      this.showWeatherMax = true;
      this.showMaxT = false;
      this.showAddress = false;
      this.showClosed = false;
      this.showBonus = false;
      this.showVisitors = false;
    },
    moveMaxT() {
      this.showWeatherMax = false;
      this.showMaxT = true;
      this.showAddress = false;
      this.showClosed = false;
      this.showBonus = false;
      this.showVisitors = false;
    },
    moveClosed() {
      this.showWeatherMax = false;
      this.showMaxT = false;
      this.showAddress = false;
      this.showClosed = true;
      this.showBonus = false;
      this.showVisitors = false;
    },
    moveBonus() {
      this.showWeatherMax = false;
      this.showMaxT = false;
      this.showAddress = false;
      this.showClosed = false;
      this.showBonus = true;
      this.showVisitors = false;
    },
    moveVisitors() {
      this.showWeatherMax = false;
      this.showMaxT = false;
      this.showAddress = false;
      this.showClosed = false;
      this.showBonus = false;
      this.showVisitors = true;
    },
    // 回到上方按鈕 -----------------------
    top() {
      const buttonElement = this.$refs.scrollTopButton;
      const buttonOffsetTop = buttonElement.offsetTop;
      const delay = 300;
      this.showText = false;
      setTimeout(() => {
        window.scrollTo({ top: buttonOffsetTop, behavior: "smooth" });
      }, delay);
    },
    changePageMove(name) {
      if (name == "首頁水滴") {
        this.$router.push({ path: "/", query: { id: "dropdrop" } });
        setTimeout(() => {
          // 获取滚动目标元素
          const target = document.getElementById("dropdrop");

          // 滚动到目标元素
          if (target) {
            target.scrollIntoView({ behavior: "smooth" });
          }
        }, 100);
      } else if (name == "互動頁面") {
        this.$router.push({ path: "/interact", query: { id: "mainpart" } });
        setTimeout(() => {
          // 获取滚动目标元素
          const target = document.getElementById("mainpart");

          // 滚动到目标元素
          if (target) {
            target.scrollIntoView({ behavior: "smooth" });
          }
        }, 100);
      } else if (name == "購票頁面") {
        this.$router.push({ path: "/ticket", query: { id: "checkdate" } });
        setTimeout(() => {
          // 获取滚动目标元素
          const target = document.getElementById("checkdate");

          // 滚动到目标元素
          if (target) {
            target.scrollIntoView({ behavior: "smooth" });
          }
        }, 100);
      }
    },
    scrollShow(event) {
      if (window.scrollY < 500) {
        this.show = false;
      } else {
        this.show = true;
      }
    },
  },
  computed: {},
};
</script>
<style scoped lang="scss">
.helperAll {
  position: fixed;
  right: 3%;
  top: 85%;
  width: 50px;
  height: 50px;
  z-index: 50;
  cursor: pointer;

  .item {
    position: relative;

    img {
      width: 100%;
    }

    .circular {
      position: absolute;
      top: -9px;
      left: -9px;
      width: 5em;
      height: 5em;

      path {
        fill-opacity: 0;
      }

      svg {
        display: block;
        overflow: visible;
      }
    }
  }
}

.showWindow {
  width: 300px;
  height: 220px;
  position: fixed;
  top: 50%;
  right: 110px;
  border: 1.5px #232d47 solid;
  background-color: #232d47;
  border-radius: 10px;
  z-index: 51;
  transition: 1s;
  transform: translateX(-1000px);
  overflow: hidden;

  .windowBtnAll {
    div {
      @include selectBtn;
      width: fit-content;
      display: inline-block;
      text-align: center;
      margin: 5px 5px;
    }
  }

  .rspbox {
    border-radius: 0 0 10px 10px;
    border-top: 1px rgb(16, 16, 82) solid;
    background-color: #fff;
    width: 100%;
    height: 50%;
    position: absolute;
    bottom: 0%;
  }

  .sayHelloTxt {
    border-top: 2px rgb(124, 23, 23);
    padding: 10px 5px;
  }

  .response {
    padding: 10px 5px;
    border-top: 2px rgb(124, 23, 23);
  }
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  height: 100vh;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #000000;
  background-image: linear-gradient(147deg, #000000 0%, #434343 74%);
}

.noselect {
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  -webkit-tap-highlight-color: transparent;
}

button {
  width: 30px;
  height: 30px;
  cursor: pointer;
  background-color: #5de6de;
  background-image: linear-gradient(315deg, #5de6de 0%, #b58ecc 74%);
  border: none;
  border-radius: 50%;
  position: absolute;
  bottom: 85px;
  left: 10px;
}

button svg {
  fill: white;
  width: 15px;
  height: 15px;
}

button:before {
  content: "Back to Top";
  position: absolute;
  font-size: 15px;
  transition: 200ms;
  color: transparent;
  font-weight: bold;
}

button:focus {
  outline: none;
}

@media (max-width: 414px) {
  .helperAll {
    position: fixed;

    top: 85%;
    width: 50px;
    height: 50px;
    overflow: hidden;
  }

  .showWindow {
    width: 300px;
    // height: 220px;
    position: fixed;
    top: 60%;
    right: 60px;
    border-radius: 10px;
    z-index: 51;
    transition: 1s;
    overflow: hidden;
  }
}
</style>
