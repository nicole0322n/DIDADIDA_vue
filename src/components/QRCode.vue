<template>
  <div>
    <button
      class="qr_btn"
      @click="showModal = true"
      v-if="!usedTicket && !tic_late && tic_state == '可使用'"
    >
      顯示電子票券
    </button>
    <transition name="fade">
      <div v-if="showModal" class="modal">
        <div class="shadow" @click="showModal = false"></div>
        <div class="modal-content">
          <div class="qrcode-content">
            <div class="qrcode-img">
              <span class="close" @click="showModal = false">&times;</span>
              <vue-qrcode :value="qrCodeData" :size="150"></vue-qrcode>
            </div>
            <div class="qrcode-info">
              <div style="height: 60px; border-left: 3px solid #333"></div>
              <div>
                <p>DIDADIDA好時光票券</p>
                <p>{{ checkDate }}</p>
                <p>請掃描電子票券入場</p>
              </div>
            </div>
            <div class="qr-confirm-btn" @click="visitPlus">
              <button @click="sendUsed">確認</button>
              <!-- 按確認要核對日期 -->
            </div>
          </div>
          <div class="deco_fishes">
            <img src="../../public/all_images/deco/deco_fishes.png" alt="" />
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>
<script>
import VueQrcode from "../../node_modules/vue-qrcode";
export default {
  name: "QRCode",
  components: {
    VueQrcode,
  },
  data() {
    return {
      usedTicket: false,
      showModal: false,
      qrCodeData: "https://yahoo.com.tw", // QR碼連到的地方
    };
  },
  methods: {
    visitPlus() {
      this.showModal = false;
      this.$store.state.visitCount++;
    },
    sendUsed() {
      const checkDateObject = new Date(this.checkDate);
      const currentDate = new Date();

      if (checkDateObject > currentDate) {
        alert("日期不符!!");
        return;
      } else if (checkDateObject <= currentDate) {
        const formData = new FormData();

        let tic_id = this.tic_id;
        formData.append("tic_id", tic_id);
        fetch(`${this.$store.state.APIurl}QRCodeCount.php`, {
          method: "post",
          body: formData,
        })
          .then((res) => res.json())
          .then((data) => {
            console.log(data);
          });
      }

      this.usedTicket = true;
      this.$emit("checkTicket", true, this.ticketIndex);
      this.$store.state.activeIndexes.push({
        visted: true,
        tickIdx: this.ticketIndex,
      });
    },
  },
  props: ["checkDate", "ticketIndex", "tic_late", "tic_id", "tic_state"],
};
</script>

<style scoped lang="scss">
.qr_btn {
  width: 150px;
  margin: 5px;
  border: 0;
  background-color: map-get($colors, "h2Blue");
  cursor: pointer;
}

.modal {
  // display: flex;
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
    width: 500px;
    height: 550px;
    margin: 0 auto;
    border: 0;
    border-radius: 15px;
    text-align: center;
    background-color: #fff;
    padding: 20px;
    position: relative;
    top: 30px;
    display: flex;
    align-items: center;
  }

  .close {
    position: absolute;
    top: 10px;
    right: 10px;
    color: #333;
    cursor: pointer;
  }

  .qrcode-content {
    width: 420px;
    height: 480px;
    margin: 0 auto;
    border: 0;
    border-radius: 15px;
    background-image: url(../../public/all_images/QRbg.jpg);
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
  }

  .qrcode-img {
    width: 200px;
    height: 200px;
    margin: 0 auto;

    img {
      width: 100%;
      border: 0;
      border-radius: 15px;
    }
  }

  .qrcode-info {
    width: 200px;
    height: 120px;
    margin: 0 auto;
    text-align: justify;
    display: flex;
    justify-content: space-evenly;
    align-items: center;

    p {
      color: map-get($colors, "light");
      font-size: map-get($fontSizes, "p");
    }
  }

  .qr-confirm-btn {
    z-index: 2;

    button {
      width: 70px;
      height: 40px;
      border: 0;
      border-radius: 10px;
      background-color: map-get($colors, "QRbtn");
      color: map-get($colors, "dark");
      font-weight: bold;
      cursor: pointer;
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

.deco_fishes {
  position: absolute;
  bottom: -5px;
  right: 40px;
}

@media screen and (max-width: 414px) {
  .qr_btn {
    width: 130px;
  }

  .modal {
    .modal-content {
      width: 300px;
      height: 400px;
    }

    .qrcode-content {
      width: 270px;
      height: 370px;
    }

    .qrcode-img {
      width: 160px;
      height: 140px;
    }
  }

  .deco_fishes {
    right: -25px;
    bottom: -20px;

    img {
      width: 70%;
    }
  }
}
</style>
