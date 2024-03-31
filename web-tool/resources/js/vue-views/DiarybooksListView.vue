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
        <div class="diary">
          <h2>北海道</h2>
        </div>
        <div class="diary">
          <h2>青森</h2>
        </div>
        <div class="diary">
          <h2>秋田</h2>
        </div>
        <div class="diary">
          <h2>北海道</h2>
        </div>
        <div class="diary">
          <h2>青森</h2>
        </div>
        <div class="diary">
          <h2>秋田</h2>
        </div>
        <div class="diary">
          <h2>北海道</h2>
        </div>
        <div class="diary">
          <h2>青森</h2>
        </div>
        <div class="diary">
          <h2>秋田</h2>
        </div>
        <div class="diary">
          <h2>北海道</h2>
        </div>
        <div class="diary">
          <h2>青森</h2>
        </div>
        <div class="diary">
          <h2>秋田</h2>
        </div>
        <div class="diary">
          <h2>北海道</h2>
        </div>
        <div class="diary">
          <h2>青森</h2>
        </div>
        <div class="diary">
          <h2>秋田</h2>
        </div>
        <div class="diary">
          <h2>北海道</h2>
        </div>
        <div class="diary">
          <h2>青森</h2>
        </div>
        <div class="diary">
          <h2>秋田</h2>
        </div>
        <div class="diary">
          <h2>+</h2>
        </div>
      </div>
    </main>
  </div>
</template>
            
<style scoped>
.container {
  margin-top: 92px;
  display: flex;
  flex-direction: column;
}

.fixed-nav {
  text-align: center;
  margin-top: 92px;
  position: fixed; /* ナビゲーションメニューを固定 */
  top: 0; /* 上端に配置 */
  width: 100%; /* 幅を100%に設定 */
  background-color: #ffffff; /* 背景色を設定 */
  z-index: 999; /* 他の要素の上に重なるようにする */
}

.nav-list {
  background-color: #ffffff;
  list-style-type: none;
  padding: 0;
  margin: 0;
  display: flex;
  justify-content: space-between; /* アイテムを均等に配置 */
}

.nav-list p {
  margin: 0;
  padding: 20px;
}

.nav-item-left,
.nav-item-center,
.nav-item-right {
  flex: 1; /* 各アイテムを均等に広げる */
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
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 20px;
}

.diary {
  text-align: center;
  border: 2px solid #ccc;
  padding: 50px 0 300px 0;
  margin-top: 30px;
  background-color: #f9f9f9;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
  cursor: pointer;
}

.diary h2 {
  margin: 0;
}

/* ウィンドウ幅が700px以下の場合のnavのスタイル */
@media screen and (max-width: 700px) {
  .container {
    margin-top: 132px;
  }
  .fixed-nav {
    margin-top: 72px;
  }
  .nav-list {
    flex-direction: column;
    align-items: center; /* アイテムを中央寄せに設定 */
  }

  .nav-list p {
    padding: 10px;
  }

  .nav-item-left,
  .nav-item-center,
  .nav-item-right {
    flex: none; /* アイテムの伸縮を解除 */
    width: auto; /* オート幅に設定して、テキストの幅に合わせる */
  }
}
</style>
  