<script>
import config from "../js/config.js";
import guardian from "../js/guardian.js";

export default {
  data() {
    return {
      greeting: "Hello World!",
      prefix: config.hostname.split(".")[0],
      meta: {
        title: "Dashboard",
      },
    };
  },
  beforeRouteEnter: (to, from, next) => {
    config.loading = true;
    guardian.guard(to, from, next);
  }
};
</script>

<template>
  <div>
    <div class="w-full" v-if="$auth.isAuthenticated">
      <div
        class="
          coding
          shadow
          inverse-toggle
          px-5
          pt-4
          shadow-lg
          text-gray-100 text-sm
          font-mono
          subpixel-antialiased
          bg-blue-800
          pb-6
          pt-4
          rounded-lg
          leading-normal
          overflow-hidden
        "
      >
        <div class="top mb-2 flex">
          <div class="h-3 w-3 bg-red-500 rounded-full"></div>
          <div class="ml-2 h-3 w-3 bg-yellow-500 rounded-full"></div>
          <div class="ml-2 h-3 w-3 bg-green-500 rounded-full"></div>
        </div>
        <div class="mt-4 flex">
          <span class="text-yellow-400">{{ prefix }}:~$</span>
          <p class="flex-1 typing items-center pl-2">
            Welcome back to your On Human experience
            <br />
          </p>
        </div>
      </div>
    </div>
    <div
      class="flex justify-center items-center flex-wrap place-items-center"
      v-if="$auth.isAuthenticated"
    >
    

        <div class="bg-white mt-5">
          <h3 class="text-4xl font-bold text-gray-700 tracking-wide mb-4">
            Dashboard
          </h3>
          
          Welcome back to your On Human experience. This is your hub for our agency here you can see and view projects, estimates, invoices, and project attachments. 
          Here you can keep track of what is going on with your projects day-to-day! 
          <br><br>
          We'll use this space to inform you about new features and changes to our platform. Thanks for powering your business with On Human.



        
        </div>
    </div>
  </div>
</template>