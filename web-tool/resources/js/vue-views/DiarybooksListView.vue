<script setup>
import { ref } from "vue";

const showPopup = ref(false);
const bookTitle = ref("");
const selectedColor = ref("#ffffff"); // カラー選択の初期値を設定する
const books = ref([]); //本のリスト

//ポップアップの表示非表示
const togglePopup = () => {
  showPopup.value = !showPopup.value;
};

//引数で本の作成情報を取得(bookの中にnewBookが入る)
const addBook = (book) => {
  books.value.push(book);
};

//本を作成するメソッド
const createBook = () => {
  //タイトルが記入されていなかったら
  if (!bookTitle.value) {
    //returnで本が未設定のまま作成されないようにする
    alert("タイトルを入力してください。");
    return;
  }

  //本の設定で選択したもの
  const newBook = {
    name: bookTitle.value,
    color: selectedColor.value,
  };

  console.log(newBook.name, newBook.color)
  //タイトルとカラーをリセットする
  bookTitle.value = "";
  selectedColor.value = "#ffffff";

  axios
    .post("/diaryadd", {
      name: newBook.title,
      color: newBook.color
    })
    .then((response) => {
      //本リストに追加
      addBook(newBook);
      //作成したときにポップアップを閉じる
      togglePopup();
      console.log(response);
    })
    .catch((error) => {
      console.log(error);
    });
};
</script>

<template>
  <div class="container">
    <nav class="fixed-nav">
      <ul class="nav-list">
        <li class="nav-item-left"><p>利用注意</p></li>
        <li class="nav-item-center"><p>日記本一覧(0冊)</p></li>
        <li class="nav-item-right"><p>アカウント名: 名無し</p></li>
      </ul>
    </nav>
    <main>
      <div class="diaries">
        <!--作成した本のリスト-->
        <div
          v-for="(book, index) in books"
          :key="index"
          class="diary"
          :style="{ backgroundColor: book.color }"
        >
          <h2>{{ book.title }}</h2>
        </div>
        <div class="diary" @click="togglePopup">
          <h2>+</h2>
        </div>
      </div>
      <!--ポップアップ-->
      <div v-if="showPopup" class="popup">
        <div class="popup-content">
          <button class="close-btn" @click="togglePopup">閉じる</button>
          <div>
            <h3>日記本新規作成</h3>
            <!--本のタイトル-->
            <input
              v-model="bookTitle"
              type="text"
              class="book-title"
              placeholder="本のタイトル"
            />
            <h3>日記本新規作成</h3>
            <!--カラー選択プルダウン-->
            <select v-model="selectedColor" class="color-select">
              <option value="#ffffff">カラーなし</option>
              <option value="red">赤</option>
              <option value="blue">青</option>
              <option value="green">緑</option>
              <option value="yellow">黄</option>
            </select>
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

.fixed-nav {
  text-align: center;
  margin-top: 92px;
  position: fixed;
  top: 0;
  width: 100%;
  background-color: #ffffff;
  z-index: 999;
  border-bottom: 1px solid #ced4da;
}

.nav-list {
  background-color: #ffffff;
  list-style-type: none;
  padding: 0;
  margin: 0;
  display: flex;
  justify-content: space-between;
}

.nav-list p {
  margin: 0;
  padding: 20px;
}

.nav-item-left,
.nav-item-center,
.nav-item-right {
  flex: 1;
  font-weight: bold;
}

.nav-item-left {
  cursor: pointer;
}

main {
  margin: 70px 40px 40px 40px;
  padding: 20px;
}

.diaries {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 20px;
}

.diary {
  text-align: center;
  border: 2px solid #ccc;
  padding: 70px 0 280px 0;
  margin-top: 30px;
  background-color: #d4d4d4;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
  cursor: pointer;
}

.diary h2 {
  margin: 0;
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

/***ポップアップ横幅調整*/
@media screen and (max-width: 1440px) {
  .popup-content {
    width: 50%;
  }
}

/*タブレット*/
@media screen and (max-width: 768px) {
  .container {
    margin-top: 132px;
  }

  .fixed-nav {
    margin-top: 62px;
  }

  .nav-list {
    flex-direction: column;
    align-items: center;
  }

  .nav-list p {
    padding: 10px;
  }

  .nav-item-left,
  .nav-item-center,
  .nav-item-right {
    flex: none;
    width: auto;
  }
}

/*ウィンドウ幅が580px以下の場合のnavのスタイル(本の横幅調整。このタイミングでやらないと本が正方形になる)*/
@media screen and (max-width: 580px) {
  .diaries {
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  }
}

/**firefox用のデザイン**/
@-moz-document url-prefix() {
  .fixed-nav {
    margin-top: 82px;
  }
  @media screen and (max-width: 768px) {
    .fixed-nav {
      margin-top: 62px;
    }
  }
}
</style>
