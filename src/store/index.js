import { createStore } from "vuex";

const publicURL =
  process.env.NODE_ENV === "development"
    ? ""
    : "https://tibamef2e.com/chd103/g4/";

// const publicpath =
//   process.env.NODE_ENV === "development"
//     ? "http://localhost/musesmuseum/public/phps/"
//     : "https://tibamef2e.com/chd103/g1/phps/";

const publicpath =
  process.env.NODE_ENV === "development"
    ? "http://localhost:8080/dida_project/public/php/"
    : "https://tibamef2e.com/chd103/g4/php/";

// const imgpublicpath =
//   process.env.NODE_ENV === "development"
//     ? process.env.BASE_URL
//     : "https://tibamef2e.com/chd103/g1/";
// 中央狀態管理
export default createStore({
  // 類似vue檔裡面的data
  state: {
    chooseFrontBack: false, //記得改回來
    storeShowLogin: false,
    quizScore: 0,
    labaScore: 0,
    loginToogle: false,
    loading: false,
    loginURL: "https://tibamef2e.com/cgd103/g1/api",
    mem_account: "charmy101@gmail.com",
    mem_psw: "charmy101",
    userName: "",
    shoppingCart: [],  // 存儲購物車中的商品
    showCartPopup: false, // 控制购物车弹出窗口的显示状态
    chooseImgSrc: publicURL,
    favoList: [],
    ticketList: [],
    totalScorePoint: 0,
    prodOrderArr: [],
    memberBtn: "mem_account_settings",
    visitCount: 0,
    activeIndexes: [],
    questionPic: true,
    showLoadingOnce: true,
    APIurl: publicpath,
    checkLogin: false,
    memberEmail: "",
    memberId: "",
  },

  // 類似vue檔裡面的computed(把 state 處理過後再丟出去)
  getters: {
    remainingTodos: (state) => {
      return (state.totalScorePoint =
        state.quizScore + state.labaScore + state.totalScorePoint);
    },
    cartItemCount: (state) => state.shoppingCart.length,   // 返回購物車中的數量
  },
  mutations: {   // 用來更改state中的數據的方法
    setUserName(state, userName) {
      state.userName = userName;
    },
    removeFavoItem(state, idx) {
      // 通过索引删除 favoList 中的项
      state.favoList.splice(idx, 1);
    },
    // 拿api
    updateSiteLoad(state, val) {
      state.siteLoading = val;
    },
    toggleCartPopup(state) {
      // 切换购物车弹出视图的显示状态
      state.showCartPopup = !state.showCartPopup;
    },
    closeCartPopup() {
      // 延迟一秒后关闭购物车弹出视图
      setTimeout(() => {
        this.toggleCartPopup();
      }, 500); // 500毫秒（1秒）后关闭
    },
    addToCart(state, product) {   // state為目前狀態，product是要加入的商品
      state.shoppingCart.push(product);
    },
  },
  actions: {   // Actions 發出 commit 呼叫 Mutations
    addProductToCart({ commit }, product) {
      commit('addToCart', product);
    },
  },
  modules: {},
});
// 在 Vuex 裡面，儲存狀態的為 State，組件需要更動狀態時，需要透過 Actions 發出一個 Commit 去呼叫 Mutations，再由 Mutations 去更改 State。整個 Vuex 的方法也稱為 store。