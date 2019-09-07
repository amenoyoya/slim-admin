import Vue from 'vue';
import Router from 'vue-router';
import Vuex from 'vuex';
import axios from 'axios';
import 'babel-polyfill'; // IE11 polyfill
import NavBar from './components/parts/NavBar';
import Home from './components/Home';
import Login from './components/Login';
import Signup from './components/Signup';
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
  mutations: {
    // ログイン状態をセット
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
      path: '/signup',
      name: 'signup',
      component: Signup
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: Dashboard,
      meta: {auth: true} // 認証必要
    },
  ]
});

// ログイン済みか確認
const authenticated = async (store) => {
  try {
    const res = await axios.post('/api/auth/', {
      csrf: document.getElementById('csrf').value, auth_token: store.state.auth.token
    });
    return res.data;
  } catch (err) {
    return {
      auth: false,
      status: err.response.status,
      message: err.response.statusText
    };
  }
};

// ログイン状態をsessionからセット
const authenticateFromSession = async store => {
  try {
    const res = await axios.post('/api/auth/session/', {csrf: document.getElementById('csrf').value});
    store.state.auth.token = res.data.token;
    store.state.auth.username = res.data.username;
  } catch (err) {
    store.state.auth.token = 'err';
    store.state.auth.username = '';
  }
};

// before route
router.beforeEach(async (to, from, next) => {
  if (to.matched.some(record => record.meta.auth)) {
    // auth_tokenがセットされてないならセッションからの認証を試行
    if (store.state.auth.token === '') {
      await authenticateFromSession(store);
    }
    // 管理画面ならルーティング前に認証処理
    const res = await authenticated(store);
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
