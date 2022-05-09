<template>
  <section>
    <h1>Products list</h1>
    <div v-for="product in products" :key="product.id">
      <div>Название продукта: {{ product.name }}</div>
      <div>Дата создания: {{ product.created_at }}</div>
      <div>Дата обновления: {{ product.updated_at }}</div>
      <div>Цена: {{ product.config.price }}</div>
      <div>Описание: {{ product.config.description }}</div>
      <br />
    </div>
  </section>
</template>

<script>
export default {
  async mounted() {
    const token = getCookie('Token');
    this.products = await this.$axios.$get('/v1/products' + '?token=' + token).catch(function (e) {
      console.log(e);
    })
  },
  data: () => ({
    products: []
  })
}


</script>
