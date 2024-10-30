<script setup lang="ts">
import { RouterLink, useRouter } from "vue-router";
import { ref, defineProps } from "vue";
import LoadingScreen from "../../LoadingScreen.vue";
import axios from "axios";

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
  displayBooks: () => void,
  showBookPopup: boolean,
  selectedBook: Book | undefined,
  selectBookNumber: number | undefined,
  toggleBookPopup: () => void,
}>();

const isLoading = ref<boolean>(false)
const router = useRouter();

//日記開く
const diaryOpen = (diaryId: number, selectBookNumber: number): void => {
  //localstrageは値を文字列として保存するから文字列に変換
  localStorage.setItem("diaryId", diaryId.toString());
  localStorage.setItem("selectBookNumber", selectBookNumber.toString());
  //diaryのページにparamsで日記IDと日記のlength番号を渡す
  router.push({
    name: "diary",
    params: { diaryId: diaryId.toString(), selectBookNumber: selectBookNumber.toString() },
  });
};
//お気に入り追加メソッド
const favoriteAddBook = async (diaryId: number): Promise<void> => {
  isLoading.value = true;

  try {
    await axios.post("/favorite/add", {
      id: diaryId,
    });

    window.alert("お気に入り追加しました");
    props.toggleBookPopup();
  } catch (error) {
    console.log(error);
  } finally {
    isLoading.value = false;
  }
};

//お気に入り削除メソッド
const favoriteDeleteBook = async (diaryId: number): Promise<void> => {
  isLoading.value = true;

  try {
    await axios.post("/favorite/delete", {
      id: diaryId,
    });

    window.alert("お気に入りを削除しました");
    props.toggleBookPopup();
    props.displayBooks();
  } catch (error) {
    console.log(error);
  } finally {
    isLoading.value = false;
  }
};

//日記の削除メソッド
const deleteBook = async (diaryId: number, diaryName: string): Promise<void> => {
  //日記削除警告
  if (window.confirm(diaryName + "を本当に削除しますか？")) {
    isLoading.value = true;

    try {
      await axios.post("/delete/diary", {
        id: diaryId,
      });

      props.displayBooks();
      props.toggleBookPopup();
    } catch (error) {
      console.log(error);
    } finally {
      isLoading.value = false;
    }
  }
};
</script>
<!--日記操作ボタンをここに書く-->
<template>
  <div v-if="showBookPopup" class="popup">
    <div class="popup-content">
      <button class="btn-close" @click="toggleBookPopup">閉じる</button>
      <!--選択された本のタイトルを表示-->
      <div v-if="selectedBook">
        <h3 class="book-title">{{ selectedBook[0].diary_name }}</h3>
      </div>
      <!--日記操作ボタン一覧-->
      <div class="book-select">
        <p
          class="book-open"
          @click="diaryOpen(selectedBook[0].diary_id, selectBookNumber)"
        >
          日記を開く
        </p>
        <p
          class="favorite"
          v-if="selectedBook[0].diary_favorite === 1"
          @click="favoriteDeleteBook(selectedBook[0].diary_id)"
        >
          お気に入り削除
        </p>
        <p
          class="favorite"
          v-else
          @click="favoriteAddBook(selectedBook[0].diary_id)"
        >
          お気に入り追加
        </p>
        <p
          class="book-delete"
          @click="
            deleteBook(selectedBook[0].diary_id, selectedBook[0].diary_name)
          "
        >
          日記を削除
        </p>
      </div>
    </div>
  </div>
  <!--ローディングアニメーション-->
  <LoadingScreen :isLoading="isLoading" />
</template>

<style scoped>
.book-select {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.book-open {
  width: 150px;
  background-color: #4caf50;
  border: none;
  color: white;
  padding: 10px 0;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 2px 20px;
  cursor: pointer;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.book-open:hover {
  background-color: #36783a;
}

.favorite {
  width: 150px;
  background-color: #4c8caf;
  border: none;
  color: white;
  padding: 10px 0;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 2px 20px;
  cursor: pointer;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.favorite:hover {
  background-color: #365d78;
}
.book-delete {
  width: 150px;
  background-color: #af4c4c;
  border: none;
  color: white;
  padding: 10px 0;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 2px 20px;
  cursor: pointer;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.book-delete:hover {
  background-color: #783636;
}

.book-title {
  text-align: center;
  color: #333;
}

@media screen and (max-width: 1400px) {
  .book-select {
    display: flex;
    justify-content: center;
    margin-top: 20px;
  }
  .book-open {
    padding: 10px 0;
    margin: 2px 5px;
  }
  .favorite {
    padding: 10px 0;
    margin: 2px 5px;
  }
  .book-delete {
    padding: 10px 0;
    margin: 2px 5px;
  }
}
/*タブレット(1024px以下)*/
@media screen and (max-width: 1024px) {
  .popup-content {
    width: 60%;
  }
}

/*タブレット(768px以下)*/
@media screen and (max-width: 768px) {
  .popup-content {
    width: 80%;
  }
}

/*スマホ(480px以下)*/
@media screen and (max-width: 480px) {
  .popup-content {
    padding: 20px;
  }
  .book-open {
    margin: 5px 0;
  }
  .favorite {
    margin: 5px 0;
  }
  .book-delete {
    margin: 5px 0;
  }
  .book-select {
    flex-direction: column;
  }
  .book-open {
    width: 100%;
  }
  .favorite {
    width: 100%;
  }
  .book-delete {
    width: 100%;
  }
}
</style>