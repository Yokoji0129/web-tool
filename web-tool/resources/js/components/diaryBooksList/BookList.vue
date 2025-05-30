<script setup lang="ts">
import { defineProps } from 'vue';
import { ref } from "vue";
import BookOperation from "./bookList/BookOperation.vue";

interface Book {
  diary_color: string;
  diary_favorite: number;
  diary_font: string;
  diary_id: number;
  diary_name: string;
  diary_text_color: string;
  diary_top_file: string;
}

const props = defineProps<{
  books: Book[],
  togglePopup: () => void,
  displayBooks: () => void,
  filteredDiarys: Book[],
  isFavoriteDisplayed: boolean,
}>();

const showBookPopup = ref<boolean>(false);
const selectedBook = ref<Book | undefined>(undefined); //選択された日記の情報を入れる
const selectBookNumber = ref<number | undefined>(undefined);

//日記のポップアップ
const toggleBookPopup = (book?: Book, index?: number): void => {
  showBookPopup.value = !showBookPopup.value;
  selectedBook.value = book;
  selectBookNumber.value = index;
};
</script>

<template>
  <h3 v-if="!books.length" class="diary-book-none">
    {{
      isFavoriteDisplayed
        ? "お気に入り日記はありません"
        : "日記を追加してください"
    }}
  </h3>
  <div class="diaries">
    <!--作成した本のリスト-->
    <div
      class="book-paper"
      v-for="(book, index) in filteredDiarys"
      :key="index"
      @click="toggleBookPopup(book, index)"
    >
      <div :class="book[0].diary_color">
        <h2 :style="{ color: book[0].diary_text_color }">
          {{ book[0].diary_name }}
        </h2>
      </div>
    </div>
    <!--ポップアップ---->
    <BookOperation
      :displayBooks="props.displayBooks"
      :showBookPopup="showBookPopup"
      :selectedBook="selectedBook"
      :selectBookNumber="selectBookNumber"
      :toggleBookPopup="toggleBookPopup"
    />
    <!--日記追加-->
    <div class="diary" @click="togglePopup" v-if="!isFavoriteDisplayed">
      <h2>+</h2>
    </div>
  </div>
</template>

<style scoped>
.diary-book-none {
  text-align: center;
}
.diaries {
  margin-top: 20px;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 3% 1%;
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
  margin-top: 5px;
  margin-left: 5px;
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

/*タブレット(1024px以下)*/
@media screen and (max-width: 1024px) {
  .diaries {
    gap: 2% 1%;
  }
}

/*スマホ(480px以下)*/
@media screen and (max-width: 480px) {
  .diaries {
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 5% 7%;
  }

  .diary {
    padding: 20px 0 150px 0;
    width: 150px;
    margin-left: 5px;
  }

  .book-paper {
    border-right: 8px solid #ffffff;
    width: 150px;
    height: 230px;
  }

  .book-paper h2 {
    font-size: 16px;
    padding: 0;
  }

  .book-backnumber-1 {
    border-left: 10px solid rgb(107, 191, 93);
    padding: 30px 0 149px 0;
  }

  .book-backnumber-2 {
    border-left: 10px solid rgb(255, 222, 155);
    padding: 30px 0 149px 0;
  }

  .book-backnumber-3 {
    border-left: 10px solid rgb(161, 142, 130);
    padding: 30px 0 149px 0;
  }

  .book-backnumber-4 {
    border-left: 10px solid rgb(110, 204, 230);
    padding: 30px 0 149px 0;
  }

  .book-backnumber-5 {
    border-left: 10px solid rgb(207, 150, 163);
    padding: 30px 0 149px 0;
  }

  .book-backnumber-6 {
    border-left: 10px solid rgb(242, 195, 201);
    padding: 30px 0 149px 0;
  }

  .book-backnumber-7 {
    border-left: 10px solid rgb(182, 176, 162);
    padding: 30px 0 149px 0;
  }

  .book-backnumber-8 {
    border-left: 10px solid rgb(233, 239, 235);
    padding: 30px 0 149px 0;
  }

  .book-backnumber-9 {
    border-left: 10px solid rgb(245, 202, 225);
    padding: 30px 0 149px 0;
  }

  .book-backnumber-10 {
    border-left: 10px solid rgb(196, 235, 171);
    padding: 30px 0 149px 0;
  }
}

/**firefox用のデザイン**/
@-moz-document url-prefix() {
  .book-backnumber-1,
  .book-backnumber-2,
  .book-backnumber-3,
  .book-backnumber-4,
  .book-backnumber-5,
  .book-backnumber-6,
  .book-backnumber-7,
  .book-backnumber-8,
  .book-backnumber-9,
  .book-backnumber-10 {
    padding: 70px 0 285px 0;
  }

  @media screen and (max-width: 480px) {
    .book-backnumber-1,
    .book-backnumber-2,
    .book-backnumber-3,
    .book-backnumber-4,
    .book-backnumber-5,
    .book-backnumber-6,
    .book-backnumber-7,
    .book-backnumber-8,
    .book-backnumber-9,
    .book-backnumber-10 {
      padding: 30px 0 153px 0;
    }
  }
}
</style>