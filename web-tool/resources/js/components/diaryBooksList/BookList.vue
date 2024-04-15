<script setup>
import axios from "axios";
import { ref } from "vue";

const props = defineProps({
  books: Array,
  togglePopup: Function,
  displayBooks: Function,
});

const loading = ref(false);
const showBookPopup = ref(false);
const selectedBook = ref(null); //選択された日記の情報を入れる

//日記のポップアップ
const toggleBookPopup = (book) => {
  showBookPopup.value = !showBookPopup.value;
  selectedBook.value = book;
};

const deleteBook = (diaryId) => {
  loading.value = true;

  axios
    .post("/delete/diary", {
      id: diaryId,
    })
    .then((response) => {
      props.displayBooks();
      toggleBookPopup();
    })
    .catch((error) => {
      console.log(error);
    })
    .finally(() => {
      loading.value = false;
    });
};
</script>

<template>
  <div class="diaries">
    <!--作成した本のリスト-->
    <div
      class="book-paper"
      v-for="(book, index) in books"
      :key="index"
      @click="toggleBookPopup(book)"
    >
      <div :class="book[0].diary_color">
        <h2 :style="{ color: book[0].diary_text_color }">
          {{ book[0].diary_name }}
        </h2>
      </div>
    </div>
    <!--ポップアップ---->
    <div v-if="showBookPopup" class="popup">
      <div class="popup-content">
        <button class="close-btn" @click="toggleBookPopup">閉じる</button>
        <!--選択された本のタイトルを表示-->
        <div v-if="selectedBook">
          <h3 class="book-title">{{ selectedBook[0].diary_name }}</h3>
        </div>
        <div class="book-select">
          <h2 class="book-open">日記を開く</h2>
          <h2 class="book-delete" @click="deleteBook(selectedBook[0].diary_id)">
            日記を削除
          </h2>
        </div>
      </div>
    </div>
    <!--ローディングアニメーション-->
    <div v-if="loading" class="loading-overlay">
      <div class="spinner"></div>
    </div>
    <!--日記追加-->
    <div class="diary" @click="togglePopup">
      <h2>+</h2>
    </div>
  </div>
</template>

<style scoped>
.delete-btn {
  background-color: #ffffff;
  position: absolute;
  font-size: 20px;
  font-weight: bold;
  margin: 0;
  padding: 5px 12px;
  cursor: pointer;
  border-radius: 0 0 10px 0;
}

.delete-btn:hover {
  background-color: #ced4da;
}

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
  padding: 30px 0;
  border-radius: 5px;
}

.close-btn {
  position: absolute;
  top: 0;
  right: 0;
  padding: 10px 15px;
}

.book-select {
  display: flex;
  justify-content: center;
}

.book-open {
  background-color: #bcd1ff;
  padding: 5% 10%;
  margin-right: 20px;
}

.book-open:hover {
  background-color: #91b4ff;
}

.book-delete {
  background-color: #ffcabc;
  padding: 5% 10%;
}

.book-delete:hover {
  background-color: #ffb29d;
}

.book-title {
  text-align: center;
  color: #333;
  background-color: #f8f9fa;
  padding: 5px 0;
}

.diaries {
  margin-top: 20px;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 3% 1%;
}

.book-paper-box {
  border-right: 2px solid red;
  border-radius: 0 10px 10px 0;
}

.book-paper {
  background-color: #ffffff;
  border-right: 12px solid #ffffff;
  border-radius: 0 10px 10px 0;
  box-shadow: 7px 7px 4px rgba(0, 0, 0, 0.5);
  width: 275px;
  height: 436px;
}

.book-paper h2 {
  background-color: #ffffff;
  padding: 5px 0;
}

.diary {
  text-align: center;
  border: 2px solid #ccc;
  padding: 70px 0 280px 0;
  background-color: #d4d4d4;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  width: 275px;
}

.diary h2 {
  margin: 0;
}

.book-backnumber-1 {
  background-image: url(../../../../public/note/note1.jpg);
  border-left: 20px solid rgb(107, 191, 93);
  background-size: cover;
  text-align: center;
  padding: 70px 0 280px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
  cursor: pointer;
}

.book-backnumber-2 {
  background-image: url(../../../../public/note/note2.jpg);
  border-left: 20px solid rgb(255, 222, 155);
  background-size: cover;
  text-align: center;
  padding: 70px 0 280px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
  cursor: pointer;
}

.book-backnumber-3 {
  background-image: url(../../../../public/note/note3.jpg);
  border-left: 20px solid rgb(161, 142, 130);
  background-size: cover;
  text-align: center;
  padding: 70px 0 280px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
  cursor: pointer;
}

.book-backnumber-4 {
  background-image: url(../../../../public/note/note4.jpg);
  border-left: 20px solid rgb(110, 204, 230);
  background-size: cover;
  text-align: center;
  padding: 70px 0 280px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
  cursor: pointer;
}

.book-backnumber-5 {
  background-image: url(../../../../public/note/note5.jpg);
  border-left: 20px solid rgb(207, 150, 163);
  background-size: cover;
  text-align: center;
  padding: 70px 0 280px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
  cursor: pointer;
}

.book-backnumber-6 {
  background-image: url(../../../../public/note/note6.jpg);
  border-left: 20px solid rgb(242, 195, 201);
  background-size: cover;
  text-align: center;
  padding: 70px 0 280px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
  cursor: pointer;
}

.book-backnumber-7 {
  background-image: url(../../../../public/note/note7.jpg);
  border-left: 20px solid rgb(182, 176, 162);
  background-size: cover;
  text-align: center;
  padding: 70px 0 280px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
  cursor: pointer;
}

.book-backnumber-8 {
  background-image: url(../../../../public/note/note8.jpg);
  border-left: 20px solid rgb(233, 239, 235);
  background-size: cover;
  text-align: center;
  padding: 70px 0 280px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
  cursor: pointer;
}

.book-backnumber-9 {
  background-image: url(../../../../public/note/note9.jpg);
  border-left: 20px solid rgb(245, 202, 225);
  background-size: cover;
  text-align: center;
  padding: 70px 0 280px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
  cursor: pointer;
}

.book-backnumber-10 {
  background-image: url(../../../../public/note/note10.jpg);
  border-left: 20px solid rgb(196, 235, 171);
  background-size: cover;
  text-align: center;
  padding: 70px 0 280px 0;
  border-radius: 0 10px 10px 0;
  box-shadow: 2px 0px 0px rgba(0, 0, 0, 0.5);
  cursor: pointer;
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
}

@media screen and (max-width: 768px) {
  .popup-content {
    width: 100%;
  }
  .diaries {
    gap: 1% 1%;
  }
}

@media screen and (max-width: 450px) {
  .book-open {
    padding: 2% 5%;
  }
  .book-delete {
    padding: 2% 5%;
  }
}
</style>