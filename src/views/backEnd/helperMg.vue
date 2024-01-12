<template>
  <div class="creatAndDel">
    <!-- <div @click="createNewOne">新增</div> -->
  </div>
  <div class="titleAll">
    <div></div>
    <div>問題關鍵字</div>
    <div>回答內容</div>
    <div></div>
  </div>
  <div class="singleRow" v-for="(i, index) in helperAll2" :key="index">
    <div style="width: 5%; text-align: center;">
      <span>{{ i.smart_id }}</span>
    </div>
    <div style="width: 40%; text-align: center;">
      <input type="text" v-model="i.smart_que" :disabled="i.dis" />
    </div>
    <div style="width: 40%; text-align: center;">
      <textarea name="" id="" cols="30" rows="3" v-model="i.smart_ans" :disabled="i.dis"></textarea>
    </div>
    <div class="updateBtnAll" style="width: 10%; text-align: center;">
      <div class="update" @click="updateQuestion(index, $event, i)" style="text-align: center;">修改</div>
      <!-- <div @click="delThisQuestion(index)">刪除</div> -->
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      helperAll: [
        [
          "交通",
          "自行開車 : 請於國道10號，海洋交流道下，左轉直行珊瑚一街搭乘接駁車 : 請於海洋市區，搭乘海洋路線777公車搭乘捷運 : 請搭乘海洋線，於滴答滴答站下車，2號出口",
          true,
        ],
        ["營業時間", "早上9:00到下午17:00", true],
        ["天氣", "今日氣溫39度", true],
        ["降雨機率", "今日降雨機率為20%", true],
      ],
      helperAll2: [],
    };
  },
  // created(){}, => 創建但未被掛載
  // mounted(){}, => 掛載以後會去做的事
  mounted() {
    fetch(`${this.$store.state.APIurl}helperMg.php`) //第一步
      // fetch(`${this.$store.state.APIurl}helperMg.php`)
      //this.$store.state.APIurl
      // axios
      .then(function (response) {
        //第二步
        //要先傳回來編譯成json檔
        return response.json();
      })

      .then((myJson) => {
        for (let i = 0; i < myJson.length; i++) {
          myJson[i].dis = true;
        }
        //第三步 覆蓋掉 helperAll2:[]
        this.helperAll2 = myJson;
        console.log(this.helperAll2);
      });
  },
  methods: {
    updateQuestion(index, e, i) {
      if (e.target.innerText == "確認") {
        this.helperAll2[index].dis = true;
        e.target.innerText = "修改";

        const formData = new FormData();
        let smart_id = i.smart_id;
        let smart_que = this.helperAll2[index].smart_que;
        let smart_ans = this.helperAll2[index].smart_ans;

        formData.append("smart_id", smart_id);
        formData.append("smart_que", smart_que);
        formData.append("smart_ans", smart_ans);
        fetch(`${this.$store.state.APIurl}helperMg.php`, {
          method: "post",
          body: formData,
        }).then((res) => res.json());
        return;
      }
      this.helperAll2[index].dis = false;
      e.target.innerText = "確認";
    },
  },
};
</script>

<style scoped lang="scss">
.creatAndDel {
  display: flex;

  div {
    border: 1px black solid;
    cursor: pointer;
  }
}

.titleAll {
  display: flex;
  justify-content: space-around;
  border-bottom: 1px black solid;
  padding-bottom: 15px;
}

.singleRow {
  display: flex;
  justify-content: space-around;
  align-items: center;

  .updateBtnAll {
    display: flex;
    align-items: center;

    div {
      margin: 0 3px;
      border: 1px black solid;
      padding: 3px;
      cursor: pointer;
    }
  }
}
</style>

