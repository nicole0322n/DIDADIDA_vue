<template>
  <div class="tick_order_main">
    <div class="tick_area">
      <div style="margin: 0 10px 0 auto;" >
        <select v-model="selectOrder" v-if="!dateOrNum" class="sbtn">
          <option value="請選擇">請選擇</option>
          <option :value="i.uniqid_num" v-for="(i, index) in ticketOrderSlice" class="orderNumTitle">
            {{ i.tic_date }}
          </option>
        </select>
        <select v-model="selectOrder" v-if="dateOrNum" class="sbtn">
          <option value="請選擇">請選擇</option>
          <option :value="i.uniqid_num" v-for="(i, index) in ticketOrderSlice" class="orderNumTitle">
            {{ i.uniqid_num }}
          </option>
        </select>
        <button @click="dateOrNum = !dateOrNum" class="sbtn" >切換</button>
      </div>

      <div class="tick_order_group" v-for="(tick, index) in filteredTickOrder" :key="tick.tickImg" :class="{
        tick_order_group_used:
          this.$store.state.activeIndexes.findIndex(
            (v) => v.tickIdx === index
          ) > -1 ||
          tick.tic_late ||
          tick.tic_state === '已使用',
      }">
        <div class="tick_img">
          <img :src="tick.tickImg" alt="" />
        </div>
        <div class="tick_info">
          <div class="item_info tick_item">
            <p>票種</p>
            <p>
              {{ tick.tic_name }}
            </p>
          </div>
          <div class="item_info tick_count">
            <p>數量</p>
            <!-- <p>{{ tick.tickName }}</p> -->
            <p>1</p>
          </div>
          <div class="item_info tick_date">
            <p>時間</p>
            <p>{{ tick.tic_date }}</p>
          </div>
          <div class="item_info tick_price">
            <p>金額</p>
            <p>NT$ {{ tick.tic_pay }}</p>
          </div>
          <div>
            <QRCode :tic_state="tick.tic_state" :tic_id="tick.tic_id" :tic_late="tick.tic_late" :checkDate="tick.tic_date"
              :ticketIndex="index" @click="activateGrayBkc(index)" @checkTicket="getCheck"></QRCode>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import memChangePage from "../components/memChangePage.vue";
import QRCode from "../components/QRCode.vue";
export default {
  name: "prodOrderInquiry",
  components: {
    memChangePage,
    QRCode,
  },
  data() {
    return {
      dateOrNum: false,
      selectOrder: "請選擇",
      grayBkc: false,
      activeIndexes: [],
      ticketOrderSlice: "",
      tickOrder: [
        // {
        //     tickImg: require("../assets/images/dolphin_pillow.jpg"),
        //     tickName: "一般全票",
        //     tickCount: "2",
        //     tickDate: "2023.08.31",
        //     tickPrice: "250",
        // },
        // {
        //     tickImg: require("../assets/images/dolphin_pillow.jpg"),
        //     tickName: "一般全票",
        //     tickCount: "2",
        //     tickDate: "2023.08.31",
        //     tickPrice: "250",
        // },
        // {
        //     tickImg: require("../assets/images/dolphin_pillow.jpg"),
        //     tickName: "一般全票",
        //     tickCount: "2",
        //     tickDate: "2023.08.31",
        //     tickPrice: "250",
        // },
        // {
        //     tickImg: require("../assets/images/dolphin_pillow.jpg"),
        //     tickName: "一般全票",
        //     tickCount: "2",
        //     tickDate: "2023.08.31",
        //     tickPrice: "250",
        // },
      ],
    };
  },
  mounted() {
    const formData = new FormData();

    let mem_email = this.$store.state.memberEmail;
    formData.append("mem_email", mem_email);
    fetch(`${this.$store.state.APIurl}tickOrderPrint.php`, {
      method: "post",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        // 处理数据，添加 tickImg 和 tic_late 属性
        for (let i = 0; i < data.length; i++) {
          data[i].tickImg = require("../../public/all_images/ticket_face.jpg");
          data[i].tic_late = false;
        }

        // 将处理后的数据保存到组件的 tickOrder 属性
        this.tickOrder = data;
        this.ticketOrderSlice = [...this.tickOrder]; // 复制原始数组

        for (let i = 0; i < this.ticketOrderSlice.length; i++) {
          for (let j = i + 1; j < this.ticketOrderSlice.length; j++) {
            if (
              this.ticketOrderSlice[i].uniqid_num ===
              this.ticketOrderSlice[j].uniqid_num
            ) {
              this.ticketOrderSlice.splice(j, 1); // 如果找到重复项，则删除
              j--; // 减少索引以补偿删除元素
            }
          }
        }
        // 继续处理数据，设置 tic_late 属性
        const currentDate = new Date();
        this.tickOrder.forEach((item) => {
          const ticDate = new Date(item.tic_date);
          // let late_date = currentDate > ticDate;

          // 移除日期和时间部分
          const currentDateWithoutTime = new Date(currentDate.toDateString());
          const ticDateWithoutTime = new Date(ticDate.toDateString());

          // 检查日期是否在未来
          let late_date = currentDateWithoutTime > ticDateWithoutTime;
          if (late_date) {
            const formData = new FormData();

            let tic_date = item.tic_date;
            let tic_state = "已過期";
            formData.append("tic_date", tic_date);
            formData.append("tic_state", tic_state);
            fetch(`${this.$store.state.APIurl}tickOrderInquiryLate.php`, {
              method: "post",
              body: formData,
            }).then((res) => res.json());
          }
          item.tic_late = late_date;
        });
      })
      .catch((error) => {
        console.error("Error fetching data:", error);
      });
  },
  computed: {
    filteredTickOrder() {
      if (!this.selectOrder || this.selectOrder == "請選擇") {
        return this.tickOrder; // 当 selectOrder 为空时返回所有 tickOrder
      } else {
        return this.tickOrder.filter(
          (tick) => tick.uniqid_num === this.selectOrder
        );
      }
    },

    activeList(idx) {
      return this.$store.state.activeIndexes[idx];
    },
  },
  methods: {
    getCheck(data, idx) {
      console.log(data, idx);
    },
    isGrayBkcActive(index) {
      return this.activeIndexes.includes(index);
    },
    activateGrayBkc(index) {
      // 将索引添加到activeIndexes中
      if (this.getCheck) {
        // this.activeIndexes.push(index);
        // alert(123);
      }
    },
    getRsp(data) {
      this.grayBkc = data;
    },
  },
};
</script>

<style scoped lang="scss">
.tick_order_main {
  p {
    color: map-get($colors, "dark");
  }

  .tick_area {
    width: 500px;
    height: 850px;
    border: 0;
    border-radius: 15px;
    margin: 0 auto;
    background-color: map-get($colors, "memarea");
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    overflow-y: auto;

    select {
      background-color: #1FB0CB;
      border: 0;
      border-radius: 5px;
      padding: 3px;
      color: #eee;
      margin-left: auto;
      margin-top: 10px;
      outline: none;
    }

    button {
      background-color: #1FB0CB;
      border: 0;
      border-radius: 5px;
      color: #eee;
      padding: 3px;
      margin-left: 5px;
    }

    .orderNumBox {
      display: flex;
      justify-content: space-around;
      flex-direction: row;
      background-color: gold;
      width: 100%;

      .orderNumTitle {
        border: 1px black solid;
        cursor: pointer;
      }
    }

    &::-webkit-scrollbar {
      width: 10px;
    }

    &::-webkit-scrollbar-track-piece {
      background: transparent;
    }

    &::-webkit-scrollbar-thumb {
      border-radius: 4px;
      background-color: rgba(0, 0, 0, 0.2);
      // border: 1px solid slategrey;
    }

    &::-webkit-scrollbar-track {
      box-shadow: transparent;
    }

    &::-webkit-scrollbar-button {
      height: 5px;
      background: transparent;
      border-radius: 4px;
    }

    .tick_order_group {
      width: 460px;
      border-bottom: 1px solid #eee;
      display: flex;
      justify-content: space-evenly;

      // z-index: 2;
    }

    .tick_late {
      background-color: gray;
      color: rgb(147, 144, 144);
    }

    .tick_order_group_used {
      background-color: gray;
      color: rgb(147, 144, 144);
    }

    .tick_order_group:last-child {
      border-bottom: 0;
    }

    .tick_img {
      width: 50%;
      height: 150px;
      margin: 20px auto;
      border: 0;
    }

    .tick_img img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    .tick_info {
      width: 50%;
      height: 150px;
      margin: 20px auto;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      align-items: flex-start;
    }

    .item_info {
      width: 100%;
      padding: 5px;
      display: flex;
      justify-content: space-evenly;
    }

    .item_info p:first-child {
      width: 30%;
      text-align: center;
      background-color: map-get($colors, "bgc");
    }

    .item_info p:nth-child(2) {
      width: 70%;
      margin-left: 10px;
    }
  }
  .sbtn{
    cursor: pointer;
  }
}

@media screen and (max-width: 414px) {
  .tick_order_main {
    .tick_area {
      width: 330px;
      height: 720px;

      .tick_order_group {
        width: 300px;
      }

      .tick_img {
        width: 50%;
      }

      .tick_info {
        width: 50%;
      }
    }
  }
}
</style>
