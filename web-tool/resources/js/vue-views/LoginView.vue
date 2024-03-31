<template>
  <div class="login-box">
    <h2>ログイン</h2>
    <form>
      <input type="text" name="username" placeholder="ユーザー名" />
      <input type="password" name="password" placeholder="パスワード" />
      <button class="login-button">ログイン</button>
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
  margin: 200px auto;
  padding: 20px;
  background-color: #f8f9fa;
  border: 1px solid #ccc;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.login-box h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}

.login-box input[type="text"],
.login-box input[type="password"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
  background-color: #fff;
}

.login-box button {
  width: 100%;
  padding: 10px;
  border: none;
  background-color: #007bff;
  color: #fff;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.login-box button:hover {
  background-color: #0056b3;
}

.signup-link {
  margin-top: 10px;
}

/*ウィンドウ幅が750px以下の場合*/
@media screen and (max-width: 700px) {
  .login-box {
    width: 300px;
    margin: 100px auto;
    margin-top: 100px;
  }
}
</style>
