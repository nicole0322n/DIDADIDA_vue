<!-- <template>
  <div
    class="wrapper"
    @mousemove="getClient"
    :class="{
      wrapperChangePositionLeft: change,
    }"
  >
    <div
      class="shadow"
      :style="{ transform: `translate(${x}px, ${y}px)` }"
      ref="shadow"
    ></div>
  </div>
</template> -->
<template>
  <div class="wrapper">
    <video
      :src="require('../assets/video/pexels_videos_2556894 (1080p).mp4')"
      class="videoShark"
      autoplay
      loop
      v-if="autoPlayTrue"
      :key="aaa"
      muted
    ></video>
    <div class="shadow" ref="shadow"></div>
    <!-- 把shadow綁的style拿掉，解決遮蓋問題
      :style="{ transform: `translate(${x}px, ${y}px)` }" -->
  </div>
</template>
<script>
export default {
  name: "product",
  data() {
    return {
      x: 0,
      y: 0,
      change: false,
      autoPlayTrue: true,
      aaa: 1,
    };
  },
  methods: {
    getClient(e) {
      let x = e.clientX - document.documentElement.clientWidth * 1.8;
      let y = e.clientY - document.documentElement.clientHeight * 1.8;

      this.x = x;
      this.y = y;

      if (this.$refs.shadow) {
        this.$refs.shadow.style.transform =
          "translate(" + x + "px, " + y + "px)";
      } else {
        console.error("$refs.shadow is null");
      }
    },
    changeBkPosition() {
      let x = e.clientX - document.documentElement.clientWidth * 1.5;
      let y = e.clientY - document.documentElement.clientHeight * 1.5;
    },
  },
  mounted() {
    document.addEventListener("mousemove", this.getClient);
    document.addEventListener("touchmove", this.getClient);
    // if (this.$route.fullPath === "/?section=hide") {
    //   this.autoPlayTrue = true;
    // }
  },
};
</script>

<style scoped lang="scss">
body {
  margin: 0;
  padding: 0;
}

.videoShark {
  width: 100%;
  vertical-align: bottom;
}

.wrapper {
  // height: 80vh;
  // background-image: url("https://churaumi.okinawa/userfiles/images/area/kuroshio/media-03.jpg");
  // background-size: cover;
  position: relative;
  overflow: hidden;
  background-position: top;
  transition: 2s;
}

.wrapperChangePositionLeft {
  background-position: bottom;
}

.shadow {
  position: absolute;
  width: 250vw;
  height: 300vh;
  left: 50%;
  top: 50%;
  transform: translateX(-50%) translateY(-50%);
  background-image: radial-gradient(
    circle at center,
    transparent,
    #000000bf 10%
  );
}
</style>

<!-- const shadow = document.querySelector('.shadow');

document.addEventListener('mousemove', (e) => {
  let x = e.clientX - (document.documentElement.clientWidth * 1.5);
  let y = e.clientY - (document.documentElement.clientHeight * 1.5);
  shadow.style.transform = 'translate(' + x + 'px, ' + y + 'px)';
}) -->
