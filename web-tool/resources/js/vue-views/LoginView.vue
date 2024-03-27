<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
  <div class="login-box">
    <h2>ログイン</h2>
    <form>
      <input type="text" name="username" placeholder="ユーザー名" />
      <input type="password" name="password" placeholder="パスワード" />
      <input type="button" value="ログイン" />
      <!--アカウント新規作成ページに飛ぶ-->
      <RouterLink to="/newAccount">
        <button class="signup-link">アカウント新規作成</button>
      </RouterLink>
    </form>
  </div>
</template>
  
<style scoped>
.login-box {
  width: 700px;
  margin: 300px auto;
  padding: 20px;
  background-color: #f2e6d9;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

.login-box h2 {
  text-align: center;
  margin-bottom: 20px;
}

.login-box input[type="text"],
.login-box input[type="password"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 2px solid #594736;
  border-radius: 5px;
  box-sizing: border-box;
  background-color: #e4d6c8;
}

.signup-link {
  text-align: center;
  width: 100%;
  padding: 10px;
  margin-top: 10px;
  border: none;
  background-color: #8b5a2b;
  color: #fff;
  border-radius: 5px;
  cursor: pointer;
}
.signup-link:hover {
  background-color: #54391e;
}
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
}
</style>
