<template>
  <div class="mem_all">
    <div class="select">
      <div class="search">
        <select v-model="chooseAccOrName">
          <option value="帳號">帳號</option>
          <option value="姓名">姓名</option>
        </select>
        <input type="searchbar" v-model="search" :placeholder="chooseAccOrName == '帳號' ? '請輸入帳號' : '請輸入姓名'" />
        <button @click="searchAccOrName">搜尋</button>
      </div>
    </div>
    <div class="mem_content">
      <div class="title">
        <ul>
          <li>Email / 帳號</li>
          <li>姓名</li>
          <li>性別</li>
          <li>生日</li>
          <li>手機</li>
          <li>地址</li>
          <li>會員狀態</li>
        </ul>
      </div>
      <div class="mem_info">
        <ul v-for="(i, index) in memberAPISlice" :key="index">
          <li>{{ i.mem_email }}</li>
          <li>{{ i.mem_name }}</li>
          <li>{{ i.mem_gender }}</li>
          <li>{{ i.mem_birth }}</li>
          <li>{{ i.mem_mob }}</li>
          <li>{{ i.mem_address }}</li>
          <li>
            <switchBtn :onText="'正常'" :off-text="'黑名單'" :disabled="false" :item="i.mem_state == 0 ? '1' : '0'"
              @toggle="updateMemberState(i)"></switchBtn>
            <!-- <label>
              <input
                type="radio"
                :name="index"
                :checked="i.mem_state == 0"
                @change="radioPush(i.mem_name, i.mem_email, 0)"
              />
              正常
            </label>
            <label>
              <input
                type="radio"
                :name="index"
                :checked="i.mem_state == 1"
                @change="radioPush(i.mem_name, i.mem_email, 1)"
              />
              黑名單
            </label> -->
          </li>
        </ul>

        <!-- <div class="mem_email">
          <p>nini0218@gmail.com</p>
        </div>
        <div class="mem_name">
          <p>緯育李白</p>
        </div>

        <div class="mem_state">
          <p>黑名單</p>
        </div> -->
      </div>
    </div>
  </div>
</template>

<script>
import switchBtn from "../../components/backComponents/toggleBtn.vue";
export default {
  data() {
    return {
      chooseAccOrName: "帳號",
      imageSrc: "",
      search: "",
      memberAPISlice: [],
      memberAPI: [],
      allBar: [
        {
          select: false,
          change_txt: true,
          imageName: "dolphin_doll.png",
          imageSrc: require("../../../src/assets/images/dolphin_doll.png"),
          category: "玩偶",
          prod_name: "超可愛海豚寶寶玩偶",
          price: "399",
          category: "活動",
          prod_detail:
            "超可愛海豚寶寶玩偶的介紹超可愛海豚寶寶玩偶的介紹超可愛海豚寶寶玩偶的介紹超可愛海豚寶寶玩偶的介紹",
        },
      ],
    };
  },
  methods: {
    searchAccOrName() {
      if (this.chooseAccOrName == "帳號") {
        this.search = this.search.toUpperCase();
        let res = this.memberAPI.filter((item) => {
          let ans = item.mem_email.toUpperCase();
          return ans.includes(this.search);
        });
        this.memberAPISlice = res;
      } else if (this.chooseAccOrName == "姓名") {
        this.search = this.search.toUpperCase();
        let res = this.memberAPI.filter((item) => {
          let ans = item.mem_name;
          return ans.includes(this.search);
        });
        this.memberAPISlice = res;
      }
    },
    updateMemberState(item) {
      if (item.mem_state == 0) {
        item.mem_state = 1;

        const formData = new FormData();
        let mem_email = item.mem_email;
        let mem_state = 1;
        formData.append("mem_email", mem_email);
        formData.append("mem_state", mem_state);

        fetch(`${this.$store.state.APIurl}memberMgChangeState.php`, {
          method: "post",
          body: formData,
        }).then((res) => res.json());
      } else {
        item.mem_state = 0;

        const formData = new FormData();
        let mem_email = item.mem_email;
        let mem_state = 0;
        formData.append("mem_email", mem_email);
        formData.append("mem_state", mem_state);

        fetch(`${this.$store.state.APIurl}memberMgChangeState.php`, {
          method: "post",
          body: formData,
        }).then((res) => res.json());
      }
    },
    radioPush(name, email, item) {
      if (item == 0) {
        alert(`${name}的權限已改為正常`);

        const formData = new FormData();
        let mem_email = email;
        let mem_state = 0;
        formData.append("mem_email", mem_email);
        formData.append("mem_state", mem_state);

        fetch(`${this.$store.state.APIurl}memberMgChangeState.php`, {
          method: "post",
          body: formData,
        }).then((res) => res.json());
      } else if (item == 1) {
        alert(`${name}的權限已改為黑名單`);

        const formData = new FormData();
        let mem_email = email;
        let mem_state = 1;
        formData.append("mem_email", mem_email);
        formData.append("mem_state", mem_state);

        fetch(`${this.$store.state.APIurl}memberMgChangeState.php`, {
          method: "post",
          body: formData,
        }).then((res) => res.json());
      }
    },
    createNew() {
      const currentDate = this.getCurrentDate();
      this.allBar.push({
        change_txt: true,
        imageName: "",
        imageSrc: "",
        category: "",
        prod_name: "",
        price: "",
        category: "",
        prod_detail: "",
      });
      this.allBar[this.allBar.length - 1].imageSrc = "";
    },
    deleteSelected() {
      this.allBar = this.allBar.filter((item) => !item.select);
    },
    //獲取今天日期
    getCurrentDate() {
      const today = new Date();
      const year = today.getFullYear();
      const month = today.getMonth() + 1;
      const day = today.getDate();
      return `${year}.${month.toString().padStart(2, "0")}.${day
        .toString()
        .padStart(2, "0")}`;
    },

    fileChange(index, event, item) {
      const file = event.target.files[0];
      if (file) {
        item.imageName = file.name;
        // item.fileType = file.type;
        // item.fileSize = file.size;
        // item.lastModified = file.lastModified;

        const reader = new FileReader();
        reader.addEventListener("load", () => {
          this.allBar[index].imageSrc = reader.result;
        });
        reader.readAsDataURL(file);
      }
    },
    updateNews(index, e) {
      if (e.target.innerText == "確認") {
        this.allBar[index][0] = true;
        e.target.innerText = "修改";
        return;
      }
      this.allBar[index][0] = false;
      e.target.innerText = "確認";
    },
  },
  mounted() {
    fetch(`${this.$store.state.APIurl}memberMgSelect.php`) //第一步
      // fetch(`${this.$store.state.APIurl}helperMg.php`)
      //this.$store.state.APIurl
      // axios
      .then(function (response) {
        //第二步
        //要先傳回來編譯成json檔
        return response.json();
      })
      .then((data) => {
        // console.log(data);
        this.memberAPI = data;
        for (let i = 0; i < this.memberAPI.length; i++) {
          this.memberAPI[i].state = "1";
        }
        this.memberAPISlice = this.memberAPI;
      });
  },
  components: {
    switchBtn,
  },
  computed: {
    selectedCount() {
      return this.allBar.filter((item) => item.select).length;
    },
    newsCount() {
      return this.allBar.length;
    },
    selectAll: {
      get() {
        return this.selectedCount === this.newsCount && this.newsCount > 0;
      },
      set(value) {
        this.allBar.forEach((item) => {
          item.select = value;
        });
      },
    },
    // 模糊篩選
    memberAPI() {
      return this.memberAPI.filter((i) => {
        const searchText = this.search.toLowerCase();
        return (
          // 可以進行模糊篩選的欄位
          i.mem_name.toLowerCase().includes(searchText) ||
          i.mem_email.toLowerCase().includes(searchText) ||
          i.mem_mob.includes(this.search) ||
          i.mem_address.toLowerCase().includes(searchText)
        );
      });
    },
  },
};
</script>
<style scoped lang="scss">
.mem_all {
  .select {
    display: flex;
    justify-content: space-between;

    .search {
      input[type="searchbar"] {
        width: 200px;
        height: 30px;
        border-radius: 1rem;
        outline: none;
        border: 1px solid #b7b7b7;
        padding-left: 10px;
        margin-right: 10px;
      }

      button {
        width: 50px;
        height: 30px;
      }
    }
  }

  .mem_content {
    margin-top: 10px;

    .title {
      width: 100%;
      border-bottom: 1px solid #000;
      padding-bottom: 5px;
      font-weight: 800;

      ul {
        width: 100%;
        display: flex;
        text-align: center;
        justify-content: space-around;
        align-items: center;

        li {
          padding: 0 5px;

          &:nth-of-type(1) {
            width: 25%;
          }

          &:nth-of-type(2) {
            width: 10%;
          }

          &:nth-of-type(3) {
            width: 5%;
          }

          &:nth-of-type(4) {
            width: 13%;
          }

          &:nth-of-type(5) {
            width: 12%;
          }

          &:nth-of-type(6) {
            width: 25%;
          }

          &:nth-of-type(7) {
            width: 10%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
          }
        }
      }
    }

    .mem_info {
      width: 100%;
      border-bottom: 1px solid #000;

      ul {
        width: 100%;
        margin: 5px 0;
        display: flex;
        text-align: center;
        justify-content: space-around;
        align-items: center;

        li {
          padding: 0 5px;

          &:nth-of-type(1) {
            width: 25%;
          }

          &:nth-of-type(2) {
            width: 10%;
          }

          &:nth-of-type(3) {
            width: 5%;
          }

          &:nth-of-type(4) {
            width: 13%;
          }

          &:nth-of-type(5) {
            width: 12%;
          }

          &:nth-of-type(6) {
            width: 25%;
          }

          &:nth-of-type(7) {
            width: 10%;
            display: flex;
            flex-wrap: wrap;
          }
        }
      }
    }
  }
}
</style>
