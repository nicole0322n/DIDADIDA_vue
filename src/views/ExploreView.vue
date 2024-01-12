<template>
  <div class="explore">
    <div class="wapper">
      <!-- 表層海洋帶 -->
      <div class="slot" id="one"></div>
      <h1 data="0m">0m</h1>

      <!-- 動物們 -->
      <div v-for="(animal, index) in animals" :key="index" :ref="`parallaxScene${index}`" :id="`scene${index}`"
        data-relative-input="true" :class="animal.category">
        <img :src="animal.image" :alt="animal.name" :data-depth="animal.depth" @click="showCard(animal)" />
        <h4 :data-depth="animal.depth">{{ $t(animal.name) }}</h4>
      </div>

      <!-- 中層海洋帶 -->
      <div class="line middle">
        <div class="slot" id="two"></div>
        <h1 data="200m">200m</h1>
      </div>

      <!-- 深層海洋帶 -->
      <div class="line deep">
        <div class="slot" id="three"></div>
        <h1 data="1000m">1000m</h1>
      </div>
      <!-- 深淵層海洋帶 -->
      <div class="line verydeep">
        <div class="slot" id="four"></div>
        <h1 data="4000m">4000m</h1>
      </div>
      <!-- 超深淵層海洋帶 -->
      <div class="line supperdeep">
        <div class="slot" id="five"></div>
        <h1 data="6000m">6000m</h1>
      </div>

      <div class="ship">
        <img src="../../public/all_images/animal/ship.png" alt="" />
      </div>
    </div>

    <div class="navBar" v-if="show">
      <ul>
        <li>
          <router-link to="#" @click.prevent="btnScroll('表層海洋帶')">0m
            <div class="drop"></div>
          </router-link>
        </li>
        <li>
          <router-link to="#" @click.prevent="btnScroll('中層海洋帶')">200m
            <div class="drop"></div>
          </router-link>
        </li>
        <li>
          <router-link to="#" @click.prevent="btnScroll('深層海洋帶')">1000m
            <div class="drop"></div>
          </router-link>
        </li>
        <li>
          <router-link to="#" @click.prevent="btnScroll('深淵層海洋帶')">4000m
            <div class="drop"></div>
          </router-link>
        </li>
        <li>
          <router-link to="#" @click.prevent="btnScroll('超深淵層海洋帶')">6000m
            <div class="drop"></div>
          </router-link>
        </li>
      </ul>
      <div class="line"></div>
    </div>

    <!-- ↓↓↓ 商品彈窗 ↓↓↓ -->
    <transition name="fade">
      <div class="card" v-if="selectedAnimal">
        <div class="shadow" @click="closeCard"></div>
        <div class="card_content">
          <div class="ani_img">
            <img :src="selectedAnimal.image" alt="" />
          </div>
          <div class="ani_name">
            <h4><span>{{ selectedAnimal.name }}</span></h4>
            <p>{{ selectedAnimal.enName }}</p>
          </div>
          <div class="ani_info">
            <p>{{ selectedAnimal.p }}</p>
          </div>
          <div class="ani_features">
            <ul>
              <li v-for="str in selectedAnimal.features" :key="str">{{ str }}</li>
            </ul>
          </div>
          <div class="close" @click="closeCard">
            <i class="fa-solid fa-xmark" style="color: #062f4a"></i>
          </div>
        </div>
      </div>
    </transition>
    <!-- ↑↑↑ 商品彈窗 ↑↑↑ -->
  </div>
</template>

<script>
import Parallax from "parallax-js";
import VueParallax from "vue-parallax";

export default {
  data() {
    return {
      parallaxValue: 30,
      selectedAnimal: null,
      show: false,
      animals: [
        {
          name: '黃高鰭刺尾魚',
          image: require('../../public/all_images/animal/goldfish.png'),
          depth: '0.2',
          category: 'goldfish',
          enName: "Yellow tang",
          p: '熱帶海洋的明亮黃色魚種，以其高背鰭和尾鰭上的骨刺而聞名。',
          features: [
            "— 外觀特徵 —",
            "擁有鮮豔的黃色身體，背鰭和尾鰭高挺，背鰭上有骨刺。額頭有黑色條紋，眼睛周圍有藍色環繞。牠們體型瘦長，這些特徵使其在熱帶海域的珊瑚礁中非常顯眼和獨特。",
            "— 棲息地 —",
            "主要棲息於熱帶海洋，特別是印度-太平洋地區的珊瑚礁。牠們經常在潮池、礁石和沿岸區域出現，以珊瑚和底層生物為食。這種環境提供了豐富的食物來源和適合繁殖的場所。"]
        },
        {
          name: "玳瑁",
          image: require("../../public/all_images/animal/turtle.png"),
          depth: "0.5",
          category: "turtle",
          enName: "Hawksbill Turtle",
          p: "一種海龜物種，屬於海洋爬行動物，被廣泛認為是美麗而又瀕危的物種。",
          features: [
            "— 外觀特徵 —",
            "外殼呈現五角形的形狀，有許多彎曲的甲板，讓牠們在水中更靈活。這些甲板上通常有不規則的金黃色、紅棕色或綠色的斑紋，為牠們提供了極佳的保護色。",
            "— 棲息地 —",
            "廣泛分佈於熱帶和亞熱帶海域，包括大西洋、印度洋和太平洋。牠們在珊瑚礁、海草床、潟湖等地找到適合的棲息地。",
          ],
        },
        {
          name: "擬刺尾鯛",
          image: require("../../public/all_images/animal/dory.png"),
          depth: "0.4",
          category: "dory",
          enName: "Palette surgeonfish(Dory)",
          p: "一種熱帶海洋魚類，以其多刺的背鰭和鮮豔的色彩而著名。",
          features: [
            "— 外觀特徵 —",
            "具有鮮艷的藍色身體，黃色背鰭和臉部橙色斑塊。額頭有一道黑帶，尾部有藍色刺。這種魚通常身材修長，擁有迷人的外觀，是珊瑚礁中的美麗生物。",
            "— 棲息地 —",
            "生活在熱帶印度-太平洋海域的珊瑚礁區域。牠們偏愛淺水區域，通常在珊瑚礁的缝隙和洞穴中覓食。這種魚類是社會性的，常成群活動，並喜歡在水流較強的地方滑翔，以覓食浮游生物和藻類。",
          ],
        },
        {
          name: "小丑魚",
          image: require("../../public/all_images/animal/nimo.png"),
          depth: "0.2",
          category: "nimo",
          enName: "Clownfish(Nemo)",
          p: "一種熱帶海洋魚類，以鮮豔色彩和與海葵互惠共生的生活方式而聞名。",
          features: [
            "— 外觀特徵 —",
            "身體圓潤、鮮豔，主要以橙色為基調，並帶有黑色條紋，通常有三條垂直條紋穿越眼睛。牠們的背鰭有銳利的棘刺，用以保護自己。小丑魚的外觀迷人，是熱帶海洋中的瑰寶。",
            "— 棲息地 —",
            "主要棲息在印度-太平洋地區的珊瑚礁區域。牠們與海葵建立互惠共生關係，常在海葵中找到避敵庇護，並共同保護海葵。這種環境提供了豐富的食物和遮蔽，使小丑魚在珊瑚礁中繁衍生息。",
          ],
        },
        {
          name: "河豚",
          image: require("../../public/all_images/animal/angryfish.png"),
          depth: "0.3",
          category: "angryfish",
          enName: "Pufferfish",
          p: "一種海洋魚類，以其圓潤的身體和膨脹能力而聞名。部分河豚具有毒性。",
          features: [
            "— 外觀特徵 —",
            "擁有特徵性的圓潤身體，大部分種類的皮膚覆蓋著小刺。牠們有突出的眼睛和一個寬大的嘴巴，常常露出可愛的微笑。河豚的身體顏色因種類而異，包括白色、棕色、灰色和橙色等。",
            "— 棲息地 —",
            "生活在世界各地的淡水和鹹水環境中，包括河流、湖泊、沼澤、海洋和珊瑚礁。牠們常常在沙泥底質或岩石底質的水域中覓食，並根據環境的不同，有各種不同種類和生態棲息地。",
          ],
        },
        {
          name: "黃顱刺蓋魚",
          image: require("../../public/all_images/animal/blueyellow.png"),
          depth: "0.1",
          category: "blueyellow",
          enName: "Blue face angelfish",
          p: "熱帶海洋魚種，以其亮黃色頭部和刺蓋而著名，生活在珊瑚礁區域。",
          features: [
            "— 外觀特徵 —",
            "具有鮮豔的亮黃色頭部和胸鰭，其餘身體為藍色。特徵性的是頭部上有許多棘刺，包括在眼睛周圍和鰓蓋上。這些刺蓋提供保護，使其在珊瑚礁中尋找食物時能夠防禦潛在的威脅。",
            "— 棲息地 —",
            "主要棲息在印度-太平洋地區的珊瑚礁和岩石礁區域。牠們喜歡在淺水區域，通常可見於潮汐區域和岩縫之間。這種環境提供了豐富的食物來源，並為牠們提供了遮蔽和庇護所。",
          ],
        },
        {
          name: "鯨鯊",
          image: require("../../public/all_images/animal/whale.png"),
          depth: "0.4",
          category: "whale",
          enName: "Whale shark",
          p: "大型的軟骨魚類，以其巨大的體型和特徵性的鯊魚外觀而著名。",
          features: [
            "— 外觀特徵 —",
            "身體呈流線型，背部呈深藍或灰色，腹部白色。牠們擁有特大的三角形背鰭、大嘴和多排鋸齒狀牙齒。眼睛相對較小，並且具有特徵性的鯊魚鰓裂。這些外觀特徵幫助鯨鯊在海洋中捕獵和生存。",
            "— 棲息地 —",
            "廣泛分布於世界各大洋，特別在溫暖和溫和的海域中常見。牠們棲息在深海和沿岸水域，包括大陸架和遠洋區域。鯨鯊在不同環境中繁衍，從熱帶到溫帶海域均可找到牠們的蹤跡。",
          ],
        },
        {
          name: "海星",
          image: require("../../public/all_images/animal/star.png"),
          depth: "0.2",
          category: "star",
          enName: "Sea star",
          p: "海洋中的無脊椎動物，以獨特的星形外觀和各種顏色而著名。",
          features: [
            "— 外觀特徵 —",
            "以多種外觀特徵聞名，其身體呈星形，通常有5臂，但也有些種類有更多臂。牠們的表面覆蓋著硬質骨板，並常有顏色斑駁或斑點。海星的顏色多種多樣，包括紅、橙、黃、藍、綠等各種明亮的色彩。",
            "— 棲息地 —",
            "廣泛分布於全球海洋，生活在不同深度的海底，從潮間帶到深海。牠們棲息在礁石、沙泥底質、岩石和珊瑚礁上。海星是多樣性和適應力強的生物，能在各種海洋環境中找到牠們的家。",
          ],
        },
        {
          name: "獅子魚",
          image: require("../../public/all_images/animal/leofish.png"),
          depth: "0.4",
          category: "leofish",
          enName: "Lionfish",
          p: "熱帶海洋魚類，以其多彩的體色和獅子般的鬚鬚而聞名。",
          features: [
            "— 外觀特徵 —",
            "有鮮豔的體色，通常為紅色、橙色或黃色，身體長而側扁，具有特徵性的長鬚。牠們的鬚鬚擺動，類似獅子的鬃毛，因此得名。背鰭高而胸鰭發達，外觀引人注目，是熱帶海洋珊瑚礁中的迷人生物。",
            "— 棲息地 —",
            "主要棲息在熱帶和亞熱帶地區的珊瑚礁和岩石礁區域。牠們喜歡沿著珊瑚礁的斜坡和洞穴中生活，這些地方提供了遮蔽和狩獵的機會。獅子魚常被視為珊瑚礁生態系統中的重要成員之一。",
          ],
        },
        {
          name: "鑽嘴魚",
          image: require("../../public/all_images/animal/linefish.png"),
          depth: "0.4",
          category: "linefish",
          enName: "Slender whipfin mojarra",
          p: "熱帶和亞熱帶海洋魚類，以其長而尖的嘴巴和多彩的體色而聞名。",
          features: [
            "— 外觀特徵 —",
            "身體細長，體色鮮豔多彩，通常為藍色或綠色，並擁有金色或橙色的斑點。牠們的嘴巴非常長且尖銳，適合捕捉小型獵物。鑽嘴魚的外觀充滿活力，是熱帶海洋中的迷人生物。",
            "— 棲息地 —",
            "主要分布在熱帶和亞熱帶海域，包括珊瑚礁、岩石礁、海草床等不同棲息地。牠們常出現在沿岸區域，水深可達數十米。這種多彩的魚類以其適應力強和廣泛分布的特點而著稱。",
          ],
        },
        {
          name: "鯊魚",
          image: require("../../public/all_images/animal/shark.png"),
          depth: "0.7",
          category: "shark",
          enName: "Shark",
          p: "大型的軟骨魚類，以其多彩的品種和在海洋食物鏈中的重要地位而著名。",
          features: [
            "— 外觀特徵 —",
            "擁有流線型身體，背部通常呈深藍或灰色，腹部白色。牠們具有鋸齒狀的三角形齒鋒，多排的齒齦，和大型背鰭。鯊魚外觀威猛，是海洋中的頂級掠食者。",
            "— 棲息地 —",
            "分佈於全球各大洋，從淺水區域到深海，牠們生活在不同環境，包括沿岸、珊瑚礁、大陸架和遠洋海域。鯊魚常在溫暖、溫和的海域出現，並根據品種和生態需求選擇不同的棲息地。",
          ],
        },
        {
          name: "白鯨",
          image: require("../../public/all_images/animal/white.png"),
          depth: "0.1",
          category: "white",
          enName: "Beluga whale",
          p: "大型鯨類之一，以其巨大體型和白色皮膚而著名。",
          features: [
            "— 外觀特徵 —",
            "體型巨大，背部呈黑色或深灰色，腹部為白色。牠們頭部龐大，嘴巴寬闊，且嘴角微微上翹。白鯨的皮膚呈白色，為其命名的原因。牠們的尾鰭寬大且呈鎌狀，尾部的凹陷為獨特特徵，使其容易識別。",
            "— 棲息地 —",
            "生活在北極和亞北極地區的冷水海域。牠們常出現在冰川、浮冰和冰緣帶附近，以尋找食物。白鯨的棲息地主要集中在北冰洋和北大西洋的高緯度地區，這些地方提供了豐富的食物和冷水環境，適合牠們的生存。",
          ],
        },
        {
          name: "水母",
          image: require("../../public/all_images/animal/jellyfish.png"),
          depth: "0.1",
          category: "jellyfish",
          enName: "Jellyfish",
          p: "透明軟體生物，主要由膠質構成，無骨骼和大腦，以其多樣的品種和美麗的外觀而著名。",
          features: [
            "— 外觀特徵 —",
            "外觀因品種而異，通常呈半透明或透明，呈鈴鐺或傘狀形狀，具有觸手，觸手上有刺細胞用於捕捉獵物。一些水母擁有鮮豔的色彩，但大多數呈淡色調。牠們的外觀優美，是海洋中迷人的生物。",
            "— 棲息地 —",
            "廣泛分布於全球的海洋，從表層到深海。牠們漂浮在水面附近，也沿著潮汐和洋流移動。水母主要生活在海洋開放水域，但也常出現在沿岸區域和珊瑚礁周圍。牠們對水溫和鹽度的變化具有很高的適應性。",
          ],
        },
        {
          name: "鋸鯊",
          image: require("../../public/all_images/animal/nosefish.png"),
          depth: "0.1",
          category: "nosefish",
          enName: "Japanese sawshark",
          p: "一種軟骨魚類，以其独特的鋸齒和橙色斑紋而著名。",
          features: [
            "— 外觀特徵 —",
            "具有流線型身體，背部呈褐色或深灰色，腹部白色。最顯著的特徵是長而鋸齒狀的嘴巴，以及身體上的明亮橙色或棕色斑紋。鋸鯊的眼睛相對較小，體態中等大小，是一種引人注目的海洋生物。",
            "— 棲息地 —",
            "廣泛分布於全球溫暖和熱帶的海域，主要生活在沿岸水域、大陸架和珊瑚礁附近。牠們常出現在較淺的水域，但也能在深海中被發現。鋸鯊是多種生態系統的一部分，包括近岸和遠洋環境。",
          ],
        },
        {
          name: "儒艮",
          image: require("../../public/all_images/animal/manatee.png"),
          depth: "0.1",
          category: "manatee",
          enName: "Dugong",
          p: "水生哺乳動物，外觀似潛水獸，生活在溫暖的海洋和淡水環境中，以草食為主。",
          features: [
            "— 外觀特徵 —",
            "體型龐大，身體呈紡錘形，沒有背鰭或尾鰭，通常呈灰色或棕色。牠們皮膚覆蓋著粗糙的皺紋和瘤狀突起，有厚重的皮膚和脂肪層，顯示出適應水生生活的特徵。牠們的頭部扁平，口巴寬大，眼睛相對小。",
            "— 棲息地 —",
            "生活在熱帶和亞熱帶的海洋、河流和湖泊中，主要棲息在沿岸和沼澤地帶。牠們常在海草床、珊瑚礁和淡水植物區域尋找食物。海牛是水生生活的專家，以其溫和的性格和草食性質而聞名。",
          ],
        },
        {
          name: "大王烏賊",
          image: require("../../public/all_images/animal/taco.png"),
          depth: "0.1",
          category: "taco",
          enName: "King squid",
          p: "大型頭足綱軟體動物，以其強大的游泳能力、巨大的觸腕和複雜的智慧而著名。",
          features: [
            "— 外觀特徵 —",
            "身體長而細長，呈橢圓形，通常為粉紅色或淡紫色。牠們擁有極長的觸腕，其中兩條較長，並具有許多吸盤，用於捕捉獵物。牠們的眼睛相對大，具有高度發達的視覺系統，是頭足綱中的智者。",
            "— 棲息地 —",
            "主要分布在深海環境中，生活在海洋中的各個區域，包括深海水域、大陸架邊緣和海山區域。牠們通常在冷水和溫水區域出現，以不同深度的水域為家，是深海生態系統中的關鍵物種之一。",
          ],
        },
        {
          name: "藍鯨",
          image: require("../../public/all_images/animal/Blue whale.png"),
          depth: "0.1",
          category: "blueWhale",
          enName: "Blue whale",
          p: "地球上最大的動物，是一種著名的鯨類，以其巨大的體型和藍色外觀而著名。",
          features: [
            "— 外觀特徵 —",
            "擁有巨大的身體，通常呈深藍色或灰藍色，背部呈扁平形狀，頭部較大且有細長的嘴巴。牠們的體型長而流線型，背鰭小而三角形，尾鰭寬大且呈鐮刀狀。藍鯨是世界上最大的動物之一，壯觀的體型令人驚嘆。",
            "— 棲息地 —",
            "生活在全球各大洋的海域，常出現在開放水域和遠洋區域。牠們喜歡遷徙，通常在季節間移動。藍鯨主要以極小浮游生物為食，常在極地和熱帶水域覓食，並在深海區域繁衍。",
          ],
        },
        {
          name: "章魚",
          image: require("../../public/all_images/animal/cutefish.png"),
          depth: "0.1",
          category: "cutefish",
          enName: "Octopus",
          p: "智慧型軟體動物，具有多樣的品種，以其伸縮自如的觸手和變換色彩的能力而著名。",
          features: [
            "— 外觀特徵 —",
            "身體柔軟，多為圓筒狀，有8條伸縮自如的觸手，每條觸手上有吸盤，用於捕捉獵物和感知周圍環境。牠們的外觀多變，可以快速變換色彩和紋路，以融入或嚇阻敵人。",
            "— 棲息地 —",
            "生活在各種海洋環境中，包括珊瑚礁、海草床、岩石區域和沙泥底質。牠們常出現在不同深度的水域，適應性極強。章魚以其巧妙的狩獵技巧和智慧而著名，是海洋生態系統中的重要成員之一。",
          ],
        },
        {
          name: "白斑烏賊",
          image: require("../../public/all_images/animal/ETfish.png"),
          depth: "0.1",
          category: "ETfish",
          enName: "Broadclub cuttlefish",
          p: "一種中型頭足綱軟體動物，以其獨特的外觀特徵和捕食技巧而著名。",
          features: [
            "— 外觀特徵 —",
            "身體呈橢圓形，主要為白色或淡色，並擁有鮮豔的藍色或黑色斑紋，這些斑紋覆蓋其觸腕和身體的部分區域。牠們通常有八條觸手，兩條特別長，且在觸腕上有吸盤，用於捕捉獵物。",
            "— 棲息地 —",
            "主要分布在全球溫暖和亞熱帶的海域，通常出現在沿岸水域、珊瑚礁附近和大陸架上。牠們多生活在深度較淺的水域，但也能在深海中被發現。白斑烏賊是頭足綱動物中的一種，以其美麗的外觀和生態重要性而受到關注。",
          ],
        },
        {
          name: "圓鱗四鰭旗魚",
          image: require("../../public/all_images/animal/harinose.png"),
          depth: "0.1",
          category: "harinose",
          enName: "Slender spearfish",
          p: "一種大型的近海魚類，以其強壯的身體和四條鰭而著名。",
          features: [
            "— 外觀特徵 —",
            "擁有強健的身體，通常呈鮮豔的藍色或綠藍色，身體覆蓋著小而圓形的鱗片。牠們有四條明顯的背鰭，其中第一背鰭特別高大，形狀如旗幟，這是其名稱的由來。此外，圓鱗四鰭旗魚有長而尖銳的吻部。",
            "— 棲息地 —",
            "主要分布在全球的溫暖和亞熱帶海域，通常出現在沿岸和大陸架上的水域。牠們偏愛近海環境，但也在遠洋區域中繁衍和覓食。圓鱗四鰭旗魚是廣受漁業和遊釣愛好者追捕的物種，因其美味的肉質而受歡迎。",
          ],
        },
        {
          name: "大白鯊",
          image: require("../../public/all_images/animal/great white shark.png"),
          depth: "0.1",
          category: "greatwhiteshark",
          enName: "Great white shark",
          p: "世界上最大的鯊魚之一，以其強壯的身體和白色的下腹部而著名。",
          features: [
            "— 外觀特徵 —",
            "擁有強健的身體，背部呈深藍色至灰色，而腹部則呈明亮的白色，這種色彩分界鮮明的外觀是其名稱的由來。牠們有大而三角形的背鰭、肥厚的尾鰭和多列鋸齒狀的牙齒。大白鯊是頂級掠食者，身型威猛。",
            "— 棲息地 —",
            "廣泛分布於全球的海洋中，包括熱帶、亞熱帶和溫帶水域。牠們常出現在沿岸、深海和開放水域，偶爾會接近沙洲和礁石區。大白鯊是高度遷徙性的物種，以尋找食物和繁殖地，是海洋生態系統的重要一環。",
          ],
        },
        {
          name: "突角鼻魚",
          image: require("../../public/all_images/animal/longnose.png"),
          depth: "0.1",
          category: "longnose",
          enName: "Nosefish",
          p: "一種奇特的海洋魚類，以其獨特的長吻和突出的頭部而著名。",
          features: [
            "— 外觀特徵 —",
            "具有極長的尖吻，突出的頭部，以及大眼睛。牠們身體呈細長形狀，背部通常呈藍色或綠色，腹部為白色。突角鼻魚的吻部可達身體長度的數倍，用於捕捉獵物，是其特有的外觀特徵之一。",
            "— 棲息地 —",
            "主要分布於熱帶和亞熱帶的海域，包括珊瑚礁、礁石區域和潟湖等沿岸水域。牠們常出現在較淺的水域，但也可在深達數十米的深度被觀察到。突角鼻魚是熱帶海洋生態系統中的一部分，喜歡棲息在珊瑚和礁石的陰影處。",
          ],
        },
        {
          name: "魟魚",
          image: require("../../public/all_images/animal/smile.png"),
          depth: "0.1",
          category: "smile",
          enName: "Stingray",
          p: "扁平且呈圓形或菱形的海洋魚類，以其獨特的外形和游動方式而著名。",
          features: [
            "— 外觀特徵 —",
            "具有柔軟的軟骨結構，而非硬骨骼。牠們的眼睛和鰓位於身體的上部，下部平滑。尾巴長而細長。魟魚的皮膚光滑，背部呈褐色或灰色，腹部較淡。",
            "— 棲息地 —",
            "生活在全球的海洋中，多數分布在沿岸和大陸架水域。牠們常出現在溫暖至溫帶的海域，並在沙泥底質、珊瑚礁、草床和岩石區域中棲息。",
          ],
        },
        {
          name: "翻車魚",
          image: require("../../public/all_images/animal/moonfish.png"),
          depth: "0.1",
          category: "moonfish",
          enName: "Moonfish",
          p: "一種具有奇特生存策略的海洋魚類，以其能夠翻滾在海底行走的方式而著名。",
          features: [
            "— 外觀特徵 —",
            "有平扁的身體，呈圓形至橢圓形，通常以灰色或褐色為主色調，身上散佈著斑點或條紋。最獨特的特徵是其胸鰭，可以像手一樣變形，用於翻滾在海底，仿彿行走的動作。",
            "— 棲息地 —",
            "生活在熱帶和亞熱帶的海域，主要分布在沿岸水域、珊瑚礁、沙泥底質和岩石區域。牠們喜歡躲藏在海底的縫隙和洞穴中，並以其獨特的翻滾行為適應不同底質。翻車魚是海底生態系統中的有趣成員之一。",
          ],
        },
        {
          name: "抹香鯨",
          image: require("../../public/all_images/animal/sperm whale.png"),
          depth: "0.1",
          category: "spermwhale",
          enName: "Sperm whale",
          p: "一種大型鯨魚，以其巨大的體型和特殊的頭部結構而著名，能夠產生濃郁的香味。",
          features: [
            "— 外觀特徵 —",
            "具有龐大的身體，身長可達15至18米，身體呈深褐色或灰色，通常有許多白色斑點或斑紋。最特殊的特徵是其頭部結構，有一個巨大的下顎和長長的吻部，下顎上方的嘴巴被稱為“抹香腺”，能夠分泌一種濃郁的香氣物質。",
            "— 棲息地 —",
            "生活在全球熱帶和亞熱帶的海洋中，通常分布在沿岸和大陸架水域。牠們喜歡暖水，經常出現在熱帶海域、珊瑚礁附近和沿海區域。抹香鯨的生活習性和獨特的頭部結構使其成為海洋生態系統中的特殊一員。",
          ],
        },
        {
          name: "魟魚",
          image: require("../../public/all_images/animal/stingray.png"),
          depth: "0.1",
          category: "stingray",
          enName: "Stingray",
          p: "扁平且呈圓形或菱形的海洋魚類，以其獨特的外形和游動方式而著名。",
          features: [
            "— 外觀特徵 —",
            "有平扁的身體，呈圓形至橢圓形，通常以灰色或褐色為主色調，身上散佈著斑點或條紋。最獨特的特徵是其胸鰭，可以像手一樣變形，用於翻滾在海底，仿彿行走的動作。",
            "— 棲息地 —",
            "生活在熱帶和亞熱帶的海域，主要分布在沿岸水域、珊瑚礁、沙泥底質和岩石區域。牠們喜歡躲藏在海底的縫隙和洞穴中，並以其独特的翻滾行為適應不同底質。翻車魚是海底生態系統中的有趣成員之一。",
          ],
        },
        {
          name: "翻車魚",
          image: require("../../public/all_images/animal/Sunfish.png"),
          depth: "0.1",
          category: "sunfish",
          enName: "Sunfish",
          p: "一種具有奇特生存策略的海洋魚類，以其能夠翻滾在海底行走的方式而著名。",
          features: [
            "— 外觀特徵 —",
            "有平扁的身體，呈圓形至橢圓形，通常以灰色或褐色為主色調，身上散佈著斑點或條紋。最獨特的特徵是其胸鰭，可以像手一樣變形，用於翻滾在海底，仿彿行走的動作。",
            "— 棲息地 —",
            "生活在熱帶和亞熱帶的海域，主要分布在沿岸水域、珊瑚礁、沙泥底質和岩石區域。牠們喜歡躲藏在海底的縫隙和洞穴中，並以其独特的翻滾行為適應不同底質。翻車魚是海底生態系統中的有趣成員之一。",
          ],
        },
        {
          name: "星魚扁鯊",
          image: require("../../public/all_images/animal/toad.png"),
          depth: "0.1",
          category: "toad",
          enName: "Squatina squatina",
          p: "一種海洋魚類，以其扁平的身體和類似星星的斑點圖案而著名。",
          features: [
            "— 外觀特徵 —",
            "有扁平的身體，呈橢圓形，通常以褐色或灰色為主色調。最獨特的特徵是其背部散佈著星星般的斑點圖案，這些斑點呈現深色，形狀各異。牠們有兩個背鰭，呈現圓潤的外形，尾鰭則分叉。",
            "— 棲息地 —",
            "主要棲息在熱帶和亞熱帶的海洋水域，通常出現在珊瑚礁、沙泥底質和岩石區域。牠們偏愛較淺的水域，但也可在深達數十米的深度被發現。星魚扁鯊是珊瑚礁生態系統中的一部分，與多種海洋生物共生。",
          ],
        },
        {
          name: "燈籠魚",
          image: require("../../public/all_images/animal/monkfish.png"),
          depth: "0.1",
          category: "monkfish",
          enName: "Laternfishes",
          p: "一種深海魚類，以其發光的器官和奇特的外觀而著名。",
          features: [
            "— 外觀特徵 —",
            "具有透明的身體，身上散佈著發光的器官，讓牠們能在深海中發出微弱的光芒。牠們的眼睛小而黑，口部呈大而扁平的形狀。燈籠魚的體型多樣，有些種類身體呈圓柱形，而其他則呈橢圓形或扁平形。",
            "— 棲息地 —",
            "主要分布在深海的暗處，通常生活在深達數千米的水下世界。牠們在這種極端的環境中生存，依賴其發光的器官來吸引獵物或交流。燈籠魚是深海生態系統中獨特的成員，生活在世界各大洋的深處。",
          ],
        },
        {
          name: "角高體金眼鯛",
          image: require("../../public/all_images/animal/ohpsfish.png"),
          depth: "0.1",
          category: "ohpsfish",
          enName: "Anoplogaster cornuta",
          p: "一種熱帶海洋魚類，以其金色的眼睛和獨特的外觀而著名。",
          features: [
            "— 外觀特徵 —",
            "身體修長，擁有金色的眼睛，體色通常是深藍或綠色，背部呈深色，腹部則較淺。其名稱源自頭部上突起的角狀部分。尾鰭呈深色，有著獨特的線條和斑紋。",
            "— 棲息地 —",
            "主要分布在熱帶和亞熱帶海域，多數棲息在珊瑚礁、岩石區域和沿岸水域。牠們偏愛溫暖的水域，通常在深度達30米的區域出現。這種鯛魚種類經常成群活動，是珊瑚礁生態系統中的重要一環。",
          ],
        },
        {
          name: "侏儒燈籠魚",
          image: require("../../public/all_images/animal/flyfish.png"),
          depth: "0.1",
          category: "flyfish",
          enName: "Dwarf lantern fish",
          p: "一種深海生物，體型極小且發光，以其微弱的光芒和獨特的生態特徵而著名。",
          features: [
            "— 外觀特徵 —",
            "體型極小，通常只有幾厘米長，身體呈半透明或透明狀，具有發光的器官，這些器官散發微弱的藍色光芒。牠們的眼睛相對較大，幫助捕捉微小的獵物。這種微小魚類在深海中維持著神秘的生存方式。",
            "— 棲息地 —",
            "生活在深海的黑暗環境中，主要分布在深度超過1000米的水域。牠們通常在中層水域漂浮，以微生物和有機碎屑為食。由於牠們生活在極端的深度，因此很少被人們觀察到，是深海生態系統中的神秘居民。",
          ],
        },
      ],
    };
  },

  methods: {
    btnScroll(name) {
      if (name == "表層海洋帶") {
        // this.$router.push({ path: '/product', query: { article: 'footer' } });
        // this.$router.push({ path: "/explore", query: { article: "one" } });
        setTimeout(() => {
          // 获取滚动目标元素
          const target = document.getElementById("one");

          // 滚动到目标元素
          if (target) {
            target.scrollIntoView({ behavior: "smooth" });
          }
        }, 100);
      } else if (name == "中層海洋帶") {
        // this.$router.push({ path: "/explore", query: { article: "two" } });
        setTimeout(() => {
          // 获取滚动目标元素
          const target = document.getElementById("two");

          // 滚动到目标元素
          if (target) {
            target.scrollIntoView({ behavior: "smooth" });
          }
        }, 100);
      } else if (name == "深層海洋帶") {
        // this.$router.push({ path: "/explore", query: { article: "three" } });
        setTimeout(() => {
          // 获取滚动目标元素
          const target = document.getElementById("three");

          // 滚动到目标元素
          if (target) {
            target.scrollIntoView({ behavior: "smooth" });
          }
        }, 100);
      } else if (name == "深淵層海洋帶") {
        // this.$router.push({ path: "/explore", query: { article: "four" } });
        setTimeout(() => {
          // 获取滚动目标元素
          const target = document.getElementById("four");

          // 滚动到目标元素
          if (target) {
            target.scrollIntoView({ behavior: "smooth" });
          }
        }, 100);
      } else if (name == "超深淵層海洋帶") {
        // this.$router.push({ path: "/explore", query: { article: "five" } });
        setTimeout(() => {
          // 获取滚动目标元素
          const target = document.getElementById("five");

          // 滚动到目标元素
          if (target) {
            target.scrollIntoView({ behavior: "smooth" });
          }
        }, 100);
      }
    },
    showCard(animal) {
      this.selectedAnimal = animal;
    },
    closeCard() {
      this.selectedAnimal = null;
    },
    scrollShow(event) {
      if (window.scrollY < 500) {
        this.show = false;
      } else {
        this.show = true;
      }
    },
  },
  mounted() {
    this.animals.forEach((animal, index) => {
      const scene = document.getElementById(`scene${index}`);
      const parallaxInstance = new Parallax(scene, {
        clipRelativeInput: true,
        pointerEvents: true,
      });
    });

    window.addEventListener("scroll", this.scrollShow);
  },
  beforeDestroy() {
    window.removeEventListener("scroll", this.scrollShow);
  },
  components: {
    VueParallax,
    Parallax,
  },
};
</script>

<style lang="scss" scoped>
// 導覽頁 ------------------------------------------------------------
.navBar {
  position: fixed;
  top: 30%;
  right: 40px;
  text-align: right;
  z-index: 1;

  ul {
    position: relative;
  }

  li {
    padding: 10px 0px;

    a {
      color: map-get($colors, light);
      padding: 0 10px;
    }

    .drop {
      display: inline-block;
      width: 15px;
      height: 15px;
      border: 3px solid #0b2f4a;
      border-radius: 50%;
      background-color: #93b7cd;
      border-top-right-radius: 0;
      transform: rotate(-45deg);
      margin-bottom: -5px;
    }
  }

  ul::after {
    content: "";
    border: 1px solid #0b2f4a;
    position: absolute;
    height: 85%;
    top: 20px;
    right: 17px;
    z-index: -1;
  }
}

// 探索動物 ------------------------------------------------------------
.explore {
  width: 100%;
  height: 460em;
  background-image: linear-gradient(to bottom,
      #93b4cd,
      #114166,
      #0b2f4a,
      #082033);
  position: relative;
  // #285f9d

  h1 {
    font-size: 75px;
    color: map-get($colors, light);
    font-family: Helvetica, Arial, sans-serif, "Lucida Sans Regular", Geneva;
    font-weight: 800;
    color: transparent;
    -webkit-text-stroke: 3px #eee;
    position: relative;
  }

  h4 {
    font-size: map-get($fontSizes, h4);
    color: map-get($colors, light);
    letter-spacing: 2px;
  }

  // 內容 ------------------------------------------------------------
  .wapper {
    width: 100%;
    height: 100%;
    margin: auto;
    text-align: center;
    background-image: url(../../public/all_images/animal/sea4.png);
    background-repeat: no-repeat;
    background-size: 100%;
    background-position: top center;
    overflow: hidden;

    .slot {
      width: 100%;
      height: 100px;
      position: absolute;
      top: -100px;
    }

    .line {
      position: absolute;
      width: 100%;
    }

    .middle {
      top: 25%;
    }

    .deep {
      top: 50%;
    }

    .verydeep {
      top: 70%;
    }

    .supperdeep {
      top: 90%;
    }

    // 動物們 ------------------------------------------------------------
    .turtle {
      translate: 20vw 50%;
      width: 400px;
      cursor: pointer;

      img {
        visibility: top;
        width: 400px;
      }

      h4 {
        margin: 10px;
      }
    }

    .goldfish {
      translate: 60vw 30%;
      width: 170px;
      cursor: pointer;

      img {
        visibility: top;
        width: 100px;
      }

      h4 {
        margin-left: 30px;
        margin-top: 65px;
      }
    }

    .dory {
      cursor: pointer;
      translate: 70vw 10em;
      width: 150px;


      img {
        visibility: top;
        width: 130px;
        transform: rotate(10deg);
      }

      h4 {
        margin: 70px 0 0 60px;
      }
    }

    .nimo {
      cursor: pointer;
      translate: 62vw 10em;
      width: 100px;

      img {
        visibility: top;
        width: 80px;
      }

      h4 {
        margin: 50px 10px;
      }
    }

    .angryfish {
      cursor: pointer;
      translate: 27vw 15em;
      width: 100px;

      img {
        visibility: top;
        width: 100px;
      }

      h4 {
        margin: -30px 0;
      }
    }

    .blueyellow {
      cursor: pointer;
      translate: 50vw 20em;
      width: 130px;

      img {
        visibility: top;
        width: 100px;
      }

      h4 {
        margin: -30px 0;
      }
    }

    .whale {
      cursor: pointer;
      translate: 20vw 25em;
      width: 1200px;
      // margin: -50px 10px 0 auto;

      img {
        visibility: top;
        width: 1200px;
      }

      h4 {
        margin-top: 25px;
      }
    }

    .star {
      cursor: pointer;
      translate: 40em 20em;
      width: 130px;
      // margin: 30px 0 0 350px;

      img {
        visibility: top;
        width: 130px;
      }

      h4 {
        margin-top: -10px;
      }
    }

    .leofish {
      cursor: pointer;
      translate: 20vw 25em;
      width: 150px;
      // margin: 0 530px 0 auto;

      img {
        visibility: top;
        width: 130px;
      }

      h4 {
        margin-top: -35px;
        margin-left: 70px;
      }
    }

    .shark {
      cursor: pointer;
      translate: 10vw 30em;
      width: 450px;

      img {
        visibility: top;
        width: 450px;
      }

      h4 {
        margin-top: 10px;
        margin-left: 60px;
      }
    }

    .white {
      cursor: pointer;
      width: 500px;
      margin-left: auto;

      img {
        visibility: top;
        width: 500px;
      }
    }

    .linefish {
      cursor: pointer;
      translate: 8vw 5em;
      width: 150px;

      img {
        visibility: top;
        width: 100px;
      }

      h4 {
        margin-top: -25px;
        margin-left: 80px;
      }
    }

    .jokfish {
      cursor: pointer;
      translate: 65vw 3em;
      width: 130px;
      // margin: 0 550px 80px auto;

      img {
        visibility: top;
        width: 130px;
      }

      h4 {
        margin-top: -15px;
        margin-left: 90px;
      }
    }

    .manatee {
      cursor: pointer;
      translate: 35vw 3em;
      width: 450px;

      img {
        visibility: top;
        width: 450px;
      }

      h4 {
        margin-top: 150px;
        margin-left: 30px;
      }
    }

    .harinose {
      cursor: pointer;
      translate: 27vw -85em;
      width: 250px;

      img {
        visibility: top;
        width: 250px;
      }

      h4 {
        margin-left: 50px;
      }
    }

    .nosefish {
      cursor: pointer;
      translate: 55vw 0;
      width: 350px;

      img {
        visibility: top;
        width: 350px;
      }

      h4 {
        margin-top: -35px;
        margin-left: 70px;
      }
    }



    .jellyfish {
      cursor: pointer;
      width: 130px;
      translate: 45vw -20em;
      // border: 1px solid red;

      img {
        visibility: top;
        width: 130px;
      }

      h4 {
        margin-top: -35px;
        margin-left: 70px;
      }
    }

    .cutefish {
      cursor: pointer;
      translate: 10vw -45em;
      width: 220px;


      img {
        visibility: top;
        width: 220px;
      }

      h4 {
        margin-top: -35px;
        margin-left: 70px;
      }
    }

    .ETfish {
      cursor: pointer;
      translate: 75vw -60em;
      width: 200px;

      img {
        visibility: top;
        width: 200px;
      }

      h4 {
        margin-top: -35px;
        margin-left: 70px;
      }
    }

    .longnose {
      cursor: pointer;
      translate: 55vw -74em;
      width: 150px;

      img {
        visibility: top;
        width: 150px;
      }

      h4 {
        margin-left: 50px;
        margin-top: -10px;
      }
    }

    .greatwhiteshark {
      cursor: pointer;
      translate: 65vw -30em;
      width: 450px;

      img {
        visibility: top;
        width: 450px;
      }

      h4 {
        margin-top: 20px;
        margin-left: 70px;
      }
    }



    .taco {
      cursor: pointer;
      translate: 40vw 70em;
      width: 750px;
      // margin: 0 280px 0 auto;

      img {
        visibility: visible;
        width: 750px;
        transform: rotate(90deg);
      }

      h4 {
        margin-top: -35px;
        margin-left: 70px;
      }
    }



    .smile {
      cursor: pointer;
      translate: 2vw -38em;
      width: 500px;

      img {
        visibility: top;
        width: 500px;
      }

      h4 {
        margin-left: 150px;
        margin-top: -30px;
      }
    }

    .moonfish {
      cursor: pointer;
      translate: 27vw -25em;
      width: 220px;

      img {
        visibility: top;
        width: 215px;
      }

      h4 {
        margin-left: 150px;
        margin-top: -30px;
      }
    }

    .spermwhale {
      cursor: pointer;
      translate: 50vw -35em;
      width: 950px;

      img {
        visibility: top;
        width: 950px;
      }

      h4 {
        margin-left: 150px;
        margin-top: 40px;
      }
    }

    .stingray {
      cursor: pointer;
      translate: 5vw -40em;
      width: 500px;

      img {
        visibility: top;
        width: 500px;
      }

      h4 {
        margin-top: 305px;
        margin-left: 70px;
      }
    }

    .sunfish {
      cursor: pointer;
      translate: 60vw -50em;
      width: 200px;

      img {
        visibility: top;
        width: 200px;
      }

      h4 {
        margin-left: 20px;
        margin-top: -20px;
      }
    }

    .toad {
      cursor: pointer;
      translate: 40vw -35em;
      width: 200px;

      img {
        visibility: top;
        width: 200px;
      }

      h4 {
        margin-left: -30px;
        margin-top: -20px;
      }
    }

    .monkfish {
      cursor: pointer;
      translate: 34vw -2em;
      width: 200px;

      img {
        visibility: top;
        width: 200px;
      }

      h4 {
        // margin-top: 10px;
        margin-left: 20px;
      }
    }

    .flyfish {
      cursor: pointer;
      translate: 20vw -40em;
      width: 200px;

      img {
        visibility: top;
        width: 200px;
      }

      h4 {
        margin-top: 80px;
      }
    }

    .ohpsfish {
      cursor: pointer;
      translate: 65vw -40em;
      width: 230px;

      img {
        visibility: top;
        width: 130px;
      }

      h4 {
        margin-top: 95px;
        margin-left: 70px;
      }
    }

    .blueWhale {
      cursor: pointer;
      margin: 30px auto 60px 0;
      width: 900px;
      // translate: 10em 10em;

      img {
        visibility: top;
        width: 900px;
      }

      h4 {
        margin-top: -35px;
        margin-left: 70px;
      }
    }

    .ship {
      translate: 0% -50%;
      z-index: -2;

      img {
        vertical-align: top;
        width: 100%;
        z-index: -2;
      }
    }
  }

  // 彈窗 ---------------------------------------------
  .card {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(40, 61, 84, 0.4);
    backdrop-filter: blur(3px);
    border-radius: 20px;
    color: #eee;
    z-index: 10;

    .shadow {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: linear-gradient(45deg,
          rgba(234, 153, 153, 0.3),
          rgba(11, 47, 74, 0.3),
          rgba(255, 217, 102, 0.3));
      z-index: -1;
      /* 在蓋板下面 */
    }

    .card_content {
      width: 700px;
      margin: auto;
      background-color: rgba(40, 61, 84, 0.8);
      backdrop-filter: blur(3px);
      border-radius: 20px;
      color: #eee;
      position: fixed;
      top: 12%;
      left: 0;
      right: 0;

      .ani_img {
        width: 200px;
        margin: -50px auto 0 auto;

        img {
          width: 100%;
        }
      }

      .ani_name {
        width: 600px;
        margin: 10px auto;
        text-align: center;

        h4 {
          font-size: 20px;
          color: #eee;
          letter-spacing: 2px;

          span {
            padding-bottom: 3px;
            border-bottom: 3px solid #93b7cd;
          }
        }

        ul {
          margin: 0 20px 30px;
        }

        li {
          font-size: 17px;
          text-align: center;
          margin-bottom: 10px;
        }

        ul:nth-child(2n) li {
          text-align: left;
        }

        p {
          margin-top: 5px;
          color: #aaa;
          font-family: SofiaProMedium-Italic;
        }

      }

      .ani_info {
        width: 600px;
        margin: 20px auto;
        text-align: justify;
        font-size: map-get($fontSizes, "p");
      }

      p {
        text-align: center;
      }

      .ani_features {
        width: 600px;
        margin: 20px auto 50px auto;
        font-size: map-get($fontSizes, "p");

        ul li:nth-child(2n-1) {
          text-align: center;
          margin: 10px;
        }

        ul li:nth-child(2n) {
          text-align: justify;
        }
      }

      .close {
        width: 45px;
        height: 45px;
        background-color: #93b7cd;
        border-radius: 50%;
        text-align: center;
        margin-bottom: -50px;
        cursor: pointer;
        position: absolute;
        left: 325px;
        bottom: 30px;

        i {
          line-height: 45px;
          font-size: map-get($fontSizes, "h3");
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
  }

  @media screen and (max-width: 415px) {
    .wapper {


      // 動物們 ------------------------------------------------------------
      .turtle {
        translate: 20vw 5em;
        width: calc(400px/1.5);

        img {
          width: calc(400px/1.5);
        }

        h4 {
          margin: 170px 100px 0;
        }
      }

      .goldfish {
        translate: 25vw 2em;
        width: 140px;
        cursor: pointer;

        img {
          width: calc(170px/2);
        }

        h4 {
          margin-left: -20px;
          margin-top: 60px;
        }
      }

      .dory {
        translate: 60vw 10em;
        width: 80px;


        img {
          width: calc(130px/2);
          transform: rotate(10deg);
        }

        h4 {
          margin: 30px 0 0 -10px;
        }
      }

      .nimo {
        translate: 45vw 10em;
        width: 100px;

        img {
          width: calc(80px/2);
        }

        h4 {
          margin: 20px -15px;
        }
      }

      .angryfish {
        translate: 15vw 15em;
        width: 100px;

        img {
          width: calc(100px/2);
        }

        h4 {
          margin: 30px 5px;
        }
      }

      .blueyellow {
        display: none;
      }

      .whale {
        translate: 10vw 20em;
        width: 1200px;
        // margin: -50px 10px 0 auto;

        img {
          width: calc(1200px/2);
        }

        h4 {
          margin: 250px 150px;
        }
      }

      .star {
        translate: 40vw 20em;
        width: 130px;

        img {
          visibility: top;
          width: 130px;
        }

        h4 {
          margin-top: 100px;
        }
      }

      .leofish {
        translate: 20vw 25em;
        width: 150px;
        // margin: 0 530px 0 auto;

        img {
          visibility: top;
          width: 130px;
        }

        h4 {
          margin-top: 65px;
          margin-left: -10px;
        }
      }

      .shark {
        translate: -30vw 75em;
        width: 450px;

        img {
          visibility: top;
          width: 450px;
        }

        h4 {
          margin-top: 0px;
          margin-left: auto;
        }
      }

      .white {
        width: 500px;
        translate: 10vw 15em;
        margin-left: 0;

        img {
          visibility: top;
          width: 500px;
        }
      }

      .linefish {
        display: none;
      }

      .jokfish {
        translate: 65vw 13em;
        width: 130px;

        img {
          visibility: top;
          width: 130px;
        }

        h4 {
          margin-top: -15px;
          margin-left: 90px;
        }
      }

      .manatee {
        translate: 35vw 35em;
        width: 450px;

        img {
          visibility: top;
          width: 450px;
        }

        h4 {
          margin-top: 320px;
          margin-left: 80px;
        }
      }

      .harinose {
        translate: 10vw -90em;
        width: 250px;

        img {
          visibility: top;
          width: 250px;
        }

        h4 {
          margin-top: 85px;
          margin-left: 50px;
        }
      }

      .nosefish {
        translate: 55vw 15em;
        width: 350px;

        img {
          visibility: top;
          width: 350px;
        }

        h4 {
          margin-top: -35px;
          margin-left: 70px;
        }
      }



      .jellyfish {
        cursor: pointer;
        width: 130px;
        translate: 55vw -20em;
        // border: 1px solid red;

        img {
          visibility: top;
          width: 130px;
        }

        h4 {
          margin-top: 85px;
          margin-left: 40px;
        }
      }

      .cutefish {
        translate: 10vw -30em;
        width: 220px;


        img {
          visibility: top;
          width: 220px;
        }

        h4 {
          margin-top: 130px;
          margin-left: 70px;
        }
      }

      .ETfish {
        translate: 5vw -10em;
        width: 200px;

        img {
          width: 200px;
        }

        h4 {
          margin-top: 100px;
        }
      }

      .longnose {
        translate: 55vw -40em;
        width: 150px;

        img {
          width: 150px;
        }

        h4 {
          margin-top: 100px;
          margin-left: 50px;
        }
      }

      .greatwhiteshark {
        cursor: pointer;
        translate: 25vw 35em;
        width: 450px;

        img {
          visibility: top;
          width: 450px;
        }

        h4 {
          margin-top: 20px;
          margin-left: 70px;
        }
      }



      .taco {
        translate: -90vw 115em;
        width: 750px;

        img {
          visibility: visible;
          width: 750px;
        }

        h4 {
          margin-top: 80px;
          margin-left: 600px;
        }
      }



      .smile {
        cursor: pointer;
        translate: -40vw -20em;
        width: 500px;

        img {
          visibility: top;
          width: 500px;
        }

        h4 {
          margin-left: 200px;
          margin-top: -30px;
        }
      }

      .moonfish {
        cursor: pointer;
        translate: 15vw 20em;
        width: 220px;

        img {
          visibility: top;
          width: 215px;
        }

        h4 {
          margin-left: 0px;
          margin-top: 130px;
        }
      }

      .spermwhale {
        translate: 10vw 50em;
        width: 950px;

        img {
          visibility: top;
          width: 950px;
        }

        h4 {
          margin-left: 150px;
          margin-top: 300px;
        }
      }

      .stingray {
        cursor: pointer;
        translate: 10vw -20em;
        width: 500px;

        img {
          visibility: top;
          width: 500px;
        }

        h4 {
          margin-top: 350px;
          margin-left: 70px;
        }
      }

      .sunfish {
        cursor: pointer;
        translate: 60vw 25em;
        width: 200px;

        img {
          visibility: top;
          width: 200px;
        }

        h4 {
          margin-left: 20px;
          margin-top: -20px;
        }
      }

      .toad {
        cursor: pointer;
        translate: 10vw 30em;
        width: 200px;

        img {
          visibility: top;
          width: 200px;
        }

        h4 {
          margin-left: 30px;
          margin-top: 150px;
        }
      }

      .monkfish {
        cursor: pointer;
        translate: 10vw 60em;
        width: 200px;

        img {
          visibility: top;
          width: 200px;
        }

        h4 {
          margin-top: 200px;
          margin-left: 20px;
        }
      }

      .flyfish {
        cursor: pointer;
        translate: 20vw 25em;
        width: 200px;

        img {
          visibility: top;
          width: 200px;
        }

        h4 {
          margin-top: 80px;
        }
      }

      .ohpsfish {
        cursor: pointer;
        translate: 55vw 40em;
        width: 230px;

        img {
          visibility: top;
          width: 130px;
        }

        h4 {
          margin-top: 95px;
          margin-left: 10px;
        }
      }

      .blueWhale {
        cursor: pointer;
        margin: 0;
        width: 900px;
        translate: -100vw 30em;

        img {
          visibility: top;
          width: 900px;
        }

        h4 {
          margin-top: -35px;
          margin-left: 70px;
        }
      }

      .ship {
        translate: 0% 290%;
        z-index: -2;

        img {
          vertical-align: top;
          width: 100%;
          z-index: -2;
        }
      }
    }

    .card {
      .card_content {
        width: 90%;
        margin: auto;
        background-color: rgba(40, 61, 84, 0.8);
        backdrop-filter: blur(3px);
        border-radius: 20px;
        color: #eee;
        position: fixed;
        top: 12%;
        left: 0;
        right: 0;

        .ani_img {
          width: 200px;
        }

        .ani_name {
          width: 90%;
        }

        .ani_info {
          width: 90%;
        }

        .ani_features {
          width: 90%;
        }

        .close {
          left: 150px;
        }
      }
    }

    .navBar {
      right: 5px;
    }
  }


}
</style>
