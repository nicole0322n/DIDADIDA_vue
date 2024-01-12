import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import product from "../views/product.vue";
import visual from "../components/visualGame.vue";
import helper from "../components/helper.vue";
const routes = [
  {
    path: "/backHome",
    name: "backHome",
    meta: {
      hideApp: true, // 需要隐藏App.vue中的组件
    },
    component: () =>
      import(
        /* webpackChunkName: "backHome" */ "../views/backEnd/backHome.vue"
      ),
    children: [
      {
        path: "/backHome/homePicMg",
        name: "homePicMg",
        component: () =>
          import(
            /* webpackChunkName: "homePicMg" */ "../views/backEnd/homePicMg.vue"
          ),
      },
      {
        path: "/backHome/gamesMg",
        name: "gamesMg",
        component: () =>
          import(
            /* webpackChunkName: "gamesMg" */ "../views/backEnd/gamesMg.vue"
          ),
      },
      {
        path: "/backHome/helperMg",
        name: "helperMg",
        component: () =>
          import(
            /* webpackChunkName: "helperMg" */ "../views/backEnd/helperMg.vue"
          ),
      },
      {
        path: "/backHome/memberMg",
        name: "memberMg",
        component: () =>
          import(
            /* webpackChunkName: "memberMg" */ "../views/backEnd/memberMg.vue"
          ),
      },
      {
        path: "/backHome/newsMg",
        name: "newsMg",
        component: () =>
          import(
            /* webpackChunkName: "newsMg" */ "../views/backEnd/newsMg.vue"
          ),
      },
      {
        path: "/backHome/orderMg",
        name: "orderMg",
        component: () =>
          import(
            /* webpackChunkName: "orderMg" */ "../views/backEnd/orderMg.vue"
          ),
      },
      {
        path: "/backHome/productMg",
        name: "productMg",
        component: () =>
          import(
            /* webpackChunkName: "productMg" */ "../views/backEnd/productMg.vue"
          ),
      },
      {
        path: "/backHome/ticketMg",
        name: "ticketMg",
        component: () =>
          import(
            /* webpackChunkName: "ticketMg" */ "../views/backEnd/ticketMg.vue"
          ),
      },
      {
        path: "/backHome/activeMg",
        name: "activeMg",
        component: () =>
          import(
            /* webpackChunkName: "activeMg" */ "../views/backEnd/activeMg.vue"
          ),
      },
      {
        path: "/backHome/authorityMg",
        name: "authorityMg",
        component: () =>
          import(
            /* webpackChunkName: "homePicMg" */ "../views/backEnd/authorityMg.vue"
          ),
      },
    ],
  },
  {
    path: "/",
    name: "home",
    component: HomeView,
    meta: {
      title: "DIDA DIDA",
      hideWave: true,
    },
  },
  {
    path: "/about",
    name: "about",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/AboutView.vue"),
    meta: {
      title: "AboutUs",
    },
  },
  {
    path: "/news",
    name: "news",
    component: () =>
      import(/* webpackChunkName: "news" */ "../views/NewsView.vue"),
    meta: {
      title: "News",
    },
  },
  {
    path: "/explore",
    name: "explore",
    component: () =>
      import(/* webpackChunkName: "explore" */ "../views/ExploreView.vue"),
    meta: {
      title: "Explore",
    },
  },
  {
    path: "/ticket",
    name: "ticket",
    component: () =>
      import(/* webpackChunkName: "ticket" */ "../views/TicketView.vue"),
    meta: {
      title: "Tickets",
    },
  },
  {
    path: "/faq",
    name: "faq",
    component: () =>
      import(/* webpackChunkName: "faq" */ "../views/FaqView.vue"),
    meta: {
      title: "Faqs",
    },
  },
  {
    path: "/guide",
    name: "guide",
    component: () =>
      import(/* webpackChunkName: "guide" */ "../views/GuideView.vue"),
    meta: {
      title: "Guide",
    },
  },
  {
    path: "/interact",
    name: "interact",
    component: () =>
      import(/* webpackChunkName: "interact" */ "../views/InteractView.vue"),
    meta: {
      title: "Interact",
    },
  },
  {
    path: "/path",
    name: "path",
    component: () => import(/*  */ "../views/Path.vue"),
    meta: {
      title: "Path",
    },
  },
  {
    path: "/member",
    name: "member",
    component: () =>
      import(/* webpackChunkName: "member" */ "../views/MemberView.vue"),
    meta: {
      title: "Member",
    },
  },
  {
    path: "/product",
    name: "product",
    component: product,
    meta: {
      title: "Products",
    },
  },
  {
    path: "/visual",
    name: "visual",
    component: visual,
  },
  {
    path: "/amountBtn",
    name: "amountBtn",
    component: () =>
      import(/* webpackChunkName: "amountBtn" */ "../components/amountBtn.vue"),
  },
  {
    path: "/replaytBtn",
    name: "replayBtn",
    component: () =>
      import(/* webpackChunkName: "replayBtn" */ "../components/replayBtn.vue"),
  },
  {
    path: "/login",
    name: "login",
    component: () =>
      import(/* webpackChunkName: "login" */ "../components/login.vue"),
  },
  {
    path: "/shoppingcart",
    name: "shoppingcart",
    component: () =>
      import(/* webpackChunkName: "member" */ "../views/ShoppingCart.vue"),
    meta: {
      title: "Cart",
      check: false,
    },
  },
  {
    path: "/cartpop",
    name: "cartpop",
    component: () =>
      import(/* webpackChunkName: "member" */ "../components/cartPopup.vue"),
  },
  {
    path: "/helper",
    name: "helper",
    component: helper,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});
router.beforeEach((to, from) => {
  if (to.meta && to.meta.title) {
    document.title = to.meta.title;
  }
});

// router.beforeEach(async (to, from) => {
//   if (to.meta && to.meta.title) {
//     document.title = to.meta.title;
//   }
//   if (to.path === "/shoppingcart") {
//     // 在这里进行用户是否已登录的验证
//     if (this.$store.state.checkLogin) {
//       alert("需先登入會員");
//       return false; // 取消路由导航，用户未登录时不允许进入购物车页面
//     }
//   }
//   return true; // 允许路由导航继续
// });

export default router;
