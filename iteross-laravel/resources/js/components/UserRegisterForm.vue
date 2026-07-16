<script setup>
import { computed } from 'vue';
import { useAuthFormStore } from '@/stores/authFormStore';

const props = defineProps({
    action: { type: String, required: true },
    csrf: { type: String, required: true },
    errors: { type: Object, default: () => ({}) },
});

const store = useAuthFormStore();
const emailError = computed(() => props.errors.email?.[0] || '');
const passwordError = computed(() => props.errors.password?.[0] || '');
</script>

<template>
  <form :action="action" method="POST">
    <input type="hidden" name="_token" :value="csrf">

    <div class="field">
      <label>ИМЯ</label>
      <input v-model="store.first_name" required name="first_name" placeholder="Иван">
    </div>
    <div class="field">
      <label>ФАМИЛИЯ</label>
      <input v-model="store.last_name" required name="last_name" placeholder="Иванов">
    </div>
    <div class="field">
      <label>КОМПАНИЯ</label>
      <input v-model="store.company_name" required name="company_name" placeholder='ООО "Компания"'>
    </div>
    <div class="field">
      <label>ПОЧТА</label>
      <input v-model="store.email" required type="email" name="email" placeholder="you@company.ru">
    </div>
    <div class="field">
      <label>НОМЕР ТЕЛЕФОНА</label>
      <input v-model="store.phone" required name="phone" placeholder="+7 (___) ___-__-__">
    </div>
    <div class="field">
      <label>ПАРОЛЬ</label>
      <input v-model="store.password" required type="password" name="password" placeholder="Минимум 8 символов">
    </div>
    <div class="field" style="margin-bottom: 28px;">
      <label>ПОВТОРИТЕ ПАРОЛЬ</label>
      <input v-model="store.password_confirmation" required type="password" name="password_confirmation" placeholder="Повторите пароль">
    </div>

    <div v-if="emailError" class="error-box">{{ emailError }}</div>
    <div v-if="passwordError" class="error-box">{{ passwordError }}</div>

    <button type="submit" class="button-primary">Зарегистрироваться</button>
  </form>
</template>
