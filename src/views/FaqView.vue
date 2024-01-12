<template>
  <ul class="card">
    <li class="card-item">
      <div class="card-item-header" :class="{ active: showHoliday }">
        <a href="#" @click.prevent="showHolidayM()">
          <h3>{{$t('營業相關')}}</h3>

          <i class="fa-solid fa-chevron-down down" style="color: #fafafa"></i>
          <i class="fa-solid fa-chevron-up up" style="color: #ffffff"></i>
        </a>
      </div>

      <div
        class="card-item-body"
        v-if="showHoliday"
        :class="{ showOpacity: holidayOpa }"
      >
        <p>
          {{$t('營業時間為上午9:00至下午17:00，最後入場時間為下午16:00。國定假日及颱風天休館。')}}
        </p>
      </div>
    </li>
    <li class="card-item">
      <div class="card-item-header" :class="{ active: showTicketPrice }">
        <a href="#" @click.prevent="showTicketPriceM()">
          <h3>{{$t('購票資訊')}}</h3>
          <i class="fa-solid fa-chevron-down down" style="color: #fafafa"></i>
          <i class="fa-solid fa-chevron-up up" style="color: #ffffff"></i>
        </a>
      </div>
      <div
        class="card-item-body"
        v-if="showTicketPrice"
        :class="{ showOpacity: ticketOpa }"
      >
        <h4>{{$t('Q:門票價錢?')}}</h4>
        <p>
          {{$t('A:一般門票價格：')}}<br />
          {{$t('成人：$500')}}<br />
          {{$t('兒童(4-11歲):$250')}}<br />
          {{$t('學生（需出示有效學生證):$400')}}<br />
          {{$t('長者(65歲以上):$250')}}
        </p>

        <h4>{{$t('Q:購票方式?')}}</h4>
        <p>
          {{$t('1.網上預訂： 在我們的官方網站上預訂門票，可享受5%的網上預訂折扣。')}}<br />
          {{$t('2.現場購票： 您也可以在水族館入口處現場購買門票。')}}<br />
          {{$t("3.團體訪問：如果您是一個大型團體（例如學校、公司或旅行團），我們提供特別優惠和團體行程安排。請提前與我們的團體訪問部門聯繫，以獲取更多信息和價格。")}}
        </p>
      </div>
    </li>

    <li class="card-item">
      <div class="card-item-header" :class="{ active: showService }">
        <a href="#" @click.prevent="showServiceM()">
          <h3>{{$t('館內服務')}}</h3>
          <i class="fa-solid fa-chevron-down down" style="color: #fafafa"></i>
          <i class="fa-solid fa-chevron-up up" style="color: #ffffff"></i>
        </a>
      </div>
      <div
        class="card-item-body"
        v-if="showService"
        :class="{ showOpacity: serviceOpa }"
      >
        <p>
          {{$t('1. 導覽和導遊')}}<br />
          {{$t('讓我們的專業導遊帶您深入探索水族館的不同區域，解釋海洋生物的奧秘，並分享有趣的故事。我們的導遊將使您更深入地了解每個展示，讓您有機會提出問題並互動。')}} 
        </p>
        <p>
          {{$t(' 2. 動手體驗活動')}}<br />
          {{$t('對於年輕和年輕心靈的訪客，我們提供各種動手體驗活動，包括觸摸池、餵食海洋生物和手工藝活動。這是一個互動的方式，讓您更親近海洋世界。')}}
        </p>
        <p>
          {{$t('3. 特別活動和展覽')}}<br />
          {{$t('我們定期舉辦特別活動和展覽，通常有限時間內提供。請查看我們的日曆，以了解最新的活動和展覽，這些活動可能包括特別講座、海報展示和主題活動。')}}
        </p>
        <p>
          {{$t('4. 禮品店')}}<br />
          {{$t('在我們的禮品店，您可以購買精美的海洋主題禮品，包括紀念品、書籍、海洋生物玩具和獨特的手工藝品。您可以帶回家一些特別的東西，以紀念您的水族館訪問。')}}
        </p>
      </div>
    </li>
    <li class="card-item">
      <div class="card-item-header" :class="{ active: showTraffic }">
        <a href="#" @click.prevent="showTrafficM()">
          <h3>{{$t('交通&周邊環境')}}</h3>
          <i class="fa-solid fa-chevron-down down" style="color: #fafafa"></i>
          <i class="fa-solid fa-chevron-up up" style="color: #ffffff"></i>
        </a>
      </div>

      <div
        class="card-item-body"
        v-if="showTraffic"
        :class="{ showOpacity: trafficOpa }"
      >
        <h4>{{$t('Q:如何前往水族館?')}}</h4>
        <p>{{$t('1.自駕車：園區設有汽車停車場收費為150元/次，機車停車場收費50元/次')}}</p>
        <p>
          {{$t('2.公共交通：您可以搭乘當地的公共交通工具，包括巴士、地鐵和有輕軌服務的列車。請查看當地交通網站以獲取最新的路線和時刻表。')}}
        </p>
        <h4>{{$t('Q:周邊環境?')}}</h4>
        <p>
          {{$t('1.公園和花園：我們的水族館附近有美麗的公園和花園，提供放鬆身心的好地方。您可以在那裡野餐、散步或欣賞自然美景。')}}
        </p>
        <p>
          {{$t('2.購物中心：附近有購物中心，供您購買紀念品、禮物和更多。您可以找到各種品牌和特色商店。')}}
        </p>
      </div>
    </li>

    <li class="card-item">
      <div class="card-item-header" :class="{ active: showExperience }">
        <a href="#" @click.prevent="showExperienceM()">
          <h3>{{$t('海洋體驗相關')}}</h3>
          <i class="fa-solid fa-chevron-down down" style="color: #fafafa"></i>
          <i class="fa-solid fa-chevron-up up" style="color: #ffffff"></i>
        </a>
      </div>
      <div
        class="card-item-body"
        v-if="showExperience"
        :class="{ showOpacity: experienceOpa }"
      >
        <h4>{{$t('Q:有身高限制?')}}</h4>
        <p>
          {{$t('A:身高必須高達110cm才能參與此活動，另外我們建議年紀需達6歲-70歲較適合參加活動。')}}
        </p>
        <h4>{{$t('Q:幾歲是需要大人陪同參與?')}}</h4>
        <p>
          {{$t('A:因親水活動且與大型動物接觸，12歲以下(含12歲)孩童務必需有至少一名大人陪同報名參與下水活動。')}} 
        </p>
      </div>
    </li>
  </ul>
</template>
<script>
export default {
  name: "faqs",
  data() {
    return {
      showTraffic: false,
      showService: false,
      showTicketPrice: false,
      showHoliday: false,
      showExperience: false,

      holidayOpa: false,
      ticketOpa: false,
      serviceOpa: false,
      trafficOpa: false,
      experienceOpa: false,
    };
  },
  props: {},
  components: {},
  computed: {
    // showTraffic:false,
    //   showService:false,
    //   showTicketPrice:false,
    //   showHoliday:false,
  },
  watch: {},
  methods: {
    showHolidayM() {
      this.showHoliday = !this.showHoliday;
      this.showTraffic = false;
      this.showService = false;
      this.showTicketPrice = false;
      if (!this.showHoliday) {
        this.holidayOpa = false;
      }
      if (this.showHoliday) {
        setTimeout(() => {
          this.holidayOpa = true;
        }, 200);
      }
    },
    showTrafficM() {
      this.showHoliday = false;
      this.showTraffic = !this.showTraffic;
      this.showService = false;
      this.showTicketPrice = false;
      if (!this.showHoliday) {
        this.trafficOpa = false;
      }
      if (this.showTraffic) {
        setTimeout(() => {
          this.trafficOpa = true;
        }, 200);
      }
    },
    showServiceM() {
      this.showHoliday = false;
      this.showTraffic = false;
      this.showService = !this.showService;
      this.showTicketPrice = false;
      if (!this.showService) {
        this.serviceOpa = false;
      }
      if (this.showService) {
        setTimeout(() => {
          this.serviceOpa = true;
        }, 200);
      }
    },
    showTicketPriceM() {
      this.showHoliday = false;
      this.showTraffic = false;
      this.showService = false;
      this.showTicketPrice = !this.showTicketPrice;
      if (!this.showTicketPrice) {
        this.ticketOpa = false;
      }
      if (this.showTicketPrice) {
        setTimeout(() => {
          this.ticketOpa = true;
        }, 200);
      }
    },

    showExperienceM() {
      this.showHoliday = false;
      this.showTraffic = false;
      this.showService = false;
      this.showTicketPrice = false;
      this.showExperience = !this.showExperience;

      if (!this.showExperience) {
        this.experienceOpa = false;
      }
      if (this.showExperience) {
        setTimeout(() => {
          this.experienceOpa = true;
        }, 200);
      }
    },
  },
  mounted() {},
};
</script>

<style scoped lang="scss">
.content {
  //  padding: 50px 200px;
  margin: auto;
}

.content h3 {
  font-size: map-get($fontSizes, "h3");
  font-weight: bold;
  color: white;
  margin: auto auto auto 0;
}
.card {
  max-width: 600px;
  margin: 0 auto;
}
.card-item {
  width: 100%;
  list-style: none;
  margin: 0 auto;
}

.card-item-header {
  width: 100%;
  padding: 16px 0;
  background-color: map-get($colors, "secondary");
  // margin: 30px 0;
  margin-top: 30px;
  margin-bottom: 50px;
  border-radius: 10px;
  border: 2px solid map-get($colors, "secondary");
  cursor: pointer;
}

.card-item-header a {
  width: 90%;
  margin: auto;
  text-decoration: none;
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.card-item-header h3 i {
  margin-right: 20px;
  // border:1px solid black;
  display: flex;
}

.card-item-body {
  width: 100%;
  margin: auto;
  padding: 0 50px;
  font-size: map-get($fontSizes, "a");
  line-height: 21px;

  opacity: 0;
  border: 2px solid map-get($colors, "secondary");
  // margin-bottom: 50px;
  border-radius: 10px;
  border-top: none;
  margin-bottom: 30px;
}

.showOpacity {
  transition: opacity 0.8s;
  opacity: 1;
  padding: 20px 30px;
}

.card-item-body p {
  width: 100%;
  margin-bottom: 20px;
  line-height: 2;
  //  border-bottom: 1px solid map-get($colors, "secondary");
}
.card-item-body p {
  border-bottom: 2px solid map-get($colors, "secondary");
}
.card-item-body p:last-child {
  width: 100%;
  border-bottom: none;
}

.card-item-header:not(.active) .up {
  display: none;
}

.card-item-header.active .down {
  display: none;
}
.card-item-header.active {
  border: 2px solid map-get($colors, "secondary");
  margin-bottom: 0;
  border-radius: 10px;
}

@media screen and (max-width: 768px) {
  .card {
    width: 60%;
    margin: 0 auto;
  }

  .card-item-header {
    width: 100%;
    padding: 7px 0;
    background-color: map-get($colors, "secondary");
    // margin: 30px 0;

    border-radius: 5px;
    border: 2px solid map-get($colors, "secondary");
  }
  .card-item-body {
    width: 100%;
    margin: auto;
    padding: 0 20px;
    font-size: map-get($fontSizes, "a");
    line-height: 21px;
    transition: 1s;
    margin-bottom: 30px;
  }
  .showOpacity {
    transition: 1s;
    opacity: 1;
    padding: 20px 30px;
  }
}
</style>
