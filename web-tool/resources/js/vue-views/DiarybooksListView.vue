<script setup>
import { RouterLink, useRouter } from "vue-router";
import { onMounted, ref, reactive } from "vue";

const showPopup = ref(false); //ポップアップの表示制御
const showTooltip = ref(false); //注意書きの表示制御
const books = ref([]); //本のリスト
const router = useRouter();

//日記作成データ
const bookData = reactive({
  bookName: "",
  bookBackColor: "#ffffff",
  bookTextColor: "#000000",
});

//ポップアップの表示非表示
const togglePopup = () => {
  showPopup.value = !showPopup.value;
};

const toggleTooltip = () => {
  showTooltip.value = !showTooltip.value;
};

const logout = () => {
  axios
    .post("/logout", {})
    .then((response) => {
      router.push("/");
      console.log(response);
    })
    .catch((error) => {
      console.log(error);
    });
}

//本の情報をとってくるメソッド
const displayBooks = () => {
  axios
    .get("/returndiary")
    .then((response) => {
      books.value = response.data;
      console.log(response.data);
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
 * **/

//本をpostするメソッド
const createBook = () => {
  //タイトルが記入されていなかったら
  if (!bookData.bookName) {
    //returnで本が未設定のまま作成されないようにする
    alert("タイトルを入力してください。");
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
      console.log(response);
    })
    .catch((error) => {
      console.log(error);
    });

  //ポップアップ内の入力情報をリセットする
  bookData.bookName = "";
  bookData.bookBackColor = "#ffffff";
  bookData.bookTextColor = "#000000";
};

//ページ表示時に情報を表示させる
onMounted(() => {
  displayBooks();
});
</script>

<template>
  <div class="logout-box">
    <button class="logout" @click="logout">ログアウト</button>
  </div>
  <div class="container">
    <nav class="fixed-nav">
      <ul class="nav-list">
        <li class="nav-item-left">
          <p @click="toggleTooltip">利用注意</p>
          <div class="tooltip" v-show="showTooltip">
            このサービスは勉強用に作成されたものです、​
            このサービスに保存できる情報量には限界があります、予めご了承ください
          </div>
        </li>
        <li class="nav-item-center">
          <p>日記本一覧({{ books.length }}冊)</p>
        </li>
        <li class="nav-item-right">
          <p>アカウント名: 名無し</p>
        </li>
      </ul>
    </nav>
    <main>
      <div class="diaries">
        <!--作成した本のリスト-->
        <div
          v-for="(book, index) in books"
          :key="index"
          class="diary"
          :style="{ backgroundColor: book[0].diary_color }"
        >
          <h2 :style="{ color: book[0].diary_text_color }">
            {{ book[0].diary_name }}
          </h2>
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
              v-model="bookData.bookName"
              type="text"
              class="book-title"
              placeholder="本のタイトル"
            />
            <h3>日記カラー選択</h3>
            <!--背景カラー選択プルダウン-->
            <div class="color-select-box">
              <select v-model="bookData.bookBackColor" class="color-select">
                <option value="#ffffff">日記カラー(白)</option>
                <option value="red">赤</option>
                <option value="blue">青</option>
                <option value="green">緑</option>
                <option value="yellow">黄</option>
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
.logout-box {
  position: absolute;
  top: 0;
  right: 0;
  z-index: 9999;
}

.logout {
  background-color: #ffffff;
  border: 1px solid #ced4da;
  padding: 35px;
}

.logout:hover {
  background-color: #c9c9c9;
}

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

.tooltip {
  position: absolute;
  width: 31%;
  bottom: -59px;
  left: 33%;
  transform: translateX(-100%);
  background-color: #8795a1;
  padding: 5px 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

/**フルHD**/
@media screen and (max-width: 1920px) {
  .tooltip {
    bottom: -83px;
  }
}

/***ポップアップ横幅調整*/
@media screen and (max-width: 1440px) {
  .popup-content {
    width: 50%;
  }
}

/*タブレット*/
@media screen and (max-width: 768px) {
  .logout {
    padding: 20px;
  }

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

  .popup-content {
    width: 100%;
  }

  .tooltip {
    left: 50%;
    bottom: 0px;
    width: 50%;
    transform: translateX(-50%);
  }
}

/*ウィンドウ幅が580px以下の場合のnavのスタイル(本の横幅調整。このタイミングでやらないと本が正方形になる)*/
@media screen and (max-width: 580px) {
  .diaries {
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  }
}

/**スマホ**/
@media screen and (max-width: 450px) {
  .logout {
    padding: 20px 10px;
  }
  .tooltip {
    bottom: 0px;
    width: 100%;
    transform: translateX(-50%);
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
