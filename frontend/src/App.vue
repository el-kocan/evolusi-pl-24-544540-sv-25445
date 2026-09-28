<script setup>
import { RouterLink, RouterView } from 'vue-router';
</script>

<template>
  <header class="site-header">
    <div class="container navigation">
      <RouterLink
        class="brand"
        to="/"
      >
        Tugas Praktikum
      </RouterLink>
      <nav>
        <RouterLink to="/">
          Daftar tugas
        </RouterLink>
        <RouterLink to="/tentang">
          Tentang
        </RouterLink>
      </nav>
    </div>
  </header>
  <main class="container">
    <RouterView />
  </main>
</template>
