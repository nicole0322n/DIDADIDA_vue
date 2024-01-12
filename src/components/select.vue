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
          <option v-for="(prod, proIndex) in prodSelect" :key="proIndex">{{ prod.option }}</option>
        </select>
        <span><i class="fa-solid fa-chevron-down" style="color: #eeeeee;"></i></span>
      </div>
      <div class="select">
        <select v-model="selectedPrice">
          <option v-for="(cost, costIndex) in costSelect" :key="costIndex">{{ cost.option }}</option>
        </select>
        <span><i class="fa-solid fa-chevron-down" style="color: #eeeeee;"></i></span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      prodSelect: [
        { option: '所有商品' },
        { option: '抱枕' },
        { option: '玩偶' },
        { option: '配飾' },
      ],
      costSelect: [
        { option: '價格' },
        { option: '由低到高' },
        { option: '由高到低' },
      ],
      selectedItem: '所有商品',
      selectedPrice: '價格',
      searchInput: ""
    };
  },
  methods: {
    handleSearch(e) {
      console.log(e.target.value)
      this.searchInput = e.target.value
    },
  },
  emit: ["transferClass", "transferPrice"],
  watch: {
    selectedItem(newValue, oldValue) {
      // 在这里可以处理选项变化的逻辑
      console.log("新选项：", newValue);
      console.log("this.selectedItem", this.selectedItem);
      this.$emit("transferClass", this.selectedItem);
    },
    selectedPrice(newValue, oldValue) {
      // 在这里可以处理选项变化的逻辑
      console.log("新选项：", newValue);
      console.log("this.selectedPrice", this.selectedPrice);
      this.$emit("transferPrice", this.selectedPrice);
    },
    searchInput(newValue, oldValue) {
      // 在这里可以处理选项变化的逻辑
      console.log("新选项：", newValue);
      console.log("this.searchInput", this.searchInput);
      this.$emit("transferSearch", this.searchInput);
    },
  },
}

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



@media screen and (max-width:768px) {
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
@media screen and (max-width: 768px) {
  .choose{
    align-items: center;
  }
}
</style>
