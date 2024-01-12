<template>
  <div v-if="loginCheck" class="loginFirst">
    <div class="login_bg">
      <div class="logo">
        <img src="../../../public/all_images/logo_all.svg" alt="" />
      </div>
      <div class="input_area">
        <label for="account">
          <img
            src="../../../public/all_images/backStage/user-icon.png"
            alt=""
          />
          <input
            id="account"
            type="text"
            placeholder="帳號"
            v-model="loginMail"
          />
        </label>
        <label for="psw">
          <img src="../../../public/all_images/backStage/psw-icon.png" alt="" />
          <input
            id="psw"
            type="password"
            placeholder="密碼"
            v-model="loginPassword"
        /></label>

        <div class="loginBtn" @click="checkLogin">登入</div>
      </div>
    </div>
  </div>

  <div class="slotAll" v-else>
    <div class="userName">
      <div v-if="loginMail == 'group4'">User:Super</div>
      <div v-else>User:{{ loginMail }}</div>
      <div class="logoutBtn" @click="logoutToHome">登出</div>
    </div>
    <div class="controlWidth">
      <div class="featureBox">
        <button
          @click="pushToActiveMg"
          :class="['singleFeature']"
          :disabled="loginMail !== 'group4' && loginPassword !== '123'"
        >
          權限管理
          <!-- <router-link :to="'/backHome/activeMg'" :class="['singleFeature']"
            >權限管理</router-link
          > -->
        </button>
        <router-link
          :to="i[1]"
          v-for="(i, index) in featureAll"
          :key="index"
          :class="['singleFeature', { active: $route.path === i[1] }]"
          @click="toggleFeature(index)"
        >
          {{ i[0] }}
        </router-link>
      </div>

      <div class="differentBox">
        <div><router-view></router-view></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "backHome",
  data() {
    return {
      loginMail: "group4",
      loginPassword: 123,
      loginCheck: true,
      featureAll: [
        ["首頁輪播圖片管理", "/backHome/homePicMg", true],
        ["最新消息管理", "/backHome/newsMg", false],
        ["活動倒數管理", "/backHome/activeMg", false],
        ["會員管理", "/backHome/memberMg", false],
        ["訂單管理", "/backHome/orderMg", false],
        ["商品管理", "/backHome/productMg", false],
        ["票券管理", "/backHome/ticketMg", false],
        ["智能小幫手", "/backHome/helperMg", false],
        ["互動", "/backHome/gamesMg", false],
      ],
      activeIndex: 0,
    };
  },

  methods: {
    pushToActiveMg() {
      this.$router.push("/backHome/authorityMg");
    },
    logoutToHome() {
      this.$router.push("/backHome");
      this.loginCheck = true;
    },
    checkLogin() {
      fetch(`${this.$store.state.APIurl}backHomeSelectAcc.php`)
        .then(function (response) {
          return response.json();
        })
        .then((data) => {
          console.log(data);
          let x = 0;
          for (let i = 0; i < data.length; i++) {
            console.log(
              data[i].emp_account == "didaMgr1" && data[i].emp_psw == "123"
            );
            if (
              data[i].emp_account == this.loginMail &&
              data[i].emp_psw == this.loginPassword &&
              data[i].emp_state == "0"
            ) {
              x = 1;
              this.loginCheck = false;
              this.$router.push({ name: "homePicMg" });
              // continue;
              break;
            } else if (
              data[i].emp_account == this.loginMail &&
              data[i].emp_psw == this.loginPassword &&
              data[i].emp_state == "1"
            ) {
              x = 1;
              this.loginCheck = false;
              this.$router.push({ name: "homePicMg" });
              // break;
            } else if (
              data[i].emp_account == this.loginMail &&
              data[i].emp_psw == this.loginPassword &&
              data[i].emp_state == "2"
            ) {
              x = 1;
              alert("已被停權");
              break;
            }
          }
          if (x == 0) {
            alert("帳密錯誤");
          }
        });
      // if (
      //   this.$refs.loginMail.value == this.loginMail &&
      //   this.$refs.loginPassword.value == this.loginPassword
      // ) {
      //   this.loginCheck = false;
      //   this.$router.push({ name: "homePicMg" });
      // }
    },
    toggleFeature(index) {
      if (this.activeIndex === index) {
        this.activeIndex = 0;
      } else {
        this.activeIndex = index;
      }
    },
    isActive(index) {
      console.log(this.activeIndex);
      return this.activeIndex === index;
    },
  },
};
</script>
<style scoped lang="scss">
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

//後台登入頁面
.loginFirst {
  height: 100vh;
  display: flex;
  width: 100%;
  justify-content: center;
  align-items: center;
  background-image: url(../../../public/all_images/backStage/back_loginBg.jpg);
  background-size: cover;

  .login_bg {
    width: 60%;
    height: 80vh;
    padding: 1.5rem 0;
    border-radius: 0.5rem;
    background-color: #878181a8;

    .logo {
      width: 11%;
      margin: auto;

      img {
        width: 100%;
        vertical-align: top;
      }
    }

    .input_area {
      width: 50%;
      // margin: auto;
      display: flex;
      flex-direction: column;
      margin: 1rem auto;
      position: relative;
      padding: 15px 0 0;
      margin-top: 10px;

      label {
        display: flex;
        align-items: center;

        img {
          width: 11%;
          padding: 3%;
          vertical-align: top;
          text-align: center;
          background-color: rgb(78, 137, 126);
          border-radius: 0.3em 0 0 0.3em;
        }
      }

      input {
        width: 90%;
        padding: 2%;
        margin: 1rem 0;
        background: rgba(170, 195, 228, 0.742);
        border: 2px solid transparent;
        border-radius: 4px;
        box-shadow: rgb(0 0 0 / 12%) 0px 1px 3px, rgb(0 0 0 / 24%) 0px 1px 2px;
        outline: none;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;

        &:focus {
          border-color: #e9ae66;
          outline: 0;
          -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075),
            0 0 8px rgba(233, 174, 102, 0.6);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075),
            0 0 8px rgba(233, 174, 102, 0.6);
        }
      }

      .loginBtn {
        text-align: center;
        width: 100%;
        margin-left: auto;
        cursor: pointer;
        outline: 0;
        border: 0;
        padding: 0.5rem;
        border-radius: 3rem;
        margin: 1rem 0;
        font-weight: 600;
        color: #ffffff;
        box-shadow: rgb(116, 235, 213) -2px -2px 0px 2px,
          rgb(159, 172, 230) 0px 0px 0px 4px,
          rgba(0, 0, 0, 0.05) 0px 0px 2px 7px;
        transition: all 0.2s;

        &:hover {
          box-shadow: rgb(159, 172, 230) -2px -2px 0px 2px,
            rgb(116, 235, 213) 0px 0px 0px 4px,
            rgba(0, 0, 0, 0.05) 0px 0px 2px 7px;
          transform: scale(1.01);
          color: #dbdbdb;
        }
      }
    }
  }
}

//後台頁面
.slotAll {
  max-width: 100vw;
  height: 100vh;
  margin: auto;
  padding-top: 10px;
  background-image: url(../../../public/all_images/backStage/watercolor-4116932_1920.png);
  background-size: cover;

  .controlWidth {
    width: 80%;
    margin-top: 1rem;
    margin-left: auto;
    display: flex;
    justify-content: space-between;

    .featureBox {
      position: fixed;
      left: 2%;
      top: 5%;
      width: 15%;
      border-radius: 1rem;
      background-color: rgb(255, 255, 255);
      display: flex;
      flex-direction: column;
      height: fit-content;
      box-shadow: black 0.1em 0.1em 0.1em;

      .singleFeature {
        cursor: pointer;
        color: #000;
        font-weight: 600;
        padding: 10px 5px;
        margin: 5px 0;
        border-radius: 1rem;
        text-align: center;
      }

      .active {
        box-shadow: rgb(116, 235, 213) -2px -2px 0px 2px,
          rgb(159, 172, 230) 0px 0px 0px 4px,
          rgba(0, 0, 0, 0.05) 0px 0px 2px 7px;
        transition: all 0.5s;
        background-color: #37838fc9;
        color: #fff5e9;
      }
    }

    .differentBox {
      padding: 2em;
      overflow: auto;
      background-color: #ffffffc6;
      width: 95%;
      height: 82vh;
      border-radius: 0.3rem;
      box-shadow: 3px 3px 6px 0px #ccdbe8 inset,
        -3px -3px 6px 1px rgba(255, 255, 255, 0.5) inset;

      &::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        background-color: #f5f5f5;
        border-radius: 10px;
      }

      &::-webkit-scrollbar {
        width: 10px;
        background-color: #f5f5f5;
      }

      &::-webkit-scrollbar-thumb {
        border-radius: 10px;
        background-image: -webkit-gradient(
          linear,
          left bottom,
          left top,
          color-stop(0.44, rgb(122, 153, 217)),
          color-stop(0.72, rgb(73, 125, 189)),
          color-stop(0.86, rgb(28, 58, 148))
        );
      }

      .allTabs {
        position: absolute;
        display: flex;
        translate: 0 -100%;
        left: 20px;

        div {
          margin: 0 10px;
          border: 1px black solid;
          border-bottom: none;
          padding: 0 10px;
          cursor: pointer;
        }
      }
    }
  }
}

.userName {
  width: 90%;
  margin: auto;
  display: flex;
  align-items: center;
  justify-content: end;

  .logoutBtn {
    margin-left: 1rem;
    width: 8rem;
    outline: none;
    color: #616467;
    border: 1px solid transparent;
    background-color: transparent;
    box-shadow: inset 0 0 0 2px #616467;
    padding: 0.5rem;
    border-radius: 5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;

    &:hover {
      color: #fff;
      background-color: #616467;
    }
  }
}
</style>
