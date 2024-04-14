<script setup>
import axios from "axios";
import { ref } from "vue";

const props = defineProps({
  books: Array,
  togglePopup: Function,
  displayBooks: Function,
});

const loading = ref(false);

const deleteBook = (diaryId) => {
  loading.value = true;

  axios
    .post("/delete/diary", {
      id: diaryId,
    })
    .then((response) => {
      props.displayBooks();
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
    <div class="book-paper" v-for="(book, index) in books" :key="index">
      <p class="delete-btn" @click="deleteBook(book[0].diary_id)">✕</p>
      <div :class="book[0].diary_color">
        <h2 :style="{ color: book[0].diary_text_color }">
          {{ book[0].diary_name }}
        </h2>
      </div>
    </div>
    <!-- ローディングアニメーション -->
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
  height: 435px;
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

@media screen and (max-width: 768px) {
  .diaries {
    gap: 1% 1%;
  }
}
</style>