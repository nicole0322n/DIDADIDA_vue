<template>
  <div class="prod_order_main">
    <div class="order_area">
      <select v-model="selectOrder" class="sbtn">
        <option value="請選擇">請選擇</option>
        <option :value="i" v-for="i in orderNumAll">訂單編號{{ i }}</option>
      </select>
      <div class="prod_order_group" v-for="prod in filteredProdOrder" :key="prod.prod_img">
        <div class="prod_img">
          <img :src="`${this.$store.state.chooseImgSrc}/all_images/product/` + prod.prod_img" alt="" />
        </div>
        <div class="prod_info">
          <div class="item_info prod_item">
            <p>品項</p>
            <p>{{ prod.prod_name }}</p>
          </div>
          <div class="item_info prod_count">
            <p>數量</p>
            <p>{{ prod.ord_qty }}</p>
          </div>
          <div class="item_info prod_date">
            <p>訂購日</p>
            <p>{{ prod.ord_date }}</p>
          </div>
          <div class="item_info prod_price">
            <p>金額</p>
            <p>NT {{ prod.ord_sum }}</p>
          </div>
        </div>
      </div>
      <div v-if="selectOrder !== '請選擇'" class="ord_info">
        <p>收件人:{{ filteredProdOrder[0].ord_person }}</p>
        <p>下單金額 :NT {{ filteredProdOrder[0].ord_sum }}元</p>
        <p>運費 : NT {{ filteredProdOrder[0].ord_ship }}</p>
        <p>總金額 : NT {{ filteredProdOrder[0].ord_pay }}元</p>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "prodOrderInquiry",
  data() {
    return {
      selectOrder: "請選擇",
      prodOrder: [],
      orderNumAll: [],
    };
  },
  created() {
    fetch(`${this.$store.state.APIurl}prodOrderSelect.php`)
      .then(function (response) {
        return response.json();
      })
      .then((data) => {
        this.prodOrder = data;
        return this.prodOrder;
      })
      .then((res) => {
        // 使用 filter 方法过滤数据
        const filteredData = res.filter(
          (item) => item.mem_id == this.$store.state.memberId
        );
        this.prodOrder = filteredData;
        const uniqueOrderIds = new Set();
        for (let i = 0; i < this.prodOrder.length; i++) {
          uniqueOrderIds.add(this.prodOrder[i].ord_id);
        }

        // 将 Set 转换为数组
        this.orderNumAll = Array.from(uniqueOrderIds);
        console.log(this.prodOrder); // 这里将打印过滤后的数据
      });

    // this.prodOrder = this.$store.state.prodOrderArr;
  },
  computed: {
    filteredProdOrder() {
      // 根据您的逻辑过滤并返回需要显示的订单信息列表
      return this.prodOrder.filter((prod) => {
        // 添加适当的条件，以确定是否包含在列表中
        return prod.ord_id === this.selectOrder;
      });
    },
  },
};
</script>

<style scoped lang="scss">
.prod_order_main {
  p {
    color: map-get($colors, "dark");
  }

  .order_area {
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
    overflow-y: scroll;

    select {
      background-color: #1FB0CB;
      border: 0;
      border-radius: 5px;
      padding: 3px;
      color: #eee;
      margin-left: auto;
      margin-right: 10px;
      margin-top: 10px;
      outline: none;
    }

    &::-webkit-scrollbar {
      width: 10px;
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

    .prod_order_group {
      width: 460px;
      border-bottom: 1px solid map-get($colors, "h2Blue");
      display: flex;
      justify-content: space-evenly;
      z-index: 2;
    }

    .prod_order_group:last-child {
      border-bottom: 0;
    }

    .prod_img {
      width: 50%;
      height: 150px;
      margin: 20px auto;
      border: 0;
    }

    .prod_img img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    .prod_info {
      width: 50%;
      height: 150px;
      margin: 20px auto;
      display: flex;
      flex-direction: column;
      justify-content: space-evenly;
    }

    .item_info {
      display: flex;
      justify-content: space-evenly;
      width: 100%;
    }

    .item_info p:first-child {
      width: 30%;
      text-align: center;
      background-color: map-get($colors, "bgc");
    }

    .item_info p:nth-child(2) {
      width: 80%;
      margin-left: 10px;
    }

    .ord_info {
      width: 460px;
      margin-top: 20px;
      text-align: start;
    }

    .close_btn {
      width: 460px;
      text-align: center;
      margin: 50px 0 30px 0;

      button {
        width: 60px;
        color: #eee;
        border: 0;
        border-radius: 5px;
        background-color: #73a8d7;
      }
    }
    .sbtn{
      cursor: pointer;
    }
  }
}

@media screen and (max-width: 414px) {
  .prod_order_main {
    .order_area {
      width: 330px;
      height: 720px;

      .ord_info {
        width: 90%;
        margin: 20px 0;
      }

      .prod_order_group {
        width: 300px;
        flex-direction: column;
      }

      .prod_img {
        width: 50%;
      }

      .prod_info {
        width: 100%;
        margin: 0 auto;
      }

      .item_info {
        justify-content: center;

        p:nth-child(2) {
          width: 150px;
        }
      }
    }
  }
}
</style>
