<script>
import config from "../js/config.js";
import Airtable from "../js/airtable.js";
import Harvest from "../js/harvest.js";
import guardian from "../js/guardian.js";

export default {
  data() {
    return {
      user: {},
      userMeta: {},
      meta: {
        title: "User Profile",
      },
    };
  },
  mounted() {
    var __this = this;

    var harvest = new Harvest(config.onHumanHarvestCompanyID);

    //var projectID = __this.$route.params.project_id;
    var userID = __this.$route.params.id;

    harvest.user(userID, function (user) {
      if (user.status !== 404) {
        __this.user = user.data;
        var airtable = new Airtable(config.hostname.split(".")[0]);

        airtable.teamMembers(userID, function (teamMember) {
          __this.userMeta = teamMember.data.records[0].fields;
          console.log(teamMember);
        });
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
    <div class="bg-white relative border mt-60">
      <div class="flex relative flex-wrap justify-center">
        <div class="w-full lg:w-3/12 px-4 lg:order-2 flex justify-center">
          <div class="relative w-40">
            <img
              :alt="`${user.first_name} ${user.last_name}`"
              :src="`${user.avatar_url}`"
              class="
                shadow-xl
                rounded-full
                h-auto
                align-middle
                border-none
                absolute
                -mt-20
                lg:-mt-20
                max-w-150-px
              "
            />
          </div>
        </div>
        <div
          class="w-full lg:w-4/12 px-4 lg:order-3 lg:text-right lg:self-center"
        >
          <div
            class="
              py-6
              px-3
              mt-32
              text-center
              lg:text-right
              items-center
              sm:mt-0
            "
          >
            <a
              title="View My LinkedIn Profile"
              target="_blank"
              class="
                bg-blue-800
                active:bg-pink-600
                uppercase
                text-white
                font-bold
                hover:shadow-md
                shadow
                text-xs
                px-4
                py-2
                rounded
                outline-none
                focus:outline-none
                sm:mr-2
                mb-1
                ease-linear
                transition-all
                duration-150
              "
              :href="`${userMeta['LinkedIn Profile URL']}`"
            >
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </div>
        <div class="w-full lg:w-4/12 px-4 lg:order-1">
          <div class="flex justify-center py-4 lg:pt-4 pt-8">
            <h3
              class="
                text-4xl
                font-semibold
                leading-normal
                mb-2
                text-blueGray-700
                mb-2
              "
            >
              Hello, I'm {{ user.first_name }}
            </h3>
          </div>
        </div>
      </div>

      <div class="border-t border-gray-200">
        <dl>
          <div
            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
          >
            <dt class="text-sm font-medium text-gray-500">Full name</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{ user.first_name }} {{ user.last_name }} <span class="text-xs">({{userMeta['Pronouns']}})</span>
            </dd>
          </div>
          <div
            class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
          >
            <dt class="text-sm font-medium text-gray-500">Roles</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <div
                class="
                  inline-block
                  rounded-full
                  text-white
                  bg-blue-800
                  text-xs
                  font-bold
                  mr-1
                  md:mr-2
                  mb-2
                  px-2
                  md:px-4
                  py-1
                "
                v-for="(role, index) in user.roles"
                :key="`role-${index}`"
              >
                {{ role }}
              </div>
            </dd>
          </div>
          <div
            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
          >
            <dt class="text-sm font-medium text-gray-500">Email address</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <a :href="`${user.email}`">{{ user.email }}</a>
            </dd>
          </div>
          <div
            class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
          >
            <dt class="text-sm font-medium text-gray-500">Timezone</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{ user.timezone }}
            </dd>
          </div>
          <div
            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
          >
            <dt class="text-sm font-medium text-gray-500">About</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <span
                v-for="(line, lineNumber) of userMeta['Bio'].split('\n')"
                v-bind:key="lineNumber"
              >
                {{ line }}<br />
              </span>
            </dd>
          </div>
        </dl>
      </div>
    </div>
  </div>
</template>