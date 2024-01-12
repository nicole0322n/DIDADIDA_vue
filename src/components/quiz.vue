<template>
  <div class="quizAll">
    <div v-if="randomTrue">
      <div
        v-for="(i, index) in currentFiveQuesAndAns"
        :key="i.index"
        class="singleQuestion"
        :class="{ alreadyClick: index.clicked }"
      >
        <div>
          <span>第{{ computedIndex(index) }}題</span>{{ i.question }}
        </div>
        <div class="theAns">
          <div @click="test(i.ans, i.index, $event)">是</div>
          <div @click="test(i.ans, i.index, $event)">否</div>
        </div>
      </div>
      <div>{{ currentFiveQuesAndAns }}</div>
      <div class="alreadyBtn" @click="getPoint" v-if="!showScore">完成問卷</div>
    </div>

    <!-- <div v-if="showScore">獲得{{ totalScore }}點 紅利點數</div> -->
    <div v-if="notEnough">
      還沒完成<span @click="notEnough = false">X</span>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      currentFiveQuesAndAns: [],
      quesAndAns: [
        { question: "鯊魚是魚嗎", ans: "是", index: 0 },
        { question: "魚是魚嗎", ans: "是", index: 1 },
        { question: "斑馬是魚嗎", ans: "否", index: 2 },
        { question: "烏賊是魚嗎", ans: "否", index: 3 },
        { question: "金魚是魚嗎", ans: "是", index: 4 },
        { question: "牛是魚嗎", ans: "否", index: 5 },
        { question: "狗是魚嗎", ans: "否", index: 6 },
        { question: "人是魚嗎", ans: "否", index: 7 },
        { question: "美人魚是魚嗎", ans: "是", index: 8 },
        { question: "綿羊是魚嗎", ans: "否", index: 9 },
      ],
      fiveQuesAndAns: [],
      totalScore: 0,
      chooseAns: [],
      showScore: false,
      notEnough: false,
      randomTrue: false,
    };
  },
  mounted() {
    this.shuffleArray();
  },
  methods: {
    shuffleArray() {
      // 使用 Fisher-Yates 随机排序算法对数组进行重新排列
      for (let i = this.quesAndAns.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [this.quesAndAns[i], this.quesAndAns[j]] = [
          this.quesAndAns[j],
          this.quesAndAns[i],
        ];
      }
      this.randomTrue = true;
      this.generateCurrentFiveQues(); // 生成当前显示的五题
    },
    generateCurrentFiveQues() {
      this.currentFiveQuesAndAns = this.quesAndAns.slice(0, 5);
      // 重置 clicked 属性
      this.currentFiveQuesAndAns.forEach((item) => {
        item.clicked = false;
      });
    },
    test(ans, index, e) {
      console.log(ans);
      console.log(index);
      console.log(e.target);
      console.log(e.target.innerText);
      for (let i = 0; i < this.chooseAns.length; i++) {
        if (this.chooseAns[i][0] == index) {
          this.chooseAns.splice(i, 1);
        }
      }
      this.chooseAns.push([index, ans, e.target.innerText]);
      console.log(this.chooseAns);
      this.currentFiveQuesAndAns[index].clicked = true; // 设置 clicked 为 true
    },
    computedIndex(index) {
      // 计算属性，返回索引加一的值
      return index + 1;
    },
    getPoint() {
      if (this.chooseAns.length < 5) {
        this.notEnough = true;
      } else if (this.chooseAns.length >= 5) {
        this.showScore = true;
      }
      for (let i = 0; i < this.chooseAns.length; i++) {
        if (this.chooseAns[i][1] == this.chooseAns[i][2]) {
          // [[1,2,3].[4,5,6],[7,8,9]]
          this.totalScore++;
          this.$store.state.quizScore++;
        }
      }
    },
  },
};
</script>
<style scoped lang="scss">
.quizAll {
  @include LQ;
  display: flex;
  flex-direction: column;
  .showMsg {
    width: 50%;
    height: 50vh;
    position: fixed;
    font-size: 100px;
  }
  .singleQuestion {
    width: 100%;
    border: 1px black solid;
    margin: 20px 0px;
    .theAns {
      display: flex;

      div {
        border: 1px black solid;
        padding: 5px;
        &:hover {
          background-color: black;
          color: white;
          cursor: pointer;
        }
      }
    }
  }
  .alreadyClick {
    background-color: gray;
  }
  .alreadyBtn {
    border: 1px black solid;
    &:hover {
      background-color: black;
      color: white;
      cursor: pointer;
    }
  }
}
</style>
