<script>
export default {
  data() {
    return {
      meta: {
        title: "Service Down"
      }
    }
  },
  mounted() {
            var loader = document.getElementById("loader-overlay");
            loader.style.display = "none";
  }
}
</script>

<template>
  <div class="text-center">
    <div class="mb-5 text-center text-gray-800 pb-10 text-3xl">We are sorry but the service is currently down.</div>
    <router-link class="lg:p-4 py-3 px-0 mt-5 bg-blue-800 text-white border rounded hover:border-indigo-400" to="/dashboard"><span>Click Here To Check If Service Is Back Up</span></router-link>
  </div>
</template>