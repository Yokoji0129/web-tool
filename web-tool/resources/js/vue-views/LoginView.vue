<script setup>
import { RouterLink, useRouter } from "vue-router";
import axios from "axios";
import { ref, reactive } from "vue";

const data = reactive({
  id: "",
  password: "",
});

const error = ref("");
const loadingLogin = ref(false);

const idSearch = async () => {
  loadingLogin.value = true;
  try {
    const response = await axios.get(`/search/${data.id}`);
    return response.data;
  } catch (error) {
    console.log(error);
    return false;
  } finally {
    loadingLogin.value = false;
  }
};

//フォーム入力条件メソッド
const validateForm = async () => {
  const idResult = await idSearch();
  //ID, passwordのどれかが一つでも空欄だった場合
  if (!data.id.trim() || !data.password.trim()) {
    error.value = "※すべての項目を入力してください。";
    return false;
  }
  //IDが存在しない場合
  if (idResult) {
    error.value = "※このIDは存在しません";
    return false;
  }

  return true;
};

const router = useRouter();

const login = async () => {
  const isValid = await validateForm();
  if (!isValid) return;
  axios
    .post("/login", {
      id: data.id,
      password: data.password,
    })
    .then((response) => {
      console.log(response);
      router.push("/diaryBooksList");
    })
    .catch((error) => {
      console.log(error);
    });
};
</script>

<template>
  <div class="login-box">
    <h2>ログイン</h2>
    <form @submit.prevent="login">
      <input v-model="data.id" type="text" name="id" placeholder="ユーザーID" />
      <input
        v-model="data.password"
        type="password"
        name="password"
        placeholder="パスワード"
      />
      <p class="error-text">{{ error }}</p>
      <button type="submit" class="login-button">ログイン</button>
      <RouterLink to="/newAccount">
        <button class="signup-link">アカウント新規作成</button>
      </RouterLink>
    </form>
    <!-- ローディングアニメーション -->
    <div v-if="loadingLogin" class="loading-overlay">
      <div class="spinner"></div>
    </div>
  </div>
</template>
  
<style scoped>
.login-box {
  width: 35%;
  margin: 250px auto;
  padding: 20px;
  background-color: #f8f9fa;
  border: 2px solid #ccc;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
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
  border: 2px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
  background-color: #fff;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
}

.login-box input[type="text"]:hover,
.login-box input[type="password"]:hover {
  border-color: #007bff;
  box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
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

@media screen and (max-width: 1024px) {
  .login-box {
    width: 60%;
  }
}
/*ウィンドウ幅が750px以下の場合*/
@media screen and (max-width: 768px) {
  .login-box {
    width: 70%;
    margin: 250px auto;
  }
}

@media screen and (max-width: 450px) {
  .login-box {
    margin: 160px auto;
  }
}
</style>
