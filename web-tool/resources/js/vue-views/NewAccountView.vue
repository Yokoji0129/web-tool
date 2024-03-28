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
  if(
    !data.id.trim() ||
    !data.password.trim() ||
    !data.confirmPassword.trim()
  ){
    error.value = "※すべての項目を入力してください。";
    return false;
  }
  //idがAlphanumericにマッチしなかった場合
  if(!Alphanumeric.test(data.id)) {
    error.value = "※IDは英数字を含み、8文字以上32文字以下で入力してください。";
    return false;
  }
  //確認用とパスワードが違った場合
  if(data.password !== data.confirmPassword) {
    error.value = "※パスワードが一致しません。";
    return false;
  }
  //passwordがAlphanumericにマッチしなかった場合
  if(!Alphanumeric.test(data.password)) {
    error.value =
      "※パスワードは英数字を含み、8文字以上32文字以下で入力してください。";
    return false;
  }
  /**ここにでき次第IDがかぶっているかの条件式書く*/
  else {
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
      <!--IDの条件満たしてる時と満たしてないときのデザイン-->
      <p
        class="bad-id"
        v-if="data.id.length >= 1"
        :class="{
          cross: !Alphanumeric.test(data.id),
          check: Alphanumeric.test(data.id),
        }"
      ></p>
      <input type="text" v-model="data.id" placeholder="ID" />
      <input type="password" v-model="data.password" placeholder="パスワード" />
      <!--パスワードの条件満たしてる時と満たしてないときのデザイン-->
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
      <p class="error-text">{{ error }}</p>
      <button class="account-name-link" type="submit">作成</button>
    </form>
  </div>
</template>

<style scoped>
.create-account-box {
  width: 700px;
  margin: auto;
  margin-top: 200px;
  padding: 20px;
  background-color: #f2e6d9;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  position: relative;
}

.create-account-box h2 {
  text-align: center;
  margin-bottom: 20px;
}

.create-account-box input[type="text"],
.create-account-box input[type="password"] {
  width: 95%;
  padding: 10px;
  margin-bottom: 15px;
  border: 2px solid #594736;
  border-radius: 5px;
  box-sizing: border-box;
  background-color: #e4d6c8;
}

.account-name-link {
  text-align: center;
  width: 95%;
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

.error-text {
  color: red;
  text-align: center;
  margin: 0;
  padding: 5px 0 10px 0;
}

.bad-id {
  position: absolute;
  top: 100px;
  right: 18px;
  margin: 0;
}

.bad-password {
  position: absolute;
  top: 155px;
  right: 18px;
  margin: 0;
}

/*id,password条件を満たした場合のスタイル*/
.check::before {
  content: "〇";
  background-color: green;
  color: white;
  padding: 3px 6px;
}

/*id,password条件を満たしていない場合のスタイル*/
.cross::before {
  content: "✕";
  background-color: red;
  color: white;
  padding: 3px 7px;
}

/*ウィンドウ幅が700px以下の場合*/
@media screen and (max-width: 700px) {
  .create-account-box {
    width: 300px;
    margin: auto;
    margin-top: 200px; /* 上方向の余白を追加 */
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
