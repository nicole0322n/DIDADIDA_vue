<template>
  <div class="ticketAll">
    <div class="topIntro">
      <div class="topTitle">{{ $t("票價資訊") }}</div>
      <ticketPrice></ticketPrice>
      <!-- <div class="ticketRow" v-for="(i, index) in ticketRowArr" :key="index">
        <div>{{ $t(i[0]) }}</div>
        <div>{{ $t(i[1]) }}</div>
        <div>{{ $t(i[2]) }}</div>
      </div>
      <div class="warning">※{{ $t('未滿4歲且有家長陪同的幼童可免費入場') }}</div> -->
    </div>
    <div id="checkdate">
    <bookDate></bookDate>
   </div>
    <div class="bottomIntro"  >
      <div class="bottomTitle">{{ $t("購票須知") }}</div>
      <div>
        <div v-for="(i, index) in warningArr" :key="index" class="singleNotice">
          <span> ◆ </span>{{ $t(i) }}
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import bookDate from "../components/bookDate.vue";
import ticketPrice from "../components/ticketPrice.vue";

export default {
  name: "HomeView",
  components: {
    bookDate,
    ticketPrice,
  },
  data() {
    return {
      ticketRowArr: [
        ["票種", "價格", "適用對象"],
        ["一般票", "NT 500", "限18歲(含)以上成人使用"],
        ["學生票", "NT 300", "限12歲(含)以上持學生證之學生適用"],
        ["孩童票", "NT 200", "限4歲(含)以上及未滿12歲兒童適用"],
        [
          "愛心票",
          "NT 200",
          "限持有身心障礙證明者、身心障礙者的1位陪同者、孕婦、滿65歲以上長者適用",
        ],
        ["團體票", "NT 350", "15人以上適用"],
      ],
      warningArr: [
        "未滿 4 歲的兒童可免費入場，需有家長陪同入場。",
        "下訂時請以「票券使用日」為主，下訂後即無法變更，敬請留意。",
        "訂單一次最高訂購上限為 6 張，每日場次數量為限量販售，售完為止。",
        "訂單恕不接受部分變更，若需變更入場日及場次請整筆重新下訂。",
        "長者票（博愛票）適用對象：限持有身心障礙證明者、身心障礙者的1位陪同者、孕婦、滿65歲以上長者適用。",
        "本館禁止攜帶外食、寵物，可攜帶開水。",
        "館內提供嬰兒車租借，未提供輪椅租借，敬請旅客見諒。",
        "請務必於訂購時確認訂購之票種是否正確，資格是否符合。",
        "此商品恕無法使用任何折扣券，敬請見諒。",
        "購票時請主動出示相關證件供售票處工作人員驗證，相關證件說明如下：",
        " 1. 學生票：本人有效學生證正本(若為應屆畢業生則提供當年度正式入學通知單或註冊單及攜帶身分證)。",
        " 2. 兒童票、長者票(博愛票)：身心障礙證明、孕婦健康手冊、國民身分證或政府核發附有照片、身分證字號及出生年、月、日等足以證明身分證件。",
      ],
      checkLogoPic: false,
      headerColor: "rgba(35, 45, 71, 0)",
      headerPosition: "relative",
      menuTitle: {
        about: "關於我們",
        news: "最新消息",
        animal: "探索海洋生物",
        buy: "DIDA商城",
      },
      aboutSub: [
        { link: "/faq", name: "常見問題" },
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
          name: "學生票",
          price: "NT 300",
          object: "限12歲(含)以上持學生證之學生適用",
        },
        {
          name: "孩童票",
          price: "NT 200",
          object: "限4歲(含)以上及未滿12歲兒童適用",
        },
        {
          name: "優待票",
          price: "NT 200",
          object:
            "限持有身心障礙證明者、身心障礙者的1位陪同者、孕婦、滿65歲以上長者適用",
        },
        { name: "團體票", price: "NT 350", object: "15名以上適用" },
        { name: "※未滿4歲且有家長陪同的幼童可免費入場" },
      ],
    };
  },
  // watch: {
  //   "$route.query"(nVal, oVal) {
  //     //   console.log(nVal);
  //   },
  // },
  mounted() {
    window.addEventListener("scroll", this.handleScroll);
  },
  beforeDestroy() {
    window.removeEventListener("scroll", this.handleScroll);
  },
  computed: {},
  methods: {
    titleCount(idx) {
      return idx + 1;
    },
    hideBanner() {
      this.$router.push({ path: "/", query: { section: "hide" } });
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
    // toFooter(){
    //     this.$router.push({ path: '/product', query: { article: 'footer' } });
    //     this.$router.push({path:'/', query:{section : 'footer' }})
    // }
  },
};
</script>
<style lang="scss" scoped>
.topIntro {
  @include ticket;
  // border: 1px map-get($colors, "secondary") solid;

  .topTitle {
    @include h3Title;
  }

  // .ticketRow {
  //   height: 61px;
  //   display: flex;
  //   align-items: center;
  //   letter-spacing: 1px;

  //   &:nth-child(2),
  //   &:last-child {
  //     background-color: map-get($colors, "secondary");
  //     color: map-get($colors, "light");
  //   }

  //   &:nth-child(4) {
  //     background-color: map-get($colors, "bgc");
  //     color: map-get($colors, "dark");
  //   }

  //   &:nth-child(6) {
  //     background-color: map-get($colors, "bgc");
  //     color: map-get($colors, "dark");
  //   }

  //   div {
  //     width: 150px;
  //     padding: 20px 12px;

  //     &:first-child {
  //       text-align: center;
  //     }

  //     &:nth-child(2) {
  //       text-align: center;
  //       border-left: none;
  //       border-right: none;
  //     }

  //     &:last-child {
  //       flex-grow: 4;
  //     }
  //   }
  // }

  .warning {
    height: 61px;
    display: flex;
    align-items: center;
    background-color: map-get($colors, "secondary");
    color: white;
    padding-left: 20px;
    letter-spacing: 1px;
  }
}

.bottomIntro {
  @include ticket;
  background-color: #979595;
  color: white;
  padding: 50px;

  .bottomTitle {
    font-size: map-get($fontSizes, "h3");
    // border: 1px red solid;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .singleNotice {
    line-height: 2;
  }
}
</style>
