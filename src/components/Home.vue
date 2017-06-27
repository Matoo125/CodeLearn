<template>
  <div>
    <section class="hero is-fullheight is-primary">
      <div class="hero-body">
        <div class="container">
          <h1 class="title">
            Welcome to Codelearn
          </h1>
          <h2 class="subtitle">
            Learn to for free.
          </h2>
        </div>
      </div>

      <div class="hero-foot">
        <tabs>
          <tab-item label="Login">
            <p class="control has-icon">
              <input class="input" type="email" placeholder="Email">
              <i class="fa fa-envelope"></i>
            </p>
            <p class="control has-icon">
              <input class="input" type="password" placeholder="Password">
              <i class="fa fa-lock"></i>
            </p>
            <p class="control">
              <button class="button is-success">
                Login
              </button>
            </p>
          </tab-item>
          <tab-item label="Register">Music Tab</tab-item>
        </tabs>
      </div>

    </section>


  </div>
</template>

<script>
export default {
  name: 'Home'
}
</script>

<style>
</style>

<style scoped>

</style>
