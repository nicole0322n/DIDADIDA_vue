<template>
  <div class="mem_main">
    <!-- 裝飾圖 -->
    <div class="deco_fishes">
      <img src="../../public/all_images/deco/deco_fishes.png" alt="" />
    </div>
    <!-- 左側選單 -->
    <div class="member_nav">
      <div class="stickers">
        <div class="photo_stickers">
          <form @submit.prevent="uploadImage">
            <input type="file" @change="pushImg($event, index)" id="fileInput" ref="imageInput" accept="image/*" />
            <label for="fileInput" id="cameraIconLabel">
              <img src="../../public/all_images/115759_camera_icon.png" alt="" />
            </label>
            <div class="imgBox">
              <img :src="changePic" alt="" />
            </div>
          </form>
        </div>
      </div>

      <div class="member_hello">
        <p>{{ this.$store.state.userName }}{{$t("，您好！")}}</p>
      </div>
      <div class="bonuspoints">
        <p>
          {{$t("尚有紅利點數 :")}} <span>{{ mem_bonus }}</span>{{$t('點')}} 
        </p>
      </div>
      <div class="verification">
        <div class="verification_google">
          <img src="../assets/images/google_icon.png" alt="" />
          <span>Google</span>
        </div>
        <label class="verification_label" for="verification_id">
          {{$t('已驗證')}} <input class="verification_input" type="checkbox" value="" id="verification_id" style="zoom: 120%" checked />
        </label>
      </div>
      <div class="btn_area">
        <button @click="memberSetting" :class="{ alreadyClick: memberClick }">
          {{ $t("會員帳號設定") }}
        </button>
        <button @click="prodOrder" :class="{ alreadyClick: prodOrderClick }">
          {{ $t("購物訂單查詢") }}
        </button>
        <button @click="tickOrder" :class="{ alreadyClick: tickOrderClick }">
          {{ $t("購票訂單查詢") }}
        </button>
        <button @click="favList" :class="{ alreadyClick: favListClick }">
          {{ $t("我的收藏清單") }}
        </button>
      </div>

      <div class="btn_area_mob">
        <select name="" id="service" @change="handleSelectChange">
          <option value="">搜尋項目</option>
          <option value="member" :class="{ alreadyClick: memberClick }">
            {{ $t("會員帳號設定") }}
          </option>
          <option value="order" :class="{ alreadyClick: prodOrderClick }">
            {{ $t("購物訂單查詢") }}
          </option>
          <option value="ticket" :class="{ alreadyClick: tickOrderClick }">
            {{ $t("購票訂單查詢") }}
          </option>
          <option value="favorite" :class="{ alreadyClick: favListClick }">
            {{ $t("我的收藏清單") }}
          </option>
        </select>
        <span><i class="fa-solid fa-chevron-down" style="color: #eeeeee"></i></span>
      </div>

      <div class="logOutBtn">
        <button v-if="this.$store.state.userName" @click="logOutAPI()" :class="{ alreadyClick: logOutClick }">
          {{ $t("登出") }}
        </button>
      </div>
    </div>

    <!-- 右側區塊 -->
    <!-- 會員帳號設定 -->
    <div v-if="this.$store.state.memberBtn === 'mem_account_settings'" class="mem_account_settings member_area">
      <h6>{{ $t("會員帳號設定") }}</h6>
      <memAccoutSettings></memAccoutSettings>
      <memAreaBG></memAreaBG>
    </div>
    <!-- 購物訂單查詢 -->
    <div v-else-if="this.$store.state.memberBtn === 'prod_order_inquiry'" class="prod_order_inquiry member_area">
      <h6>{{ $t("購物訂單查詢") }}</h6>
      <prodOrderInquiry id="showProdOrder"></prodOrderInquiry>
      <memAreaBG></memAreaBG>
    </div>
    <!-- 購票訂單查詢 -->
    <div v-else-if="this.$store.state.memberBtn === 'tick_order_inquiry'" class="tick_order_inquiry member_area">
      <h6 id="showtickOrder">{{ $t("購票訂單查詢") }}</h6>
      <tickOrderInquiry></tickOrderInquiry>
      <memAreaBG></memAreaBG>
    </div>
    <!-- 我的收藏清單 -->
    <div v-else="this.$store.state.memberBtn === 'mem_bonuspoint'" class="favorites_list member_area">
      <h6>{{ $t("我的收藏清單") }}</h6>
      <favoritesList></favoritesList>
      <memAreaBG></memAreaBG>
    </div>
  </div>
</template>
<script>
import memAccoutSettings from "../components/memAccoutSettings.vue";
import prodOrderInquiry from "../components/prodOrderInquiry.vue";
import tickOrderInquiry from "../components/tickOrderInquiry.vue";
import favoritesList from "../components/favoritesList.vue";
import memAreaBG from "../components/memAreaBG.vue";
import { mapGetters } from "vuex";
export default {
  components: {
    memAccoutSettings,
    prodOrderInquiry,
    tickOrderInquiry,
    favoritesList,
    memAreaBG,
  },
  data() {
    return {
      memberClick: true,
      prodOrderClick: false,
      tickOrderClick: false,
      favListClick: false,
      logOutClick: false,
      btn: "mem_account_settings",
      mem_bonus: 0,
      allBar: [],
      avatarAll: [],
      changePic: "",
      mem_name: this.$store.state.userName,
    };
  },
  created() {
    if (!this.$store.state.userName) {
      alert("需先登入!!");
      this.$router.push("/");
    }
  },
  mounted() {
    if (this.$store.state.userName) {
      const formData = new FormData();
      let mem_name = this.$store.state.userName;
      formData.append("mem_name", mem_name);
      let catchOrignBonus = 0;
      fetch(`${this.$store.state.APIurl}labaUpateBonus.php`, {
        method: "post",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          catchOrignBonus = parseInt(data[0].mem_bonus);
          this.mem_bonus = catchOrignBonus;
        });
    }
    if (this.$store.state.userName) {
      const formData = new FormData();
      let mem_name = this.$store.state.userName;
      formData.append("mem_name", mem_name);
      fetch(`${this.$store.state.APIurl}memberSelectPhoto.php`, {
        method: "post",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          this.changePic = `${this.$store.state.chooseImgSrc}/all_images/memAvatar/${data[0].mem_pic}`;
          console.log(this.changePic);
        });
    }

    if (this.$route.query.section === "showProdOrder") {
      this.prodOrderClick = true;
      this.memberClick = false;
    } else if (this.$route.query.section === "showtickOrder") {
      this.memberClick = false;
      this.tickOrderClick = true;
    }
  },
  computed: {
    score() {
      return this.$store.state.totalScorePoint;
    },
    ...mapGetters(["remainingTodos"]),
  },
  methods: {
    handleSelectChange(event) {
      const selectedValue = event.target.value;
      switch (selectedValue) {
        case 'member':
          this.memberSetting();
          break;
        case 'order':
          this.prodOrder();
          break;
        case 'ticket':
          this.tickOrder();
          break;
        case 'favorite':
          this.favList();
          break;
        default:
          break;
      }
    },
    favList() {
      this.$store.state.memberBtn = "favorites_list";
      this.prodOrderClick = false;
      this.memberClick = false;
      this.tickOrderClick = false;
      this.favListClick = true;
      this.logOutClick = false;
    },
    tickOrder() {
      this.$store.state.memberBtn = "tick_order_inquiry";
      this.prodOrderClick = false;
      this.memberClick = false;
      this.tickOrderClick = true;
      this.favListClick = false;
      this.logOutClick = false;
    },
    prodOrder() {
      this.$store.state.memberBtn = "prod_order_inquiry";
      this.prodOrderClick = true;
      this.memberClick = false;
      this.tickOrderClick = false;
      this.favListClick = false;
      this.logOutClick = false;
    },
    memberSetting() {
      this.$store.state.memberBtn = "mem_account_settings";
      this.memberClick = true;
      this.prodOrderClick = false;
      this.tickOrderClick = false;
      this.favListClick = false;
      this.logOutClick = false;
    },
    logOutAPI() {
      this.$router.push("/", { replace: true });
      fetch("https://tibamef2e.com/cgd103/g1/api/postMemberLogout.php")
        .then((res) => res.json())
        .then((json) => console.log(json));
      this.$store.state.userName = "";
      this.$store.state.shoppingCart = [];
      this.$store.state.favoList = [];
      this.$store.state.ticketList = [];
      this.$store.state.totalScorePoint = 0;
    },
    pushImg(e, index) {
      let file = e.target.files[0];
      console.log(file);
      if (file) {
        const formData = new FormData();
        formData.append("image", file);
        formData.append("mem_name", this.mem_name);

        fetch(`${this.$store.state.APIurl}memAvatar.php`, {
          method: "POST",
          body: formData,
        })
          .then(function (response) {
            return response.json();
          })
          .then((data) => {
            console.log(data);
          });
      }

      this.changePic = file;
      console.log("file", file);

      let readFile = new FileReader();
      readFile.readAsDataURL(file);
      readFile.addEventListener("load", function () {
        let image = new Image();
        image.src = readFile.result;
        console.log(image.src);
        image.style.width = "100%";
        image.style.height = "100%";
        document.querySelectorAll(".imgBox")[0].innerHTML = "";
        document.querySelectorAll(".imgBox")[0].appendChild(image);
      });
    },
  },
};
</script>
<style scoped lang="scss">
.mem_main {
  width: 1200px;
  margin: 200px auto 130px auto;
  display: flex;
  justify-content: center;
  position: relative;

  .deco_fishes {
    position: absolute;
    top: -280px;
    right: 255px;
  }

  .member_nav {
    width: 400px;
    height: 1000px;
    border-radius: 10px 0 0 10px;
    background-color: map-get($colors, "secondary");
    position: relative;

    .btn_area_mob {
      display: none;
    }

    .stickers {
      height: 100px;
      position: relative;

      .photo_stickers {
        // position: relative;

        .imgBox {
          display: inline-block;
          width: 270px;
          height: 270px;
          border-radius: 50%;
          overflow: hidden;
          position: absolute;
          top: -180px;
          left: 65px;
          z-index: 2;

          img {
            width: 100%;
            height: 100%;
          }
        }

        input[type="file"] {
          display: none;
        }

        #cameraIconLabel {
          cursor: pointer;
          display: inline-block;
          padding: 10px;
          background-color: transparent;
          border: 0;
          position: absolute;
          top: 40px;
          left: 175px;
          z-index: 3;

          img {
            width: 25px;
            height: 25px;
          }
        }
      }
    }

    .member_hello {
      width: fit-content;
      margin: 20px auto 0 auto;
      font-size: map-get($fontSizes, "h3");
      color: map-get($colors, "light");
    }

    .bonuspoints {
      width: fit-content;
      margin: 0 auto;
      color: map-get($colors, "light");

      p {
        font-size: map-get($fontSizes, "p");
        width: fit-content;
        border-bottom: 1px solid map-get($colors, "light");

        span {
          font-size: map-get($fontSizes, "h5");
        }
      }
    }

    .verification {
      width: 340px;
      height: 50px;
      margin: 30px auto;
      padding: 30px;
      border: 0;
      border-radius: 10px;
      font-size: map-get($fontSizes, "p");
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: map-get($colors, "bgc");

      .verification_google {
        width: 100px;
        display: flex;
        justify-content: space-evenly;
        align-items: center;

        span {
          font-size: map-get($fontSizes, "p");
          letter-spacing: 1px;
        }
      }

      .verification_label {
        width: 80px;
        display: flex;
        justify-content: space-evenly;
        align-items: center;
      }
    }

    .btn_area {
      width: 340px;
      height: 520px;
      margin: 40px auto;
      text-align: center;

      button {
        width: 200px;
        height: 60px;
        border: 0;
        cursor: pointer;
        background-color: map-get($colors, "secondary");
        font-size: map-get($fontSizes, "p");
        color: map-get($colors, "light");
        letter-spacing: 1px;
      }

      :hover {
        color: white;
        border-bottom: 1px solid map-get($colors, "light");
      }

      .alreadyClick {
        background-color: #1fb0cb;
        color: white;
      }
    }

    .logOutBtn {
      width: 340px;
      margin: 40px auto;
      text-align: center;

      button {
        width: 200px;
        height: 60px;
        border: 0;
        cursor: pointer;
        background-color: map-get($colors, "secondary");
        font-size: map-get($fontSizes, "p");
        color: map-get($colors, "light");
        letter-spacing: 1px;
      }

      :hover {
        color: white;
        border-bottom: 1px solid map-get($colors, "light");
      }

      .alreadyClick {
        background-color: #1fb0cb;
        color: white;
      }
    }
  }

  .member_area {
    width: 800px;
    height: 1000px;
    border: 0;
    border-radius: 0 10px 10px 0;
    position: relative;
    background-color: map-get($colors, "bgc");
    color: map-get($colors, "dark");
    overflow: hidden;

    h6 {
      text-align: center;
      width: 500px;
      margin: 40px auto 10px auto;
      padding-bottom: 20px;
      border-bottom: 1px solid map-get($colors, "dark");
      font-size: map-get($fontSizes, "h3");
    }
  }

  .mem_account_settings {
    background-color: map-get($colors, "mainColor");
    color: map-get($colors, "light");

    h6 {
      border-bottom: 1px solid map-get($colors, "light");
      margin: 40px auto;
    }
  }
}

@media screen and (max-width: 768px) {
  .stickers {
    .photo_stickers {
      width: 200px;
      height: 200px;
      top: -120px;
    }
  }

  .member_hello {
    width: 100%;
    font-size: map-get($fontSizes, "h5");

    .deco_fishes {
      right: 100px;
    }
  }

  .mem_main {
    width: 100%;
    flex-direction: column;
    align-items: center;

    .verification {
      width: 600px;
    }

    .member_nav {
      width: 600px;

      button {
        width: 550px;
      }
    }

    .mempic,
    .bubble {
      display: none;
    }
  }
}

@media screen and (max-width: 414px) {
  .mem_main {
    .member_nav {
      .stickers {
        .photo_stickers {


          #cameraIconLabel {
            padding: 100px;
            border: 1px solid transparent;
            border-radius: 50%;
            top: -150px;
            left: 65px;
            z-index: 0;
          }

          .imgBox {
            left: 0;
            right: 0;
            margin: auto;
            pointer-events: none;
          }
        }
      }

      .verification {
        width: 85%;
      }

      .btn_area {
        display: none;
      }

      .btn_area_mob {
        display: flex;
        position: relative;

        select {
          margin: auto;
          border: none;
          background-color: #1fb0cb;
          padding: 10px;
          width: 60%;
          color: map-get($colors, 'light');
          appearance: none;
        }

        span {
          position: absolute;
          top: 10px;
          right: 90px;
          font-size: 1rem;
          pointer-events: none;
        }



      }
    }
  }

  .member_hello {
    width: 100%;
    font-size: map-get($fontSizes, "h5");
  }

  .deco_fishes {
    display: none;
  }

  .mem_main {
    width: 100%;

    .mem_account_settings {
      h6 {
        width: 100%;
      }
    }

    h6 {
      width: 100%;
      padding: 20px 25px;
    }

    .verification {
      width: 350px;
    }

    .member_nav {
      width: 90%;
      height: 400px;
      border-radius: 5px 5px 0 0;

      button {
        width: 310px;
        background-color: map-get($colors, "memnav");
      }
    }

    .member_area {
      width: 90%;
      height: 900px;
      border-radius: 0 0 5px 5px;
      background-color: map-get($colors, "bgc");
      color: map-get($colors, "dark");

      h6 {
        width: 100%;
      }
    }

    .mempic,
    .bubble {
      display: none;
    }
  }
}
</style>
