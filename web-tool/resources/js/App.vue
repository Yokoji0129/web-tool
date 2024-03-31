<template>
  <div>
    <header class="header">
        <h1 class="header-title">旅行日記</h1>
    </header>
    <RouterView />
    <footer class="footer">
      <p>&copy; 2024 旅行日記</p>
    </footer>
  </div>
</template>

<style scoped>
p{
  margin: 0;
}
/* ヘッダーのスタイル */
.header {
  background-color: #f8f9fa;
  border-bottom: 1px solid #ced4da;
  padding: 20px;
  text-align: center;
  position: fixed; /* ヘッダーを固定 */
  top: 0; /* 上端に配置 */
  left: 0; /* 左端に配置 */
  width: 100%; /* 幅を100%に設定 */
  z-index: 999; /* 他の要素の上に重なるようにする */
}

.header-title {
  margin: 0;
  font-size: 2rem;
  font-family: "Georgia", serif;
  color: #2f3439;
}

.footer {
  background-color: #5a646d;
  color: #ffffff;
  padding: 20px;
  text-align: center;
  position: fixed; /* フッターを固定 */
  left: 0; /* 左端に配置 */
  bottom: 0; /* 下端に配置 */
  width: 100%; /* 幅を100%に設定 */
  z-index: 999; /* 他の要素の上に重なるようにする */
}

/* ウィンドウ幅が750px以下の場合のヘッダーのスタイル */
@media screen and (max-width: 700px) {
  .header {
    padding: 10px;
  }
  .footer {
    padding: 5px;
  }
}
</style>
