<template>
  <main class="path_main">
    <div class="path_container">
      <h1>DIDA DIDA</h1>
      <div class="front">
        <router-link to="/" @click="this.$store.state.chooseFrontBack = true">
          <button></button>
          <p>前台</p>
        </router-link>
      </div>

      <!-- 尚未建立 -->

      <div class="back">
        <router-link to="/backHome" @click="this.$store.state.chooseFrontBack = true">
          <button></button>
          <p>後台</p>
        </router-link>
      </div>
    </div>
    <div class='center'>
      <div class='blob'></div>
    </div>
  </main>
</template>

<script>
export default {
  components: {},
  data() {
    return {};
  },
  methods: {},
};
</script>

<style scoped lang="scss">
// @import "@/assets/sass/style.scss";

main {
  background-image: url("../../public/all_images/water-1330252_1920.jpg");
  filter: contrast(70%);
  background-color: #ebe8e8;
  min-height: 100vh;
  background-size: 100% 100%;
  position: relative;
  overflow: hidden;
  transition: all 3s ease-in-out;

  &:hover {
    background-size: 110% 110%;
  }
}

h1 {
  width: 100%;
  font-size: 5rem;
  text-align: center;
  position: absolute;
  top: 20%;
  left: 50%;
  transform: translate(-50%, -30%);
  // background-image: url(../../public/all_images/waves-bg.jpg);
  color: #ffffff;
  letter-spacing: 5px;
  animation: bg_move 200s linear infinite;
  text-shadow: 0px 14px 10px rgba(0, 0, 0, 0.15),

    0px 24px 2px rgba(0, 0, 0, 0.1),

    0px 34px 30px rgba(0, 0, 0, 0.1);


}

@keyframes bg_move {
  0% {
    background-position: 0% 40%;
  }

  50% {
    background-position: 100% 40%;
  }

  100% {
    background-position: 0% 40%;
  }

}

.front {
  position: absolute;
  top: 40%;
  left: 10%;

}

.back {
  position: absolute;
  top: 40%;
  right: 10%;

}

button {
  height: 10rem;
  width: 10rem;
  border-radius: 58% 43% 33% 64% / 50% 38% 53% 50%;
  // background: transparent;
  box-shadow: inset 6px 33px 20px 0 #dcd9d9, inset 20px 80px 15px 0 #f4f0f0, 10px 20px 20px 0px #697c91c7;
  cursor: pointer;
  border: none;
  scale: 1;
  transition: all .3s;
  position: relative;

  &:hover {
    scale: 1.1;
    animation: bubble_rotate 10s linear infinite;
  }

}


p {
  color: #232D47;
  font-size: 3em;
  position: absolute;
  inset: 0;
  text-align: center;
  top: 35%;
  pointer-events: none;
}

button::before {
  content: '';
  position: absolute;
  border-radius: 37% 54% 46% 46%;
  background: white;
  width: 40%;
  transform: rotate(-30deg);
  height: 15%;
  top: 10%;
  left: 20%;
}

button::after {
  content: '';
  position: absolute;
  border-radius: 50%;
  background: white;
  width: 10%;
  height: 10%;
  top: 40%;
  left: 10%;
}

@keyframes bubble_rotate {
  0% {
    transform: rotate(0deg);
    border-radius: 48% 43% 53% 64% / 50% 58% 53% 60%;
  }

  100% {
    transform: rotate(360deg);
    border-radius: 68% 43% 53% 64% / 60% 58% 73% 60%;
  }

}
@media screen and (max-width:768px) {
  h1{
    font-size: 3rem;
  }
  button {
  height: 5rem;
  width: 5rem;
}
p{
  font-size: 1.5rem;
}
  
}
</style>
