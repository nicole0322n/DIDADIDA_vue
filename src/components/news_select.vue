<template>
  <div class="choose">
    <div class="search_box">
      <div class="search">
        <button class="icon"><i class="fas fa-search"></i></button>
        <input type="text" class="input-search" placeholder="搜尋" v-model="searchInput">
      </div>
    </div>
    <div class="select_wrap">
      <div class="select">
        <select name="" id="itemClass" v-model="selectedItem">
          <option v-for="(item, index) in tagSelect" :key="index">
            {{ item.option }}
          </option>
        </select>
        <span><i class="fa-solid fa-chevron-down" style="color: #eeeeee"></i></span>
      </div>
      <div class="select">
        <select v-model="selectedmonth">
          <option v-for="(item, index) in monthSelect" :key="index">
            {{ item.option }}
          </option>
        </select>
        <span><i class="fa-solid fa-chevron-down" style="color: #eeeeee"></i></span>
      </div>
    </div>
  </div>
</template>
  
<script>
export default {
  data() {
    return {
      tagSelect: [
        { option: "所有主題" },
        { option: "表演" },
        { option: "活動" },
        { option: "優惠" }
      ],
      monthSelect: [{ option: "由新到舊" }, { option: "由舊到新" }],
      selectedItem: "所有主題",
      selectedmonth: "由新到舊",
      searchInput: ""
    };
  },
  methods: {
    handleSearch(e) {
      console.log(e.target.value)
      this.searchInput = e.target.value
    },
  },
  emits: ["transferClass", "transfertime"],
  watch: {
    selectedItem(newValue, oldValue) {
      // 在这里可以处理选项变化的逻辑
      console.log("新选项：", newValue);
      console.log("this.selectedItem", this.selectedItem);
      this.$emit("transferClass", this.selectedItem);
    },
    selectedmonth(newValue, oldValue) {
      // 在这里可以处理选项变化的逻辑
      console.log("新选项：", newValue);
      console.log("this.selectedmonth", this.selectedmonth);
      this.$emit("transfertime", this.selectedmonth);
    },
    searchInput(newValue, oldValue) {
      // 在这里可以处理选项变化的逻辑
      console.log("新选项：", newValue);
      console.log("this.searchInput", this.searchInput);
      this.$emit("transferSearch", this.searchInput);
    },
  },

};
</script>
<style scoped lang="scss">
.choose {
  width: 94vw;
  margin: 50px 0;
  display: flex;
  flex-direction: row-reverse;
  justify-content: space-evenly;
  box-sizing: border-box;


  select {
    @include selectBtn;
  }

  /* Remove IE arrow */
  select::-ms-expand {
    display: none;
  }

  /* Custom Select wrapper */
  .select {
    @include btnWidth;
    margin: 0 1em 0 0;
    display: flex;

    span {
      @include btnSpan;
    }
  }

  option {
    background-color: #2c3e50;
  }

  .select_wrap {
    width: 50%;
    display: flex;
    justify-content: start;
  }

  .search_box {
    width: 50%;

    .search {
      width: fit-content;
      height: fit-content;
      position: relative;
      margin-left: auto;
    }

    .input-search,
    .input-search:focus {
      height: 50px;
      width: 50px;
      border-style: none;
      padding: 10px;
      font-size: 18px;
      letter-spacing: 2px;
      outline: none;
      border-radius: 25px;
      transition: all .5s ease-in-out;
      background-color: #b6e3d8;
      padding-right: 40px;
      color: #000000;
      cursor: pointer;
    }

    .input-search::placeholder {
      color: rgba(146, 126, 132, 0.5);
      letter-spacing: 2px;
    }

    .icon {
      width: 50px;
      height: 50px;
      border-style: none;
      font-size: 20px;
      font-weight: bold;
      outline: none;
      pointer-events: none;
      border-radius: 50%;
      position: absolute;
      right: 0px;
      color: #584d4d;
      background-color: transparent;
    }

    .icon:focus~.input-search {
      width: 15em;
      border-radius: 0px;
      background-color: transparent;
      border-bottom: 1px solid rgba(0, 0, 0, 0.5);
      transition: all 500ms cubic-bezier(0, 0.110, 0.35, 2);
    }

    .input-search:focus,
    .input-search:not(:placeholder-shown) {
      width: 15em;
      border-radius: 0px;
      background-color: transparent;
      border-bottom: 1px solid rgba(0, 0, 0, 0.5);
      transition: all 500ms cubic-bezier(0, 0.110, 0.35, 2);
    }

  }
}



@media screen and (max-width:767px) {
  .choose {
    display: block;

    .select_wrap {
      width: 100%;
      justify-content: center;
    }

    .search_box {
      width: 100%;
      margin-bottom: 1rem;
      margin-left: auto;

      .icon:focus~.input-search {
        width: 10em;
      }

      .input-search:focus,
      .input-search:not(:placeholder-shown) {
        width: 10em;
      }

    }
  }

}
</style>
  