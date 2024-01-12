<template>
  <section class="profile__main">
    <!-- 姓名 -->
    <div class="field__group mem_name">
      <div class="name">
        <div class="field__label">姓名</div>

        <input
          type="text"
          class="field_input"
          maxlength="50"
          v-model="mem_name"
          disabled
        />
      </div>
      <!-- <div class="surname">
                <div class="field__label">姓</div>
                <input type="text" class="field_input" maxlength="50">
            </div> -->
    </div>
    <!-- 性別 -->
    <div class="field__group">
      <div>
        <div class="field__label">性別</div>
        <input
          type="text"
          class="field_input"
          v-model="mem_gender"
          placeholder="請輸入男或女或其他"
          @blur="cheackGender"
        />
      </div>
    </div>
    <!-- 出生日期 -->
    <div class="field__group">
      <div>
        <div class="field__label">出生日期</div>
        <input
          type="date"
          class="field_input"
          v-model="mem_birth"
          @blur="checkbirth"
        />
      </div>
    </div>
    <!-- 電話號碼 -->
    <div class="field__group">
      <div>
        <div class="field__label">電話號碼</div>
        <input
          type="tel"
          class="field_input"
          v-model="mem_mob"
          @blur="checkMob"
        />
      </div>
    </div>
    <!-- Email -->
    <div class="field__group">
      <div>
        <div class="field__label">聯絡Email</div>
        <input
          type="email"
          class="field_input mem_email"
          v-model="mem_email"
          disabled
        />
      </div>
    </div>
    <!-- 地址 -->
    <div class="field__group">
      <div>
        <div class="field__label">地址</div>
        <input type="text" class="field_input mem_addr" v-model="mem_address" />
      </div>
    </div>
  </section>
  <div class="field__action">
    <button class="mem_btn" @click="saveMem">儲存</button>
  </div>
</template>
<script>
export default {
  name: "memAccoutSettings",
  data() {
    return {
      mem_list: [],
      mem_address: "",
      mem_mob: "",
      mem_email: "",
      mem_birth: "",
      mem_gender: "",
      mem_name: "",
      mem_bonus: "",
    };
  },
  mounted() {
    if (this.$store.state.userName) {
      const formData = new FormData();

      let mem_name = this.$store.state.userName;

      formData.append("mem_name", mem_name);

      fetch(`${this.$store.state.APIurl}memAccoutSetting.php`, {
        method: "post",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          this.mem_list = data;
          this.mem_address = this.mem_list[0].mem_address;
          this.mem_bonus = this.$store.state.totalScorePoint = parseInt(
            this.mem_list[0].mem_bonus
          );
          this.mem_mob += this.mem_list[0].mem_mob;
          this.mem_email = this.mem_list[0].mem_email;
          this.mem_birth = this.mem_list[0].mem_birth;
          this.mem_gender = this.mem_list[0].mem_gender;
          this.mem_name = this.mem_list[0].mem_name;
        });
    }
  },
  methods: {
    saveMem() {
      const formData = new FormData();
      let mem_name = this.mem_name;
      let mem_address = this.mem_address;
      let mem_mob = this.mem_mob;
      let mem_birth = this.mem_birth;
      let mem_gender = this.mem_gender;
      formData.append("mem_name", mem_name);
      formData.append("mem_address", mem_address);
      formData.append("mem_mob", mem_mob);
      formData.append("mem_birth", mem_birth);
      formData.append("mem_gender", mem_gender);

      fetch(`${this.$store.state.APIurl}memAccoutUpdate.php`, {
        method: "post",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          if (Array.isArray(data) && data.length === 0) {
            alert("更新失敗");
          } else {
            alert("更新成功");
          }
        });
    },
    checkMob() {
      let pattern = /^09\d{8}$/;

      if (!pattern.test(this.mem_mob)) {
        alert("請確認手機號碼");
        this.mem_mob = "";
      }
    },
    checkbirth() {
      const currentDate = new Date();
      const year = currentDate.getFullYear();
      const month = currentDate.getMonth() + 1;
      const day = currentDate.getDate();

      const enteredYear = parseInt(this.mem_birth.substring(0, 4), 10);
      const enteredMonth = parseInt(this.mem_birth.substring(5, 7), 10);
      const enteredDay = parseInt(this.mem_birth.substring(8, 10), 10);

      if (
        enteredYear > year ||
        (enteredYear === year && enteredMonth > month) ||
        (enteredYear === year && enteredMonth === month && enteredDay > day)
      ) {
        alert("請確認出生日期");
        this.mem_birth = "";
        return;
      }
    },

    cheackGender() {
      if (
        this.mem_gender !== "男" &&
        this.mem_gender !== "女" &&
        this.mem_gender !== "其他"
      ) {
        this.mem_gender = "";
        alert("請輸入男or女or其他");
        return;
      }
    },
  },
};
</script>

<style scoped lang="scss">
.profile__main {
  width: 450px;
  height: 550px;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;

  .field__group {
    width: 430px;

    .field__label {
      letter-spacing: 1px;
      font-size: map-get($fontSizes, "p");
    }

    .field_input {
      width: 430px;
      height: 40px;
      margin: 5px 0;
      padding: 10px;
      letter-spacing: 1px;
      font-size: map-get($fontSizes, "p");
      border: 1px solid #333;
      border-radius: 5px;
    }
  }

  .mem_name {
    display: flex;
    justify-content: space-between;

    .field_input {
      width: 200px;
    }
  }
}

.field__action {
  width: 500px;
  margin: 0 auto;
  text-align: center;
  border-top: 1px solid;
  padding-top: 30px;
  margin-top: 60px;

  .mem_btn {
    width: 150px;
    height: 40px;
    border: 0;
    border-radius: 5px;
    font-size: map-get($fontSizes, "p");
    letter-spacing: 1px;
    color: map-get($colors, "light");
    background-color: map-get($colors, "h2Blue");
  }
}

@media screen and (max-width: 414px) {
  .profile__main {
    width: 100%;
    margin-top: 20px;

    .field__group {
      width: 90%;
      flex-direction: column;
      .field_input {
        width: 90%;
      }
      .field_input {
        width: 100%;
      }
    }

    .mem_email,
    .mem_addr {
      width: 300px;
    }

    .field_input {
      border: 0;
    }
  }

  .field__action {
    width: 100%;
    margin-top: 30px;
  }
}
</style>
