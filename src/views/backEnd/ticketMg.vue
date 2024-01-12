<template>
  <Tabs value="name1">
    <TabPane label="票種 / 票價管理" name="name1">
      <button class="add" @click="createNewOne">+ 新增項目</button>

      <li>
        <p class="tickettype">票種</p>
        <p>價格</p>
        <p>條件</p>
      </li>
      <ul v-for="(i, index) in helperAll2" :key="index">
        <li>
          <p class="tickettype">
            <label for=""><input type="text" v-model="i.tic_name" :disabled="i.dis" /></label>
          </p>
          <p>
            <label for=""><input type="text" v-model="i.tic_price" :disabled="i.dis" /></label>
          </p>
          <p>
            <textarea name="" id="" cols="30" rows="5" v-model="i.tic_info" :disabled="i.dis"></textarea>
          </p>

          <div class="updateBtnAll">
            <button @click="updateTicket(index, $event, i)">修改</button>
            <switchBtn :onText="'上架'" :off-text="'下架'" :disabled="i.dis" :item="i.tick_state == '1' ? '1' : '0'"
              @toggle="updateTickState(i)"></switchBtn>
          </div>
        </li>

        <!-- //    <li>
    //       <p class="tickettype">一般票</p>
    //       <p>NT 500</p>
    //       <p>限18歲(含)以上成人使用</p>
    //       <button >修改</button>
    //     </li>
    //     <li>
    //       <p class="tickettype">學生票</p>
    //       <p>NT 300</p>
    //       <p>限12歲(含)以上持學生證之學生適用</p>
    //       <button >修改</button>
    //     </li>
    //     <li>
    //       <p class="tickettype">孩童票</p>
    //       <p>NT 200</p>
    //       <p>限4歲(含)以上及未滿12歲兒童適用</p>
    //       <button>修改</button>
    //     </li>
    //     <li>
    //       <p class="tickettype">優待票</p>
    //       <p>NT 200</p>
    //       <p>
    //         限持有身心障礙證明者、身心障礙者的1位陪同者、孕婦、滿65歲以上長者適用
    //       </p>
    //       <button>修改</button>
    //     </li>
    //     <li>
    //       <p>團體票</p>
    //       <p>NT 350</p>
    //       <p>
    //         最低人数要求：團隊人数必須超过 10 人，才能享受團體票折扣。
    //       </p>
    //       <button>修改</button>
    //     </li>  -->
      </ul>
    </TabPane>

    <TabPane label="不開放時間管理" name="name2">
      <p>選擇日期</p>
      <div class="dateTextAll">
        <div class="dateAll">
          <div class="calendar">
            <VDatePicker v-model="date" borderless expanded :min-date="new Date()" locale="tw" mode="date"
              :disabled="disableDateSelection" :events="eventDates" />
          </div>
        </div>
        <div class="select">
          <p>
            <span :style="{ color: computedTextColor }">已選日期: {{ formattedDate }}</span>
          </p>
          <input type="checkbox" @change="changeDate" v-model="checkDateBtn" />確定不開放
          <div>
            目前狀態 :
            <span :style="{ color: computedTextColor }">{{ nowState }}</span>
          </div>
        </div>
      </div>
    </TabPane>
  </Tabs>
</template>

<script>
import { resolveTransitionHooks } from "vue";
import switchBtn from "../../components/backComponents/toggleBtn.vue";
export default {
  name: "bookDate",
  data() {
    return {
      upOrDown: "1",
      checkDateBtn: false,
      state: "",
      date: null, // 选定的日期
      // 初始化 selectedDates 以存储已选择的日期
      selectedDates: [],
      disabledDateRanges: [
        // // 禁用 2023 年 10 月 15 日到 2023 年 10 月 20 日
        // [new Date("2023-10-15"), new Date("2023-10-20")],
        // [new Date("2023-10-28")],
        // // 禁用 2023 年 11 月 1 日到 2023 年 11 月 5 日
        // [new Date("2023-11-01"), new Date("2023-11-05")],
      ],
      disableDateSelection: false, // 是否禁用日期选择的标志
      eventDates: [], // 存储已选择的日期的数组
      ticket: [
        {
          ticketname: "一般票",
          price: "NT 500",
          content: "限18歲(含)以上成人使用",
          change: true,
        },
        {
          ticketname: "學生票",
          price: "NT 300",
          content: "限12歲(含)以上持學生證之學生適用",
          change: true,
        },
        {
          ticketname: "孩童票",
          price: "NT 200",
          content: "限4歲(含)以上及未滿12歲兒童適用",
          change: true,
        },
        {
          ticketname: "優待票",
          price: "NT 150",
          content:
            "限持有身心障礙證明者、身心障礙者的1位陪同者、孕婦、滿65歲以上長者適用",
          change: true,
        },
        {
          ticketname: "團體票",
          price: "NT 350",
          content:
            " 最低人数要求：團隊人數必須超過 10 人，才能享受團體票折扣。",
          change: true,
        },
      ],
      helperAll2: [],
    };
  },

  mounted() {
    fetch(`${this.$store.state.APIurl}closeDateSelect.php`)
      .then(function (response) {
        return response.json();
      })
      .then((data) => {
        for (let i = 0; i < data.length; i++) {
          data[i].close_date = new Date(`${data[i].close_date}`);
          this.disabledDateRanges.push(data[i].close_date);
        }
      });
    fetch(`${this.$store.state.APIurl}ticketMg.php`) //第一步
      // fetch(`${this.$store.state.APIurl}helperMg.php`)
      //this.$store.state.APIurl
      .then(function (response) {
        //第二步
        //要先傳回來編譯成json檔
        return response.json();
      })

      .then((myJson) => {
        for (let i = 0; i < myJson.length; i++) {
          myJson[i].dis = true;
        }
        //第三步 裝在data陣列裡
        this.helperAll2 = myJson;
        console.log(this.helperAll2);
      });
  },
  beforeDestroy() { },
  computed: {
    checkArr() {
      for (let i = 0; i < this.disabledDateRanges.length; i++) {
        if (
          this.disabledDateRanges[i].getDate() ===
          new Date(this.date).getDate() &&
          this.disabledDateRanges[i].getMonth() ===
          new Date(this.date).getMonth()
        ) {
          return true;
        } else {
          return false;
        }
      }
    },
    nowState() {
      let isOpen = true; // 默认状态为开放

      for (let i = 0; i < this.disabledDateRanges.length; i++) {
        // console.log(this.disabledDateRanges[i]);
        // console.log(new Date(this.date));
        if (
          this.disabledDateRanges[i].getDate() ===
          new Date(this.date).getDate() &&
          this.disabledDateRanges[i].getMonth() ===
          new Date(this.date).getMonth() &&
          this.disabledDateRanges[i].getFullYear() ===
          new Date(this.date).getFullYear()
        ) {
          isOpen = false;
          break;
        }
        if (!isOpen) {
          break; // 如果状态为关闭，跳出外部循环
        }
      }

      return isOpen ? "開放" : "關閉";
    },

    computedTextColor() {
      // 在这里使用计算属性来返回文本颜色
      if (this.nowState == "關閉") {
        this.checkDateBtn = true;
      } else {
        this.checkDateBtn = false;
      }
      return this.nowState == "關閉" ? "red" : "blue";
    },
    containerStyles() {
      // 在这里返回一个包含自定义样式的对象
      return {
        backgroundColor: "lightblue",
        /* 添加其他自定义样式，如文本颜色、边框等 */
      };
    },
    catchDate() {
      return `${new Date(this.date).getFullYear()}.${new Date(this.date).getMonth() + 1
        }.${new Date(this.date).getDate()}`;
    },

    // 日期格式
    formattedDate() {
      if (this.date) {
        const dateObject = new Date(this.date);
        const year = dateObject.getFullYear();
        const month = String(dateObject.getMonth() + 1).padStart(2, "0");
        const day = String(dateObject.getDate()).padStart(2, "0");

        return `${year}-${month}-${day}`;
      } else {
        return "";
      }
    },
  },
  components: {
    switchBtn,
  },
  methods: {
    updateTickState(i) {
      if (i.tick_state == "1") {
        const formData = new FormData();
        let tictype_id = i.tictype_id;
        i.tick_state = "0";
        formData.append("tictype_id", tictype_id);
        formData.append("tick_state", i.tick_state);
        fetch(`${this.$store.state.APIurl}ticketMgUpdateState.php`, {
          method: "post",
          body: formData,
        }).then((res) => res.json());
      } else {
        const formData = new FormData();
        let tictype_id = i.tictype_id;
        i.tick_state = "1";
        formData.append("tictype_id", tictype_id);
        formData.append("tick_state", i.tick_state);
        fetch(`${this.$store.state.APIurl}ticketMgUpdateState.php`, {
          method: "post",
          body: formData,
        }).then((res) => res.json());
      }
    },
    changeDate() {
      // alert(this.checkDateBtn);
      if (this.checkDateBtn) {
        const formData = new FormData();

        let close_date = this.formattedDate;
        formData.append("close_date", close_date);
        fetch(`${this.$store.state.APIurl}ticketMgInsert.php`, {
          method: "post",
          body: formData,
        }).then((res) => res.json());

        alert("已被設定為不開放");
        this.disabledDateRanges.push(new Date(`${this.formattedDate}`));
      } else if (!this.checkDateBtn) {
        const formData = new FormData();

        let close_date = this.formattedDate;
        formData.append("close_date", close_date);
        fetch(`${this.$store.state.APIurl}ticketMgDel.php`, {
          method: "post",
          body: formData,
        }).then((res) => res.json());
        for (let i = 0; i < this.disabledDateRanges.length; i++) {
          if (
            this.disabledDateRanges[i].getDate() ===
            new Date(this.date).getDate() &&
            this.disabledDateRanges[i].getMonth() ===
            new Date(this.date).getMonth() &&
            this.disabledDateRanges[i].getFullYear() ===
            new Date(this.date).getFullYear()
          ) {
            this.disabledDateRanges.splice(i, 1);
            this.checkDateBtn = false;
          }
        }
        alert("已被設定為開放");
      }
    },
    createNewOne() {
      this.helperAll2.push({
        tictype_id: 0,
        tic_name: "",
        dis: true,
        tic_price: 0,
        tic_info: "",
      });
    },
    onDateSelected() {
      if (this.date) {
        // 将选定的日期添加到已选择的日期数组
        this.selectedDates.push(this.date);
        // 将选定的日期添加到事件日期数组以便在日历中显示
        this.eventDates.push({
          start: this.date,
          end: this.date,
          color: "primary", // 可以根据需要选择颜色
        });
        // 禁用日期选择
        this.disableDateSelection = true;
      }
    },

    updateTicket(index, e, i) {
      if (i.tictype_id == 0) {
        if (e.target.innerText == "確認") {
          this.helperAll2[index].dis = true;
          e.target.innerText = "修改";

          const formData = new FormData();

          let tic_name = this.helperAll2[index].tic_name;
          let tic_info = this.helperAll2[index].tic_info;
          let tic_price = this.helperAll2[index].tic_price;

          formData.append("tic_name", tic_name);
          formData.append("tic_info", tic_info);
          formData.append("tic_price", tic_price);
          fetch(`${this.$store.state.APIurl}ticketMgInsertTicType.php`, {
            method: "post",
            body: formData,
          }).then((res) => res.json());
          return;
        }
        this.helperAll2[index].dis = false;
        e.target.innerText = "確認";
        return;
      }
      if (e.target.innerText == "確認") {
        this.helperAll2[index].dis = true;
        e.target.innerText = "修改";

        const formData = new FormData();
        let tictype_id = i.tictype_id;
        let tic_name = this.helperAll2[index].tic_name;
        let tic_info = this.helperAll2[index].tic_info;
        let tic_price = this.helperAll2[index].tic_price;

        formData.append("tictype_id", tictype_id);
        formData.append("tic_name", tic_name);
        formData.append("tic_info", tic_info);
        formData.append("tic_price", tic_price);
        fetch(`${this.$store.state.APIurl}ticketUpdate.php`, {
          method: "post",
          body: formData,
        }).then((res) => res.json());
        alert("修改成功");
        return;
      }
      this.helperAll2[index].dis = false;
      e.target.innerText = "確認";
    },
  },

  // 添加此方法以禁用已选择的日期
  disableSelectedDates(date) {
    // 检查日期是否在已选择的日期数组中，如果在则返回 true，否则返回 false
    return this.selectedDates.some((selectedDate) => {
      return (
        selectedDate.getFullYear() === date.getFullYear() &&
        selectedDate.getMonth() === date.getMonth() &&
        selectedDate.getDate() === date.getDate()
      );
    });
  },
};
</script>

<style lang="scss" scoped>
// .ivu-tabs .ivu-tabs-tabpane{
//     width: 60%;
//     height: 60%;
// }
.calendar .vc-container {
  /* 使用computed中的样式属性 */
  background-color: var(--container-background-color);
  /* 添加其他样式规则，如果需要的话 */
}

.name2 p {
  margin-left: 30px;
  border: 2px black solid;
}

:deep(.calendar) .vc-disabled {
  cursor: not-allowed;
  text-decoration: line-through;
}

:deep(.calendar) .vc-week {
  padding: 10px;
}

:deep(.calendar) .vc-weekdays {
  padding: 10px;
}

:deep(.calendar) .vc-weeks {
  margin: 10px;
}

:deep(.calendar) .vc-header {
  height: 50px;
  background-color: map-get($colors, "secondary");
  margin: 0;
  //   padding-left: 150px;
  //   padding-right: 150px;
}

:deep(.calendar) .vc-arrow,
:deep(.calendar) .vc-title {
  color: map-get($colors, "light");
  background-color: map-get($colors, "secondary");
  z-index: 2;
}

.dateTextAll {
  display: flex;
  justify-content: center;
  align-items: center;
}

textarea{
  padding: 0.2rem 0.5rem;
}
.dateAll {
  @include ticket;

  .dateTitle {
    @include h3Title;
  }

  .dateTextAll {
    display: flex;
    flex-direction: row;
    justify-content: space-between;

    .calendar {
      width: 40%;
      height: 80%;
      border: 1px #68769a solid;
    }

    .calendarOptionAll {
      width: 40%;
      height: 80%;
      display: flex;
      flex-direction: column;

      //   border: 1px red solid;
      .optionTitle {
        display: flex;
        justify-content: space-between;
        padding-bottom: 5px;
        border-bottom: 1px #979595 solid;
        font-size: map-get($fontSizes, "h4");

        div {
          &:last-child {
            cursor: pointer;

            img {
              margin-right: 10px;
              margin-bottom: -5px;
            }
          }
        }
      }
    }
  }
}

.totalNum {
  padding-top: 15px;
  padding-right: 20px;
  display: flex;
  justify-content: flex-end;
  align-items: baseline;

  div {
    &:first-child {
      margin: 0 25px;
      font-weight: bold;
    }
  }

  div:nth-child(2) {
    color: map-get($colors, "secondary");
    font-size: map-get($fontSizes, "h4");
    font-weight: bold;
  }

  .select {
    display: flex;
    margin-top: 40px;
  }
}
</style>

<style scoped lang="scss">
li {
  display: flex;
  flex-direction: row;
  border-bottom: 1px solid black;
  width: 70%;
  margin: 0 auto;

  p {
    &:first-child {
      width: 26%;
      margin: 20px 10px;
      text-align: center;
    }
  }

  p {
    &:nth-child(2) {
      width: 20%;
      margin: 20px 10px;
      text-align: center;
    }
  }

  p {
    &:nth-child(3) {
      width: 35%;
      margin: 20px 10px;
      text-align: center;
    }
  }
}

.add {
  margin-left: 200px;
  margin-top: 10px;
}

ul {
  width: 100%;
  margin-top: 30px;

  li {
    display: flex;
    flex-direction: row;
    border-bottom: 1px solid black;
    width: 70%;
    margin: 0 auto;

    &:last-child {
      border-bottom: none;
    }

    p {
      &:first-child {
        width: 30%;
        margin: 20px 10px;
      }
    }

    p {
      &:nth-child(2) {
        width: 30%;
        margin: 20px 10px;
      }
    }

    p {
      &:nth-child(3) {
        width: 40%;
        margin: 20px 10px;
      }
    }

    .tickettype {
      width: 60px;
    }

    button {
      width: 60px;
      height: 30px;
      margin: 20px 0;
    }
  }
}
</style>
