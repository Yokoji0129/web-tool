<script setup>
</script>

<template>
  <div class="login-box">
    <h2>Login</h2>
    <form action="process_login.php" method="post">
      <input type="text" name="username" placeholder="ユーザー名" />
      <input type="password" name="password" placeholder="パスワード" />
      <input type="button" value="ログイン" />
      <RouterLink to="/newAccount">
        <!--アカウント新規作成ページに飛ぶ-->
        <p class="signup-link">アカウント新規作成</p>
      </RouterLink>
    </form>
  </div>
</template>
  
<style scoped>
/*ログイン機能を囲う箱*/
.login-box {
  width: 700px;
  margin: 100px auto;
  margin-top: 300px;
  padding: 20px;
  background-color: #f2e6d9; /* 革の本をイメージした色 */
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* 影の追加 */
}

.login-box h2 {
  text-align: center;
  margin-bottom: 20px;
}

/*ユーザー名とパスワードデザイン*/
.login-box input[type="text"],
.login-box input[type="password"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 2px solid #594736; /* 革の本の枠線の色 */
  border-radius: 5px;
  box-sizing: border-box;
  background-color: #e4d6c8; /* 革の本のページの色 */
}

/*ログインボタンデザイン*/
.login-box input[type="button"] {
  width: 100%;
  padding: 10px;
  border: none;
  background-color: #8b5a2b; /* 革の本のボタンの色 */
  color: #fff;
  border-radius: 5px;
  cursor: pointer;
}

.login-box input[type="button"]:hover {
  background-color: #54391e; /* ホバー時の色変更 */
}

/*アカウント新規作成ボタンデザイン*/
.signup-link {
  margin-bottom: 0;
  text-align: center;
  color: black;
  cursor: pointer;
}

.signup-link:hover {
  text-decoration: underline;
}

a {
  text-decoration: none;
}

/*ウィンドウ幅が700px以下の場合*/
@media screen and (max-width: 700px) {
  .login-box {
    width: 300px;
    margin: 100px auto;
    margin-top: 200px;
  }
}
</style>
