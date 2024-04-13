<script setup>
import { onMounted, ref, reactive } from "vue";

import LogoutBtn from "../components/diaryBooksList/LogoutBtn.vue";
import navList from "../components/diaryBooksList/navList.vue";
import BookList from "../components/diaryBooksList/BookList.vue";

const showPopup = ref(false); //ポップアップの表示制御
const books = ref([]); //本のリスト

//日記作成データ
const bookData = reactive({
  bookName: "",
  bookBackColor: "",
  bookTextColor: "#000000",
});

//ポップアップの表示非表示
const togglePopup = () => {
  showPopup.value = !showPopup.value;
};

//本の情報をとってくるメソッド
const displayBooks = () => {
  axios
    .get("/returndiary")
    .then((response) => {
      books.value = response.data;
    })
    .catch((error) => {
      console.log(error);
    });
};

/**
 * やること
 * 1.テキストカラーの選択できるようにする
 * 2.本のタイトルの文字数制限つける(文字が多いとデザインがおかしくなるため)
 * 3.背景カラーの増加とカラーコードの試行錯誤(プルダウンをv-forで短くできるかやってみる)
 * 5.navの項目のコードを追加する
 * 6.本を追加した後からも本の情報を変えれるようにする
 * 7.本作成時フォントも変えれるようにする
 * 8.navListで三つのうちクリックしてる状態のところの色を変える
 * 9.日記本一覧のnavのところにsort機能作る
 * **/

//本をpostするメソッド
const createBook = () => {
  //タイトルが記入されていなかったら
  if (!bookData.bookName) {
    //returnで本が未設定のまま作成されないようにする
    alert("タイトルを入力してください。");
    return;
  }
  if (!bookData.bookBackColor) {
    alert("日記のデザインを選択してください");
    return;
  }

  axios
    .post("/diaryadd", {
      name: bookData.bookName,
      color: bookData.bookBackColor,
      textColor: bookData.bookTextColor,
    })
    .then((response) => {
      //作成したときにポップアップを閉じる
      togglePopup();
      //本の表示
      displayBooks();
    })
    .catch((error) => {
      console.log(error);
    });

  //ポップアップ内の入力情報をリセットする
  bookData.bookName = "";
  bookData.bookBackColor = "";
  bookData.bookTextColor = "#000000";
};

//ページ表示時に情報を表示させる
onMounted(() => {
  displayBooks();
});
</script>

<template>
  <!--ログアウトボタン-->
  <LogoutBtn />
  <div class="container">
    <!--ユーザー名などのnav-->
    <navList :books="books" />
    <main>
      <!--本一覧-->
      <BookList :books="books" :togglePopup="togglePopup" />
      <!--ポップアップ-->
      <div v-if="showPopup" class="popup">
        <div class="popup-content">
          <button class="close-btn" @click="togglePopup">閉じる</button>
          <div>
            <h3>日記本新規作成</h3>
            <!--本のタイトル-->
            <input
              v-model="bookData.bookName"
              type="text"
              class="book-title"
              placeholder="本のタイトル"
            />
            <h3>日記カラー選択</h3>
            <!--背景カラー選択プルダウン-->
            <div class="color-select-box">
              <select v-model="bookData.bookBackColor" class="color-select">
                <option value="">日記デザイン選択</option>
                <option value="book-backnumber-1">日記デザイン(1)</option>
                <option value="book-backnumber-2">日記デザイン(2)</option>
                <option value="book-backnumber-3">日記デザイン(3)</option>
                <option value="book-backnumber-4">日記デザイン(4)</option>
                <option value="book-backnumber-5">日記デザイン(5)</option>
                <option value="book-backnumber-6">日記デザイン(6)</option>
                <option value="book-backnumber-7">日記デザイン(7)</option>
                <option value="book-backnumber-8">日記デザイン(8)</option>
                <option value="book-backnumber-9">日記デザイン(9)</option>
                <option value="book-backnumber-10">日記デザイン(10)</option>
              </select>
              <select v-model="bookData.bookTextColor" class="color-select">
                <option value="#000000">日記テキストカラー(黒)</option>
                <option value="red">赤</option>
                <option value="blue">青</option>
                <option value="green">緑</option>
                <option value="yellow">黄</option>
              </select>
            </div>
            <!--本を作成するボタン-->
            <div class="create-btn">
              <button @click="createBook">作成</button>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
.container {
  margin-top: 90px;
  display: flex;
  flex-direction: column;
}

main {
  margin: 70px 5% 200px 10%;
  padding: 20px;
}

/* ポップアップ */
.popup {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 1000;
  display: flex;
  justify-content: center;
  align-items: center;
}

.popup-content {
  position: relative;
  width: 35%;
  background-color: white;
  padding: 30px;
  border-radius: 5px;
}

.popup-content h3 {
  margin: 20 0 10px 0;
  text-align: center;
  color: #333;
}

.close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
}

.book-title {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
  background-color: #fff;
}

.selected-image {
  width: 100%;
  max-height: 200px;
  object-fit: contain;
}
.color-select-box {
  display: flex;
}

.color-select {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-bottom: 20px;
}

.create-btn {
  text-align: center;
}

.create-btn button {
  width: 100%;
  padding: 10px;
  border: none;
  background-color: #007bff;
  color: #fff;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.create-btn button:hover {
  background-color: #0056b3;
}

@media screen and (max-width: 1597px) {
  main {
    margin: 70px 5% 330px 10%;
  }
}

@media screen and (max-width: 1440px) {
  .popup-content {
    width: 50%;
  }
}

@media screen and (max-width: 1145px) {
  main {
    margin: 70px 5% 730px 10%;
  }
}

@media screen and (max-width: 1053px) {
  main {
    margin: 70px 5% 470px 10%;
  }
}

/*タブレット*/
@media screen and (max-width: 768px) {
  .container {
    margin-top: 132px;
  }

  .popup-content {
    width: 100%;
  }
}

</style>
