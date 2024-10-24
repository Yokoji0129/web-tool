<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';

interface BookData {
  bookBackColor: string
}

const props = defineProps<{
  bookData: BookData,
  selectedBackColor?: string,
}>();

const emit = defineEmits(['update:selectedBackColor'])

interface BackgroundColor {
  id: string;
  class: string;
}

//背景カラーの選択肢
const backgroundColors: BackgroundColor[] = [
  { id: "日記デザイン(1)", class: "book-backnumber-1" },
  { id: "日記デザイン(2)", class: "book-backnumber-2" },
  { id: "日記デザイン(3)", class: "book-backnumber-3" },
  { id: "日記デザイン(4)", class: "book-backnumber-4" },
  { id: "日記デザイン(5)", class: "book-backnumber-5" },
  { id: "日記デザイン(6)", class: "book-backnumber-6" },
  { id: "日記デザイン(7)", class: "book-backnumber-7" },
  { id: "日記デザイン(8)", class: "book-backnumber-8" },
  { id: "日記デザイン(9)", class: "book-backnumber-9" },
  { id: "日記デザイン(10)", class: "book-backnumber-10" },
];

//本のイメージclass取得(日記作成ポップアップでの見本)
const bookBackColorSelect = () => {
  const selectedColor = props.bookData.bookBackColor;
  emit('update:selectedBackColor', selectedColor);
  console.log(selectedColor)
};
</script>

<template>
  <select v-model="bookData.bookBackColor" class="color-select" @change="bookBackColorSelect">
    <option value="">日記背景デザイン</option>
    <option v-for="(backColor, index) in backgroundColors" :key="index" :value="backColor.class">
      {{ backColor.id }}
    </option>
  </select>
</template>

<style scoped></style>