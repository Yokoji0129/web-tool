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
p {
  margin: 0;
}

.header {
  background-color: #f8f9fa;
  border-bottom: 1px solid #ced4da;
  padding: 20px 0;
  text-align: center;
  position: fixed; 
  top: 0; 
  left: 0; 
  width: 100%;
  z-index: 99;
}

.header-title {
  margin: 0;
  font-size: 2rem;
  font-family: "Georgia", serif;
  color: #2f3439;
}

.footer {
  text-align: center;
  background-color: #5a646d;
  color: #ffffff;
  padding: 20px;
  text-align: center;
  position: fixed;
  left: 0; 
  bottom: 0;
  width: 100%;
  z-index: 999; 
  font-family: "Georgia", serif;
}

/* ウィンドウ幅が750px以下の場合のヘッダーのスタイル */
@media screen and (max-width: 768px) {
  .header {
    padding: 5px 0;
  }
  .footer {
    padding: 5px;
  }
}

/**firefox用のデザイン**/
@-moz-document url-prefix() {
  @media screen and (max-width: 768px) {
    .header {
      padding: 10px 0;
    }
  }
}
</style>
