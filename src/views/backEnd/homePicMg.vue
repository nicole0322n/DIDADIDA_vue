<template>
  <div class="homePicAll">
    <div @click="createNew">
      <button>+新增項目</button>
    </div>
    <div class="bannerTitle">
      <div>順序</div>
      <div>圖片</div>
      <div>上傳圖片</div>
    </div>
    <div class="singleBar" v-for="(i, index) in bannerAll" :key="index">
      <div>{{ indexPlus(index) }}</div>
      <div class="imgBox">
        <img :src="i.banner_pic" alt="" />
      </div>
      <div>
        <input type="file" @change="pushImg($event, index)" :disabled="i.isDis" />
        <div>尺寸 1920 X 200px</div>
      </div>

      <div class="updateAndDel">
        <div @click="updatePic(index, $event, i)">修改</div>
        <div @click="delRow(i, index)">刪除</div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      allBar: [],
      bannerAll: [],
      changePic: ""
    };
  },
  computed: {},
  mounted() {
    fetch(`${this.$store.state.APIurl}homeMgSelect.php`)
      .then(function (response) {
        return response.json();
      })

      .then((myJson) => {
        for (let i = 0; i < myJson.length; i++) {
          myJson[i].banner_pic = `${this.$store.state.chooseImgSrc}/all_images/banner/${myJson[i].banner_pic}`;
          myJson[i].isDis = true;
        }
        this.bannerAll = myJson;
      });
  },
  methods: {
    createNew() {
      if (this.bannerAll.length >= 5) {
        alert("已達上限");
        return;
      } else {
        this.bannerAll.push(["", true]);
      }
    },
    delRow(item, index) {
      const formData = new FormData();
      let banner_id = this.bannerAll[index].banner_id;

      formData.append("banner_id", banner_id);

      fetch(`${this.$store.state.APIurl}homePicMg.php`, {
        method: "POST",
        body: formData,
      }).then((res) => res.json());
      this.bannerAll.splice(index, 1);
    },
    updatePic(index, e, i) {
      if (e.target.innerText == "確認") {
        this.bannerAll[index].isDis = true;
        e.target.innerText = "修改";

        console.log(this.changePic);

        const formData = new FormData();
        let banner_id = this.bannerAll[index].banner_id;
        let banner_pic = this.bannerAll[index].banner_pic;

        formData.append("banner_id", banner_id);
        formData.append("image", this.changePic);
        // 使用fetch或axios將數據發送到PHP後端

        // 修改 ----------------------------
        if (i.banner_id) {
          let banner_id = i.banner_id;
          let formData = new FormData();
          formData.append("banner_id", banner_id);
          formData.append("image", this.changePic);

          alert("圖片修改成功");

          fetch(`${this.$store.state.APIurl}homePicMg.php`, {
            method: "post",
            body: formData,
          })
            .then((res) => res.json())
            .then((result) => {
              alert("圖片更新OK");
              console.log(result);
            });
          return;
        } else {
          fetch(`${this.$store.state.APIurl}homeMgInsert.php`, {
            method: "post",
            body: formData,
          })
            .then((res) => res.json())
            .then((result) => {
              alert("圖片更新OK");
              console.log(result);
            });
          return;
        }
      }
      this.bannerAll[index].isDis = false;
      e.target.innerText = "確認";
    },
    indexPlus(idx) {
      return (idx += 1);
    },
    getImagePath(index) {
      // 使用 require 导入图片，确保路径正确
      return require(`@/assets/images/bannerAll[${index}]`);
    },
    pushImg(e, index) {
      // console.log(e.target.files[0].name);
      // console.log(index);
      // this.bannerAll[
      //   index
      // ][0] = require(`../../assets/images/${e.target.files[0].name}`);
      // this.bannerAll[index][1] = true;

      let file = e.target.files[0];
      this.changePic = file;
      console.log("file", file);

      let readFile = new FileReader();
      readFile.readAsDataURL(file);
      readFile.addEventListener("load", function () {
        let image = new Image();
        image.src = readFile.result;
        console.log(image.src);
        image.style.width = "100%";
        image.style.height = "100%";
        document.querySelectorAll(".imgBox")[index].innerHTML = "";
        document.querySelectorAll(".imgBox")[index].appendChild(image);
      });
    },
  },
};
</script>

<style scoped lang="scss">
.homePicAll {
  .bannerTitle {
    display: flex;
    border-bottom: 1px black solid;
    padding: 20px 0 0;
    font-weight: 800;
    // justify-content: space-around;

    & div:first-child {
      margin-left: 30px;
    }

    & div:nth-of-type(2) {
      margin-left: 65px;
    }

    & div:last-child {
      margin-left: 28%;
    }
  }


  .singleBar {
    display: flex;
    align-items: center;
    justify-content: space-around;
    border-bottom: 1px black solid;

    .imgBox {
      width: 250px;
      height: 150px;

      img {
        width: 100%;
        height: 100%;
        vertical-align: bottom;
      }
    }

    .updateAndDel {
      display: flex;

      div {
        border: 1px black solid;
        cursor: pointer;
        padding: 5px 15px;
        margin: 3px;
      }
    }
  }
}
</style>
