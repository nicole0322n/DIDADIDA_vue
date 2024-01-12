<template>
  <div class="dateAll">
    <div class="dateTitle">{{ $t("選擇日期與票數") }}</div>
    <div class="dateTextAll">
      <div class="calendar">
        <VDatePicker
          v-model="date"
          borderless
          expanded
          :min-date="new Date()"
          locale="tw"
          :masks="{ title: 'YYYY MMM' }"
          mode="date"
          :disabled-dates="disabledDateRanges"
        />
      </div>
      <div class="calendarOptionAll">
        <div class="optionTitle">
          <div>{{ $t("選擇數量") }}</div>
          <div @click="clearTicketCount">
            <img src="../assets/images/reorganize.png" alt="" />{{
              $t("全部重選")
            }}
          </div>
        </div>
        <div
          v-for="(i, index) in optionDetailArr"
          class="optionAll"
          :key="index"
        >
          <div class="ticketType">
            <div>{{ $t(i[0]) }}</div>
            <div>{{ $t(i[1]) }}</div>
          </div>
          <div class="ticketSal">
            <div>NT$ {{ $t(i[2]) }} / {{ $t("每人") }}</div>
            <div class="clickTicket">
              <input type="button" value="-" @click="ticketdown(index)" />
              <input type="text" :value="i[3]" />
              <input type="button" value="+" @click="ticketPlus(index)" />
            </div>
          </div>
        </div>
        <div class="totalNum">
          <div>{{ $t("總金額") }}</div>
          <div>
            NT$ <span>{{ totalPrice }}</span>
          </div>
        </div>
        <div class="bookbtn">
          <button @click="bookTickets" class="bookbtnbtn">
            {{ $t("立即購票") }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "bookDate",
  components: {},
  data() {
    return {
      date: "",
      disabledDateRanges: [
        // // 禁用 2023 年 10 月 15 日到 2023 年 10 月 20 日
        // [new Date("2023-10-15"), new Date("2023-10-15")],
        // [new Date("2023-10-28"), new Date("2023-10-28")],
        // // 禁用 2023 年 11 月 1 日到 2023 年 11 月 5 日
        // [new Date("2023-11-01"), new Date("2023-11-01")],
      ],
      optionDetailArr: [
        ["成人", "(18~64歲)", "500", 0],
        ["兒童", "(4~11歲)", "250", 0],
        ["學生", "(12歲以上(含)持學生證者)", "400", 0],
        ["長者", "(65歲以上(含))", "150", 0],
      ],
      totalPrice: 0,
    };
  },
  watch: {
    date(newVal, oldVal) {
      if (!oldVal) {
        return;
      }
      for (let i = 0; i < this.optionDetailArr.length; i++) {
        this.optionDetailArr[i][3] = 0;
      }
      this.totalPrice = 0;
    },
  },
  mounted() {
    fetch(`${this.$store.state.APIurl}closeDateSelect.php`)
      // fetch("http://localhost/dida_project/public/php/closeDateSelect.php")
      .then(function (response) {
        return response.json();
      })
      .then((data) => {
        for (let i = 0; i < data.length; i++) {
          // [new Date("2023-11-01"), new Date("2023-11-01")],
          data[i].close_date = [
            new Date(`${data[i].close_date}`),
            new Date(`${data[i].close_date}`),
          ];
          this.disabledDateRanges.push(data[i].close_date);
        }
        console.log(this.disabledDateRanges);
      });
    fetch(`${this.$store.state.APIurl}ticketMg.php`)
      // fetch("http://localhost/dida_project/public/php/ticketMg.php") //第一步
      // fetch(`${this.$store.state.APIurl}helperMg.php`)
      //this.$store.state.APIurl
      .then(function (response) {
        //第二步
        //要先傳回來編譯成json檔
        return response.json();
      })
      .then((data) => {
        data = data.filter((item) => item.tick_state == "1");
        for (let i = 0; i < this.optionDetailArr.length; i++) {
          this.optionDetailArr[i][0] = data[i].tic_name;
          this.optionDetailArr[i][2] = data[i].tic_price;
          this.optionDetailArr[i][4] = data[i].tictype_id;
        }
        const extraData = data.slice(this.optionDetailArr.length);

        // 将 extraData 数组中的元素添加到 this.optionDetailArr 末尾
        // ["長者", "(65歲以上(含))", "150", 0],
        for (let i = 0; i < extraData.length; i++) {
          this.optionDetailArr.push([
            extraData[i].tic_name,
            // 票種名稱
            extraData[i].tic_info,
            // 票種資訊
            extraData[i].tic_price,
            // 票的單價
            0,
            // 數量
            extraData[i].tictype_id,
          ]);
        }
        console.log(this.optionDetailArr);

        // this.optionDetailArr.push(...extraData);
      });
  },
  beforeDestroy() {},
  computed: {
    catchDate() {
      return `${new Date(this.date).getFullYear()}.${
        new Date(this.date).getMonth() + 1
      }.${new Date(this.date).getDate()}`;
    },
  },
  methods: {
    bookTickets() {
      if (!this.$store.state.userName) {
        alert("需先登入會員");
        return;
      } else {
        let countTicAndType = [];
        for (let i = 0; i < this.optionDetailArr.length; i++) {
          // extraData[i].tic_name,
          //   // 票種名稱
          //   extraData[i].tic_info,
          //   // 票種資訊
          //   extraData[i].tic_price,
          //   // 票的單價
          //   0,
          // 數量
          if (this.optionDetailArr[i][3] > 0) {
            countTicAndType.push({
              tictype_id: this.optionDetailArr[i][4],
              ticPrice: this.optionDetailArr[i][2],
              ticQty: this.optionDetailArr[i][3],
            });
          }
        }
        console.log(countTicAndType);
        let formData = new FormData();
        formData.append("datas", JSON.stringify(countTicAndType));
        fetch(`${this.$store.state.APIurl}bookDateNumRecord.php`, {
          method: "POST",

          body: formData,
        })
          .then((res) => res.json())
          .then((data) => {
            this.uniqid_num = data["訂單編號"];
            return this.uniqid_num;
          })
          .then((result) => {
            for (let i = 0; i < this.optionDetailArr.length; i++) {
              const lastElement =
                this.optionDetailArr[i][this.optionDetailArr[i].length - 2];
              if (lastElement === 0) {
                continue; // 如果最後一個元素是零，則跳過這個子陣列
              } else {
                for (let j = 0; j < lastElement; j++) {
                  //     tickImg: require("../assets/images/dolphin_pillow.jpg"),
                  //     tickName: "一般全票",
                  //     tickCount: "2",
                  //     tickDate: "2023.08.31",
                  //     tickPrice: "250",
                  console.log(
                    this.optionDetailArr[i][this.optionDetailArr[i].length - 2]
                  );

                  this.$store.state.ticketList.push({
                    tickImg: require("../../public/all_images/ticket_face.jpg"),
                    tickName: `${this.optionDetailArr[i][0]}票`,
                    tickCount: `1`,
                    tickDate: this.catchDate,
                    tickPrice: `${this.optionDetailArr[i][2]}`,
                  });
                  const formData = new FormData();

                  let mem_name = this.$store.state.userName;
                  formData.append("mem_name", mem_name);
                  fetch(`${this.$store.state.APIurl}bookDateFront.php`, {
                    method: "post",
                    body: formData,
                  })
                    .then((res) => res.json())
                    .then((data) => {
                      let catchMemEmail = "";
                      catchMemEmail = data[0].mem_email;
                      let mem_id = data[0].mem_id;
                      const formData = new FormData();

                      // let mem_id = this.$store.state.userName;
                      let tic_date = this.catchDate;
                      let tic_pay = this.optionDetailArr[i][2];
                      let tic_name = this.optionDetailArr[i][0];
                      let tic_state = "可使用";
                      formData.append("mem_id", mem_id);
                      formData.append("mem_email", catchMemEmail);
                      formData.append("tic_date", tic_date);
                      formData.append("tic_name", tic_name);
                      formData.append("tic_pay", tic_pay);
                      formData.append("tic_state", tic_state);
                      formData.append("uniqid_num", result);

                      fetch(`${this.$store.state.APIurl}bookDatePush.php`, {
                        method: "post",
                        body: formData,
                      }).then((res) => res.json());
                    });
                  // console.log(
                  //   this.$store.state.ticketList[
                  //     this.$store.state.ticketList.length - 1
                  //   ]
                  // );
                }
              }
            }
          });
      }
      this.checkAndNavigate();
    },
    checkAndNavigate() {
      let countTickets = 0;
      for (let i = 0; i < this.optionDetailArr.length; i++) {
        countTickets += parseInt(this.optionDetailArr[i][3]);
      }

      if (countTickets > 0 && this.date) {
        this.$store.state.memberBtn = "tick_order_inquiry";
        setTimeout(() => {
          this.$store.state.memberBtn = "tick_order_inquiry";
          this.$router.push({
            path: "/member",
            query: { section: "showtickOrder" },
          });
          setTimeout(() => {
            // 获取滚动目标元素
            const target = document.getElementById("showtickOrder");

            // 滚动到目标元素
            if (target) {
              target.scrollIntoView({ behavior: "smooth" });
            }
          }, 400);
        }, 300);
      } else {
        alert("未選日期或票數");
      }
    },
    clearTicketCount() {
      for (let i = 0; i < this.optionDetailArr.length; i++) {
        this.optionDetailArr[i][3] = 0;
      }
      this.totalPrice = 0;
    },
    ticketdown(idx) {
      if (this.optionDetailArr[idx][3] > 0) {
        this.optionDetailArr[idx][3]--;
        this.totalPrice -= parseInt(this.optionDetailArr[idx][2]);
        // idx == 0
        //   ? (this.totalPrice -= parseInt(this.optionDetailArr[idx][2]))
        //   : idx == 1
        //   ? (this.totalPrice -= parseInt(this.optionDetailArr[idx][2]))
        //   : idx == 2
        //   ? (this.totalPrice -= parseInt(this.optionDetailArr[idx][2]))
        //   : idx == 3
        //   ? (this.totalPrice -= parseInt(this.optionDetailArr[idx][2]))
        //   : "";
      }
    },
    ticketPlus(idx) {
      this.optionDetailArr[idx][3]++;
      this.totalPrice += parseInt(this.optionDetailArr[idx][2]);
      // idx == 0
      //   ? (this.totalPrice += parseInt(this.optionDetailArr[idx][2]))
      //   : idx == 1
      //   ? (this.totalPrice += parseInt(this.optionDetailArr[idx][2]))
      //   : idx == 2
      //   ? (this.totalPrice += parseInt(this.optionDetailArr[idx][2]))
      //   : idx == 3
      //   ? (this.totalPrice += parseInt(this.optionDetailArr[idx][2]))
      //   : "";
    },
  },
};
</script>
<style lang="scss" scoped>
:deep(.calendar) .vc-disabled {
  cursor: not-allowed;
  text-decoration: line-through;
}

:deep(.calendar) .vc-week {
  padding: 10px;
}
// :deep(.calendar) .vc-day-content {
//   background-color: red;
// }

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
  padding-left: 150px;
  padding-right: 150px;
}

:deep(.calendar) .vc-arrow,
:deep(.calendar) .vc-title {
  color: map-get($colors, "light");
  background-color: map-get($colors, "secondary");
  z-index: 2;
}

.dateAll {
  @include ticket;

  .dateTitle {
    @include h3Title;
  }

  .dateTextAll {
    width: 100%;
    display: flex;
    justify-content: space-between;

    .calendar {
      width: 45%;
      height: 80%;
      border: 1px #68769a solid;
    }

    .calendarOptionAll {
      width: 45%;
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

      .bookbtn {
        display: flex;
        justify-content: flex-end;
        padding: 20p;
        margin: 40px 10px;
        border: 0;
        cursor: pointer;

        button {
          width: 150px;
          height: 50px;
          border: 0;
          border-radius: 5px;
          font-size: map-get($fontSizes, "h4");
          background-color: map-get($colors, "secondary");
          color: map-get($colors, "light");
          cursor: pointer;
        }
      }

      .optionAll {
        display: flex;
        align-items: center;
        padding: 15px 0;
        justify-content: space-between;
        border-bottom: 1px #979595 solid;
        font-weight: bold;
        letter-spacing: 1px;

        .ticketType {
          display: flex;
          flex-wrap: wrap;
          flex-direction: column;
          // align-items: center;

          div {
            &:first-child {
              font-size: 18px;
              margin-right: 5px;
            }

            &:last-child {
              font-size: 12px;
              color: #979595;
            }
          }
        }

        .ticketSal {
          display: flex;
          align-items: flex-end;
          flex-wrap: wrap;
          justify-content: flex-end;

          .clickTicket {
            display: flex;

            input {
              width: 27px;
              border: 0;
              text-align: center;
              background-color: #9fbdce;
              font-size: 15px;
              outline: none;
            }

            input:first-child {
              border-radius: 15px 0 0 15px;
              cursor: pointer;
            }

            input:last-child {
              border-radius: 0 15px 15px 0;
              cursor: pointer;
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
      }
    }
  }
}

@media screen and (max-width: 414px) {
  :deep(.calendar) .vc-disabled {
    cursor: not-allowed;
    text-decoration: line-through;
  }

  :deep(.calendar) .vc-week {
    padding: 5px;
  }

  :deep(.calendar) .vc-weekdays {
    padding: 5px;
  }

  :deep(.calendar) .vc-weeks {
    margin: 5px;
  }

  :deep(.calendar) .vc-header {
    height: 40px;
    background-color: map-get($colors, "secondary");
    margin: 0;
    padding-left: 100px;
    padding-right: 120px;
  }

  :deep(.calendar) .vc-arrow {
    font: 12px;
    color: map-get($colors, "light");
    background-color: map-get($colors, "secondary");
    margin-left: -15px;
    margin-right: -15px;
    z-index: 4;
  }
  :deep(.calendar) .vc-title {
    color: map-get($colors, "light");
    background-color: map-get($colors, "secondary");
    z-index: 3;
  }
  :deep(.calendar) .vc-container {
    border: 1px #68769a solid;
  }
  .dateTextAll {
    flex-direction: column;
    width: 335px;
    .calendarOptionAll {
      width: 335px;
      // width: 100%;
      // height: 80%;
      display: flex;
      flex-direction: column;

      .optionAll {
        width: 335px;
        display: flex;
        align-items: center;
        padding: 15px 0;
        justify-content: space-between;
        border-bottom: 1px #979595 solid;
        font-weight: bold;
        letter-spacing: 1px;
      }
      .optionTitle {
        // display: flex;
        // justify-content: space-between;
        padding-top: 15px;
        width: 335px;
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
      .totalNum {
        width: 335px;
        padding-top: 15px;
        padding-right: 0px;
        // display: flex;
        justify-content: space-between;
        // align-items: baseline;
        div {
          &:first-child {
            margin: 0;
          }
        }
      }
    }
  }
  .bookbtnbtn {
    display: block;
    // justify-content: flex-end;
    // padding: 20px;
    // margin: 20px -100px;
    border: red 1px solid;
    cursor: pointer;

    button {
      width: 150px;
      height: 50px;
      border: 0;
      border-radius: 5px;
      font-size: map-get($fontSizes, "h4");
      background-color: map-get($colors, "secondary");
      color: map-get($colors, "light");
      cursor: pointer;
    }
  }
}
</style>
