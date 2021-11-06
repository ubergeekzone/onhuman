<template>
  <div>
    <div class="bg-white border shadow overflow-hidden sm:rounded-lg">
      <div class="px-4 py-5 sm:px-6">
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
          <div class="flex items-center">
            <div class="flex-shrink-0 h-10 w-10">
              <img :src="`//logo.clearbit.com/${companyWebsite}`" class="h-10 w-10 rounded-full" />
            </div>
            <div class="ml-4">
              <div class="text-sm font-medium text-gray-900">
                {{ $auth.user.name }}
              </div>
              <div class="text-sm text-gray-500">
                {{ contact.email }}
              </div>
            </div>
          </div>
        </dd>
      </div>
      <div class="border-t border-gray-200">
        <dl>
                    <div
            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
          >
            <dt class="text-sm font-medium text-gray-500">Company Name</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{ contact.client.name }} 
            </dd>
          </div>
                    <div
            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
          >
            <dt class="text-sm font-medium text-gray-500">Company Address</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{ companyAddress }} 
            </dd>
          </div>
          <div
            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
          >
            <dt class="text-sm font-medium text-gray-500">Full name</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{ contact.first_name }} {{ contact.last_name }}
            </dd>
          </div>
          <div
            class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
          >
            <dt class="text-sm font-medium text-gray-500">Title</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{ contact.title }}
            </dd>
          </div>
          <div
            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
          >
            <dt class="text-sm font-medium text-gray-500">Email address</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{ contact.email }}
            </dd>
          </div>
          <div
            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
          >
            <dt class="text-sm font-medium text-gray-500">Office Phone</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{ contact.phone_office }}
            </dd>
          </div>
          <div
            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
          >
            <dt class="text-sm font-medium text-gray-500">Mobile Phone</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{ contact.phone_mobile }}
            </dd>
          </div>
          <div
            class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
          >
            <dt class="text-sm font-medium text-gray-500">
              Harvest Company ID
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{ $auth.user["https://neboagecy.localhost/harvestCompanyID"] }}
            </dd>
          </div>
          <div
            class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
          >
            <dt class="text-sm font-medium text-gray-500">
              Harvest Contact ID
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{ $auth.user["https://neboagecy.localhost/harvestContactID"] }}
            </dd>
          </div>
        </dl>
      </div>
    </div>

    <p class="mt-10 text-center">
      if you need to update your contact information, please contact your
      project manager.
    </p>
  </div>
</template>

<script>
import config from "../js/config.js";
import Harvest from "../js/harvest.js";
import guardian from "../js/guardian.js";

export default {
  data: () => ({
    contact: {},
    companyAddress: null,
    companyWebsite: config.companyWebsite,
  }),
  mounted() {
    var __this = this;
    var harvest = new Harvest();

    harvest.contact(
      this.$auth.user["https://neboagecy.localhost/harvestContactID"],
      function (contact_data) {
        if (contact_data.status !== 404) {
          __this.contact = contact_data.data;
          __this.companyAddress = config.companyAddress;
          __this.companyWebsite = config.companyWebsite;
        }
      }
    );
  },
  methods: {},
  beforeRouteEnter: (to, from, next) => {
    config.loading = true;
    guardian.guard(to, from, next);
  },
};
</script>
