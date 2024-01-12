<template>
  <div class="select_btn">
    <prodSelect @transferClass="getClass" @transferPrice="getPrice" @transferSearch="searchClick"></prodSelect>
  </div>
  <div class="card" v-for="(i, index) in chooseItem" :key="i.imageSrc">
    <div class="heart">
      <heart @change-heart="changeHeart($event, i, index)" :keepLove="keepHeartArr[index]"
        :is-active="mountedShowLove.findIndex((v) => v == i.prod_id) > -1"></heart>
    </div>
    <div class="pic">
      <a href="#" @click.prevent="showProductDetails(i)"><img :src="`${this.$store.state.chooseImgSrc}all_images/product/${i.prod_img}`"
          :alt="i.prod_img" /></a>
    </div>

    <div class="name">
      <a href="">{{ i.prod_name }}</a>
    </div>
    <div class="info">
      <div class="cost">
        <span>NT$ {{ i.prod_price }}</span>
      </div>
      <div class="prod_btn">
        <div class="num">
          <input type="button" value="–" @click="productDown(index)" />
          <input type="text" :value="i.count" size="1" />
          <input type="button" value="+" @click="i.count++" />
        </div>
        <div class="buy">
          <i
            class="fa-solid fa-cart-shopping"
            style="color: #9fbdce"
            @click.prevent="
              pushAndTogglePopup(i.prod_img, i.prod_name, i.count, i.prod_price)
            "
          ></i>
          <!-- pushInShoppingCart(
                  i.imageSrc,
                  i.titleName,
                  i.count,
                  i.prodPrice
                ) -->

          <cartpop />
        </div>
      </div>
    </div>
  </div>
  <!-- ↓↓↓ 商品彈窗 ↓↓↓ -->
  <transition name="fade">
    <div v-if="selectedProduct" class="modal">
      <div class="shadow" @click="closeModal"></div>
      <div class="modal-content">
        <div class="prod-content">
          <div class="prod-img">
            <img :src="`${this.$store.state.chooseImgSrc}/all_images/product/${selectedProduct.prod_img}`" />
          </div>
          <div class="prod-info">
            <div>
              <h5>{{ $t(selectedProduct.prod_name) }}</h5>
              <p>NT${{ $t(selectedProduct.prod_price) }}</p>
            </div>
            <p>{{ $t(selectedProduct.prod_info) }}</p>
          </div>
        </div>
        <div class="close" @click="closeModal">
          <i class="fa-solid fa-xmark" style="color: #062f4a"></i>
        </div>
      </div>
    </div>
  </transition>
  <!-- ↑↑↑ 商品彈窗 ↑↑↑ -->
  <Page :total="chooseItem2.length" @on-change="updatePage" class="changepage" :page-size="pageSize"
    v-model="this.getPage" />
</template>

<script>
import heart from "./heart.vue";
import prodSelect from "../components/select.vue";
import cartpop from "../components/cartPopup.vue";
import { mapMutations } from "vuex";
export default {
  name: "son",
  data() {
    return {
      mountedShowLove: [],
      cardsAll: [],
      chooseItem: [],
      pageSize: 8,
      selectFirst: false,
      priceFirst: false,
      chooseItem2: [],
      selectOption: "所有商品",
      getPriceOption: "價格",
      getPage: 1,
      keepHeartArr: [],
      searchInput: "",
      showModal: false,
      selectedProduct: null,
    };
  },
  created() {
    this.mountedShowLove = [];
    fetch(`${this.$store.state.APIurl}prod_cardFavSelect.php`)
      .then(function (response) {
        return response.json();
      })
      .then((data) => {
        if (!this.$store.state.userName) {
          return;
        }

        for (let i = 0; i < data.length; i++) {
          if (this.$store.state.memberId == data[i].mem_id) {
            this.mountedShowLove.push(data[i].prod_id);
          }
        }
      });
  },
  async mounted() {
    try {
      // 非同步請求數據
      const response = await fetch(
        `${this.$store.state.APIurl}productSelect.php`
      );
      const myJson = await response.json();
      for (let i = 0; i < myJson.length; i++) {
        myJson[i].count = 1;
      }
      this.cardsAll = myJson.filter((item) => item.prod_listed !== "0");

      //加載後
      this.chooseItem = [...this.cardsAll];
      this.cardsAll.sort((a, b) => {
        return parseInt(a.prodPrice) - parseInt(b.prodPrice);
      });
      this.chooseItem2 = this.cardsAll;
      this.chooseItem = this.chooseItem2.slice(0, this.pageSize);
      for (let i = 0; i < this.chooseItem2.length; i++) {
        this.keepHeartArr.push(true);
      }
      for (let i = 0; i < this.$store.state.favoList.length; i++) {
        this.keepHeartArr[this.$store.state.favoList[i].favIndex] = false;
      }
      this.getClass(this.selectOption);
      this.getPrice(this.getPriceOption);
    } catch (error) {
      console.error("数据加载失败：", error);
    }
  },
  props: {
    msg1: [String, Number],
  },
  components: {
    heart,
    prodSelect,
    cartpop,
  },
  computed: {
    favList() {
      return this.$store.state.favoList;
    },
  },
  methods: {
    // 商品彈窗 ----------------------------------
    showProductDetails(i) {
      this.selectedProduct = i;
    },
    closeModal() {
      this.selectedProduct = null;
    },
    // ------------------------------------------
    productDown(idx) {
      if (this.chooseItem[idx].count > 0) {
        this.chooseItem[idx].count--;
      }
    },
    pushInShoppingCart(img1, name1, count1, price1) {
      console.log([img1, name1, count1, price1]);
      if (!this.$store.state.userName) {
        alert("需先登入會員");
        return;
      }
      for (let i = 0; i < this.$store.state.shoppingCart.length; i++) {
        if (img1 === this.$store.state.shoppingCart[i].imgURL) {
          this.$store.state.shoppingCart[i].count += count1;
          return;
        }
      }
      this.$store.state.shoppingCart.push({
        imgURL: img1,
        name: name1,
        price: price1,
        count: count1,
        select: false,
      });
      console.log(this.$store.state.shoppingCart);
    },
    allSelect() {
      let chooseItem2 = this.cardsAll;
      if (this.selectOption !== "所有商品") {
        chooseItem2 = chooseItem2.filter(
          (item) => item.prod_category === this.selectOption
        );
      }

      if (this.getPriceOption === "由低到高") {
        chooseItem2.sort(
          (a, b) => parseInt(a.prod_price) - parseInt(b.prod_price)
        );
      } else if (this.getPriceOption === "由高到低") {
        chooseItem2.sort(
          (a, b) => parseInt(b.prod_price) - parseInt(a.prod_price)
        );
      }
      const searchInput = this.searchInput.toUpperCase();
      if (searchInput.trim() !== "") {
        chooseItem2 = chooseItem2.filter((i) => {
          const search_content = i.prod_name.toUpperCase();
          return search_content.includes(searchInput);

        });
      }

      this.chooseItem2 = chooseItem2;
      this.$nextTick(() => {
        this.updatePage(1);
      });
    },
    getClass(data) {
      this.selectOption = data;
      this.allSelect();
      this.updatePage(1);
    },
    getPrice(data) {
      this.getPriceOption = data;
      this.allSelect();
      this.updatePage(1);
    },

    searchClick(data) {
      this.searchInput = data;
      this.allSelect();
      this.updatePage(1);
    },
    updatePage(data) {
      this.getPage = data;
      const optionStartIdx = (this.getPage - 1) * this.pageSize;
      const optionEndIdx = optionStartIdx + this.pageSize;
      console.log(optionStartIdx);
      console.log(optionEndIdx);
      console.log(this.chooseItem2);
      this.chooseItem = this.chooseItem2.slice(optionStartIdx, optionEndIdx);
    },
    changeHeart(isFav, i, index) {
      const mountedShowLoveIndex = this.mountedShowLove.findIndex(
        (v) => v == i.prod_id
      );

      if (mountedShowLoveIndex > -1) {
        this.mountedShowLove.splice(mountedShowLoveIndex, 1);

        let formData = new FormData();
        let prod_id = i.prod_id;
        formData.append("mem_id", this.$store.state.memberId);
        formData.append("prod_id", prod_id);
        fetch(`${this.$store.state.APIurl}prod_cardFavDelete.php`, {
          method: "POST",

          body: formData,
        });
      } else {
        this.mountedShowLove.push(i.prod_id);
        this.$store.state.favoList.push({
          favoImg: i.prod_img,
          favoName: i.prod_name,
          favoPrice: i.prod_price,
          favoIntroduction: i.prod_info,
          favIndex: index,
        });
        let formData = new FormData();
        let prod_id = i.prod_id;
        formData.append("mem_id", this.$store.state.memberId);
        formData.append("prod_id", prod_id);
        fetch(`${this.$store.state.APIurl}prod_cardFavInsert.php`, {
          method: "POST",

          body: formData,
        });
      }
    },

    closeCartPopup() {
      // 延迟一秒后关闭购物车弹出视图
      setTimeout(() => {
        this.toggleCartPopup();
      }, 500); // 500毫秒（1秒）后关闭
    },

    ...mapMutations(["toggleCartPopup"]),
    pushAndTogglePopup(prod_img, prod_name, count, prod_price) {
      // 添加商品到购物车
      this.pushInShoppingCart(prod_img, prod_name, count, prod_price);

      // 切换购物车弹出视图的显示状态
      if (this.$store.state.userName) {
        this.toggleCartPopup();
        this.closeCartPopup();
      }
    },
  },
};
</script>
<style scoped lang="scss">
.card {
  width: calc((100% / 4) - 20px);
  margin: 0 10px 50px;
  display: flex;
  flex-wrap: wrap;

  .heart {
    margin: 0 0 -50px auto;
    padding: 0 15px;
    z-index: 2;
  }

  .pic {
    width: 270px;
    height: 270px;
    overflow: hidden;
    margin-bottom: 10px;
    box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.2);
  }

  .pic img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    vertical-align: top;
    transform: scale(1);
    transition: 0.7s;
  }

  .pic img:hover {
    transition: 0.7s;
    transform: scale(1.1);
  }

  .name {
    padding: 0 10px;
    font-size: 17px;
    letter-spacing: 1px;
    margin-top: 10px;
    margin-bottom: 10px;
    line-height: 1.5;
    font-family: Gowun Batang, "Times New Roman", Times, NotoSerifCJKtc-Regular,
      serif;
    color: #333;
  }

  .name a {
    text-decoration: none;
    color: #333;
    transition: 0.3s;
    font-size: Gowun Batang, "Times New Roman", Times, NotoSerifCJKtc-Regular,
      serif;
    display: block;
  }

  .info {
    width: 100%;
    padding: 0 10px;
    display: flex;
    justify-content: space-between;
  }

  .prod_btn {
    display: flex;

    .num input {
      width: 27px;
      border: 0;
      text-align: center;
      background-color: #9fbdce;
      font-size: 15px;
      outline: none;
    }

    .num input:first-child {
      border-radius: 15px 0 0 15px;
      cursor: pointer;
    }

    .num input:last-child {
      border-radius: 0 15px 15px 0;
      cursor: pointer;
    }
  }

  .buy {
    width: 35px;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;

    i {
      font-size: 17px;
    }

    .fa-cart-shopping {
      width: 12px;
    }

    :hover .fa-plus {
      display: none;
    }

    :hover .fa-cart-shopping {
      display: inline-block;
    }

    :hover {
      background-color: #eee;
    }
  }

  .name a:hover {
    color: map-get($colors, hoverColor);
    transition: 0.2s;
  }

  .buy img:nth-child(1):hover {
    transition: 0.2s;
    opacity: 0;
  }
}

.select_btn {
  width: 1200px;
  margin: 50px auto;
  display: flex;
  justify-content: end;
}

.changepage {
  width: 1200px;
  text-align: center;
  margin-bottom: 20px;
}

.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6); // 彈窗背景亮度
  z-index: 10;
  justify-content: center;
  align-items: center;

  .shadow {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    z-index: -1;
    /* 在蓋板下面 */
  }

  .modal-content {
    width: 1000px;
    height: 400px;
    margin: 0 auto;
    border: 0;
    border-radius: 5px;
    text-align: center;
    background-color: rgba(40, 61, 84, 0.8);
    padding: 20px;
    position: relative;
    top: 100px;
    display: flex;
    align-items: center;
  }

  .close {
    width: 45px;
    height: 45px;
    background-color: #93b7cd;
    border-radius: 50%;
    text-align: center;
    cursor: pointer;
    position: absolute;
    top: -20px;
    right: -20px;

    i {
      line-height: 45px;
      font-size: 30px;
    }
  }

  .prod-content {
    width: 90%;
    height: 90%;
    margin: 0 auto;
    // border: 1px solid #333;
    border-radius: 15px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
  }

  .prod-img {
    margin-right: 50px;
    width: 40%;
    height: 80%;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border: 0;
      border-radius: 15px;
    }
  }

  .prod-info {
    width: 50%;
    height: 80%;
    text-align: justify;
    display: flex;
    justify-content: flex-start;
    align-items: flex-start;
    flex-direction: column;

    h5 {
      color: map-get($colors, "light");
    }

    p {
      color: map-get($colors, "light");
      font-size: map-get($fontSizes, "p");
    }

    >p {
      margin-top: 30px;
      line-height: 30px;
    }
  }
}

// 彈窗顯示與隱藏延遲動畫效果
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}

@media screen and (max-width: 768px) {
  .select_btn {
    width: 100%;
    justify-content: center;
  }

  .card {
    width: 40%;
    margin: 0 30px 50px;

    .heart {
      margin: 0 30px -50px auto;
    }
  }

  .modal {
    .modal-content {
      width: 700px;
      top: 60px;
    }
  }

  .changepage {
    width: 100%;
  }
}

@media screen and (max-width: 414px) {
  .card {
    margin: 0 15px 50px;

    .pic {
      width: 160px;
      height: 160px;
    }
    .name {
      padding: 0;
      margin-bottom: 0;
    }
    .info {
      padding: 0;
      display: initial;
    }


    .heart {
      margin: 0 0 -50px auto;
    }
  }

  .modal {
    .modal-content {
      width: 80%;
      top: 60px;
      padding: 0;
    }

    .prod-content {
      flex-direction: column;
      justify-content: flex-end;
    }

    .prod-img {
      height: 120px;
      width: 120px;
      margin: 0;
    }

    .prod-info {
      width: 80%;
      margin-top: 10px;

      >p {
        margin-top: 10px;
        line-height: 30px;
      }
    }
  }

  .changepage {
    width: 100%;
  }
  .select_btn {
    margin: 0 auto;
  }
}
</style>
