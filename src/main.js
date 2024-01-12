import { createApp } from "vue";
import ViewUIPlus from "view-ui-plus";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import "view-ui-plus/dist/styles/viewuiplus.css";
import { createI18n } from "vue-i18n";
import VCalendar from "v-calendar";
import "v-calendar/style.css";
// import Parallax from 'parallax-js';
import VueParallax from "vue-parallax";


const i18n = createI18n({
  locale: 'zh-TW', // 默認語言
  fallbackLocale: 'zh-TW', // 找不到 messages 的翻譯，就使用設定的語言
  messages: {
    en: {
      // 對應中文: '英文翻譯',
      // header & footer --------------------------
      關於DIDA: 'About DIDA',
      關於我們: 'About Us',
      最新消息: 'News',
      探索海洋生物: ' Explore Marine Creatures ',
      DIDA商城: 'DIDA Mall',
      社群媒體: 'Social Media',
      常見問答: 'FAQs',
      園區導覽: 'Park Quide',
      互動遊戲: 'Interactive Game',
      最新活動: 'Latest Campaign',
      表演資訊: 'Performance Information',
      優惠消息: 'Discount Updates',
      表層海洋帶: 'Epipelagic Zone',
      中層海洋帶: 'Mesopelagic Zone',
      深層海洋帶: 'Bathypelagic Zone',
      深淵層海洋帶: 'Abyssopelagic Zone',
      超深淵層海洋帶: 'Hadopelagic Zone',
      DIDA購物: 'Shopping',
      DIDA購票: 'Ticketing',
      登出: 'Log out',
      '本網站為緯育TibaMe_前端設計工程師班CHD103學員專題成果作品,本平台僅供學習、展示之用。若有抵觸有關著作權, 或有第三人主張侵害智慧財產權等情事, 均由學員負法律上責任, 緯育公司概不負責。若有侵權疑慮, 您可以私訊[緯育TibaMe], 後續會由專人協助處理。': 'ok',
      // index -------------------------------------
      DIDADIDA海洋館: 'DIDADIDA AQUARIUM',
      營業時間: 'Opening Hours',
      最後入場: 'Last Tours',
      今日入園人數: 'VISITORS OF THE DAY',
      人: 'ppl',
      // Ticket ------------------------------------
      票價資訊: 'TICKET INFORMATION',
      票種: 'Ticket Types',
      成人票: 'Adult Ticket',
      學生票: 'Student Ticket',
      兒童票: 'Children Ticket',
      愛心票: 'Accessible Ticket',
      團體票: 'Group Ticket',
      "未滿4歲且有家長陪同的幼童可免費入場": "Children under 4 years old accompanied by parents can enter for free.",
      價格: 'Price',
      適用對象: 'Eligible Individuals',
      '限18歲(含)以上成人使用': 'Restricted to adults aged 18 years and above (inclusive).',
      '限12歲(含)以上持學生證之學生適用': 'Only available to students aged 12 or above (inclusive) with a student ID card.',
      '限4歲(含)以上及未滿12歲兒童適用': 'Restricted to children aged 4 years and above and under 12 years old.',
      '限持有身心障礙證明者、身心障礙者的1位陪同者、孕婦、滿65歲以上長者適用': 'Applicable only to people with a disability certificate, one person accompanying the person with a disability, pregnant women, and seniors over 65 years old.',
      '15人以上適用': 'Applicable to more than 15 people.',

      選擇日期與票數: 'Select Date & Quantity',
      選擇數量: 'Select Quantity',
      全部重選: 'Reselect All',
      成人: 'Adult',
      兒童: 'Children',
      學生: 'Student',
      長者: 'Elder',
      '(18~64歲)': '(18~64 years old)',
      '(4~11歲)': '(4~11 years old)',
      '(12歲以上(含)持學生證者)': '(Those 12 years old and above(inclusive) holding student ID card)',
      '(65歲以上(含))': '(65 years and above (inclusive))',
      每人: 'per',
      總金額: 'Total',
      立即購票: 'Book Now',
      更多商品: 'Shop Now',
      購票須知: 'Ticket Purchase Instructions',
      '未滿 4 歲的兒童可免費入場，需有家長陪同入場。': 'Children under 4 years old are admitted free and must be accompanied by a parent.',
      '下訂時請以「票券使用日」為主，下訂後即無法變更，敬請留意。': 'Please note that the "ticket expiration date" is the main one when placing an order. It cannot be changed after the order is placed.',
      '訂單一次最高訂購上限為 6 張，每日場次數量為限量販售，售完為止。': 'The maximum order limit for one order is 6, and the number of daily sessions is limited and sold while stocks last.',
      '訂單恕不接受部分變更，若需變更入場日及場次請整筆重新下訂。': 'Partial changes to orders will not be accepted. If you need to change the entry date and venue, please place a new order in full.',
      '長者票（博愛票）適用對象：限持有身心障礙證明者、身心障礙者的1位陪同者、孕婦、滿65歲以上長者適用。': `Applicable objects for senior citizens' tickets(fraternity tickets): Only those with a disability certificate, one companion of a person with a disability, pregnant women, and seniors over 65 years old.`,
      '本館禁止攜帶外食、寵物，可攜帶開水。': 'No outside food or pets are allowed in the hotel, but boiled water is allowed.',
      '館內提供嬰兒車租借，未提供輪椅租借，敬請旅客見諒。': 'Strollers are available for rent in the museum, but wheelchairs are not available for rent. Please forgive me.',
      '請務必於訂購時確認訂購之票種是否正確，資格是否符合。': 'Please be sure to confirm whether the ticket type you ordered is correct and whether you meet the qualifications when ordering.',
      '此商品恕無法使用任何折扣券，敬請見諒。': 'Please understand that no discount coupons can be used on this product.',
      '購票時請主動出示相關證件供售票處工作人員驗證，相關證件說明如下：': 'When purchasing tickets, please take the initiative to present relevant documents for verification by the ticket office staff. The relevant documents are explained as follows:',
      ' 1. 學生票：本人有效學生證正本(若為應屆畢業生則提供當年度正式入學通知單或註冊單及攜帶身分證)。': '1. Student ticket: The original of my valid student ID card (if you are a fresh graduate, please provide the official admission notice or registration form of the current year and bring your ID card).',
      ' 2. 兒童票、長者票(博愛票)：身心障礙證明、孕婦健康手冊、國民身分證或政府核發附有照片、身分證字號及出生年、月、日等足以證明身分證件。': '2. Child tickets and elderly tickets (fraternity tickets): certificate of physical and mental disabilities, maternal health handbook, national identity card or government-issued document with photo, ID card number and year, month, and day of birth that are sufficient to prove identity.',
      // 購物車跳窗------------------------------------------------
      //
      交通指南: 'TRAFFIC GUIDE',
      地址: 'Address',
      海洋市深海區珊瑚一街404號: '404 Coral Street, Deep Sea District, Ocean City."',
      交通: 'Driving Directions',
      自行開車: 'Self-driving',
      '請於國道10號，海洋交流道下，左轉直行珊瑚一街': 'Take National Highway 10 and exit at the Marine Interchange. Turn left and continue on Coral Street.',
      搭乘公車: 'Taking the Bus',
      '請於海洋市區，搭乘海洋路線777公車': "Please take the Marine Route 777 bus in the Marine city area.",
      搭乘捷運: 'Taking the Metro',
      '請搭乘海洋線，於滴答滴答站下車，2號出口': "Please take the Marine Line and get off at Tick-Tock Station, Exit 2.",
      //
      熱賣商品: 'BESTSELLERS',
      //
      活動倒數: 'EVENT COUNTDOWN',

      // 購物車跳窗------------------------------------------------
      已加入購物車: 'Your cart has got some goodies!',
      //頁面大標題-------------------------------------------------
      關於我們: 'About DIDADIDA',
      與海洋世界的美好相遇: 'Encountering the Beauty of the Marine World',
      '我們是一個致力於讓人們更深入了解海洋的環境與生態的地方。秉持著經營公共事業的嚴謹服務精神，以海洋為核心主題，融合休閒、娛樂、養生、教育、環保和文化等多元特質，成為頂級國際休閒勝地。': "We are a place dedicated to deepening people's understanding of the marine environment and ecology. With a commitment to the rigorous service of public affairs, we center our activities around the theme of the ocean, integrating diverse qualities such as leisure, entertainment, well-being, education, environmental protection, and culture. This has made us a top-tier international leisure destination.",
      跨域合作的研究活動: 'Research Activities in Cross-Domain Collaboration',
      '在這裡可以近距離觀察到令人驚嘆的海洋生物，探索海洋的奧秘。只有真正了解海洋的價值和重要性，才能夠更好的保護它。因此我們通過生動的展覽、互動體驗和教育活動，將海洋科學帶入您的生活中。您可以在這裡探索各種海洋生物、觸摸海洋的心跳，並參與各種互動體驗。': "Here, you can observe awe-inspiring marine life up close and explore the mysteries of the ocean. Only by truly understanding the value and importance of the ocean can we better protect it. Therefore, through vivid exhibitions, interactive experiences, and educational activities, we bring marine science into your life. Here, you can explore various marine species, feel the heartbeat of the ocean, and participate in various interactive experiences.",
      參與海洋保育計畫: 'Participating in Marine Conservation Programs',
      '我們的目標不僅僅是提供娛樂，更是啟發人們保護我們的藍色星球，與環保組織合作，參與海洋保育計畫，並持續努力減少我們的環境足跡。希望通過我們的努力，能夠促進人們對海洋保護的關注，並鼓勵大家共同努力，為地球的未來做出貢獻。': "Our goal is not only to provide entertainment but also to inspire people to protect our blue planet. We collaborate with environmental organizations, participate in marine conservation programs, and continuously work to reduce our environmental footprint. We hope that through our efforts, we can raise awareness about marine conservation and encourage everyone to work together to make a contribution to the future of our planet.",
      '本網站為緯育TibaMe_前端設計工程師班CHD103學員專題成果作品,本平台僅供學習、展示之用。若有抵觸有關著作權, 或有第三人主張侵害智慧財產權等情事, 均由學員負法律上責任, 緯育公司概不負責。若有侵權疑慮, 您可以私訊': "This website is the project work of CHD103 students in the Front-End Design Engineering program at TibaMe. This platform is intended for learning and showcasing purposes. If there are any copyright conflicts or claims of intellectual property infringement by third parties, the legal responsibility lies with the students, and TibaMe is not responsible for such matters. If you have any concerns regarding infringement, you can send a private message to ",
      '[緯育]': '[TibaMe]',
      ', 後續會由專人協助處理。': ", and they will assist with the resolution.",

      //FAQs頁面
      營業相關: "BUSINESS HOURS",
      "營業時間為上午9:00至下午17:00，最後入場時間為下午16:00。國定假日及颱風天休館。": "Our openning hours are from 9:00 AM to 5:00 PM, with the last entry allowed until 4:00 PM. We are closed on national holidays and during typhoon conditions.",
      購票資訊: "TICKETING DETAILS",
      "Q:門票價錢?": "Q: Ticket Prices?",
      "A:一般門票價格：": "A: Regular ticket prices:",
      "成人：$500": "Adults: $500",
      "兒童(4-11歲):$250": "Children (4-11 years old): $250",
      "學生（需出示有效學生證):$400": "Students (with valid student ID): $400",
      "長者(65歲以上):$250": "Seniors (65 and older): $250",
      "Q:購票方式?": "Q: How to Purchase Tickets?",
      "1.網上預訂： 在我們的官方網站上預訂門票，可享受5%的網上預訂折扣。": "1.Online Booking: Reserve your tickets on our official website and enjoy a 5% online booking discount.",
      "2.現場購票： 您也可以在水族館入口處現場購買門票。": "2.On-Site Purchase: You can also buy tickets at the aquarium's entrance.",
      "3.團體訪問：如果您是一個大型團體（例如學校、公司或旅行團），我們提供特別優惠和團體行程安排。請提前與我們的團體訪問部門聯繫，以獲取更多信息和價格。": "3.Group Visits: If you're part of a large group (such as a school, company, or tour group), we offer special discounts and group itinerary arrangements. Please contact our group visit department in advance for more information and pricing.",
      "": "",
      "": "",
      "": "",
      "": "",

      //拉霸頁面
      問卷: 'QUIZ',
      拉霸: 'SLOT',
      試手氣: 'Try Your Luck',
      再玩一次: "REPLAY",
      完成問卷: "SUBMIT",
      "恭喜完成問卷!": "Comgrats!You've complete the quiz!",

      //園區
      園區地圖: 'PARK MAP',
      點我翻頁: 'Click to turn page',
      // Gallery
      淺層館: 'Shallow',
      中層館: 'Intermediate',
      深層館: 'Deep',
      "海洋表層區是指地球上的海洋中的最上層部分，通常指的是水面以下的相對較薄的水層，它包括了海洋中最頂部的數百米到一千米的水深範圍。這個區域在海洋學和生態學中非常重要，因為它直接受到陽光照射、風浪、潮汐和季節變化的影響，同時也是眾多海洋生物的居住地。": "The Ocean Surface Zone refers to the uppermost layer of the Earth's oceans, typically denoting the relatively thinner layer of water beneath the surface. It encompasses the top several hundred meters to around a thousand meters of water depth in the ocean. This zone is of great importance in oceanography and ecology because it is directly affected by sunlight, wind, waves, tides, and seasonal changes, and it serves as a habitat for numerous marine organisms.",
      //生物
      海星: 'Seastar',

      //探索
      黃高鰭刺尾魚: 'Yellow tang',
      玳瑁: 'Hawksbill Turtle',
      擬刺尾鯛: 'Palette surgeonfish',
      小丑魚: 'Clownfish',
      河豚: 'Pufferfish',
      黃顱刺蓋魚: 'Blue face angelfish',
      鯨鯊: 'Whale shark',
      海星: 'Sea star',
      獅子魚: 'Lionfish',
      鑽嘴魚: 'Slender whipfin mojarra',
      鯊魚: 'Shark',
      白鯨: 'Beluga whale',
      水母: 'Jellyfish',
      鋸鯊: 'Japanese sawshark',
      儒艮: 'Manatee',
      大王烏賊: 'Taco',
      藍鯨: 'Blue whale',
      章魚: 'Octopus',
      白斑烏賊: 'Broadclub cuttlefish',
      圓鱗四鰭旗魚: 'Slender spearfish',
      大白鯊: 'Great white shark',
      突角鼻魚: 'Nosefish',
      魟魚: 'Stingray',
      翻車魚: 'Moonfish',
      抹香鯨: 'Sperm whale',
      魟魚: 'Stingray',
      翻車魚: 'Sunfish',
      星魚扁鯊: 'Squatina squatina',
      燈籠魚: 'Laternfishes',
      角高體金眼鯛: 'Anoplogaster cornuta',
      侏儒燈籠魚: 'Dwarf lantern fish',

      //會員
      "，您好！": ',Hello!',
      "尚有紅利點數 :": "Reward Bonus :",
      點: 'points',
      已驗證: 'verified',
      會員帳號設定: 'Account Settings',

    },
  },
},
)
const vueApp = createApp(App);
vueApp.use(store);
vueApp.use(router);
vueApp.use(ViewUIPlus); // 套件也要宣告
vueApp.use(i18n); // 語言切換
vueApp.use(VCalendar, {});
// vueApp.use(Parallax);
vueApp.use(VueParallax);
vueApp.mount("#app");

router.beforeEach((to, from, next) => {
  // 每次路由切換時，將頁面滾動到頂部
  window.scrollTo(0, 0);
  next();
});
