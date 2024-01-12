<template>
  <div class="guide">
    <h3Title>
      <template v-slot:h3>
        <h3>{{$t('園區地圖')}}</h3>
      </template>
    </h3Title>
    <div class="guide_map">
      <button @click="toggleBook" class="flip-btn"><span>{{$t('點我翻頁')}}</span></button>
      <div class="cover">
        <img :src="`${this.$store.state.chooseImgSrc}/all_images/guide/cover-left.jpg`" alt="">
      </div>
      <div id="book">
        <div id="top">
          <img src="https://i.imgur.com/RBBeLsB.jpg" alt="" />

          <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 100 100">
            <!-- 線性漸層 -->
            <defs>
              <filter id="drop-shadow-filter" x="0" y="0" width="150%" height="150%">
                <feDropShadow dx="0.1em" dy="0.2em" stdDeviation="0.1em" flood-color="rgba(0,0,0,0.5)" />
              </filter>
            </defs>
            <!-- 中層區 -->
            <g @click="scrollToSection(3)">
              <rect x="78" y="9" width="20" height="8" rx="1" ry="1" style="fill:#4B88FFa2;stroke-width:10;"></rect>
              <text x="79" y="15" fill="#fff" filter="url(#drop-shadow-filter)">{{$t('中層館')}}</text>
              <polyline points="0,0 85,0 85,9" style="fill:none; stroke:#786969; stroke-width:0.3" /> 
              <circle cx="90" cy="6" r="1" style="fill:none; stroke:#ffffff; stroke-width:0.2" />
              <circle cx="76" cy="10" r="2" style="fill:none; stroke:#ffffff; stroke-width:0.4" />
              <circle cx="85" cy="18" r="1.5" style="fill:none; stroke:#ffffff; stroke-width:0.2" />
            </g>
            <!-- 深層區 -->
            <g @click="scrollToSection(4)">
              <rect x="78" y="36" width="20" height="8" rx="1" ry="1" style="fill:#0016D8a2;stroke-width:10;"></rect>
              <text x="79" y="42" fill="#fff" filter="url(#drop-shadow-filter)">{{$t('深層館')}}</text>
              <polyline points="33,40 78,40" style="fill:none; stroke:#786969; stroke-width:0.3" />
              <circle cx="90" cy="49" r="1" style="fill:none; stroke:#ffffff; stroke-width:0.4" />
              <circle cx="95" cy="40" r="2" style="fill:none; stroke:#ffffff; stroke-width:0.2" />
              <circle cx="79" cy="38" r="1.5" style="fill:none; stroke:#ffffff; stroke-width:0.3" />
            </g>
          </svg>
        </div>
      </div>

      <div :class="{ 'open': isOpen, 'closed': !isOpen }" id="flip">
        <div id="front">
          <img :src="`${this.$store.state.chooseImgSrc}/all_images/guide/cover-right.jpg`" alt="">
          <div class="fishes">
            <img :src="`${this.$store.state.chooseImgSrc}/all_images/deco/deco_fishes.png`" alt="">
          </div>
          <div class="turtle">
            <img :src="`${this.$store.state.chooseImgSrc}/all_images/deco/deco_turtle_1.png`" alt="">
          </div>

        </div>
        <div id="back">
          <img :src="`${this.$store.state.chooseImgSrc}/all_images/guide/left.jpg`" alt="">
          <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 100 100">
            <!-- 線性漸層 -->
            <defs>
              <filter id="drop-shadow-filter" x="0" y="0" width="150%" height="150%">
                <feDropShadow dx="0.1em" dy="0.2em" stdDeviation="0.1em" flood-color="rgba(0,0,0,0.5)" />
              </filter>
            </defs>
            <!-- 表層區 -->
            <g @click="scrollToSection(2)" id="section1">
              <rect x="6" y="15" width="20" height="8" rx="1" ry="1" style="fill:#67daf4a2;stroke-width:10;"></rect>
              <text x="7" y="21" fill="#fff" filter="url(#drop-shadow-filter)">{{$t('淺層館')}}</text>
              <polyline points="15,15 15,10 50,10" style="fill:none; stroke:#786969; stroke-width:0.3" />
              <circle cx="6" cy="20" r="1" style="fill:none; stroke:#ffffff; stroke-width:0.5" />
              <circle cx="22" cy="18" r="2" style="fill:none; stroke:#ffffff; stroke-width:0.35" />
              <circle cx="18" cy="28" r="1.5" style="fill:none; stroke:#ffffff; stroke-width:0.4" />
            </g>
          </svg>
        </div>
      </div>

    </div>
  </div>
  <h3Title>
    <template v-slot:h3>
      <h3>{{$t('園區導覽')}}</h3>
    </template>
  </h3Title>


  <div class="tabs">
    <h4>{{ $t('淺層館') }}</h4>
    <input type="radio" name="name" v-model="selectedTab" value="tab2" id="section2" />

    <div class="content">
      <div class="wrap">
        <div class="about_content">

          <p>
            {{ $t('海洋表層區是指地球上的海洋中的最上層部分，通常指的是水面以下的相對較薄的水層，它包括了海洋中最頂部的數百米到一千米的水深範圍。這個區域在海洋學和生態學中非常重要，因為它直接受到陽光照射、風浪、潮汐和季節變化的影響，同時也是眾多海洋生物的居住地。') }}
          </p>
        </div>
        <div class="fish_wrap">
          <div class="fish" v-for="(item, index) in shallow_pic" :key="index">
            <div class="num">{{ index + 1 }}</div>
            <div class="pic_shape" :style="{ backgroundImage: `url(${item.pic})` }">
            </div>
            <div class="name">{{ $t(item.name) }}</div>
          </div>
        </div>
      </div>
    </div>
    <h4>{{ $t('中層館') }}</h4>
    <input type="radio" name="name" v-model="selectedTab" value="tab3" id="section3" />
    <div class="content">
      <div class="wrap">
        <div class="about_content">
          <p>
            {{ $t('海洋中層區的深度通常位於海平面以下約200米到1000米之間。隨著深度的增加，光線變得越來越有限，所以這個區域被稱為"光線不足層"。海洋中層區擁有豐富的生物多樣性，包括各種魚類、烏賊、燈籠魚等生物。這些生物通常會遷徙到這個區域，以覓食或避開掠食者。') }}
          </p>
        </div>
        <div class="fish_wrap">
          <div class="fish" v-for="(item, index) in middle_pic" :key="index">
            <div class="num">{{ index + 1 }}</div>
            <div class="name">{{ $t(item.name) }}</div>
            <div class="pic_shape" :style="{ backgroundImage: `url(${item.pic})` }">
            </div>
          </div>
        </div>
      </div>
    </div>
    <h4>{{ $t('深層館') }}</h4>
    <input type="radio" name="name" v-model="selectedTab" value="tab4" id="section4" />
    <div class="content">
      <div class="wrap">
        <div class="about_content">
          <p>{{ $t('深海區，是地球上最神祕和未被完全探索的地方之一，隱藏着無數令人驚奇的祕密。這片深不可測的海域位於陸地架的邊緣，通常從水面下200米（656英尺）深處開始，一直延伸到世界各個海洋的深部。') }}</p>
        </div>
        <div class="fish_wrap">
          <div class="fish" v-for="(item, index) in deep_pic" :key="index">
            <div class="num">{{ index + 1 }}</div>
            <div class="pic_shape" :style="{ backgroundImage: `url(${item.pic})` }">
            </div>
            <div class="name">{{ $t(item.name) }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import h3Title from "../components/h3TitleComponent.vue";

export default {
  data() {
    return {
      selectedTab: "tab2", // 默认选中的选项卡
      isClickScrollVisible: false,
      currentSection: 1,
      isOpen: true,
      shallow_pic: [
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/pexels-francesco-ungaro-2289411.jpg`, name: '海星' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/Mark_Rosenstein,iNaturalist.org.CC_BY-NC-SA.©Sea_Cucumbers.jpg`, name: '海參' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/pexels-nirav-shah-10303342.jpg`, name: '黃邊裸胸鱔' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/jellyfish.jpg`, name: '水母' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/dolphin.jpg`, name: '海豚' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/stingray.jpg`, name: '魟魚' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/shark_pic.jpg`, name: '鯊魚' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/killer_whale.jpg`, name: '虎鯨' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/lionfish-711799_1280.jpg`, name: '獅子魚' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/blue-5059268_1280.jpg`, name: '斑紋刺蓋魚' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/longhorn-cowfish-375110_1280.jpg`, name: '角箱魨' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/fish-7391851_1280.jpg`, name: '突角鼻魚' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/fish-2921430_1280.jpg`, name: '黃高鰭刺尾魚' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/pallet-doctor-fish-793369_1280.jpg`, name: '擬刺尾鯛' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/david-clode-HDVmdzQxAds-unsplash.jpg`, name: '小丑魚' }
      ],
      middle_pic: [
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/peter-boshra-j8BRxbtTwTQ-unsplash.jpg`, name: '烏賊' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/michael-worden-7hrNYNE7x44-unsplash.jpg`, name: '旗魚' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/noe-sardet-hp4SVuJM2-g-unsplash.jpg`, name: '櫛棘燈籠魚' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/ocean-sunfish-7177835_1280.jpg`, name: '翻車魨' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/sea-toad-62916_1280.jpg`, name: '斑點單棘躄魚' },

      ],
      deep_pic: [
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/Dumbo_Octopus©NOAA-Ocean-Exploration.jpg`, name: '小飛象章魚' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/Swimming_Sea_Cucumber©NOAA-Ocean-Exploration.jpg`, name: '浮游海參' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/Bobtail_Squid©Rickard_Zerpe.jpg`, name: '短尾烏賊' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/Chimaera©NOAA-Ocean-Exploration.jpg`, name: '銀鮫' },
        { pic: `${this.$store.state.chooseImgSrc}/all_images/guide/giant_isopod©NOAA-Ocean-Exploration.jpg`, name: '大王具足蟲' },

      ]
    };
  },
  components: {
    h3Title,
  },
  methods: {
    scrollToSection(sectionIndex) {
      const sectionElement = document.querySelector("#section" + sectionIndex);
      if (sectionElement) {
        sectionElement.scrollIntoView({
          behavior: "smooth",
          block: "start",
          inline: "nearest",
        });
      }
      this.selectedTab = "tab" + sectionIndex;
    },


    toggleBook() {
      this.isOpen = !this.isOpen;
    },
  },

};
</script>

<style scoped lang="scss">
h3 {
  @include h3Title();
}

::-webkit-scrollbar-track {
  -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
  background-color: #f5f5f5;
  border-radius: 10px;
}

::-webkit-scrollbar {
  width: 10px;
  background-color: #f5f5f5;
}

::-webkit-scrollbar-thumb {
  border-radius: 10px;
  background-image: -webkit-gradient(linear,
      left bottom,
      left top,
      color-stop(0.44, rgb(122, 153, 217)),
      color-stop(0.72, rgb(73, 125, 189)),
      color-stop(0.86, rgb(28, 58, 148)));
}

// 地圖css
.guide_map {
  position: relative;
  max-width: 90vw;
  margin: 5rem auto;
  transform: translateZ(-100px);

  .flip-btn {
    outline: none;
    border: none;
    background-color: rgb(175, 34, 100);
    color: #fff;
    padding: 1em 2em;
    position: absolute;
    border-radius: 12px 12px 0 0;
    font-size: 1em;
    top: -49px;
    left: 5%;
    z-index: 1;
    cursor: pointer;
    animation: bounce 4s infinite;

  }
  
  @keyframes bounce {

    5%,
    50% {
      transform: scale(1);
    }

    10% {
      transform: scale(0.9);
    }

    15% {
      transform: scale(1.15);
    }

    20% {
      transform: scale(1.15) rotate(-5deg);
    }

    25% {
      transform: scale(1.15) rotate(5deg);
    }

    30% {
      transform: scale(1.15) rotate(-3deg);
    }

    35% {
      transform: scale(1.15) rotate(2deg);
    }

    40% {
      transform: scale(1.15) rotate(0);
    }
  }



  .cover {
    width: 45vw;
    position: relative;
    left: 0;
    box-shadow: 0 0.2em 0.3em 0 #666;

    img {
      width: 100%;
      vertical-align: top;
    }
  }
}

/* 翻頁效果 */
#flip {
  max-width: 1200px;
  position: absolute;
  left: 50%;
  top: 0;
  transform: translateZ(-10px);
  transform-style: preserve-3d;
}


/* 打開 */
@keyframes wrapper-closed {
  0% {
    transform: rotateY(-180deg);
  }

  100% {
    transform: rotateY(0deg);
  }
}

@keyframes wrapper-open {
  0% {
    transform: rotateY(0deg);
  }

  100% {
    transform: rotateY(-180deg);
  }
}

/* 初始狀態合起 */
#flip.closed {
  animation: wrapper-closed 2s linear forwards;
}

/* 打開狀態 */
#flip.open {
  animation: wrapper-open 2s linear forwards;
}

#flip>div {
  position: absolute;
  left: 0;
  transform-origin: 0 100%;
  transform-style: preserve-3d;
}

/* 左內頁 */
#back {
  position: relative;
  width: 45vw;
  transform: rotateY(.4deg);
  transform-origin: -100% 0;
  z-index: 1;

  img {
    width: 100%;
    vertical-align: top;
  }

  svg {
    position: absolute;
    top: 0;
    left: 0;
    transform: rotateY(-180deg) translateZ(10px);


    rect {
      cursor: pointer;
    }

    text {
      font-size: 5px;
      pointer-events: none;
    }
    circle{
      pointer-events: none;
      &:nth-of-type(1){
        animation: bubble 3s linear infinite;
      }
      &:nth-of-type(2){
        animation: bubble 3s linear infinite 1s;
      }
      &:nth-of-type(3){
        animation: bubble 3s linear infinite 0.6s;
      }
    }
  }
}
@keyframes bubble{
  10%{
    opacity: 1;
    transform: translate( 0, -1px);
  }
  50%{
    opacity: 0.6;
    transform: translate( 5px, -5px);
  }
  100%{
    opacity: 0;
    transform: translate( 0px, -10px);
  }
}



#front {
  width: 45vw;
  overflow: hidden;

  img {
    width: 100%;
    vertical-align: top;
  }
}
.fishes{
    width: 12rem;
    position: absolute;
    right: 0;
    top: 0;
    animation: move 10s linear  infinite;
    img{
      width: 100%;
    }
  }
  .turtle{
    width: 6rem;
    position: absolute;
    left: -50px;
    bottom: -30px;
    rotate: 155deg;
    animation: move-2 13s linear  infinite -1s;

    img{
      width: 100%;
    }
  }
  @keyframes move {
    0%{
      transform: translate(5em, -6em);
    }
    10%{
      transform: translate(-6em, 1em);
    }
    20%{
      transform: translate(-14em, 6em);
    }
    30%{
      transform: translate(-21em, 11em);
    }
    40%{
      transform: translate(-28em, 16em);
    }
    50%{
      transform: translate(-35em, 21em);
    }
    60%{
      transform: translate(-42em, 26em);
    }
    70%{
      transform: translate(-49em, 31em);
    }
    80%{
      transform: translate(-56em, 36em);
    }
    90%{
      transform: translate(-63em, 41em);
    }
    100%{
      transform: translate(-70em, 46em);
    }
    
  }
  @keyframes move-2 {
    0%{
      transform: translate(-5em, 0);
    }
    20%{
      transform: translate(-20em, 2em);
    }
    40%{
      transform: translate(-35em, 4em);
    }
    60%{
      transform: translate(-50em, 6em);
    }
    80%{
      transform: translate(-65em, 8em);
    }
    100%{
      transform: translate(-80em, 10em);
    }
   
    
    
  }



#book {
  max-width: 50%;
  position: absolute;
  left: 50%;
  top: 0;
  transform: translate3d(0px, 0px, -10px) rotateX(0deg) rotateZ(0deg);
  transform-style: preserve-3d;
  box-shadow: 0.2em 0.2em 0.2em 0 #666;

}

/* 內右頁 */
#book #top {
  transform: rotateX('180deg');
  width: 45vw;
  position: relative;
  left: 0;
  top: 0;

  img {
    width: 100%;
    vertical-align: top;
  }

  svg {
    position: absolute;
    top: 0;
    right: 0;

    rect {
      cursor: pointer;
    }

    text {
      font-size: 5px;
      pointer-events: none;
    }
    circle{
      pointer-events: none;
      &:nth-of-type(1){
        animation: bubble 3s linear infinite;
      }
      &:nth-of-type(2){
        animation: bubble 3s linear infinite 1s;
      }
      &:nth-of-type(3){
        animation: bubble 3s linear infinite 0.6s;
      }
    }
  }
}

// 地圖css結束
.tabs {
  display: flex;
  box-sizing: border-box;
  position: relative;
  max-width: 100%;
  padding-top: 5rem;


  h4 {
    position: absolute;
    display: flex;
    justify-content: center;
    align-items: center;
    left: 5px;
    width: 8%;
    height: 2.5rem;
    z-index: 2;
    pointer-events: none;
    font-size: 1rem;

    &:nth-of-type(1) {
      top: 10px;
      left: 32%;
    }

    &:nth-of-type(2) {
      top: 10px;
      left: 46%;
    }

    &:nth-of-type(3) {
      top: 10px;
      left: 60%;
    }
  }

  input[type="radio"] {
    position: absolute;
    width: 8%;
    height: 2.5rem;
    appearance: none;
    cursor: pointer;
    z-index: 1;
    box-shadow: #9FACE6 -2px -2px 0px 2px, #74EBD5 0px 0px 0px 4px, rgba(0, 0, 0, 0.05) 0px 0px 2px 7px;
    transition: all 0.2s;
    border-radius: 40px;

    &:hover {
      box-shadow: #74EBD5 -2px -2px 0px 2px, #9FACE6 0px 0px 0px 4px, rgba(0, 0, 0, 0.05) 0px 0px 2px 7px;
      transform: scale(1.01);
    }

    &:checked {
      background-color: #cbefc3;
    }


    &:nth-of-type(1) {
      top: 10px;
      left: 32%;

    }

    &:nth-of-type(2) {
      top: 10px;
      left: 46%;

    }

    &:nth-of-type(3) {
      top: 10px;
      left: 60%;
    }

    &:checked+.content {
      display: block;
    }
  }

  .content {
    width: 100%;
    position: relative;
    background-size: cover;

    &:nth-of-type(1) {
      display: none;
      background-image: url(../../public/all_images/guide/middle.jpg);
    }

    &:nth-of-type(2) {
      display: none;
      background-image: url(../../public/all_images/guide/mikita-GdkuJ6tyciU-unsplash.jpg);
    }

    &:nth-of-type(3) {
      display: none;
      background-image: url(../../public/all_images/guide/shallow.jpg);
    }

    .wrap {
      display: flex;
      align-items: center;
      color: map-get($colors, 'light');
      text-shadow: black 0.1em 0.1em 0.2em;
      line-height: 1.5em;

      .about_content {
        width: 60%;
        padding: 4rem;
        line-height: 1.5em;
        font-size: 1.2rem;
      }

      .fish_wrap {
        background-color: rgba(116, 125, 134, 0.603);
        padding: 1rem;
        max-height: 700px;
        overflow-y: scroll;
        margin: auto;
        width: 40%;
        color: map-get($colors, 'light');

        .fish {
          width: 100%;
          position: relative;
          margin: 1rem 0;

          .name {
            position: absolute;
            font-size: map-get($fontSizes, "p");
            top: 45px;
          }

          .num {
            width: 30%;
            position: absolute;
            font-size: 1.5rem;
            border-bottom: #fff solid 1px;
            color: map-get($colors, 'light');
          }

          .pic_shape {
            width: 60%;
            margin: auto;
            aspect-ratio: 1/1;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;

          }
        }
      }
    }
  }
}

@media screen and (max-width: 768px) {

  .guide_map {
    .flip-btn {
      font-size: 0.7rem;
      top: -32px;
      padding: 0.7em 1em;
    }
  }
  .fishes{
    width: 2.5rem;
  }
  .turtle{
    width: 4rem;
  }

  .tabs {

    h4 {

      width: 20%;

      &:nth-of-type(1) {
        left: 10%;
      }

      &:nth-of-type(2) {
        left: 40%;
      }

      &:nth-of-type(3) {
        left: 70%;
      }
    }

    input[type="radio"] {
      width: 20%;

      &:nth-of-type(1) {
        left: 10%;
      }

      &:nth-of-type(2) {
        left: 40%;
      }

      &:nth-of-type(3) {
        left: 70%;
      }
    }

    .content {

      .wrap {
        flex-direction: column;
        .about_content {
          padding: 2rem;
          margin: 3rem 0;
          font-size: 0.7rem;
          width: 100%;
        }

        .fish_wrap {
          width: 100%;
          height: 480px;

          .fish {
            width: 50%;
            margin: 3rem auto;

            .name {
              top: 15px;
              left: -40px;
            }

            .num {
              left: -45px;
              top: -25px;
            }

            .pic_shape {
              width: 100%;
            }
          }
        }
      }
    }
  }
}
</style>
