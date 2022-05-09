<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Goldenhands</a>

    <div class="collapse navbar-collapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <nuxt-link class="nav-link" exact no-prefetch active-class="active" to="/">Список продуктов</nuxt-link>
        </li>
        <li class="nav-item">
          <nuxt-link class="nav-link" no-prefetch active-class="active" to="/about">О нас</nuxt-link>
        </li>
        <li class="nav-item">
          <nuxt-link class="nav-link" no-prefetch active-class="active" to="/delivery">Доставка</nuxt-link>
        </li>
        <li class="nav-item">
          <nuxt-link class="nav-link" no-prefetch active-class="active" to="/login">Логин</nuxt-link>
        </li>
      </ul>
    </div>
  </nav>
</template>
