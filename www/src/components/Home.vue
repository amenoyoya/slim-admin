<template>
  <div>
    <nav-bar></nav-bar>
    <section class="section">
      <router-view></router-view>
    </section>
  </div>
</template>

<script>
export default {
  mounted() {
    // ダッシュボードにリダイレクト
    this.$router.push('/dashboard');
  }
}
</script>