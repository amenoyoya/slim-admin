<template>
  <nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <a class="navbar-item has-text-info is-size-4" href="https://github.com/amenoyoya">
        <i class="fas fa-atom"></i> AM3:ware
      </a>
    </div>

    <div class="navbar-menu">
      <div class="navbar-start">
        <a class="navbar-item" @click.prevent="toHome">
          <i class="fas fa-home"></i> Home
        </a>
      </div>

      <div class="navbar-end">
        <div class="navbar-item">
          <div class="buttons">
            <a class="button is-danger">
              <strong>Sign up</strong>
            </a>
            <a class="button is-light">
              Log in
            </a>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  methods: {
    toHome() {
      self.$route.push('/');
    }
  }
};
</script>
