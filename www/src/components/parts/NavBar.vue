<template>
  <nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <a class="navbar-item has-text-info is-size-4" href="https://github.com/amenoyoya">
        <i class="fas fa-atom"></i> &nbsp; AM3:ware
      </a>
    </div>

    <!-- スマホ版 navbar-menu -->
    <a role="button" :class="'navbar-burger burger ' + burger" aria-label="menu" aria-expanded="false" data-target="default-navbar" @click.prevent="expandBurger">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
    
    <!-- PC版 navbar-menu -->
    <div id="default-navbar" :class="'navbar-menu ' + burger">
      <div class="navbar-start">
        <a class="navbar-item" href="/">
          <i class="fas fa-home"></i> &nbsp; Home
        </a>
      </div>

      <div class="navbar-end">
        <!-- ユーザー名｜ログアウト -->
        <div :class="'navbar-item has-dropdown ' + dropdown" v-if="$store.state.auth.username !== ''">
          <a class="navbar-link" @click.prevent="switchDropDown">
            <i class="fas fa-user"></i> &nbsp; {{ $store.state.auth.username }}
          </a>
          <div class="navbar-dropdown">
            <a class="navbar-item" @click.prevent="logout">Log out</a>
          </div>
        </div>
        <!-- サインイン｜ログイン -->
        <div class="navbar-item" v-else>
          <div class="buttons">
            <router-link to="/signup/" class="button is-danger">
              <strong>Sign up</strong>
            </router-link>
            <a class="button is-light" href="/login/">
              Log in
            </a>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      burger: '',
      dropdown: false,
    }
  },
  methods: {
    expandBurger() {
      if (this.burger === '') {
        this.burger = 'is-active';
      } else {
        this.burger = '';
      }
    },
    switchDropDown() {
      if (this.dropdown === '') {
        this.dropdown = 'is-active';
      } else {
        this.dropdown = '';
      }
    },
    async logout() {
      const res = await axios.post('/api/logout/', {csrf: document.getElementById('csrf').value});
      this.$store.commit('authenticate', res.data);
      this.$router.push('/login/'); 
    }
  }
};
</script>
