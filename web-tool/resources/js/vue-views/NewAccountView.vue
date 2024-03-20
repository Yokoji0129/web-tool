<template>
  <div class="login-box">
    <h2>アカウント新規作成</h2>
    <form action="process_login.php" method="post">
      <input type="text" placeholder="ID" />
      <input type="password" name="password" placeholder="パスワード" />
      <input type="password" name="password" placeholder="パスワード確認" />
      <RouterLink to="/accountName">
        <p class="signup-link">作成</p>
      </RouterLink>
    </form>
  </div>
</template>

<style scoped>
/*ウィンドウ幅が700px以下の場合*/
@media screen and (max-width: 700px) {
  .login-box {
    width: 300px;
    margin: 100px auto;
    margin-top: 200px;
  }
  .signup-link {
    width: 93%;
  }
}
</style>