<script setup lang="ts">
import { useRoute } from "vue-router";
import { ref, onMounted, reactive } from "vue";
import BurgerMenu from "../components/diary/BurgerMenu.vue";
import PageOperation from "../components/diary/PageOperation.vue";
import PageMove from "../components/diary/PageMove.vue";
import LoadingScreen from "../components/LoadingScreen.vue";
import axios from "axios";
const isLoading = ref<boolean>(false)

//日記を開くときに渡される日記ID
const diaryId = ref<string | undefined>(
  localStorage.getItem("diaryId") || undefined
);

//日記を開くときに渡される日記index
const selectBookNumber = ref<string | undefined>(
  //localStorageから値を取得し、もし値がない場合はundefinedをセット
  localStorage.getItem("selectBookNumber") || undefined
);

const showPopup = ref<boolean>(false); //ポップアップの表示制御フラグ

//スマホ用ページ操作表示フラグ
const showMenu = ref<boolean>(false);
//ページ操作メニュー表示()スマホ専用
const toggleMenu = (): void => {
  if (window.innerWidth <= 1024) {
    showMenu.value = !showMenu.value;
  }
};

//ポップアップの表示非表示
const togglePopup = (): void => {
  showPopup.value = !showPopup.value;
};

//タイトルを改行させないようにするメソッド
const preventNewline = (event: Event): void => {
  const target = event.target as HTMLInputElement | HTMLTextAreaElement;
  target.value = target.value.replace(/\n/g, "");
};

interface Diary {
  diary_color: string;
  diary_favorite: number;
  diary_font: string;
  diary_id: number;
  diary_name: string;
  diary_text_color: string;
  diary_top_file: string;
}
//日記の全情報入れる
const diary = ref<Diary[]>([]);
const diaryInfo = async (): Promise<void> => {
  try {
    const response = await axios.get("returndiary");
    diary.value = response.data;
    console.log(response.data)
  } catch (error) {
    console.log(error);
  }
};

/**
 * やること
 * ページ移動したときに一番上を表示させる(タブレットやスマホサイズの時)
 * ページ追加場所を指定できるようにする
 *保存しないでページ移動押した際に保存するように警告を出す
 * **/

 interface Page {
  diary_id: number;
  page_file1: string;
  page_file2: string;
  page_file3: string;
  page_file4: string;
  page_file5: string;
  page_file6: string;
  page_file_txt1: string | null;
  page_file_txt2: string | null;
  page_file_txt3: string | null;
  page_file_txt4: string | null;
  page_file_txt5: string | null;
  page_file_txt6: string | null;
  page_id: number;
  page_marker_color: string | null;
  page_title: string | null;
  page_title_color: string | null;
  page_txt1: string | null;
  page_txt2: string | null;
  page_txt_color: string | null;
}

const pages = ref<Page[]>([]); //日記ページのデータを格納する配列
const currentPageIndex = ref(0); //現在表示しているページのindex

interface PageData{
  pageTitle: string,
  pageText1: string,
  pageText2: string,
}

//ページの要素追加データ
const pageData = reactive<PageData>({
  pageTitle: "",
  pageText1: "",
  pageText2: "",
});

//ページ追加用メソッド
const pageAdd = async (): Promise<void> => {
  isLoading.value = true;

  try {
    await axios.post("/pageadd", {
      //日記ID
      id: diaryId.value,
      //タイトル文字色
      title_color: "",
      //ページタイトル
      title: "",
      //文章1
      txt: "",
      //文章2
      txt2: "",
      //マーカーの色
      marker_color: "",
      //文章の文字の色
      txt_color: "",
      //画像1の文章
      file_txt1: "",
      //画像2の文章
      file_txt2: "",
      //画像3の文章
      file_txt3: "",
      //画像4の文章
      file_txt4: "",
      //画像5の文章
      file_txt5: "",
      //画像6の文章
      file_txt6: "",
    });

    alert(`${pages.value.length + 1}ページ目が追加されました`);
    displayPage();
  } catch (error) {
    console.log(error);
  } finally {
    isLoading.value = false;
  }

  showMenu.value = false;
};

//ページ表示メソッド
const displayPage = async (): Promise<void> => {
  try {
    const response = await axios.get(`/returnpage/${diaryId.value}`);
    pages.value = response.data;
    console.log(response.data)

    if (pages.value.length === 0) {
      // ページが空の場合(日記初回に開くとき)、新しいページを追加
      pageAdd();
    } else {
      currentPage();
    }
  } catch (error) {
    console.log(error);
  }
};

//ページ移動したときに表示内容変える
const currentPage = (): void => {
  //現在のページに合わせて現在のページのデータを取得
  const currentPage = pages.value[currentPageIndex.value][0];
  //取得したページのデータを表示用の変数に設定
  pageData.pageTitle = currentPage.page_title;
  pageData.pageText1 = currentPage.page_txt1;
  pageData.pageText2 = currentPage.page_txt2;
};

//ページ編集メソッド
const pageEdit = async (fileUrl: File | null = null): Promise<void> => {
  isLoading.value = true;

  try {
    console.log("送信するファイルURL:", fileUrl);  //ここでURLが渡されているか確認
    const formData = new FormData();
    formData.append("id", pages.value[currentPageIndex.value][0].page_id);
    formData.append("title_color", "");
    formData.append("title", pageData.pageTitle || "");
    formData.append("txt", pageData.pageText1 || "");
    formData.append("txt2", pageData.pageText2 || "");
    formData.append("marker_color", "");
    formData.append("txt_color", "");
    formData.append("file_txt1", "");
    formData.append("file_txt2", "");
    formData.append("file_txt3", "");
    formData.append("file_txt4", "");
    formData.append("file_txt5", "");
    formData.append("file_txt6", "");
    formData.append("file_txt4", "");
    formData.append("page_file1", fileUrl || "");

    const response = await axios.post("/edit/page", formData,
    {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });
    console.log(response.data);
    alert(`${currentPageIndex.value + 1}ページ目が保存されました`);
    toggleMenu();
    displayPage();
  } catch (error) {
    console.log(error);
  } finally {
    isLoading.value = false;
  }
};

//ここから画像処理
//ファイル選択とアップロード
const selectedFile = ref<File | null>(null);

// ファイル選択処理
const onFileSelected = (event: Event): void => {
  const target = event.target as HTMLInputElement;
  if (target.files) {
    selectedFile.value = target.files[0];
    //選択されたファイルを確認
    console.log("選択されたファイル:", selectedFile.value);
  }
};

//画像アップロード
const uploadFile = async (): Promise<void> => {
  if (selectedFile.value) {
    const formData = new FormData();
    formData.append("file", selectedFile.value);

    try {
      const response = await axios.post("/file", formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      });

      console.log("アップロード成功:", response.data);

      //サーバーが返すレスポンスが true の場合
      if (response.data === true) {
        pageEdit(selectedFile.value); //URLを渡してpageEditを実行
      } else {
        console.error("ファイルアップロードに失敗しました");
      }

      selectedFile.value = null; //アップロード後に選択されたファイルをリセット
    } catch (error) {
      console.log("アップロードエラー", error);
    }
  } else {
    alert("ファイルを選択してください。");
  }
};



onMounted(() => {
  console.log(`開いた日記のindexID(${selectBookNumber.value})`)
  diaryInfo();
  displayPage();
});
</script>

<template>
  <BurgerMenu
    :diary="diary"
    :selectBookNumber="selectBookNumber"
    :pages="pages"
    :pageData="pageData"
    @update:currentPageIndex="currentPageIndex = $event"
  />
  <PageOperation
    :pageAdd="pageAdd"
    :pageEdit="pageEdit"
    :showMenu="showMenu"
    :toggleMenu="toggleMenu"
    :pages="pages"
    :currentPageIndex="currentPageIndex"
    @update:isLoading="isLoading = $event"
    :displayPage="displayPage"
  />
  <!--ここまでスマホ用ページ操作ボタン-->
  <div class="flex-box">
    <!--左側デザイン-->
    <div class="left-contents">
      <div class="fuction-box">
        <select class="color-select">
          <option value="">マーカー色なし</option>
          <option value="">マーカー 赤</option>
          <option value="">マーカー 青</option>
          <option value="">マーカー 緑</option>
        </select>
        <select class="color-select">
          <option value="">文字色なし</option>
          <option value="">文字色 赤</option>
          <option value="">文字色 青</option>
          <option value="">文字色 緑</option>
        </select>
      </div>
      <div class="text-area">
        <div class="page-title-box">
          <textarea
            class="page-title"
            placeholder="ページタイトル"
            v-model="pageData.pageTitle"
            @input="preventNewline"
          ></textarea>
        </div>
        <textarea
          class="page-text"
          placeholder="文章1"
          v-model="pageData.pageText1"
        ></textarea>
        <textarea
          class="page-text"
          placeholder="文章2"
          v-model="pageData.pageText2"
        ></textarea>
      </div>
    </div>
    <!--右側デザイン-->
    <div class="right-contents">
      <form @submit.prevent="uploadFile" enctype="multipart/form-data">
        <div class="file-box">
          <label>
            <input type="file" name="file" @change="onFileSelected" />
            {{ selectedFile ? "画像名 : " + selectedFile.name : "写真未選択" }}
          </label>
          <button class="add-img" type="submit">写真を追加</button>
        </div>
      </form>
      <!--写真貼る場所-->
      <div class="image-box">
        <div class="image-container">
          <img class="delete-img" src="../../../public/icon/delete-img.png" />
          <img
            @click="togglePopup"
            class="image"
            src="../../../public/testImage/testImage.jpeg"
          />
        </div>
      </div>
    </div>
  </div>
  <!--ポップアップ-->
  <div v-if="showPopup" class="popup">
    <div class="popup-content-img">
      <button class="btn-close" @click="togglePopup">閉じる</button>
      <div class="popup-img">
        <img src="../../../public/testImage/testImage.jpeg" />
      </div>
      <div class="image-text">
        <textarea placeholder="コメント"></textarea>
      </div>
      <div class="keepImgText-btn">
        <button>保存</button>
      </div>
    </div>
  </div>
  <!--ページ遷移-->
  <PageMove
    @update:currentPageIndex="currentPageIndex = $event"
    :currentPageIndex="currentPageIndex"
    :pages="pages"
    :currentPage="currentPage"
  />
  <!--ローディングアニメーション-->
  <LoadingScreen :isLoading="isLoading" />
</template>

<style scoped>
.flex-box {
  display: flex;
  padding: 82px 0 0 0;
  height: 90vh;
}

.left-contents {
  width: 50%;
  background-color: rgba(74, 73, 73, 0.5);
}

.text-area {
  text-align: center;
}

.page-title {
  margin-top: 10px;
  text-align: center;
  font-size: 24px;
  width: 95%;
  padding-top: 20px;
  padding-bottom: 10px;
  resize: none;
  border: 1px solid #ced4da;
  border-radius: 5px;
}

.page-title:hover {
  border-color: #9aa0a7;
}

.page-text {
  margin-top: 20px;
  width: 93%;
  height: 32vh;
  font-size: 24px;
  line-height: 1.5;
  resize: none;
  padding: 10px;
  border: 1px solid #ced4da;
  border-radius: 5px;
}

.page-text:hover {
  border-color: #9aa0a7;
}

.left-contents textarea::selection {
  background-color: yellow;
  color: red;
}

.fuction-box {
  display: flex;
}

select {
  width: 100%;
  height: 50px;
  cursor: pointer;
}

.right-contents {
  width: 50%;
  background-color: rgba(74, 73, 73, 0.5);
  position: relative;
}

.file-box {
  margin: 12px 0;
}

label {
  padding: 12px 40% 13px 10px;
  font-size: 14px;
  border: 2px solid #ccc;
  background-color: #ffffff;
  cursor: pointer;
  transition: 0.3s;
}

label:hover {
  color: #007bff;
  border-color: #007bff;
}

input[type="file"] {
  display: none;
}

.add-img {
  font-size: 14px;
  padding: 12.7px 20px 12.7px 20px;
  border: 2px solid #ccc;
  background-color: #ffffff;
  cursor: pointer;
  transition: 0.3s;
  position: absolute;
  top: 0px;
}

.add-img:hover {
  color: #007bff;
  border-color: #007bff;
}

.image-box {
  overflow: auto;
  text-align: center;
  height: 78vh;
}

.image {
  margin: 30px auto;
  max-width: 100%;
  height: auto;
  display: block;
}

.image-container {
  position: relative;
  display: inline-block;
}

.delete-img {
  cursor: pointer;
  position: absolute;
  top: 35px;
  right: 0;
  width: 50px;
}

.popup-content-img {
  position: relative;
  width: auto;
  height: auto;
  background-color: #ffffff;
  padding: 20px;
  border-radius: 5px;
  border: 3px solid #ced4da;
  box-shadow: 7px 7px 4px rgba(0, 0, 0, 0.5);
  overflow-y: auto;
  /*スクロール可能*/
}

.popup-img img {
  max-width: 100%;
  margin: 20px 0 0 0;
}

.image-text textarea {
  padding: 5px;
  width: 97%;
  height: 60px;
  font-size: 20px;
  resize: none;
}

.keepImgText-btn {
  text-align: center;
}

.keepImgText-btn button {
  width: 100%;
  padding: 10px;
  border: none;
  background-color: #007bff;
  color: #fff;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

/**デスクトップのtextarea調整**/
@media screen and (max-width: 1980px) {
  .page-text {
    height: 25vh;
  }

  .image-box {
    height: 72vh;
  }
}

/**ノートパソコンのtextarea調整**/
@media screen and (max-width: 1600px) {
  .flex-box {
    height: 80vh;
  }

  .page-title {
    height: 4vh;
    margin-top: 0;
  }

  .page-text {
    height: 22vh;
    margin-top: 10px;
  }

  .image-box {
    height: 70vh;
  }
}

@media screen and (max-width: 1300px) {
  .page-title {
    margin-top: 0;
  }

  .page-text {
    height: 17vh;
  }
}

@media screen and (max-width: 1024px) {
  .flex-box {
    flex-direction: column;
  }

  .color-select {
    margin-bottom: 8px;
  }

  .left-contents {
    width: 100%;
  }

  .right-contents {
    width: 100%;
  }

  .page-title {
    margin-top: 10px;
  }

  .image-box {
    margin-bottom: 100px;
  }

  .popup-content-img {
    padding: 10px;
  }

  .popup-img img {
    margin: 10px 0 0 0;
  }

  .file-box {
    margin-top: 25px;
  }

  .add-img {
    padding: 12.5px 20px 12.5px 20px;
    margin-top: 13px;
  }
}

/*タブレット(768px以下)*/
@media screen and (max-width: 768px) {
  .flex-box {
    margin: -20px 0;
    flex-direction: column;
  }
}

/*スマホ(480px以下)*/
@media only screen and (max-width: 480px) {
  .page-title {
    margin: 0;
    font-size: 18px;
  }

  .page-text {
    margin-top: 5px;
    font-size: 14px;
    width: 90%;
  }

  .image {
    margin: 15px auto;
  }

  .delete-img {
    top: 20px;
  }

  label {
    padding: 12px 20px 13px 20px;
  }
}

@-moz-document url-prefix() {
  .flex-box {
    padding: 72px 0 0 0;
  }

  .file-box {
    margin: 15.5px 0 15px 0;
  }

  label {
    padding: 16px 40% 15px 10px;
    font-size: 14px;
    border: 2px solid #ccc;
    background-color: #ffffff;
    cursor: pointer;
    transition: 0.3s;
  }

  @media screen and (max-width: 1024px) {
    .file-box {
      margin-top: 30px;
    }

    .add-img {
      padding: 13px 20px 13px 20px;
      margin-top: 14px;
    }
  }

  @media screen and (max-width: 768px) {
    .flex-box {
      padding: 81.5px 0 0 0;
    }
  }
}
</style>
