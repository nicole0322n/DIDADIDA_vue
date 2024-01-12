<template>
  <div v-if="this.$store.state.storeShowLogin">
    <div class="backplate" @click="hideLogin"></div>

    <div
      class="container"
      :class="{ 'right-panel-active': isSignUp }"
      id="container"
    >
      <!-- signup固定填單 -->
      <transition name="fade" mode="out-in">
      <div class="form-container sign-up-container" >
        <form>
          <h1>創建帳號</h1>
          <div class="social-container">
            <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social"><i class="fa-brands fa-google"></i></a>
            <a href="#" class="social"
              ><i class="fa-brands fa-instagram fa-lg"></i
            ></a>
          </div>
          <span>或使用電子郵件登入</span>
          <input
            type="text"
            v-model="name"
            placeholder="姓名"
            @input="testNameSignUp"
            :class="{ checkInput: !isValidName, correctInput: isValidName }"
          />
          <span v-if="!isValidName" class="caution">請輸入有效姓名</span>

          <input
            type="email"
            v-model="email"
            placeholder="電子信箱"
            @input="testMailSignUp"
            :class="{ checkInput: !isValidEmail, correctInput: isValidEmail }"
          />
          <span v-if="!isValidEmail" class="caution">請輸入有效的信箱</span>

          <input
            type="password"
            v-model="password"
            placeholder="密碼"
            @input="testPassWordSignUp"
            :class="{
              checkInput: !isValidPassword,
              correctInput: isValidPassword,
            }"
          />
          <span v-if="!isValidPassword" class="caution"
            >密碼長度需在8~12個字之間,至少含一個英文字母(不分大小寫)</span
          >
          <button @click.prevent="insertPerson">註冊</button>
          <div style="color: red" v-if="APIEmailCheck">帳號已重複</div>
        </form>
      </div>
    </transition>

      <!-- signin固定填單 -->
      <transition name="fade" mode="out-in">
      <div class="form-container sign-in-container" >
        <form @submit.prevent="submitSignInForm">
          <h1>登入</h1>
          <div class="social-container">
            <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social"><i class="fa-brands fa-google"></i></a>
            <a href="#" class="social"
              ><i class="fa-brands fa-instagram fa-lg"></i
            ></a>
          </div>
          <span>或使用您的帳號</span>
          <input
            type="email"
            v-model="signInEmail"
            placeholder="電子信箱"
            :class="{
              checkInput: !signInNotCorrect,
              correctInput: signInNotCorrect,
            }"
          />
          <span v-if="!signInNotCorrect" class="caution">信箱或密碼錯誤</span>
          <input
            type="password"
            v-model="signInPassword"
            placeholder="密碼"
            :class="{
              checkInput: !signInNotCorrect,
              correctInput: signInNotCorrect,
            }"
          />
          <span v-if="!signInNotCorrect" class="caution">信箱或密碼錯誤</span>
          <a href="#">忘記密碼?</a>
          <button @click="signInMem">登入</button> 
        </form>
      </div>
    </transition>









      <!-- 滑蓋區 -->
      <div class="overlay-container">
        <div class="overlay">
          <!-- signin滑蓋 -->
          <div class="overlay-panel overlay-left">
            <h1>歡迎回來!</h1>
            <p>登入與DIDADIDA一起探索海底世界吧!</p>
            <button class="ghost" @click="toggleSignUp">登入</button>
          </div>
          <!-- signup滑蓋 -->
          <div class="overlay-panel overlay-right">
            <h1>你好!</h1>
            <p>創建帳號加入DIDADIDA的海洋探索行列吧!</p>
            <button class="ghost" @click="toggleSignUp">註冊</button>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- --------------------------------------------- -->
  <div v-if="this.$store.state.storeShowLogin" class="rwdpart">
    <div class="backplate" @click="hideLogin"></div>

    <div
      class="container"
      id="container"
    >
    <!-- rwd signup填單 -->
    <div class="form-container rwd-sign-up-container" v-if ="isSign">
        <form>
          <h1>創建帳號</h1>
          <div class="social-container">
            <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social"><i class="fa-brands fa-google"></i></a>
            <a href="#" class="social"
              ><i class="fa-brands fa-instagram fa-lg"></i
            ></a>
          </div>
          <span>或使用電子郵件登入</span>
          <input
            type="text"
            v-model="name"
            placeholder="姓名"
            @input="testNameSignUp"
            :class="{ checkInput: !isValidName, correctInput: isValidName }"
          />
          <span v-if="!isValidName" class="caution">請輸入有效姓名</span>

          <input
            type="email"
            v-model="email"
            placeholder="電子信箱"
            @input="testMailSignUp"
            :class="{ checkInput: !isValidEmail, correctInput: isValidEmail }"
          />
          <span v-if="!isValidEmail" class="caution">請輸入有效的信箱</span>

          <input
            type="password"
            v-model="password"
            placeholder="密碼"
            @input="testPassWordSignUp"
            :class="{
              checkInput: !isValidPassword,
              correctInput: isValidPassword,
            }"
          />
          <span v-if="!isValidPassword" class="caution"
            >密碼長度需在8~12個字之間,至少含一個英文字母(不分大小寫)</span
          >

          <button @click.prevent="insertPerson">註冊</button>
          <div style="color: red" v-if="APIEmailCheck">帳號已重複</div>
          <button @click="toggleSwitch" class="rwdbtn" >或登入</button>
        </form>
      </div>
<!-- ----- -->

<!-- rwd signin填單 -->
<div class="form-container rwd-sign-in-container" v-if="!isSign">
        <form @submit.prevent="submitSignInForm">
          <h1>登入</h1>
          <div class="social-container">
            <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social"><i class="fa-brands fa-google"></i></a>
            <a href="#" class="social"
              ><i class="fa-brands fa-instagram fa-lg"></i
            ></a>
          </div>
          <span>或使用您的帳號</span>
          <input
            type="email"
            v-model="signInEmail"
            placeholder="電子信箱"
            :class="{
              checkInput: !signInNotCorrect,
              correctInput: signInNotCorrect,
            }"
          />
          <span v-if="!signInNotCorrect" class="caution">信箱或密碼錯誤</span>
          <input
            type="password"
            v-model="signInPassword"
            placeholder="密碼"
            :class="{
              checkInput: !signInNotCorrect,
              correctInput: signInNotCorrect,
            }"
          />
          <span v-if="!signInNotCorrect" class="caution">信箱或密碼錯誤</span>
          <a href="#">忘記密碼?</a>
          <button @click="signInMem">登入</button> 
          <button @click="toggleSwitch" class="rwdbtn"  >或註冊</button>
          
          
        </form>
      </div>
<!-- ----------->
   </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isSignUp: false,
      isSign:false,
      memArr: [],
      name: "",
      email: "",
      password: "",
      signInEmail: "",
      signInPassword: "",
      isValidName: true,
      isValidEmail: true,
      isValidPassword: true,
      signInNotCorrect: true,
      testEmail: "123@gmail.com",
      testPassword: "123",
      showAllPage: true,
      checkApiRes: false,
      APIEmailCheck: false,
      signInAPI: "",
    };
  },
  mounted() {
    localStorage.setItem("mem_account", "www@gmail.com");
    localStorage.setItem("mem_psww", "123456789a");
    this.signInEmail = localStorage.getItem("mem_account");
    this.signInPassword = localStorage.getItem("mem_psww");
  },

  methods: {
    insertPerson() {
      if (
        !this.isValidPassword ||
        !this.isValidName ||
        !this.isValidEmail ||
        !this.name ||
        !this.email ||
        !this.password
      ) {
        alert("失敗");
      } else {
        const formData = new FormData();

        let mem_email = this.email;

        formData.append("mem_email", mem_email);
        formData.append("checkEmail", 1);
        // fetch(`${this.$store.state.APIurl}labaSelect.php`);
        fetch(`${this.$store.state.APIurl}memberInsert.php`, {
          method: "post",
          body: formData,
        })
          .then((res) => {
            return res.json();
          })
          .then((data) => {
            if (Array.isArray(data) && data.length === 0) {
              // JSON 数组为空
              this.APIEmailCheck = false;
              console.log(this.APIEmailCheck);
              console.log(JSON.stringify(data));

              const formData = new FormData();
              let mem_email = this.email;
              let mem_name = this.name;
              let mem_psw = this.password;

              formData.append("mem_email", mem_email);
              formData.append("mem_name", mem_name);
              formData.append("mem_psw", mem_psw);

              fetch(`${this.$store.state.APIurl}memberInsert.php`, {
                method: "post",
                body: formData,
              }).then((res) => {
                return res.json();
              });

              alert("申請成功");
              this.email = "";
              this.name = "";
              this.password = "";
            } else {
              // JSON 数组非空
              this.APIEmailCheck = true;
            }
          });
      }
    },
    hideLogin() {
      this.$store.state.storeShowLogin = !this.$store.state.storeShowLogin;
      this.name = "";
      this.email = "";
      this.password = "";
      this.isValidName = true;
      this.isValidEmail = true;
      this.isValidPassword = true;
      this.signInEmail = "";
      this.signInPassword = "";
      this.signInNotCorrect = true;
    },
    signInMem() {
      const formData = new FormData();

      let mem_email = this.signInEmail;
      let mem_psw = this.signInPassword;
      formData.append("mem_email", mem_email);
      formData.append("mem_psw", mem_psw);
      fetch(`${this.$store.state.APIurl}memberSelect.php`, {
        method: "post",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          if (Array.isArray(data) && data.length === 0) {
            alert("帳號或密碼錯誤");
            return;
          } else if (data[0].mem_state == 1) {
            alert("此帳號已遭封鎖");
            return;
          }
          this.signInAPI = data;
          // this.$store.state.userName = this.signInAPI[0].mem_name;
          this.$store.commit("setUserName", data[0].mem_name);
          this.$store.state.memberId = data[0].mem_id;
          this.$store.state.memberEmail = this.signInEmail;
          console.log("this.$store.state.userName", this.$store.state.userName);
          console.log(this.signInAPI);

          this.$store.state.storeShowLogin = false;
          this.$store.state.isUserLoggedIn = true;
        });
      // fetch(
      //   `${this.$store.state.loginURL}/getConfirmMember.php`,
      //   // "https://tibamef2e.com/cgd103/g1/api/getConfirmMember.php"
      //   {
      //     method: "POST",
      //     // body: new URLSearchParams(input),
      //     body: new URLSearchParams({
      //       // mem_account: "charmy101@gmail.com",
      //       // mem_psw: "charmy101",
      //       mem_account: this.signInEmail,
      //       mem_psw: this.signInPassword,
      //     }),
      //   }
      // )
      //   .then((res) => res.json())
      //   .then((json) => {
      //     console.log(json);
      //     this.checkApiRes = json.code;
      //     console.log(this.checkApiRes);
      //     if (this.checkApiRes == 1) {
      //       this.$store.state.userName = json.memInfo.mem_name;
      //       console.log(this.$store.state.userName);
      //     }
      //   })
      //   .then(() => {
      //     if (this.checkApiRes == 0) {
      //       this.signInNotCorrect = false;
      //     } else if (this.checkApiRes == 1) {
      //       this.signInNotCorrect = true;
      //       this.$store.state.storeShowLogin =
      //         !this.$store.state.storeShowLogin;
      //     }
      //   });
    },
    testNameSignUp() {
      let regex = /^[\u4e00-\u9fa5]{2,4}$/;
      this.isValidName = regex.test(this.name);
    },
    testMailSignUp() {
      let regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
      this.isValidEmail = regex.test(this.email);
    },
    testPassWordSignUp() {
      let regex = /^(?=.*[a-zA-Z]).{8,12}$/;
      this.isValidPassword = regex.test(this.password);
    },
    toggleSignUp() {
      this.isSignUp = !this.isSignUp;
      if (!this.isSignUp) {
        this.name = "";
        this.email = "";
        this.password = "";
        this.isValidName = true;
        this.isValidEmail = true;
        this.isValidPassword = true;
      } else {
        this.signInEmail = "";
        this.signInPassword = "";
        this.signInNotCorrect = true;
      }
    },
    toggleSwitch() {
      this.isSign = !this.isSign; // Toggle the value of isSign
      if (!this.isSignUp) {
        this.name = "";
        this.email = "";
        this.password = "";
        this.isValidName = true;
        this.isValidEmail = true;
        this.isValidPassword = true;
      } else {
        this.signInEmail = "";
        this.signInPassword = "";
        this.signInNotCorrect = true;
      }
    },
    validateName() {
      // 正则表达式示例：只包含字母和空格的姓名
      var regex = /^[A-Za-z\s]+$/;
      this.isValidName = regex.test(this.name);
    },
    validateEmail() {
      // 正则表达式示例：验证电子邮件地址
      var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
      this.isValidEmail = regex.test(this.email);
    },
    validatePassword() {
      // 正则表达式示例：密码包含字母、数字和特殊字符
      var regex = /^(?=.*[a-zA-Z]).{8,12}$/;
      this.isValidPassword = regex.test(this.password);
    },
    submitSignUpForm() {
      this.validateName();
      this.validateEmail();
      this.validatePassword();

      // 在这里执行注册逻辑
      if (this.isValidName && this.isValidEmail && this.isValidPassword) {
        // 执行注册逻辑
        // ...
      }
    },
    submitSignInForm() {
      // 在这里执行登录逻辑
      // 使用 this.signInEmail 和 this.signInPassword 进行验证和登录
      // ...
    },
  },
};
</script>

<style scoped lang="scss">
@import url("https://fonts.googleapis.com/css2?family=Cardo:ital,wght@0,400;0,700;1,400&family=Inknut+Antiqua:wght@300;400;500;600;700;800;900&display=swap");
@import url("https://fonts.googleapis.com/css?family=Montserrat:400,800");

* {
  box-sizing: border-box;
}

.checkInput {
  border: 2px red solid;
}

.correctInput:focus {
  border: 2px black solid;
}

body {
  background: #f6f5f7;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  font-family: "Montserrat", sans-serif;
  height: 100vh;
  margin: -20px 0 50px;
  position: relative;
}

.backplate {
  width: 100%;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
  position: fixed;
  z-index: 9;
  top: 0;
  left: 0;
}

h1 {
  font-weight: bold;
  margin: 0;
}

h2 {
  text-align: center;
}

.caution {
  color: red;
}

p {
  font-size: 14px;
  font-weight: 100;
  line-height: 20px;
  letter-spacing: 0.5px;
  margin: 20px 0 30px;
}

span {
  font-size: 12px;
}

a {
  color: #333;
  font-size: 14px;
  text-decoration: none;
  margin: 15px 0;
}

button {
  border-radius: 20px;
  border: 1px solid #fff;
  background-color: #a2d2d4;
  color: map-get($colors, "light");
  font-size: 12px;
  font-weight: bold;
  padding: 12px 45px;
  letter-spacing: 1px;
  text-transform: uppercase;
  transition: transform 80ms ease-in;
  cursor: pointer;
}

button:active {
  transform: scale(0.95);
}

button:focus {
  outline: none;
}

button.ghost {
  background-color: transparent;
  border-color: #ffffff;
  cursor: pointer;
}

form {
  background-color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  padding: 0 50px;
  height: 100%;
  text-align: center;
}

input {
  background-color: #eee;
  border: none;
  padding: 12px 15px;
  margin: 8px 0;
  width: 100%;
}

input:focus {
  outline: none;
  /* 去掉外边框 */
  /* 或者将外边框样式设置为透明 */
  outline: 2px solid transparent;
}

.container {
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  position: fixed;
  z-index: 10;
  overflow: hidden;
  width: 768px;
  max-width: 100%;
  min-height: 480px;
  /* margin: 0 auto; */
  transform: translate(50%, -50%);
  top: 50%;
  right: 50%;
}

.form-container {
  position: absolute;
  top: 0;
  height: 100%;
  transition: all 0.6s ease-in-out;
}

.sign-in-container {
  left: 0;
  width: 50%;
  z-index: 2;
}

.container.right-panel-active .sign-in-container {
  transform: translateX(100%);
}

.sign-up-container {
  left: 0;
  width: 50%;
  opacity: 0;
  z-index: 1;
}

.container.right-panel-active .sign-up-container {
  transform: translateX(100%);
  opacity: 1;
  z-index: 5;
  animation: show 0.6s;
}

@keyframes show {
  0%,
  49.99% {
    opacity: 0;
    z-index: 1;
  }

  50%,
  100% {
    opacity: 1;
    z-index: 5;
  }
}

.overlay-container {
  position: absolute;
  top: 0;
  left: 50%;
  width: 50%;
  height: 100%;
  overflow: hidden;
  transition: transform 0.6s ease-in-out;
  z-index: 100;
}

.container.right-panel-active .overlay-container {
  transform: translateX(-100%);
}

.overlay {
  background-image: url(../../public/all_images/login_overlay2.jpg);
  /* background: #0b2d7b;
  background: -webkit-linear-gradient(to right, #0b2d7b, #475aab);
  background: linear-gradient(to right, #0b2d7b, #475aab); */
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center 80%;
  color: #ffffff;
  position: relative;
  left: -100%;
  height: 100%;
  width: 200%;
  transform: translateX(0);
  transition: transform 0.6s ease-in-out;
}

.container.right-panel-active .overlay {
  transform: translateX(50%);
}

.overlay-panel {
  position: absolute;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  padding: 0 40px;
  text-align: center;
  top: 0;
  height: 100%;
  width: 50%;
  transform: translateX(0);
  transition: transform 0.6s ease-in-out;
}

.overlay-left {
  transform: translateX(-20%);
}

.container.right-panel-active .overlay-left {
  transform: translateX(0);
}

.overlay-right {
  right: 0;
  transform: translateX(0);
}

.container.right-panel-active .overlay-right {
  transform: translateX(20%);
}

.social-container {
  margin: 20px 0;
}

.social-container a {
  border: 1px solid #dddddd;
  border-radius: 50%;
  display: inline-flex;
  justify-content: center;
  align-items: center;
  margin: 0 5px;
  height: 40px;
  width: 40px;
}
.rwd-sign-in-container {
 display: none;
}
.rwd-sign-up-container {
  display: none;
}
.rwdpart{
  display: none;
}

@media screen and (max-width: 414px){

  .container{
    width: 80%;
    transform: translateX(30%,-50%);
  }
  .backplate {
  width: 100%;
  height: 150vh;
  background-color: rgba(0, 0, 0, 0.5);
  position: fixed;
  z-index: 9;
  top: 0;
  left: 0;
}
.sign-in-container {
  display: none;
}
.sign-up-container {
  display: none;
}

.rwdpart{
  display: block;
}
.rwd-sign-in-container {
  display: block;
  left: 0;
  width: 100%;
  z-index: 2;
}
.rwd-sign-up-container {
  display: block;
  left: 0;
  width: 100%;
  z-index: 2;
}
.overlay {
  display:none;
}
.rwdbtn{
  color: rgb(153, 178, 186);
  background-color: transparent;
  font-size: 12px;
  width:fit-content;
  display: block;
  position: relative;
  left: 100px;
  bottom: -35px;
  text-decoration: underline;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}

.rwd-sign-up-container, .rwd-sign-in-container {
  opacity: 1;
}
}

</style>
