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
  async mounted() {
    // ダッシュボードにリダイレクト
    this.$router.push('/dashboard');
  }
}
</script>