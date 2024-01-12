<template>
  <div class="quizAll">
    <div class="borderdeco">
      <div
        v-for="(i, index) in randomQuestions"
        :key="index"
        class="singelQuestion"
      >
        <div
          class="questionTitle"
          :style="{ backgroundColor: i.isWrong ? '#ff0000' : '#1fb0cb' }"
        >
          0{{ indexPlus(index) }}
        </div>

        <div class="questionarrange">
          <div class="questionPost">{{ i.qa_que }}</div>

          <div>
            <label class="testPoition">
              <input
                type="radio"
                :name="i.qa_no"
                @click="pushInArr(i.qa_no, i.qa_ans, '是', i.qa_bonus)"
                :disabled="isDisabled"
              />
              是
            </label>
            <label class="testPoition">
              <input
                type="radio"
                :name="i.qa_no"
                @click="pushInArr(i.qa_no, i.qa_ans, '否', i.qa_bonus)"
                :disabled="isDisabled"
              />
              否
            </label>
            <!-- <div class="ansBtn" @click="pushInArr(i.index, i.ans, $event)">是</div>
        <div class="ansBtn" @click="pushInArr(i.index, i.ans, $event)">否</div> -->
          </div>
        </div>
      </div>

      <div @click="complete" class="cmpBtn" v-if="!showResult">{{$t('完成問卷')}}</div>
      <div
        v-if="notComplete"
        class="notCmpBtn"
        :class="{ notCmpBtnFrames: moveSideKeyFrames }"
      >
        尚未完成
        <!-- <span @click="notComplete = false">X</span> -->
      </div>

      <gameResult v-if="showResult"></gameResult>
    </div>
  </div>
</template>

<script>
import gameResult from "../components/gameResult.vue";
export default {
  data() {
    return {
      quesAndAns: [],
      randomQuestions: [],
      finalAns: [],
      notComplete: false,
      totalPoint: 0,
      showResult: false,
      moveSideKeyFrames: false,
      isDisabled: false,
    };
  },
  mounted() {
    fetch(`${this.$store.state.APIurl}quiz.php`)
      .then(function (response) {
        return response.json();
      })
      .then((myJson) => {
        this.quesAndAns = myJson;
        for (let i = 0; i < this.quesAndAns.length; i++) {
          this.quesAndAns[i].isWrong = false;
        }
        const shuffled = this.quesAndAns
          .slice()
          .sort(() => Math.random() - 0.5);
        this.randomQuestions = shuffled.slice(0, 5);
      });

    // this.shuffleArray();
  },
  components: {
    gameResult,
  },
  computed: {},
  methods: {
    complete() {
      if (this.finalAns.length < 5) {
        this.notComplete = true;
        this.moveSideKeyFrames = true;
        setTimeout(() => {
          this.moveSideKeyFrames = false;
        }, 500);
        return;
      }

      for (let i = 0; i < this.finalAns.length; i++) {
        // qa_no qa_ans (是,否) qa_bonus
        console.log(this.finalAns[i][1] == this.finalAns[i][2]);
        if (this.finalAns[i][1] == this.finalAns[i][2]) {
          this.totalPoint += parseInt(this.finalAns[i][3]);
        } else {
          this.randomQuestions[i].isWrong = true;
        }
      }
      if (this.$store.state.userName) {
        this.$store.state.quizScore = this.totalPoint;

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
            return catchOrignBonus;
          })
          .then((orign) => {
            const formData = new FormData();
            let mem_name = this.$store.state.userName;
            let mem_bonus = orign + this.$store.state.quizScore;
            let updateBonus = "1";
            formData.append("mem_name", mem_name);
            formData.append("mem_bonus", mem_bonus);
            formData.append("updateBonus", updateBonus);
            fetch(`${this.$store.state.APIurl}labaUpdate2.php`, {
              method: "post",
              body: formData,
            }).then((res) => res.json());
          });
      }

      if (this.finalAns.length >= 5) {
        this.showResult = true;

        this.notComplete = false;
        this.moveSideKeyFrames = true;
        setTimeout(() => {
          this.moveSideKeyFrames = false;
        }, 500);
      }
      this.isDisabled = true;
    },
    pushInArr(index, ans, e, bonus) {
      for (let i = 0; i < this.finalAns.length; i++) {
        if (this.finalAns[i][0] == index) {
          this.finalAns.splice(i, 1);
        }
      }
      // qa_no qa_ans (是,否) qa_bonus
      console.log(this.finalAns);
      this.totalPoint = 0;
      this.finalAns.push([index, ans, e, bonus]);
      if (this.finalAns.length >= 5) {
        this.notComplete = false;
      }
    },
    indexPlus(index) {
      return index + 1;
    },
    shuffleArray() {
      const shuffled = this.quesAndAns.slice().sort(() => Math.random() - 0.5);
      this.randomQuestions = shuffled.slice(0, 5);
    },
  },
};
</script>
<style scoped lang="scss">
.quizAll {
  @include LQ;
  .showWrong {
    background-color: rgb(134, 83, 83, 0.5);
    border-radius: 5px;
    padding: 10px;
  }
  .borderdeco {
    border: 4px #dc564a dashed;
    border-radius: 15px;
    padding: 20px;
  }
  .singelQuestion {
    // border: 1px red solid;
    padding: 15px 0px;
    border-bottom: 2px dashed rgba(0, 0, 0, 0.16);

    div {
      .ansBtn {
        border: 1px black solid;
        cursor: pointer;
        height: 30px;
      }
    }

    .questionTitle {
      font-size: map-get($fontSizes, "h4");
      font-weight: bold;
      border-radius: 50%;

      color: white;
      text-align: center;
      position: relative;
      width: 40px;
      height: 40px;
      align-items: center;
      line-height: 40px;
    }
    //     .questionTitle:before {
    //   content: "";
    //   position: absolute;
    //   top: -90%;
    //   left: 50%;
    //   border: 20px solid transparent;
    //   border-bottom: 40px solid #1FB0CB;;
    //   transform: translateX(-50%);
    //   z-index: 49;
    // }
    .questionPost {
      font-size: 18px;
      letter-spacing: 2px;
      margin: 3px 0px;
    }
    div {
      .testPoition {
        cursor: pointer;
        margin: 0 5px;
      }
    }
  }
  .questionarrange {
    display: flex;
    justify-content: space-between;
  }
  .cmpBtn {
    @include selectBtn;
    // border: 1px black solid;
    cursor: pointer;

    width: 180px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto;
    margin-top: 20px;
  }
  .notCmpBtn {
    color: rgb(188, 91, 91);
    font-size: 14px;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .notCmpBtnFrames {
    animation: moveSide 0.3s;
  }
  @keyframes moveSide {
    0% {
      translate: 0px;
    }
    25% {
      translate: 10px 0px;
    }
    50% {
      translate: 0px;
    }
    75% {
      translate: -10px 0px;
    }
    100% {
      translate: 0px;
    }
  }
}

@media screen and (max-width: 414px) {
  .questionarrange {
    flex-direction: column;
  }
}
</style>
