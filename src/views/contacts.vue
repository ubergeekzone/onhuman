<script>
import config from "../js/config.js";
import Harvest from "../js/harvest.js";
import guardian from "../js/guardian.js";

export default {
  data: () => ({
    contacts: [],
    companyWebsite: config.companyWebsite,
    currentSort: "name",
    currentSortDir: "asc",
    pageSize: 100,
    currentPage: 1,
    totalRecords: 0
  }),
  mounted() {
    var __this = this;

    var harvest = new Harvest(config.onHumanHarvestCompanyID);

    harvest.contacts(function (contacts) {
      if (contacts.status !== 404) {
        __this.contacts = contacts.data.contacts;
        __this.totalRecords = contacts.data.total_entries
      }
    });
  },
  computed: {
    sortedContacts: function () {
      return this.contacts
        .sort((a, b) => {
          let modifier = 1;
          if (this.currentSortDir === "desc") modifier = -1;
          if (a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
          if (a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
          return 0;
        })
        .filter((row, index) => {
          let start = (this.currentPage - 1) * this.pageSize;
          let end = this.currentPage * this.pageSize;
          if (index >= start && index < end) return true;
        });
    },
  },
  methods: {
    nextPage: function () {
      if (this.currentPage * this.pageSize < this.contacts.length)
        this.currentPage++;
    },
    prevPage: function () {
      if (this.currentPage > 1) this.currentPage--;
    },
  },
  beforeRouteEnter: (to, from, next) => {
    config.loading = true;
    guardian.guard(to, from, next);
  },
};
</script>

<template>
  <div>
    <h3 class="text-4xl font-bold text-gray-700 tracking-wide mb-4">
      Contacts
    </h3>

    <div class="flex flex-col">
      <div class="overflow-x-auto sm:-mx-6 mt-2 lg:-mx-8">
        <div class="align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div
            class="
              shadow
              overflow-hidden
              border-l border-r border-b border-gray-200
            "
          >
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th
                    scope="col"
                    class="
                      px-6
                      py-3
                      bg-blue-800
                      text-left text-xs
                      font-medium
                      text-white
                      uppercase
                      tracking-wider
                    "
                  >
                    Name
                  </th>
                  <th
                    scope="col"
                    class="
                      px-6
                      py-3
                      bg-blue-800
                      text-left text-xs
                      font-medium
                      text-white
                      uppercase
                      tracking-wider
                    "
                  >
                    Title
                  </th>
                  <th
                    scope="col"
                    class="
                      px-6
                      py-3
                      bg-blue-800
                      text-left text-xs
                      font-medium
                      text-white
                      uppercase
                      tracking-wider
                    "
                  >
                    Phone Office
                  </th>
                  <th
                    scope="col"
                    class="
                      px-6
                      py-3
                      bg-blue-800
                      text-left text-xs
                      font-medium
                      text-white
                      uppercase
                      tracking-wider
                    "
                  >
                    Phone Mobile
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="contact in sortedContacts" v-bind:key="contact.id">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="flex-shrink-0 h-10 w-10">
                        <img
                          class="h-10 w-10 rounded-full"
                          :src="`//logo.clearbit.com/${companyWebsite}`"
                          alt=""
                        />
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">
                          {{ contact.first_name }} {{ contact.last_name }}
                        </div>
                        <div class="text-sm text-gray-500">
                          {{ contact.email }}
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ contact.title }}</div>
                    <div class="text-sm text-gray-500">
                      {{ contact.client.name }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ contact.phone_office }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ contact.phone_mobile }}
                  </td>
                </tr>

                <!-- More people... -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div
      class="
        bg-white
        p-6
        py-3
        flex
        items-center
        justify-between
        border-b border-l border-r border-gray-200
        sm:rounded-lg
        shadow
      "
    >
      <div class="flex-1 flex justify-between sm:hidden">
        <a
          href="#"
          class="
            relative
            inline-flex
            items-center
            px-4
            py-2
            border border-gray-300
            text-sm
            font-medium
            rounded-md
            text-gray-700
            bg-white
            hover:bg-gray-50
          "
        >
          Previous
        </a>
        <a
          href="#"
          class="
            ml-3
            relative
            inline-flex
            items-center
            px-4
            py-2
            border border-gray-300
            text-sm
            font-medium
            rounded-md
            text-gray-700
            bg-white
            hover:bg-gray-50
          "
        >
          Next
        </a>
      </div>
      <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
          <p class="text-sm text-gray-700">
            Total
            <span class="font-medium">{{totalRecords}}</span>
            records
          </p>
        </div>
        <div>
              <button class="border p-2 rounded text-sm bg-blue-900 text-white" @click="prevPage">Previous</button>
    <button class="border p-2 rounded text-sm  bg-blue-900 text-white" @click="nextPage">Next</button>
        </div>
      </div>
    </div>
  </div>
</template>