<template>
   
  <div class="product_allCards">
    <news_card></news_card>
  </div>
  <!-- card -->
</template>
   
<script>
import news_card from '../components/news_card.vue'
import login from '../components/login.vue'
import footer1 from '../components/footer.vue'
import header1 from '../components/header.vue'
import wave from '../components/wave.vue'
import select_info from '../components/news_select.vue'


export default {
  name: 'news',
  data() {
    return {
    
    }
  },
  props: {
    msg: String
  },
  components: {
    news_card,
    footer1,
    login,
    header1,
    wave,
    select_info
  },
  
  methods: {
    toTop() {
      this.$router.push({ path: '/news', query: { headerSection: 'header' } });

    },
  
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


.product_allCards {
  display: flex;
  justify-content: start;
  align-items: center;
  flex-wrap: wrap;
}

div {
  font-size: map-get($fontSizes, 'div');
}
</style>