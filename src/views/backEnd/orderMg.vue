<template>
  <Tabs value="name1">
    <!-- 訂單頁籤 -->
    <TabPane label="購物訂單" name="name1">
      <div class="titleAll">
        <select v-model="chooseProductOption">
          <option value="訂單編號">訂單編號</option>
          <option value="會員信箱">會員信箱</option>
        </select>
        <input type="text" :placeholder="chooseProductOption == '訂單編號'
          ? '請輸入訂單編號'
          : '請輸入會員信箱'
          " v-model="prodChooseOrder" />
        <div @click="prodChooseNameOrOrder">搜尋</div>
      </div>
      <div class="orderTableAll">
        <div class="tableTitleAll">
          <div>訂單編號</div>
          <div>會員帳號</div>
          <div class="to3">商品名稱</div>
          <div class="to4">數量</div>
          <div class="to5">時間</div>

          <div class="to6">狀態</div>
        </div>
        <div v-for="(i, index) in prodOrderSlice" class="singleOrderTable">
          <div class="o1">{{ i.ord_id }}</div>
          <div class="o2">{{ i.mem_email }}</div>
          <div class="o3">{{ i.prod_name }}</div>
          <div class="o4">{{ i.ord_qty }}</div>

          <div class="o5">{{ i.prodCount }}</div>
          <div class="o6">{{ i.ord_date }}</div>
          <!-- <div>{{ i.ord_state }}</div> -->
          <switchBtn class="o7" :onText="'已出貨'" :off-text="'待出貨'" :disabled="false" :item="i.state"
            @toggle="updateMemberState(i)"></switchBtn>
          <!-- <select>
            <option :value="i.ord_state">{{ i.ord_state }}</option>
          </select> -->

          <!-- <div class="updateOrderBtn">
            <div class="update" @click="updateOrder(index, $event, i)">
              <button>修改</button>
            </div>
          </div> -->
        </div>
      </div>
    </TabPane>
    <!-- 購票訂單頁籤 -->
    <TabPane label="票卷訂單" name="name2">
      <div class="titleAll">
        <select name="" v-model="chooseName">
          <option value="訂單編號">訂單編號</option>
          <option value="會員信箱">會員信箱</option>
        </select>
        <input type="text" :placeholder="chooseName == '訂單編號' ? '請輸入訂單編號' : '請輸入會員信箱'
          " v-model="chooseOrder" />
        <div @click="chooseNameOrOrder">搜尋</div>
      </div>
      <div class="ticketTableAll">
        <div class="ticketTableTitleAll">
          <div>訂單編號</div>
          <div>會員帳號</div>
          <div>票種</div>
          <div>單價</div>
          <div>票卷日期</div>
          <div>票卷狀態</div>
        </div>
        <div v-for="(i, index) in ticketOrderSlice" class="singleTicketBar" :key="index">
          <div class="t1">{{ i.tic_id }}</div>
          <div class="t2">{{ i.mem_email }}</div>
          <div class="t3">
            <!-- <div v-for="j in i.ticketType">{{ j }}</div> -->
            {{ i.tic_name }}
          </div>
          <div class="t4">
            <!-- <div v-for="j in i.ticketCount">{{ j }}</div> -->
            {{ i.tic_pay }}
          </div>
          <div class="t5">{{ i.tic_date }}</div>
          <div class="t6">{{ i.tic_state }}</div>
          <!-- <button>詳細資料</button> -->
          <!-- <button @click="toggleDetails(index, 'ticketOrder')">票券狀態</button>
         <div v-if="i.showDetails" class="details"> -->
          <!-- 這裡放置詳細資料欄位 -->
        </div>
      </div>
    </TabPane>
  </Tabs>
</template>
<script>
import switchBtn from "../../components/backComponents/toggleBtn.vue";
export default {
  name: "orderMg",
  data() {
    return {
      chooseProductOption: "訂單編號",
      chooseName: "訂單編號",
      chooseOrder: "",
      prodChooseName: "訂單編號",
      prodChooseOrder: "",
      prodOrder: [
        // {
        //   orderNumber: "abc12345",
        //   memberAccount: "asv3567878",
        //   prodName: ["海豚抱枕"],
        //   prodCount: 1,
        //   orderTime: "2023.08.31",
        //   orderState: "問題訂單",
        // },
        // {
        //   orderNumber: "abc12345",
        //   memberAccount: "asv3567878",
        //   prodName: ["海豚抱枕"],
        //   prodCount: 1,
        //   orderTime: "2023.08.31",
        //   orderState: "確認訂單",
        // },
        // {
        //   orderNumber: "abc12345",
        //   memberAccount: "asv3567878",
        //   prodName: ["海豚抱枕", "海星吊飾", "海星吊飾"],
        //   prodCount: 1,
        //   orderTime: "2023.08.31",
        //   orderState: "問題訂單",
        // },
      ],
      prodOrderSlice: [],
      ticketOrder: [
        // {
        //   orderNumber: "a123456",
        //   memberAccount: "asv3567878",
        //   ticketType: ["成人票"],
        //   ticketCount: [1],
        //   ticketDate: "2023.08.31",
        // },
        // {
        //   orderNumber: "a123456",
        //   memberAccount: "asv3567878",
        //   ticketType: ["學生票", "兒童票", "成人票"],
        //   ticketCount: [2, 1, 3],
        //   ticketDate: "2023.08.31",
        // },
        // {
        //   orderNumber: "a123456",
        //   memberAccount: "asv3567878",
        //   ticketType: ["成人票"],
        //   ticketCount: [1],
        //   ticketDate: "2023.08.31",
        // },
      ],
      orderAll: [],
      orderSlice: [],
      ticorderAll: [],
      ticketOrderSlice: [],
    };
  },
  components: {
    switchBtn,
  },
  computed: {},
  mounted() {
    ////fetch ordrMg.php
    fetch(`${this.$store.state.APIurl}prodOrderSelect.php`) //第一步
      // fetch(`${this.$store.state.APIurl}orderMg.php`)
      //this.$store.state.APIurl
      // axios
      .then(function (response) {
        //第二步
        //要先傳回來編譯成json檔
        return response.json();
      })

      .then((myJson) => {
        this.prodOrderSlice = this.prodOrder = myJson;
        for (let i = 0; i < this.prodOrder.length; i++) {
          if (this.prodOrder[i].ord_state == "已出貨") {
            this.prodOrder[i].state = "0";
          } else {
            this.prodOrder[i].state = "1";
          }
        }
        console.log(this.prodOrder);
      });

    ////fetch tickMg.php
    fetch(`${this.$store.state.APIurl}tickOrderMg.php`) //第一步
      // fetch(`${this.$store.state.APIurl}orderMg.php`)
      //this.$store.state.APIurl
      // axios
      .then(function (response) {
        //第二步
        //要先傳回來編譯成json檔
        return response.json();
      })

      .then((myJson) => {
        this.ticketOrderSlice = this.ticketOrder = myJson;
      });
  },

  methods: {
    // 商品狀態 (待出貨 已出貨)
    updateMemberState(i) {
      if (i.state == "1") {
        const formData = new FormData();
        let ord_id = i.ord_id;
        let ord_state = "已出貨";
        formData.append("ord_id", ord_id);
        formData.append("ord_state", ord_state);
        fetch(`${this.$store.state.APIurl}orderMgUpdate.php`, {
          method: "post",
          body: formData,
        });
        for (let j = 0; j < this.prodOrder.length; j++) {
          if (this.prodOrder[j].ord_id == i.ord_id) {
            this.prodOrder[j].state = "0";
            // alert(this.prodOrder[i].ord_id);
          }
          // console.log(this.prodOrder[j].ord_id == i.ord_id);
        }
        i.state = "0";
      } else {
        const formData = new FormData();
        let ord_id = i.ord_id;
        let ord_state = "待出貨";
        formData.append("ord_id", ord_id);
        formData.append("ord_state", ord_state);
        fetch(`${this.$store.state.APIurl}orderMgUpdate.php`, {
          method: "post",
          body: formData,
        });
        for (let j = 0; j < this.prodOrder.length; j++) {
          if (this.prodOrder[j].ord_id == i.ord_id) {
            this.prodOrder[j].state = "1";
            // alert(this.prodOrder[i].ord_id);
          }
          // console.log(this.prodOrder[j].ord_id == i.ord_id);
        }
        i.state = "1";
      }
    },
    ////購物訂單
    prodResetArr() {
      if (this.prodChooseOrder == "") {
        this.orderSlice = this.prodOrder;
      }
    },
    prodChooseNameOrOrder() {
      if (this.chooseProductOption == "訂單編號") {
        this.prodChooseOrder = this.prodChooseOrder.toUpperCase();
        let res = this.prodOrder.filter((item) => {
          let ans = item.ord_id;
          return ans.includes(this.prodChooseOrder);
        });
        this.prodOrderSlice = res;
      } else if (this.chooseProductOption == "會員信箱") {
        this.prodChooseOrder = this.prodChooseOrder.toUpperCase();
        let res = this.prodOrder.filter((item) => {
          let ans = item.mem_email.toUpperCase();
          return ans.includes(this.prodChooseOrder);
        });
        this.prodOrderSlice = res;
      } else {
        this.prodOrderSlice = this.prodOrder;
      }
    },
    toggleDetails(index, dataType) {
      if (dataType === "prodOrder") {
        this.prodOrder[index].showDetails = !this.prodOrder[index].showDetails;
      } else if (dataType === "ticketOrder") {
        this.ticketOrderSlice[index].showDetails =
          !this.ticketOrderSlice[index].showDetails;
      }
    },

    ////購票訂單
    resetArr() {
      if (this.chooseOrder == "") {
        this.ticketOrderSlice = this.ticketOrder;
      }
    },
    chooseNameOrOrder() {
      if (this.chooseName == "訂單編號") {
        this.chooseOrder = this.chooseOrder.toUpperCase();
        let res = this.ticketOrder.filter((item) => {
          let ans = item.tic_id;
          return ans.includes(this.chooseOrder);
        });
        this.ticketOrderSlice = res;
      } else if (this.chooseName == "會員信箱") {
        this.chooseOrder = this.chooseOrder.toUpperCase();
        let res = this.ticketOrder.filter((item) => {
          let ans = item.mem_email.toUpperCase();
          return ans.includes(this.chooseOrder);
        });
        this.ticketOrderSlice = res;
      } else {
        this.ticketOrderSlice = this.ticketOrder;
      }
    },

    updateOrder(index, e, i) {
      if (e.target.innerText == "確認") {
        this.orderAll[index].dis = true;
        e.target.innerText = "修改";

        const formData = new FormData();
        let ord_id = i.ord_id;
        let ord_date = this.orderAll[index].ord_date;
        let ord_sum = this.orderAll[index].ord_sum;
        let ord_ship = this.orderAll[index].ord_ship;
        let ord_pay = this.orderAll[index].ord_pay;
        let ord_person = this.orderAll[index].ord_person;
        let ord_phone = this.orderAll[index].ord_phone;
        let ord_add = this.orderAll[index].ord_add;
        let ord_state = this.orderAll[index].ord_state;
        let ord_redeem = this.orderAll[index].ord_redeem;

        formData.append("ord_id", ord_id);
        formData.append("ord_date", ord_date);
        formData.append("ord_sum", ord_sum);
        formData.append(" ord_ship ", ord_ship);
        formData.append("ord_pay", ord_pay);
        formData.append("ord_person ", ord_person);
        formData.append("ord_phone", ord_phone);
        formData.append("ord_add", ord_add);
        formData.append("ord_state", ord_state);
        formData.append("ord_redeem", ord_redeem);
        fetch(`${this.$store.state.APIurl}orderMg.php`, {
          method: "post",
          body: formData,
        }).then((res) => res.json());
        return;
      }
      this.orderAll[index].dis = false;
      e.target.innerText = "確認";
    },
  },
};
</script>
<style lang="scss" scoped>
.titleAll {
  display: flex;

  select {
    margin-right: 15px;
  }

  input {
    margin-right: 15px;
  }

  div {
    border: 1px black solid;
    padding: 3px 10px;
    border-radius: 5px;
    cursor: pointer;
  }
}

.ticketTableAll {
  .ticketTableTitleAll {
    padding: 10px 0px;
    border-bottom: 1px black solid;
    display: flex;
    justify-content: space-around;

    div {
      flex-grow: 1;

      &:last-child {
        flex-grow: 2;
      }
    }
  }

  .ticketTableTitleAll>div {
    &:nth-of-type(1) {
      margin-left: 25px;
      width: 16%;
    }

    &:nth-of-type(2) {
      margin-left: 30px;
      width: 25%;
    }

    &:nth-of-type(3) {
      margin-left: 50px;
      width: 16%;
    }

    &:nth-of-type(4) {
      margin-left: 40px;
      width: 16%;
    }

    &:nth-of-type(5) {
      margin-left: 40px;
      width: 16%;
    }

    &:nth-of-type(6) {
      margin-left: 40px;
      width: 16%;
    }


  }

  .singleTicketBar {
    display: flex;
    border-bottom: 1px black solid;
    padding-bottom: 5px;
    padding-top: 5px;
    align-items: center;
    justify-content: space-around;
  }
}

.orderTableAll {
  .tableTitleAll {
    display: flex;
    justify-content: space-around;
    padding-bottom: 10px;
    border-bottom: 1px rgb(97, 18, 18) solid;
    padding-top: 10px;
    font-weight: 800;

    div {
      flex-grow: 1;

      &:last-child {
        flex-grow: 1.5;
      }
    }
  }

  .singleOrderTable {
    display: flex;
    border-bottom: 1px black solid;
    padding-top: 5px;
    padding-bottom: 5px;
    align-items: center;
    justify-content: space-between;
  }

  //  .o1{
  //   margin-right: 10px;
  //   margin-left: 20px;
  //  }
  //  .accounttitle{
  //   margin-right: 150px;
  //  }
  //  .o2{
  //   margin-left: 50px;
  //  }
  //  .o3{
  //   margin-left: 70px;
  //   margin-right: 20px;
  //  }
  .to3 {
    margin-left: 70px;
  }

  .to4 {
    margin-left: 30px;
  }

  .to5 {
    margin-right: 40px;
  }

  .to5 {
    margin-left: 45px;
  }

  .singleOrderTable>div {

    &:nth-of-type(1) {
      margin-left: 10px;
      width: 10%;
    }

    &:nth-of-type(2) {
      width: 25%;
    }

    &:nth-of-type(3) {
      width: 15%;
    }

    &:nth-of-type(4) {
      margin-left: 40px;
      width: 1%;
    }

    &:nth-of-type(5) {
      width: 10%;
    }

    &:nth-of-type(6) {
      width: 10%;
    }

    &:nth-of-type(7) {
      margin-top: 2px;
      width: 10%;
    }

  }
}
</style>
