<script>
import config from "../js/config.js";
import Harvest from "../js/harvest.js";
import guardian from "../js/guardian.js"

export default {
  data() {
    return {
      estimates: {},
      meta: {
        title: "Estimates"
      }
    }
  },
  mounted() {

      var __this = this;
      var harvest = new Harvest(config.onHumanHarvestCompanyID);
    

      harvest.estimates(config.onHumanHarvestCompanyID, function (estimates) {
        if (estimates.status !== 404) {
          __this.estimates = estimates.data.estimates;
        }
      })

  },
    beforeRouteEnter: (to, from, next) => {
    config.loading = true;
    guardian.guard(to, from, next);
  }
}
</script>

<template>
  <div>
          <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 mt-2 lg:-mx-8">
              <div class="align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div
                  class="
                    shadow
                    overflow-hidden
                    border-l border-r border-b
                    rounded
                    border-gray-200
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
                          ID
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
                          Issue Date
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
                          Current State
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
                          Total Amount
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <div class="contents w-full" v-if="estimates.length">
                        <tr v-for="estimate in estimates" v-bind:key="estimate.id">
                          <td class="px-6 py-4 text-blue-800 text-sm whitespace-nowrap">
                            <a target="_blank" class="font-bold" :href="`https://fullturnwebsolutionsllc.harvestapp.com/client/estimates/${estimate.client_key}`">#{{ estimate.number }}</a>
                          </td>
                          <td class="px-6 py-4 text-sm whitespace-nowrap">
                            {{ estimate.issue_date | moment("MM/D/YYYY") }}
                          </td>
                          <td class="px-6 py-4 text-sm whitespace-nowrap">
                             {{ estimate.state }}
                          </td>
                          <td class="px-6 py-4  text-sm whitespace-nowrap">
                            ${{ estimate.amount | formatNumber }}
                          </td>
                        </tr>
                      </div>
                      <div v-else>
                        <tr>
                          <td class="p-5" colspan="6">
                            No Estimates Were Found
                          </td>
                        </tr>
                      </div>
                      <!-- More people... -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
  </div>
</template>