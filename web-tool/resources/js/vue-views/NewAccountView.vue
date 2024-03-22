<script setup>
import { RouterLink } from "vue-router";
import axios from "axios";
import { ref } from "vue";

const id = ref("");
const password = ref("");
const confirmPassword = ref("");

//postでユーザーのIDやpasswordを送る
const submitForm = () => {
  axios
    .post("/post", {
      id: id.value,
      password: password.value,
      confirmPassword: confirmPassword.value,
    })
    .then((response) => {
      console.log("成功");
      //成功したときに名前作成ページに飛ぶようにやる予定
    })
    .catch((error) => {
      console.log("エラー");
    });
};
</script>

<template>
  <div class="create-account-box">
    <h2>アカウント新規作成</h2>
    <form @submit.prevent="submitForm">
      <input type="text" v-model="id" placeholder="ID" />
      <input type="password" v-model="password" placeholder="パスワード" />
      <input
        type="password"
        v-model="confirmPassword"
        placeholder="パスワード確認"
      />
      <button class="account-name-link" type="submit">作成</button>
    </form>
  </div>
</template>
<style scoped>
.create-account-box {
  width: 700px;
  margin: 300px auto;
  padding: 20px;
  background-color: #f2e6d9;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

.create-account-box h2 {
  text-align: center;
  margin-bottom: 20px;
}

.create-account-box input[type="text"],
.create-account-box input[type="password"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 2px solid #594736;
  border-radius: 5px;
  box-sizing: border-box;
  background-color: #e4d6c8;
}

.account-name-link {
  text-align: center;
  width: 100%;
  padding: 10px;
  border: none;
  background-color: #8b5a2b;
  color: #fff;
  border-radius: 5px;
  cursor: pointer;
}

.account-name-link:hover {
  background-color: #54391e;
}

/*ウィンドウ幅が700px以下の場合*/
@media screen and (max-width: 700px) {
  .create-account-box {
    width: 300px;
    margin: 100px auto;
    margin-top: 200px;
  }
  .signup-link {
    width: 93%;
  }
}
</style>