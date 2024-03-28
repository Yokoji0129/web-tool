<script setup>
import { RouterLink, useRouter } from "vue-router";
import axios from "axios";
import { ref, reactive } from "vue";

//フォーム入力のデータリアクティブ
const data = reactive({
  id: "",
  password: "",
  confirmPassword: "",
});
const error = ref(""); //フォーム入力エラー文字入れ
const router = useRouter(); //特定の処理後にページ遷移させるための変数

//ID,パスワードの長さが8文字未満、または33文字以上の場合(英数字含む)の正規表現
const Alphanumeric = /^(?=.*[0-9])(?=.*[a-zA-Z])[0-9a-zA-Z]{8,32}$/;

//フォーム入力条件メソッド
const validateForm = () => {
  //全部の値が埋められていなかった場合
  if (
    !data.id.trim() ||
    !data.password.trim() ||
    !data.confirmPassword.trim()
  ) {
    error.value = "※すべての項目を入力してください。";
    return false;
  }
  //idがAlphanumericにマッチしなかった場合
  if (!Alphanumeric.test(data.id)) {
    error.value = "※IDは英数字を含み、8文字以上32文字以下で入力してください。";
    return false;
  }
  //確認用とパスワードが違った場合
  if (data.password !== data.confirmPassword) {
    error.value = "※パスワードが一致しません。";
    return false;
  }
  //passwordがAlphanumericにマッチしなかった場合
  if (!Alphanumeric.test(data.password)) {
    error.value =
      "※パスワードは英数字を含み、8文字以上32文字以下で入力してください。";
    return false;
  } else {
  /**ここにでき次第IDがかぶっているかの条件式書く*/
    return true;
  }
};

/**
 * 次回やること
 * 記号や特殊文字がパスワードやIDに入っていた場合
 * 「使用できない文字が含まれています」と表示させる
 **/

//フォーム送信メソッド
const submitForm = () => {
  if (!validateForm()) return; //フォーム入力に誤りがあった場合falseになって処理を止める
  axios
    .post("/post", {
      id: data.id,
      password: data.password,
      confirmPassword: data.confirmPassword,
    })
    .then((response) => {
      console.log("成功");
      //フォーム送信成功時アカウント名作成ページ遷移する
      router.push("/accountName");
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
      <input type="text" v-model="data.id" placeholder="ID" />
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
      <!--エラーの際テキスト表示-->
      <p class="error-text">{{ error }}</p>
      <button class="account-name-link" type="submit">作成</button>
    </form>
  </div>
</template>

<style scoped>
.create-account-box {
  width: 700px;
  margin: auto;
  margin-top: 120px;
  padding: 20px;
  background-color: #f8f9fa;
  border: 1px solid #ccc;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  position: relative;
}

.create-account-box h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}

.create-account-box input[type="text"],
.create-account-box input[type="password"] {
  width: 95%;
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
  background-color: #fff;
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
  top: 100px;
  right: 20px;
  margin: 0;
}

.no-password {
  position: absolute;
  top: 155px;
  right: 20px;
  margin: 0;
}

.bad-id {
  position: absolute;
  top: 100px;
  right: 15px;
  margin: 0;
}

.bad-password {
  position: absolute;
  top: 155px;
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

/*ウィンドウ幅が750px以下の場合*/
@media screen and (max-width: 750px) {
  .create-account-box {
    width: 300px;
    margin: auto;
    margin-top: 100px; /* 上方向の余白を追加 */
  }
  .create-account-box input[type="text"],
  .create-account-box input[type="password"] {
    width: 90%;
  }
  .account-name-link {
    width: 90%;
  }
  .bad-id {
    position: absolute;
    right: 15px;
  }
  .bad-password {
    position: absolute;
    right: 15px;
  }
}
</style>
