<script setup>
import { RouterLink, useRouter } from "vue-router";
import axios from "axios";
import { ref, reactive } from "vue";

//フォーム入力のデータリアクティブ
const data = reactive({
  id: "",
  password: "",
  confirmPassword: "",
  accountName: "",
});
const error = ref(""); //フォーム入力エラー文字入れ
const loadingLogin = ref(false);
const id = ref(""); //ユーザーidが存在するかの情報が入る

//IDが存在するか検索するためのメソッド
const idSearch = async () => {
  //tryは非同期処理が成功するか失敗するかに関係なく実行される。
  loadingLogin.value = true;
  try {
    const response = await axios.get(`/search/${data.id}`);
    id.value = response.data;
    return response.data;
  } catch (error) {
    console.log(error);
    return false;
  } finally {
    loadingLogin.value = false;
  }
};

//ID,パスワードの長さが8文字未満、または33文字以上の場合(英数字含む)の正規表現
const Alphanumeric = /^(?=.*[0-9])(?=.*[a-zA-Z])[0-9a-zA-Z]{8,32}$/;

//フォーム入力条件メソッド
const validateForm = async () => {
  //idResultにIDが存在するかしないかのtrue or falseが格納される
  //awaitでidSearchの非同期処理が終わるまでそれ以降の処理を待つ
  const idResult = await idSearch();

  //ID,passwordのどれかが一つでも空欄だった場合
  if (
    !data.id.trim() ||
    !data.password.trim() ||
    !data.confirmPassword.trim()
  ) {
    error.value = "※すべての項目を入力してください。";
    return false;
  }
  //IDが英数字8文字以上32文字以下で入力されなかった場合
  if (!Alphanumeric.test(data.id)) {
    error.value = "※IDは英数字を含み、8文字以上32文字以下で入力してください。";
    return false;
  }
  //passwordが英数字8文字以上32文字以下で入力されなかった場合
  if (!Alphanumeric.test(data.password)) {
    error.value =
      "※パスワードは英数字を含み、8文字以上32文字以下で入力してください。";
    return false;
  }
  //確認用とパスワードが違った場合
  if (data.password !== data.confirmPassword) {
    error.value = "※パスワードが一致しません。";
    return false;
  }
  //IDが存在した場合(falseの時)
  if (!idResult) {
    error.value = "※このIDは既に存在しています。";
    return false;
  }

  return true;
};

const router = useRouter(); //特定の処理後にページ遷移させるための変数
const loginBack = () => {
  router.push("/");
};

//フォーム送信メソッド
const submitForm = async () => {
  //awaitでvalidateの処理が終わるまで待つ
  const isValid = await validateForm();
  //falseだったら非同期処理がされないで処理が止まる
  if (!isValid) return;

  axios
    .post("/post", {
      id: data.id,
      password: data.password,
      confirmPassword: data.confirmPassword,
      accountName: data.accountName,
    })
    .then((response) => {
      console.log(response);
      //フォーム送信成功時ログインページ遷移する
      router.push("/");
    })
    .catch((error) => {
      console.log(error);
    });
};
</script>


<template>
  <div class="create-account-box">
    <p class="login-back" @click="loginBack">ログイン画面に戻る</p>
    <h2>アカウント新規作成</h2>
    <form @submit.prevent="submitForm">
      <input type="text" v-model="data.id" placeholder="ユーザーID" />
      <!--IDの条件満たしてる時と満たしてないときのデザイン-->
      <p class="no-id">□</p>
      <p
        class="bad-id"
        v-if="data.id.length >= 1"
        :class="{
          cross: !Alphanumeric.test(data.id),
          check: Alphanumeric.test(data.id),
        }"
      ></p>

      <input type="password" v-model="data.password" placeholder="パスワード" />
      <!--パスワードの条件満たしてる時と満たしてないときのデザイン-->
      <p class="no-password">□</p>
      <p
        class="bad-password"
        v-if="data.password.length >= 1"
        :class="{
          cross: !Alphanumeric.test(data.password),
          check: Alphanumeric.test(data.password),
        }"
      ></p>
      <input
        type="password"
        v-model="data.confirmPassword"
        placeholder="パスワード確認"
      />
      <input
        type="text"
        v-model="data.accountName"
        placeholder="アカウント名"
      />
      <!--エラーの際テキスト表示-->
      <p class="error-text">{{ error }}</p>
      <button class="account-name-link" type="submit">作成</button>
    </form>
  </div>
  <!-- ローディングアニメーション -->
  <div v-if="loadingLogin" class="loading-overlay">
    <div class="spinner"></div>
  </div>
</template>

<style scoped>
.create-account-box {
  width: 35%;
  margin: 250px auto;
  padding: 20px;
  background-color: #f8f9fa;
  border: 2px solid #ccc;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  position: relative;
}

.create-account-box h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}

.login-back {
  cursor: pointer;
  margin: 0;
  color: #333;
}
.login-back:hover {
  color: #007bff;
}

.create-account-box input[type="text"],
.create-account-box input[type="password"] {
  width: 95%;
  padding: 10px;
  margin-bottom: 15px;
  border: 2px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
  background-color: #fff;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
}

.create-account-box input[type="text"]:hover,
.create-account-box input[type="password"]:hover {
  border-color: #007bff;
  box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
}

.account-name-link {
  text-align: center;
  width: 100%;
  padding: 10px;
  border: none;
  background-color: #007bff;
  color: #fff;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.account-name-link:hover {
  background-color: #0056b3;
}

.error-text {
  color: red;
  text-align: center;
  margin: 0;
  padding: 5px 0 15px 0;
}

.no-id {
  position: absolute;
  top: 125px;
  right: 20px;
  margin: 0;
}

.no-password {
  position: absolute;
  top: 180px;
  right: 20px;
  margin: 0;
}

.bad-id {
  position: absolute;
  top: 125px;
  right: 15px;
  margin: 0;
}

.bad-password {
  position: absolute;
  top: 180px;
  right: 15px;
  margin: 0;
}

/*id,password条件を満たした場合のスタイル*/
.check::before {
  content: "〇";
  background-color: green;
  color: white;
  padding: 3px 7px;
}

/*id,password条件を満たしていない場合のスタイル*/
.cross::before {
  content: "✕";
  background-color: red;
  color: white;
  padding: 3px 8px;
}

@media screen and (max-width: 1440px) {
  .no-id {
    right: 15px;
  }

  .no-password {
    right: 15px;
  }
  .bad-id {
    position: absolute;
    right: 10px;
  }
  .bad-password {
    position: absolute;
    right: 10px;
  }
}

@media screen and (max-width: 1024px) {
  .create-account-box {
    width: 60%;
  }
}

@media screen and (max-width: 768px) {
  .create-account-box {
    width: 70%;
    margin: 250px auto;
  }
  .create-account-box input[type="text"],
  .create-account-box input[type="password"] {
    width: 90%;
  }
  .account-name-link {
    width: 100%;
  }
  .no-id {
    right: 33px;
  }

  .no-password {
    right: 33px;
  }
  .bad-id {
    position: absolute;
    right: 25px;
  }
  .bad-password {
    position: absolute;
    right: 25px;
  }
}

@media screen and (max-width: 480px) {
  .create-account-box {
    margin: 130px auto;
  }
  .no-id {
    right: 20px;
  }

  .no-password {
    right: 20px;
  }
  .bad-id {
    position: absolute;
    right: 10px;
  }
  .bad-password {
    position: absolute;
    right: 10px;
  }
}
</style>
