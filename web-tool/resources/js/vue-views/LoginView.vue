<script setup>
</script>

<template>
  <div class="login-box">
    <h2>ログイン</h2>
    <form action="process_login.php" method="post">
      <input type="text" name="username" placeholder="ユーザー名" />
      <input type="password" name="password" placeholder="パスワード" />
      <input type="button" value="ログイン" />
      <!--アカウント新規作成ページに飛ぶ-->
      <RouterLink to="/newAccount">
        <p class="signup-link">アカウント新規作成</p>
      </RouterLink>
    </form>
  </div>
</template>
  
<style scoped>
.login-box input[type="button"] {
  width: 100%;
  padding: 10px;
  border: none;
  background-color: #8b5a2b;
  color: #fff;
  border-radius: 5px;
  cursor: pointer;
}

.login-box input[type="button"]:hover {
  background-color: #54391e;
}
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
