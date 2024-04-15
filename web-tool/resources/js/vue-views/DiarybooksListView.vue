<script setup>
import { onMounted, ref, reactive } from "vue";

import navList from "../components/diaryBooksList/navList.vue";
import BookList from "../components/diaryBooksList/BookList.vue";

const showPopup = ref(false); //ポップアップの表示制御
const books = ref([]); //本のリスト
const loadingBook = ref(false);
const selectedBackColor = ref(null); //本の背景classを入れる
const selectedTextColor = ref(null); //本のテキストカラーを入れる

//本のイメージclass取得(日記作成ポップアップでの見本)
const bookBackColorSelect = () => {
  selectedBackColor.value = bookData.bookBackColor;
};
const bookTextColorSelect = () => {
  selectedTextColor.value = bookData.bookTextColor;
};

//日記作成データ
const bookData = reactive({
  bookName: "",
  bookBackColor: "",
  bookTextColor: "",
  bookFont: "test",
});

//背景カラーの選択肢
const backgroundColors = [
  {
    id: "日記デザイン(1)",
    class: "book-backnumber-1",
  },
  {
    id: "日記デザイン(2)",
    class: "book-backnumber-2",
  },
  {
    id: "日記デザイン(3)",
    class: "book-backnumber-3",
  },
  {
    id: "日記デザイン(4)",
    class: "book-backnumber-4",
  },
  {
    id: "日記デザイン(5)",
    class: "book-backnumber-5",
  },
  {
    id: "日記デザイン(6)",
    class: "book-backnumber-6",
  },
  {
    id: "日記デザイン(7)",
    class: "book-backnumber-7",
  },
  {
    id: "日記デザイン(8)",
    class: "book-backnumber-8",
  },
  {
    id: "日記デザイン(9)",
    class: "book-backnumber-9",
  },
  {
    id: "日記デザイン(10)",
    class: "book-backnumber-10",
  },
];

//テキストカラー選択肢
const textColors = [
  {
    id: "黒",
    color: "#000000",
  },
  {
    id: "赤",
    color: "red",
  },
  {
    id: "青",
    color: "blue",
  },
  {
    id: "緑",
    color: "green",
  },
  {
    id: "黄",
    color: "yellow",
  },
];

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
};

//ページ表示時に情報を表示させる
onMounted(() => {
  displayBooks();
});
</script>

<template>
  <div class="container">
    <!--ユーザー名などのnavコンポーネント-->
    <navList :books="books" />
    <main>
      <!--本一覧コンポーネント-->
      <BookList
        :books="books"
        :togglePopup="togglePopup"
        :displayBooks="displayBooks"
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
              placeholder="日記のタイトル"
            />
            <h3>日記デザイン選択</h3>
            <!--背景カラー選択プルダウン-->
            <div class="color-select-box">
              <!--日記背景デザイン選択-->
              <select
                v-model="bookData.bookBackColor"
                class="color-select"
                @change="bookBackColorSelect"
              >
                <option value="">日記背景デザイン</option>
                <option
                  v-for="(backColor, index) in backgroundColors"
                  :key="index"
                  :value="backColor.class"
                >
                  {{ backColor.id }}
                </option>
              </select>
              <!--テキストカラー選択プルダウン-->
              <select
                v-model="bookData.bookTextColor"
                class="color-select"
                @change="bookTextColorSelect"
              >
                <option value="">テキスト色</option>
                <option
                  v-for="(textColor, index) in textColors"
                  :key="index"
                  :value="textColor.color"
                >
                  {{ textColor.id }}
                </option>
              </select>
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
          <div class="book-paper">
            <div>
              <!--本のイメージが選択されている場合-->
              <div :class="selectedBackColor">
                <h4 class="image-h4" :style="{ color: selectedTextColor }">
                  {{ bookData.bookName }}
                </h4>
              </div>
            </div>
          </div>
          <!--ここに本のイメージ-->
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
.book-paper {
  background-color: #ffffff;
  border-radius: 0 10px 10px 0;
  width: 260px;
  height: 350px;
  margin-left: 30px;
  text-align: center;
  font-size: 24px;
}

.image-h4 {
  background-color: #ffffff;
}

.book-backnumber-1 {
  background-image: url(../../../public/note/note1.jpg);
  border-left: 20px solid rgb(107, 191, 93);
  background-size: cover;
  text-align: center;
  padding: 70px 0 190px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
}
.book-backnumber-2 {
  background-image: url(../../../public/note/note2.jpg);
  border-left: 20px solid rgb(255, 222, 155);
  background-size: cover;
  text-align: center;
  padding: 70px 0 190px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
}
.book-backnumber-3 {
  background-image: url(../../../public/note/note3.jpg);
  border-left: 20px solid rgb(161, 142, 130);
  background-size: cover;
  text-align: center;
  padding: 70px 0 190px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
}
.book-backnumber-4 {
  background-image: url(../../../public/note/note4.jpg);
  border-left: 20px solid rgb(110, 204, 230);
  background-size: cover;
  text-align: center;
  padding: 70px 0 190px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
}
.book-backnumber-5 {
  background-image: url(../../../public/note/note5.jpg);
  border-left: 20px solid rgb(207, 150, 163);
  background-size: cover;
  text-align: center;
  padding: 70px 0 190px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
}
.book-backnumber-6 {
  background-image: url(../../../public/note/note6.jpg);
  border-left: 20px solid rgb(242, 195, 201);
  background-size: cover;
  text-align: center;
  padding: 70px 0 190px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
}
.book-backnumber-7 {
  background-image: url(../../../public/note/note7.jpg);
  border-left: 20px solid rgb(182, 176, 162);
  background-size: cover;
  text-align: center;
  padding: 70px 0 190px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
}
.book-backnumber-8 {
  background-image: url(../../../public/note/note8.jpg);
  border-left: 20px solid rgb(233, 239, 235);
  background-size: cover;
  text-align: center;
  padding: 70px 0 190px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
}
.book-backnumber-9 {
  background-image: url(../../../public/note/note9.jpg);
  border-left: 20px solid rgb(245, 202, 225);
  background-size: cover;
  text-align: center;
  padding: 70px 0 190px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
}
.book-backnumber-10 {
  background-image: url(../../../public/note/note10.jpg);
  border-left: 20px solid rgb(196, 235, 171);
  background-size: cover;
  text-align: center;
  padding: 70px 0 190px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
}

.container {
  margin-top: 90px;
  display: flex;
  flex-direction: column;
}

main {
  margin: 70px 5% 500px 10%;
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
  display: flex;
}

.popup-content {
  position: relative;
  width: 35%;
  height: auto;
  background-color: #ffffff;
  padding: 30px;
  border-radius: 5px;
  border: 3px solid #ced4da;
  box-shadow: 7px 7px 4px rgba(0, 0, 0, 0.5);
  overflow-y: auto; /*スクロール可能*/
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

.color-select {
  cursor: pointer;
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  margin-bottom: 20px;
  border: 2px solid #ccc;
  transition: border-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
}

.color-select:hover {
  color: #007bff;
  border-color: #007bff;
  box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
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

@media screen and (max-width: 1000px) {
  .popup-content {
    width: 70%;
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
  .book-paper {
    margin-left: 0px;
    margin-top: 30px;
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
  .book-paper {
    margin-top: 10px;
  }
}
</style>
