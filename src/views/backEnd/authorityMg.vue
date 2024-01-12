<!-- <template>
  <div class="titleAll">
    <div v-for="i in titleAll">{{ i }}</div>
  </div>
  <div>
    <div v-for="(i, index) in allMgr" :key="index" class="singleMgr">
      <div>{{ i.emp_id }}</div>
      <div>{{ i.emp_account }}</div>
      <div>{{ i.emp_psw }}</div>
      <switchBtn :onText="'正常'" :off-text="'停用'" :disabled="false"
        :item="i.emp_state == '1' ? '1' : i.emp_state == '2' ? '0' : ''" class="switchBtn" @toggle="updateMgrState(i)">
      </switchBtn>
    </div>
  </div>
</template> -->

<template>
  <table>
    <tr>
      <th>編號</th>
      <th>帳號</th>
      <th>密碼</th>
      <th>狀態</th>
    </tr>
    <tr v-for="(i, index) in allMgr" :key="index" class="singleMgr">
      <td>{{ i.emp_id }}</td>
      <td>{{ i.emp_account }}</td>
      <td>{{ i.emp_psw }}</td>
      <td>
        <switchBtn :onText="'正常'" :off-text="'停用'" :disabled="false"
          :item="i.emp_state == '1' ? '1' : i.emp_state == '2' ? '0' : ''" class="switchBtn" @toggle="updateMgrState(i)">
        </switchBtn>
      </td>
    </tr>
  </table>
</template>

<script>
import switchBtn from "../../components/backComponents/toggleBtn.vue";
export default {
  name: "authorityMg",
  data() {
    return {
      allMgr: [],
      titleAll: ["編號", "帳號", "密碼"],
    };
  },
  mounted() {
    fetch(`${this.$store.state.APIurl}backHomeSelectAcc.php`)
      .then(function (response) {
        return response.json();
      })
      .then((data) => {
        this.allMgr = data;
        this.allMgr.shift();
      });
  },
  components: {
    switchBtn,
  },
  methods: {
    updateMgrState(i) {
      if (i.emp_state == "1") {
        i.emp_state = "2";
        let emp_id = i.emp_id;
        const formData = new FormData();

        formData.append("emp_state", i.emp_state);
        formData.append("emp_id", emp_id);
        fetch(`${this.$store.state.APIurl}backHomeUpdateAcc.php`, {
          method: "post",
          body: formData,
        }).then((res) => res.json());
        return;
      }
      i.emp_state = "1";
      let emp_id = i.emp_id;
      const formData = new FormData();

      formData.append("emp_state", i.emp_state);
      formData.append("emp_id", emp_id);
      fetch(`${this.$store.state.APIurl}backHomeUpdateAcc.php`, {
        method: "post",
        body: formData,
      }).then((res) => res.json());
    },
  },
};
</script>
<style scoped lang="scss">
table {
  width: 100%;

  th {
    border-bottom: 1px solid #333;
    padding: 10px;
  }

  td {
    vertical-align: middle;
    padding: 10px;
  }
}

.titleAll {
  display: flex;
  padding-bottom: 10px;
  justify-content: space-around;
  border-bottom: 1px black solid;
}

.singleMgr {
  text-align: center;

  .switchBtn {
    margin: auto;
  }
}
</style>
