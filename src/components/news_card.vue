<template>
  <div class="select_btn">
    <newsSelect
      @transferClass="filterNewsByTag"
      @transfertime="filterNewsByTime"
      @transferSearch="searchClick"
    >
    </newsSelect>
  </div>
  <div class="card" v-for="(item, index) in displayedNews" :key="index">
    <a href="#">
      <div class="pic">
        <img :src="`${this.$store.state.chooseImgSrc}/all_images/news/${item.news_img}`" alt="" />
      </div>
      <div class="tag">{{ item.news_category }}</div>
      <div class="news_title">
        {{ item.news_title }}
        <div class="info">
          {{ item.news_date }}
        </div>
      </div>

      <div class="news_content">
        {{ item.news_content }}
      </div>
    </a>
  </div>
  <Page class="page" :total="filteredNews.length" @on-change="updatePage" :page-size="pageSize" v-model="this.currentPage"/>
</template>

<script>
import newsSelect from "../components/news_select.vue";
export default {
  data() {
    return {
      showPage: true,
      news_content: [
     
      ],
      pageSize: 9,
      currentPage: 1,
      displayedNews: [],
      filteredNews: [],
      tagOption: "所有主題",
      timeOption: "由新到舊",
      searchInput: " ",
    };
  },
  async mounted() {
    try {
      // 非同步請求數據
      const response = await fetch(`${this.$store.state.APIurl}newsSelect.php`);
      const myJson = await response.json();
      this.news_content = myJson.filter((item) => item.news_state !== "0");

      // 数据加载完成后进行筛选操作
      this.filterNewsByTag(this.tagOption);
      this.filterNewsByTime(this.timeOption);
      this.updatePage(1); // 触发一次分页更新，显示第一页的数据
      window.addEventListener("resize", this.handleWindowSize);
      this.handleWindowSize();
    } catch (error) {
      console.error("数据加载失败：", error);
    }
  },
  components: {
    newsSelect,
  },
  methods: {
    handleWindowSize() {
      const windowWidth = window.innerWidth;
      if (windowWidth > 992) {
        this.pageSize = 9;
      } else if (windowWidth > 767 && windowWidth <= 992) {
        this.pageSize = 8;
      } else {
        this.pageSize = 6;
      }
      this.updatePage(this.currentPage);
    },
    updatePage(page) {
      this.currentPage = page;
      console.log(this.currentPage);
      const startIdx = (this.currentPage - 1) * this.pageSize;
      const endIdx = startIdx + this.pageSize;
      this.displayedNews = this.filteredNews.slice(startIdx, endIdx);
    },
    applyFilters() {
      let filteredNews = this.news_content;

      if (this.tagOption !== "所有主題") {
        filteredNews = filteredNews.filter(
          (item) => item.news_category === this.tagOption
        );
      }
      if (this.timeOption === "由新到舊") {
        filteredNews.sort(
          (a, b) =>
            new Date(b.news_date).getTime() - new Date(a.news_date).getTime()
        );
      } else if (this.timeOption === "由舊到新") {
        filteredNews.sort(
          (a, b) =>
            new Date(a.news_date).getTime() - new Date(b.news_date).getTime()
        );
      }

      const searchInput = this.searchInput.toUpperCase();
      if (searchInput.trim() !== "") {
        filteredNews = filteredNews.filter((item) => {
          const search_content =
            item.news_title.toUpperCase() + item.news_content.toUpperCase();
          return search_content.includes(searchInput);
        });
      }

      // 更新 filteredNews 数组
      this.filteredNews = filteredNews;
    },

    filterNewsByTag(data) {
      this.tagOption = data;
      this.applyFilters();
      this.showPage = false;
      setTimeout(() => {
        this.showPage = true;
      }, 100);
      this.updatePage(1);
    },

    filterNewsByTime(data) {
      this.timeOption = data;
      this.applyFilters();
      this.updatePage(1);
    },

    searchClick(data) {
      this.searchInput = data;
      this.applyFilters();
      this.updatePage(1);
    },
  },
  beforeDestroy() {
    // 移除窗口宽度监听器，以防止内存泄漏
    window.removeEventListener("resize", this.handleWindowSize);
  },
};
</script>
<style scoped lang="scss">
.select_btn {
  margin: auto;
}

.card {
  max-width: calc(100% / 3);
  aspect-ratio: 1/1;
  padding: 0 30px 0;
  font-size: map-get($fontSizes, "a");
  position: relative;
  margin-bottom: 1rem;

  a {
    text-decoration: none;
    color: #333;
    transition: 0.3s;
  }

  .pic {
    overflow: hidden;
    position: relative;
    z-index: 1;
    width: 100%;

    img {
      aspect-ratio: 3 / 2;
      width: 100%;
      vertical-align: top;
      transform: scale(1);
      transition: 0.7s;

      &:hover {
        transition: 0.7s;
        transform: scale(1.1);
      }
    }
  }

  .tag {
    position: absolute;
    top: 10px;
    left: 20px;
    border-radius: 0 0 0 0.1em;
    background-color: #dc564a;
    padding: 0.3em 0.5em;
    color: map-get($colors, "light");
    font-size: 1rem;
    z-index: 2;
  }

  &::after {
    content: "";
    position: absolute;
    top: 42px;
    z-index: 1;
    left: 20px;
    border-bottom: solid 10px transparent;
    border-right: solid 10px #763030;
  }

  .news_title {
    max-width: 100%;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-size: map-get($fontSizes, "div");
    position: relative;
    padding-top: 0.5rem;

    .info {
      width: 8rem;
      height: 3.2rem;
      position: absolute;
      bottom: 0;
      right: -25px;
      background-image: url(../../public/all_images/news/output-onlinepngtools.png);
      background-size: contain;
      background-repeat: no-repeat;
      background-position: right;
      color: #2d0c0c;
      font-size: 0.8rem;
      text-align: center;
      padding-top: 1.5rem;
      z-index: 4;
    }
  }

  .news_content {
    line-height: 1.5;
    color: #333;
    transition: 0.3s;
    margin-top: 0.5em;
  }
}

.page {
  width: 100%;
  text-align: center;
  margin-bottom: 1rem;
}

@media screen and (max-width: 992px) {
  .card {
    max-width: calc(100% / 2);

    .news_content {
      display: -webkit-box;
      -webkit-box-orient: vertical;
      -webkit-line-clamp: 3;
      overflow: hidden;
    }
  }
}

@media screen and (max-width: 767px) {
  .card {
    max-width: 100%;
  }
}
</style>
