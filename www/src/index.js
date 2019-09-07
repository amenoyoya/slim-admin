import Vue from 'vue';
import Router from 'vue-router';
import Vuex from 'vuex';
import axios from 'axios';
import 'babel-polyfill'; // IE11 polyfill
import NavBar from './components/parts/NavBar';
import Home from './components/Home';
import Login from './components/Login';
import Dashboard from './components/Dashboard';

Vue.use(Router);
Vue.use(Vuex);

// <nav-bar> コンポーネント追加
Vue.component('nav-bar', NavBar);

// store: グローバル状態管理
const store = new Vuex.Store({
  state: {
    // ログイン状態
    auth: {
      token: '',
      username: ''
    }
  },
  getters: {
    // ログイン済みか判定
    async authenticated(state) {
      try {
        const res = await axios.post('/api/auth/', {csrf: document.getElementById('csrf').value, auth_token: state.auth.token});
        return {
          auth: res.data.auth,
          message: res.data.message
        }
      } catch (error) {
        return {
          auth: false,
          status: error.response.status,
          message: error.response.statusText
        };
      }
    },
  },
  mutations: {
    authenticate(state, auth) {
      state.auth.token = auth.token;
      state.auth.username = auth.username;
    }
  }
});

// router
const router = new Router({
  mode: 'history',
  base: '/',
  routes: [
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: Dashboard,
      meta: {auth: true} // 認証必要
    },
  ]
});

// before route
router.beforeEach(async (to, from, next) => {
  if (to.matched.some(record => record.meta.auth)) {
    // 管理画面ならルーティング前に認証処理
    const res = await store.getters.authenticated;
    if (res.auth) {
      next();
    } else {
      next({ path: '/login', query: { redirect: to.fullPath }});
    }
  } else {
    next();
  }
});

new Vue({
  store,
  router,
  render: h => h(Home)
}).$mount('#app');
