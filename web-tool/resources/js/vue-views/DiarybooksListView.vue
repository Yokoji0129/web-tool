<script setup>
import { onMounted, ref, reactive, computed } from "vue";

import NavList from "../components/diaryBooksList/NavList.vue";
import BookList from "../components/diaryBooksList/BookList.vue";
import BackColor from "../components/diaryBooksList/BackColor.vue";
import TextColor from "../components/diaryBooksList/TextColor.vue";
import DiaryImage from "../components/diaryBooksList/DiaryImage.vue";
import LoadingScreen from "../components/LoadingScreen.vue";
const isLoading = ref(false)
const books = ref([]); //本のリスト
const selectedBackColor = ref(null); //本の背景classを入れる
const selectedTextColor = ref(null); //本のテキストカラーを入れる

//日記作成データ
const bookData = reactive({
  bookName: "",
  bookBackColor: "",
  bookTextColor: "",
  bookFont: "test",
});

//検索文字入れ
const searchTerm = ref("");
//文字検索
const filteredDiarys = computed(() => {
  //配列がからの時(垢作成初期時など)にからの配列を返す
  if (!Array.isArray(books.value)) {
    return [];
  }

  //データベース内のアイテム名を含むアイテムだけをフィルタリング
  return books.value.filter((book) =>
    book[0].diary_name.includes(searchTerm.value)
  );
});

const showPopup = ref(false); //ポップアップの表示制御フラグ

//ポップアップの表示非表示
const togglePopup = () => {
  showPopup.value = !showPopup.value;
};

const isFavoriteDisplayed = ref(false); //お気に入り表示フラグ

//本の情報をとってくるメソッド
const displayBooks = async () => {
  try {
    const response = await axios.get(
      isFavoriteDisplayed.value ? "/favorite/return" : "/returndiary"
    );
    books.value = response.data;
  } catch (error) {
    console.error(error);
  }
};

//お気に入り表示と通常表示ボタンの表示切替
const displayFavoriteBooks = () => {
  isFavoriteDisplayed.value = !isFavoriteDisplayed.value;
  displayBooks();
};

/**
 * やること
 * 2.本を追加した後からも本の情報を変えれるようにする
 * 3.本作成時フォントも変えれるようにする
 * 4.お気に入り本がないときにお気に入り本がありませんと表示させる
 * 5.日記が一冊もないときに日記を追加してくださいと表示させる
 * **/

//本をpostするメソッド
const createBook = async () => {
  //タイトルが記入されていなかったら
  if (!bookData.bookName) {
    //returnで本が未設定のまま作成されないようにする
    alert("タイトルを入力してください。");
    return;
  }
  if (bookData.bookName.length > 8) {
    alert("タイトルは8文字以内にしてください。");
    return;
  }
  if (!bookData.bookBackColor) {
    alert("日記の背景デザインを選択してください。");
    return;
  }
  if (!bookData.bookTextColor) {
    alert("日記のテキストカラーを選択してください。");
    return;
  }
  isLoading.value = true;

  try {
    await axios.post("/diaryadd", {
      name: bookData.bookName,
      color: bookData.bookBackColor,
      textColor: bookData.bookTextColor,
      font: bookData.bookFont,
    });

    // 作成したときにポップアップを閉じる
    togglePopup();
    // 本の表示
    displayBooks();
  } catch (error) {
    console.error(error);
  } finally {
    isLoading.value = false;
  }

  //ポップアップ内の入力情報をリセットする
  bookData.bookName = "";
  bookData.bookBackColor = "";
  bookData.bookTextColor = "";
  bookData.bookFont = "test";
  selectedBackColor.value = "";
  selectedTextColor.value = "";
};

//ページ表示時に情報を表示させる
onMounted(() => {
  displayBooks();
});
</script>

<template>
  <div class="search-box">
    <img src="../../../public/icon/search.png" alt="検索icon" width="24px" />
    <input
      type="text"
      class="diary-search"
      placeholder="日記検索"
      v-model="searchTerm"
    />
  </div>
  <div class="container">
    <!--ユーザー名などのnavコンポーネント-->
    <NavList
      :books="books"
      :displayFavoriteBooks="displayFavoriteBooks"
      :isFavoriteDisplayed="isFavoriteDisplayed"
    />
    <main>
      <!--本一覧コンポーネント-->
      <BookList
        :books="books"
        :togglePopup="togglePopup"
        :displayBooks="displayBooks"
        :filteredDiarys="filteredDiarys"
        :isFavoriteDisplayed="isFavoriteDisplayed"
      />
      <!--ポップアップ-->
      <div v-if="showPopup" class="popup">
        <div class="popup-content">
          <button class="btn-close" @click="togglePopup">閉じる</button>
          <div>
            <h3>日記本新規作成</h3>
            <!--本のタイトル-->
            <input
              v-model="bookData.bookName"
              type="text"
              class="book-title"
              placeholder="日記のタイトル(8文字以内)"
            />
            <h3>日記デザイン選択</h3>
            <div class="color-select-box">
              <!--日記背景デザイン選択プルダウン-->
              <BackColor
                :bookData="bookData"
                :selectedBackColor="selectedBackColor"
                @update:selectedBackColor="selectedBackColor = $event"
              />
              <!--テキストカラー選択プルダウン-->
              <TextColor
                :bookData="bookData"
                :selectedTextColor="selectedTextColor"
                @update:selectedTextColor="selectedTextColor = $event"
              />
            </div>
            <!--本を作成するボタン-->
            <div class="create-btn">
              <button @click="createBook">作成</button>
            </div>
            <!-- ローディングアニメーション -->
            <LoadingScreen :isLoading="isLoading" />
          </div>
        </div>
        <div>
          <!--ここに本のイメージ-->
          <DiaryImage
            :selectedBackColor="selectedBackColor"
            :selectedTextColor="selectedTextColor"
            :bookData="bookData"
          />
          <!--ここに本のイメージ-->
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
.search-box img {
  position: fixed;
  top: 28px;
  right: 335px;
  z-index: 1000;
}

.diary-search {
  border: 2px solid #ccc;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
  position: fixed;
  top: 16px;
  right: 20px;
  padding: 15px 150px 15px 35px;
  z-index: 999;
}

.diary-search:hover {
  border-color: #007bff;
}

.container {
  margin-top: 75px;
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

/*タブレット(1024px以下)*/
@media only screen and (max-width: 1024px) {
  .diary-search {
    z-index: 0;
  }
  .search-box img {
    z-index: 0;
  }
  .popup-content {
    width: 60%;
  }
}

/*タブレット(768px以下)*/
@media only screen and (max-width: 768px) {
  .diary-search {
    top: 11px;
    right: 20px;
    padding: 10px 70px 10px 30px;
  }

  .container {
    margin-top: 120px;
  }

  .popup-content {
    width: 80%;
  }

  .popup {
    flex-direction: column;
  }

  .color-select-box {
    flex-direction: column;
  }
}

/*スマホ(480px以下)*/
@media only screen and (max-width: 480px) {
  main {
    margin: 70px 15px 120px 20px;
  }

  .popup-content {
    width: 70%;
    padding: 20px;
  }

  .popup {
    flex-direction: column;
  }

  .color-select-box {
    flex-direction: column;
  }
}

@-moz-document url-prefix() {
  .search-box img {
    top: 25px;
    right: 335px;
  }

  .diary-search {
    top: 12px;
    right: 23px;
  }

  @media only screen and (max-width: 768px) {
    .search-box img {
      top: 20px;
      right: 250px;
    }

    .diary-search {
      top: 12px;
      right: 20px;
    }
  }
}
</style>
