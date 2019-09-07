<template>
  <nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <a class="navbar-item has-text-info is-size-4" href="https://github.com/amenoyoya">
        <i class="fas fa-atom"></i> &nbsp; AM3:ware
      </a>
    </div>

    <div class="navbar-menu">
      <div class="navbar-start">
        <a class="navbar-item" href="/">
          <i class="fas fa-home"></i> &nbsp; Home
        </a>
      </div>

      <div class="navbar-end">
        <!-- ユーザー名｜ログアウト -->
        <div class="navbar-item has-dropdown is-hoverable" v-if="$store.state.auth.username !== ''">
          <a class="navbar-link">
            <i class="fas fa-user"></i> &nbsp; {{ $store.state.auth.username }}
          </a>
          <div class="navbar-dropdown">
            <a class="navbar-item" @click.prevent="logout">Log out</a>
          </div>
        </div>
        <!-- サインイン｜ログイン -->
        <div class="navbar-item" v-else>
          <div class="buttons">
            <a class="button is-danger" disabled="true">
              <strong>Sign up</strong>
            </a>
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
  methods: {
    async logout() {
      const res = await axios.post('/api/logout/', {csrf: document.getElementById('csrf').value});
      this.$store.commit('authenticate', res.data);
      this.$router.push('/login/'); 
    }
  }
};
</script>
