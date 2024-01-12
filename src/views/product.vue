<template>
  <div class="product_allCards">
    <prod_card></prod_card>
  </div>
  <!-- card -->
</template>
   
<script>
import prod_card from '../components/prod_card.vue'
import login from '../components/login.vue'
import footer1 from '../components/footer.vue'
import header1 from '../components/header.vue'
import wave from '../components/wave.vue'
import prodSelect from '../components/select.vue'
import { TreeChildConfig } from 'view-ui-plus'


export default {
  name: 'product',
  data() {
    return {
      chooseClass: ''
    }
  },
  props: {
    msg: String
  },
  components: {
    prod_card,
    footer1,
    login,
    header1,
    wave,
    prodSelect,

  },
  watch: {
    "$route.query"(nVal, oVal) {
      console.log(nVal.headerSection)
      const id = this.$route.query.headerSection;
      console.log(id)
      if (!id) return;
      const el = document.getElementById(id)
      console.log(el)
      const y = el.getBoundingClientRect().y
      console.log(y)
      window.scrollTo({
        top: y,
        behavior: 'smooth'
      })
    },
  },
  methods: {
    toTop() {
      this.$router.push({ path: '/product', query: { headerSection: 'header' } });

    },
    handleClass(data) {
      this.chooseClass = data
      console.log(this.chooseClass)
    }
  },
  mounted() {
    console.log(this.$route.query)
    const id = this.$route.query.article;
    if (!id) return;
    const el = document.getElementById(id)
    const y = el.getBoundingClientRect().y
    console.log(y)
    window.scrollTo({
      top: y,
      behavior: 'smooth'
    })

  }
}

</script>
<style scoped lang="scss">
// @font-face {
//     font-family: 'YourFontFamily'; /* 替换为你的字体名称 */
//     src: url('../assets/font/NotoSerifCJKtc-Regular.otf') format('otf'); /* 替换为字体文件的实际路径 */

//   }
//   *{
//     font-family: 'YourFontFamily' 
//   }
// *{
//   font-family: 'YourFontFamily' 
// }
.product_button {
  width: 1200px;
  display: flex;
  justify-content: end;
}



// @font-face {
//     font-family: 'YourFontFamily'; /* 替换为你的字体名称 *
//     src: url('../assets/font/NotoSerifCJKtc-Regular.otf') format('otf'); /* 替换为字体文件的实际路径 */

//   }

.product_allCards {
  width: 1200px;
  margin: 50px auto;
  display: flex;
  align-items: center;
  flex-wrap: wrap;
}

div {
  font-size: map-get($fontSizes, 'div');
}

@media screen and (max-width: 768px) {
  .product_allCards {
    width: 100%;
    justify-content: space-between;
  }
}

@media screen and (max-width: 414px) {
  .product_allCards {
    margin: 0;
  }
}
</style>