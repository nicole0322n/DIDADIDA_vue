<template>
  <div class="favorites_list_main">
    <div class="favorites_list_area">
      <div class="favorites_list_group" v-for="(favo, index) in favAPI" :key="favo.prod_img">
        <span class="close" @click="delSingleItem(favo, index)">&times;</span>
        <div class="favorites_list_img">
          <img :src="favo.prod_img" alt="" />
        </div>
        <div class="favorites_list_info">
          <div>
            <h5>{{ favo.prod_name }}</h5>
            <p>NT {{ favo.prod_price }}</p>
          </div>
          <div>
            <p>{{ favo.prod_info }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import memChangePage from "../components/memChangePage.vue";
export default {
  name: "favoritesList",
  components: {
    memChangePage,
  },
  data() {
    return {
      favoList: [],
      favAPI: [],
    };
  },
  mounted() {
    fetch(`${this.$store.state.APIurl}prod_cardFavSelect.php`)
      .then(function (response) {
        return response.json();
      })
      .then((data) => {
        this.favAPI = [];
        if (!this.$store.state.userName) {
          return;
        }
        for (let i = 0; i < data.length; i++) {
          if (this.$store.state.memberId == data[i].mem_id) {
            this.favAPI.push(data[i]);
          }
          data[i].prod_img = `${this.$store.state.chooseImgSrc}/all_images/product/${data[i].prod_img}`;
        }
        this.favAPI = data;
        console.log(this.favAPI);
      });
  },
  methods: {
    delSingleItem(favo, idx) {
      this.favAPI.splice(idx, 1);
      let formData = new FormData();
      let prod_id = favo.prod_id;
      formData.append("mem_id", this.$store.state.memberId);
      formData.append("prod_id", prod_id);
      fetch(`${this.$store.state.APIurl}prod_cardFavDelete.php`, {
        method: "POST",

        body: formData,
      });
      this.$store.commit("removeFavoItem", idx);
    },
  },
};
</script>

<style scoped lang="scss">
.favorites_list_area {
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
  overflow-y: auto;

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

  .favorites_list_group {
    width: 460px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-evenly;
    z-index: 2;
    position: relative;

    .close {
      position: absolute;
      top: 10px;
      right: 10px;
      cursor: pointer;
      color: map-get($colors, "dark");
    }
  }

  h5 {
    font-size: map-get($fontSizes, "div");
    color: map-get($colors, "dark");
  }

  p {
    width: 90%;
    text-align: justify;
    font-size: map-get($fontSizes, "mini");
    color: map-get($colors, "dark");
  }

  .favorites_list_group:last-child {
    border-bottom: 0;
  }

  .favorites_list_img {
    width: 50%;
    height: 150px;
    margin: 20px auto;
  }

  .favorites_list_img img {
    width: 100%;
    height: 100%;
    object-fit: contain;
  }

  .favorites_list_info {
    width: 50%;
    height: 150px;
    margin-top: 20px;
  }
}

@media screen and (max-width: 414px) {
  .favorites_list_area {
    width: 330px;
    height: 720px;

    p {
      width: 100%;
    }

    .favorites_list_group {
      width: 300px;
      flex-direction: column;
    }

    .favorites_list_img {
      width: 100%;
    }

    .favorites_list_info {
      width: 100%;
      margin: 0 auto;
    }
  }
}
</style>
