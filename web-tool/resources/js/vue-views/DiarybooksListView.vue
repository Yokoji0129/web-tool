<script setup>
import { onMounted, ref, reactive } from "vue";

import navList from "../components/diaryBooksList/navList.vue";
import BookList from "../components/diaryBooksList/BookList.vue";
import BackColor from "../components/diaryBooksList/BackColor.vue";
import TextColor from "../components/diaryBooksList/TextColor.vue";
import DiaryImage from "../components/diaryBooksList/DiaryImage.vue";

const books = ref([]); //本のリスト
const loadingBook = ref(false);//ローディングフラグ
const selectedBackColor = ref(null); //本の背景classを入れる
const selectedTextColor = ref(null); //本のテキストカラーを入れる

//日記作成データ
const bookData = reactive({
  bookName: "",
  bookBackColor: "",
  bookTextColor: "",
  bookFont: "test",
});

const showPopup = ref(false); //ポップアップの表示制御フラグ

//ポップアップの表示非表示
const togglePopup = () => {
  showPopup.value = !showPopup.value;
};

const isFavoriteDisplayed = ref(false); //お気に入り表示フラグ

//本の情報をとってくるメソッド
const displayBooks = () => {
  //isFavoriteDisplayedがtrueかfalseでAPIの切り替えをする
  axios
    .get(isFavoriteDisplayed.value ? "/favorite/return" : "/returndiary")
    .then((response) => {
      books.value = response.data;
    })
    .catch((error) => {
      console.log(error);
    })
};

//お気に入り表示と通常表示ボタンの表示切替
const displayFavoriteBooks = () => {
  isFavoriteDisplayed.value = !isFavoriteDisplayed.value;
  displayBooks();
};

/**
 * やること
 * 2.本のタイトルの文字数制限つける(文字が多いとデザインがおかしくなるため)
 * 6.本を追加した後からも本の情報を変えれるようにする
 * 7.本作成時フォントも変えれるようにする
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
    alert("日記の背景デザインを選択してください");
    return;
  }
  if (!bookData.bookTextColor) {
    alert("日記のテキストカラーを選択してください");
    return;
  }

  loadingBook.value = true;
  axios
    .post("/diaryadd", {
      name: bookData.bookName,
      color: bookData.bookBackColor,
      textColor: bookData.bookTextColor,
      font: bookData.bookFont,
    })
    .then((response) => {
      //作成したときにポップアップを閉じる
      togglePopup();
      //本の表示
      displayBooks();
    })
    .catch((error) => {
      console.log(error);
    })
    .finally(() => {
      loadingBook.value = false;
    });

  //ポップアップ内の入力情報をリセットする
  bookData.bookName = "";
  bookData.bookBackColor = "";
  bookData.bookTextColor = "";
  bookData.bookFont = "test";
  selectedBackColor.value = "";
  selectedTextColor.value = ""
};

//ページ表示時に情報を表示させる
onMounted(() => {
  displayBooks();
});
</script>

<template>
  <div class="container">
    <!--ユーザー名などのnavコンポーネント-->
    <navList :books="books" :displayFavoriteBooks="displayFavoriteBooks" :isFavoriteDisplayed="isFavoriteDisplayed" />
    <main>
      <!--本一覧コンポーネント-->
      <BookList :books="books" :togglePopup="togglePopup" :displayBooks="displayBooks" />
      <!--ポップアップ-->
      <div v-if="showPopup" class="popup">
        <div class="popup-content">
          <button class="btn-close" @click="togglePopup">閉じる</button>
          <div>
            <h3>日記本新規作成</h3>
            <!--本のタイトル-->
            <input v-model="bookData.bookName" type="text" class="book-title" placeholder="日記のタイトル" />
            <h3>日記デザイン選択</h3>
            <div class="color-select-box">
              <!--日記背景デザイン選択プルダウン-->
              <BackColor :bookData="bookData" :selectedBackColor="selectedBackColor"
                @update:selectedBackColor="selectedBackColor = $event" />
              <!--テキストカラー選択プルダウン-->
              <TextColor :bookData="bookData" :selectedTextColor="selectedTextColor"
                @update:selectedTextColor="selectedTextColor = $event" />
              <!--フォント選択プルダウン(まだできてない)-->
              <select v-model="bookData.bookFont" class="color-select">
                <option value="test">フォント</option>
              </select>
            </div>
            <!--本を作成するボタン-->
            <div class="create-btn">
              <button @click="createBook">作成</button>
            </div>
            <!-- ローディングアニメーション -->
            <div v-if="loadingBook" class="loading-overlay">
              <div class="spinner"></div>
            </div>
          </div>
        </div>
        <div>
          <!--ここに本のイメージ-->
          <DiaryImage
            :selectedBackColor="selectedBackColor"
            :selectedTextColor="selectedTextColor"
            :bookData="bookData" />
          <!--ここに本のイメージ-->
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
  margin: 100px 70px 300px 70px;
}

.popup-content h3 {
  margin: 20 0 10px 0;
  text-align: center;
  color: #333;
}

.btn-close {
  width: 100%;
  padding: 10px;
  border: none;
  background-color: #555;
  color: #fff;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-close:hover {
  background-color: #333;
}

.book-title {
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

.book-title:hover {
  border-color: #007bff;
  box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
}

.selected-image {
  width: 100%;
  max-height: 200px;
  object-fit: contain;
}

.color-select-box {
  display: flex;
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

@media screen and (max-width: 1440px) {
  .popup-content {
    width: 50%;
  }
}

@media screen and (max-width: 1024px) {
  .popup-content {
    width: 60%;
  }

  main {
    margin: 90px 40px 200px 40px;
  }
}

@media screen and (max-width: 820px) {
  .popup-content {
    width: 60%;
  }

  main {
    margin: 90px 70px 200px 70px;
  }
}

/*タブレット*/
@media screen and (max-width: 768px) {
  .container {
    margin-top: 132px;
  }

  .popup-content {
    width: 80%;
  }

  .popup {
    flex-direction: column;
  }
}

@media screen and (max-width: 600px) {
  .color-select-box {
    flex-direction: column;
  }
}

@media screen and (max-width: 450px) {
  .popup-content {
    width: 70%;
  }

  main {
    margin: 70px 25px 120px 25px;
  }
}

@media screen and (max-width: 375px) {
  main {
    margin: 70px 15px 120px 15px;
  }
}

@media screen and (max-width: 320px) {
  main {
    margin: 70px 70px 260px 70px;
  }
}
</style>
