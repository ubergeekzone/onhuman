<script>
import config from "../js/config.js";
import Airtable from "../js/airtable.js";
import Harvest from "../js/harvest.js";
import guardian from "../js/guardian.js";



export default {
  data() {
    return {
      projects: [],
      companyWebsite: config.companyWebsite,
      testCardImage: null,
      meta: {
        title: "Projects",
      },
    };
  },
  mounted() {
    var __this = this;

    var harvest = new Harvest(config.onHumanHarvestCompanyID);

    harvest.projects(function (projects) {
      if (projects.status !== 404) {
        var airtable = new Airtable(config.hostname.split(".")[0]);

        airtable.projects(30533260, function (projects) {
          console.log(projects.data.records[0].fields["Project Image"][0].url);
          __this.testCardImage =
            projects.data.records[0].fields["Project Image"][0].url;
          console.log(projects);
        });

        __this.projects = projects.data.projects;
        __this.totalRecords = projects.data.total_entries;
      }
    });
  },
  beforeRouteEnter: (to, from, next) => {
    config.loading = true;
    guardian.guard(to, from, next);
  },
};
</script>

<template>
  <div>
    <h3
      class="
        text-4xl
        font-semibold
        leading-normal
        mb-5
        text-center text-gray-800
        mb-14
      "
    >
      {{ meta.title }}
    </h3>
    <div class="flex justify-center items-center flex-wrap place-items-center">
      <div class="grid md:grid-cols-4 sm:grid-cols-0 lg:grid-cols-4 gap-10">
        <!-- card -->
        <div
          v-for="project in projects"
          v-bind:key="project.id"
          class="
            shadow-lg
            rounded-xl
            lg:w-80
            md:w-64
            sm:w-80
            bg-white
            relative
            overflow-hidden
          "
        >
          <a href="#">
            <img class="rounded-t-lg" :src="testCardImage" alt="" />
          </a>
          <div href="#" class="w-full p-4 h-full block">
            <div class="flex items-center border-b-2 mb-2 py-2">
              <img
                class="w-10 h-10 object-cover rounded-full"
                alt="User avatar"
                :src="`//logo.clearbit.com/${companyWebsite}`"
              />

              <div class="pl-3">
                <div class="font-medium">{{ project.client.name }}</div>
                <div class="text-gray-600 text-sm">
                  Due On {{ project.ends_on | moment("MM/D/YYYY") }}
                </div>
              </div>
            </div>
            <div class="w-full">
              <p class="text-gray-800 text-xl font-medium mb-2">
                {{ project.name }}
                <span class="text-xs text-gray-600">({{ project.id }})</span>
              </p>
              <p class="text-gray-400 text-sm mb-4">
                {{ project.notes | truncate(100, "...") }}
              </p>
            </div>
            <a
              class="
                text-white
                bg-blue-700
                hover:bg-blue-800
                focus:ring-4 focus:ring-blue-300
                font-medium
                rounded-lg
                text-sm
                px-3
                py-2
                text-center
                inline-flex
                items-center
              "
              :href="`#/projects/project/${project.id}`"
            >
              Read more
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

