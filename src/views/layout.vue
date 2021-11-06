<template>
<div  class="flex-grow">
  <div class="antialiased bg-white border-b">
      <div class="container mx-auto">
    <header class="px-3 bg-white flex flex-wrap w-full items-center lg:py-0 py-2">
      <div class="flex-1 pt-5 pb-5  flex justify-between  items-center">
        <router-link to="/dashboard">
       <img src="dist/assets/images/onhuman-logo.png" class="w-56"> 
      </router-link>
    </div>
     <label for="menu-toggle" class="pointer-cursor lg:hidden block"><svg class="fill-current text-gray-900" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><title>menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path></svg></label>
    <input class="hidden" type="checkbox" id="menu-toggle" />
    <div class="hidden lg:flex lg:items-center lg:w-auto w-full" id="menu">
      <nav>
      <ul class="lg:flex items-center justify-between text-base text-gray-700 pt-4 lg:pt-0">
        <li><router-link v-if="$auth.isAuthenticated" class="lg:p-4 py-3 px-0 block border-b-2 border-transparent hover:border-indigo-400" to="/dashboard">Dashboard</router-link>
        <li><router-link v-if="$auth.isAuthenticated" class="lg:p-4 py-3 px-0 block border-b-2 border-transparent hover:border-indigo-400" to="/projects">Projects</router-link></li>
        <li><router-link v-if="$auth.isAuthenticated" class="lg:p-4 py-3 px-0 block border-b-2 border-transparent hover:border-indigo-400" to="/estimates">Estimates</router-link></li>
        <li><router-link v-if="$auth.isAuthenticated" class="lg:p-4 py-3 px-0 block border-b-2 border-transparent hover:border-indigo-400" to="/contacts">Contacts</router-link></li>
        <li><router-link v-if="$auth.isAuthenticated" class="lg:p-4 py-3 px-0 block border-b-2 border-transparent hover:border-indigo-400" to="/profile">Profile</router-link></li>
        <li><router-link v-if="$auth.isAuthenticated" class="lg:p-4 py-3 px-0 block border-b-2 border-transparent hover:border-indigo-400" to="/"><span @click="logout">Logout</span></router-link></li>
        <li><router-link v-if="!$auth.isAuthenticated" class="lg:p-4 py-3 px-0 block border-b-2 border-transparent hover:border-indigo-400" to="/"><span @click="login">Login</span></router-link></li>
      </ul>
      </nav>
    </div>
    </header>
   </div>
    </div>

    <div class="container px-3 mt-16 mx-auto">
      
  <div wire:loading id="loader-overlay" class="fixed loader-overlay top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-black opacity-90 flex flex-col items-center justify-center">
    <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
    <h2 class="text-center text-white text-xl font-semibold">Loading...</h2>
    <p class="w-1/3 text-center text-white">This may take a few seconds, please don't close this page.</p>
  </div>
      <router-view></router-view>
      </div>
</div>
</template>
<script>
  export default {
    methods: {
      // Log the user in
      login() {
        this.$auth.loginWithRedirect();
      },
      // Log the user out
      logout() {
        this.$auth.logout({
          returnTo: window.location.origin
        });
      }
    }
  }
</script>