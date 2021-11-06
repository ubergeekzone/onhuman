<script>
import config from "../js/config.js";
import Airtable from "../js/airtable.js";
import Harvest from "../js/harvest.js";
import guardian from "../js/guardian.js";

function openCity(evt, cityName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].parentNode.className = tablinks[i].parentNode.className.replace(
      " -mb-px",
      ""
    );
    tablinks[i].parentNode.className = tablinks[i].parentNode.className.replace(
      " border-b-2",
      ""
    );
    tablinks[i].parentNode.className = tablinks[i].parentNode.className.replace(
      " border-blue-800",
      ""
    );
    tablinks[i].parentNode.className = tablinks[i].parentNode.className.replace(
      " opacity-100",
      ""
    );
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.parentNode.className +=
    " -mb-px border-b-2 border-blue-800 opacity-100";

  event.preventDefault();
}

export default {
  data() {
    return {
      isActive: false,
      project: {},
      task_assignments: {},
      user_assignments: {},
      time_entries: {},
      total_time_entries: {},
      project_meta: {},
      companyWebsite: null,
      invoices: {},
      expenses: {},
      meta: {
        title: "Project",
      },
    };
  },
  mounted() {
    var __this = this;

    this.isActive = this.selected;

    var harvest = new Harvest(config.onHumanHarvestCompanyID);

    var projectID = __this.$route.params.id;

    __this.companyWebsite = config.companyWebsite;

    harvest.project(projectID, function (project) {
      if (project.status !== 404) {
        var project = project;

        var airtable = new Airtable(config.hostname.split(".")[0]);

        airtable.projects(projectID, function (projects) {
          project.data.projectCardImage =
            projects.data.records[0].fields["Project Image"][0].url;
          __this.project_meta = projects.data.records[0].fields["Attachments"];
        });

        __this.project = project.data.project;
        __this.task_assignments = project.data.ProjectTaskAssignments;
        __this.user_assignments = project.data.ProjectUserAssignments;
        __this.time_entries = project.data.ProjectTimeEntries;
        __this.total_time_entries = project.data.totalTaskHours;

        harvest.invoices(
          config.onHumanHarvestCompanyID,
          projectID,
          function (invoices) {
            if (invoices.status !== 404) {
              __this.invoices = invoices.data.invoices;
              console.log(__this.invoices);
            }
          }
        );

        harvest.expenses(
          config.onHumanHarvestCompanyID,
          projectID,
          function (expenses) {
            if (expenses.status !== 404) {
              __this.expenses = expenses.data.expenses;
            }
          }
        );
      }
    });
  },
  beforeRouteEnter: (to, from, next) => {
    config.loading = true;
    guardian.guard(to, from, next);
  },
  methods: {
    selectTab(selectedTab) {
      openCity(event, selectedTab);
    },
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
        mb-4
      "
    >
      {{ project.name }}
    </h3>

    <div class="bg-white shadow overflow-hidden border sm:rounded-lg">
      <div
        class="max-h-96 h-96 bg-cover border-gray-200 border-b-1"
        style="
          background-image: url('https://dl.airtable.com/.attachments/a42d965dffafe1305f6f18593dfef4a3/2b5da1dc/10min-walk-photo.jpg');
        "
      ></div>
      <div class="px-4 py-5 w-full text-center items-center sm:px-6">
        <a
          href="#"
          title="Start Date"
          class="
            inline-block
            rounded-full
            text-white
            bg-green-500
            text-xs
            font-bold
            mr-1
            md:mr-2
            mb-2
            px-2
            md:px-4
            py-1
          "
        >
          {{ project.starts_on | moment("MM/D/YYYY") }}
        </a>

        <a
          href="#"
          title="End Date"
          class="
            inline-block
            rounded-full
            text-white
            bg-red-500
            text-xs
            font-bold
            mr-1
            md:mr-2
            mb-2
            px-2
            md:px-4
            py-1
          "
        >
          {{ project.ends_on | moment("MM/D/YYYY") }}
        </a>

        <a
          v-if="project.budget_by === 'project_cost'"
          href="#"
          title="Project Budget Type"
          class="
            inline-block
            rounded-full
            text-white
            bg-yellow-500
            text-xs
            font-bold
            mr-1
            md:mr-2
            mb-2
            px-2
            md:px-4
            py-1
          "
        >
          Total Project Fees
        </a>
        <a
          v-else-if="project.budget_by === 'project'"
          href="#"
          title="Project Budget Type"
          class="
            inline-block
            rounded-full
            text-white
            bg-yellow-500
            text-xs
            font-bold
            mr-1
            md:mr-2
            mb-2
            px-2
            md:px-4
            py-1
          "
        >
          Hours Per Project
        </a>
        <a
          v-else-if="project.budget_by === 'task'"
          href="#"
          title="Project Budget Type"
          class="
            inline-block
            rounded-full
            text-white
            bg-yellow-500
            text-xs
            font-bold
            mr-1
            md:mr-2
            mb-2
            px-2
            md:px-4
            py-1
          "
        >
          Hours Per Task
        </a>
        <a
          v-else-if="project.budget_by === 'task_fees'"
          href="#"
          title="Project Budget Type"
          class="
            inline-block
            rounded-full
            text-white
            bg-yellow-500
            text-xs
            font-bold
            mr-1
            md:mr-2
            mb-2
            px-2
            md:px-4
            py-1
          "
        >
          Fees Per Task </a
        ><a
          v-else-if="project.budget_by === 'person'"
          href="#"
          title="Project Budget Type"
          class="
            inline-block
            rounded-full
            text-white
            bg-yellow-500
            text-xs
            font-bold
            mr-1
            md:mr-2
            mb-2
            px-2
            md:px-4
            py-1
          "
        >
          Hours Per Person </a
        ><a
          v-else-if="project.budget_by === 'none'"
          href="#"
          title="Project Budget Type"
          class="
            inline-block
            rounded-full
            text-white
            bg-yellow-500
            text-xs
            font-bold
            mr-1
            md:mr-2
            mb-2
            px-2
            md:px-4
            py-1
          "
        >
          No Budget </a
        ><a
          v-else
          href="#"
          title="Project Budget Type"
          class="
            inline-block
            rounded-full
            text-white
            bg-yellow-500
            text-xs
            font-bold
            mr-1
            md:mr-2
            mb-2
            px-2
            md:px-4
            py-1
          "
        >
          No Budget
        </a>

        <a
          v-if="project.is_active"
          href="#"
          title="Project Status"
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
        >
          Active
        </a>
        <a
          v-else
          href="#"
          title="Project Status"
          class="
            inline-block
            rounded-full
            text-white
            bg-red-800
            text-xs
            font-bold
            mr-1
            md:mr-2
            mb-2
            px-2
            md:px-4
            py-1
          "
        >
          Inactive
        </a>
      </div>
      <div class="border-t border-gray-200">
        <dl>
          <div class="px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Project ID</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{ project.id }}
            </dd>
          </div>
          <div
            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6"
          >
            <dt class="text-sm font-medium text-gray-500">Project Code</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{ project.code }}
            </dd>
          </div>
          <div class="px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Project Budget</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              ${{ project.cost_budget | formatNumber }}
            </dd>
          </div>
          <div
            class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6"
          >
            <dt class="text-sm font-medium text-gray-500">
              Meet Your Project Manager
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <div v-for="pm in user_assignments" :key="pm.id">
                <div v-if="pm.is_project_manager">
                  <div class="flex mb-8 items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <img
                        :src="`${pm.meta.avatar_url}`"
                        alt=""
                        class="h-10 w-10 rounded-full"
                      />
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">
                        {{ pm.user.name }}
                      </div>
                      <div class="text-sm text-gray-500">
                        {{ pm.meta.email }}
                      </div>
                    </div>
                  </div>

                  <router-link
                    class="
                      mt-4
                      inline--block
                      p-2
                      pl-5
                      pr-5
                      bg-yellow-400
                      text-gray-800
                      rounded-lg
                      font-bold
                    "
                    :to="`/projects/${pm.project.id}/project-manager/${pm.meta.id}`"
                    >Learn More About Your Project Manager</router-link
                  >
                </div>
              </div>
            </dd>
          </div>
          <div
            class="
              bg-white
              px-4
              py-2
              pb-5
              sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6
            "
          >
            <dt class="text-sm font-medium text-gray-500">Notes</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-3">
              {{ project.notes }}
            </dd>
          </div>
        </dl>
      </div>
    </div>

    <div class="w-full mx-auto mt-4 mb-20">
      <!-- Tabs -->
      <ul id="tabs" class="inline-flex w-full px-1 pt-2">
        <li
          class="
            px-4
            py-2
            -mb-px
            font-semibold
            text-gray-800
            border-b-2 border-blue-800
            opacity-50 opacity-100
          "
        >
          <a class="tablinks" @click="selectTab('tasks')" href="#tasks"
            ><i class="fas fa-tasks pr-2"></i> Tasks</a
          >
        </li>
        <!--li class="px-4 py-2 font-semibold text-gray-800 opacity-50">
          <a href="#timesheets" class="tablinks" @click="selectTab('timesheets')"
            ><i class="far fa-clock pr-2"></i> Timesheets</a
          >
        </li>-->
        <li class="px-4 py-2 font-semibold text-gray-800 opacity-50">
          <a href="#invoices" class="tablinks" @click="selectTab('invoices')"
            ><i class="fas fa-dollar-sign pr-2"></i> Invoices</a
          >
        </li>
        <li class="px-4 py-2 font-semibold text-gray-800 opacity-50">
          <a href="#expenses" class="tablinks" @click="selectTab('expenses')"
            ><i class="fas fa-hand-holding-usd pr-2"></i> Expenses</a
          >
        </li>
        <li class="px-4 py-2 font-semibold text-gray-800 opacity-50">
          <a
            href="#attachments"
            class="tablinks"
            @click="selectTab('attachments')"
            ><i class="fas fa-paperclip pr-2"></i> Attachments</a
          >
        </li>
      </ul>

      <!-- Tab Contents -->
      <div id="tab-contents">
        <div id="tasks" class="pt-4 tabcontent">
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
                          Team
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
                          Hours
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
                          Billable
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
                          Status
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <tr
                        v-for="task in task_assignments.task_assignments"
                        v-bind:key="task.id"
                      >
                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                          {{ task.task.name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="flex items-center overflow-hidden mt-2">
                            <img
                              v-for="user in user_assignments"
                              v-bind:key="user.id"
                              class="
                                inline-block
                                h-6
                                w-6
                                rounded-full
                                text-white
                                border-2 border-white
                                object-cover object-center
                              "
                              :title="`${user.user.name}`"
                              :src="`${user.meta.avatar_url}`"
                              alt=""
                            />
                          </div>
                        </td>
                        <td
                          class="
                            px-6
                            py-4
                            whitespace-nowrap
                            text-sm text-gray-500
                          "
                        >
                          {{ total_time_entries[task.task.id] | formatNumber }}
                          hours
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <span
                            v-if="task.billable"
                            class="
                              px-2
                              inline-flex
                              text-xs
                              leading-5
                              font-semibold
                              rounded-full
                              bg-green-100
                              text-green-800
                            "
                          >
                            Yes
                          </span>
                          <span
                            v-else
                            class="
                              px-2
                              inline-flex
                              text-xs
                              leading-5
                              font-semibold
                              rounded-full
                              bg-red-100
                              text-red-800
                            "
                          >
                            No
                          </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <span
                            v-if="task.is_active"
                            class="
                              px-2
                              inline-flex
                              text-xs
                              leading-5
                              font-semibold
                              rounded-full
                              bg-green-100
                              text-green-800
                            "
                          >
                            Active
                          </span>
                          <span
                            v-else
                            class="
                              px-2
                              inline-flex
                              text-xs
                              leading-5
                              font-semibold
                              rounded-full
                              bg-red-100
                              text-red-800
                            "
                          >
                            Inactive
                          </span>
                        </td>
                      </tr>

                      <!-- More people... -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--<div id="timesheets" class="hidden p-4 tabcontent">Second tab</div>-->

        <div id="expenses" class="hidden pt-4 tabcontent">
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
                          Category
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
                          Spent Date
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
                          Total Cost
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
                          Billable
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
                          Notes
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <div class="contents w-full" v-if="expenses.length">
                        <tr v-for="expense in expenses" v-bind:key="expense.id">
                          <td class="px-6 py-4  text-sm whitespace-nowrap">
                            {{ expense.expense_category.name }}
                          </td>
                          <td class="px-6 py-4 text-sm whitespace-nowrap">
                            {{ expense.spent_date | moment("MM/D/YYYY") }}
                          </td>
                          <td class="px-6 py-4  text-sm whitespace-nowrap">
                            ${{ expense.total_cost | formatNumber }}
                          </td>
                           <td class="px-6 py-4  text-sm whitespace-nowrap">
                            <span
                            v-if="expense.billable"
                            class="
                              px-2
                              inline-flex
                              text-xs
                              leading-5
                              font-semibold
                              rounded-full
                              bg-green-100
                              text-green-800
                            "
                          >
                            Yes
                          </span>
                          <span
                            v-else
                            class="
                              px-2
                              inline-flex
                              text-xs
                              leading-5
                              font-semibold
                              rounded-full
                              bg-red-100
                              text-red-800
                            "
                          >
                            No
                          </span>
                          </td>
                          <td class="px-6 py-4  text-sm whitespace-nowrap">
                            {{ expense.notes }}
                          </td>
                        </tr>
                      </div>
                      <div v-else>
                        <tr>
                          <td class="p-5" colspan="6">
                            No Expenses Were Found
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

        <div id="invoices" class="hidden pt-4 tabcontent">
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
                          Due Date
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
                      <div class="contents w-full" v-if="invoices.length">
                        <tr v-for="invoice in invoices" v-bind:key="invoice.id">
                          <td class="px-6 py-4 text-blue-800 text-sm whitespace-nowrap">
                            <a target="_blank" class="font-bold" :href="`https://fullturnwebsolutionsllc.harvestapp.com/client/invoices/${invoice.client_key}`">#{{ invoice.id }}</a>
                          </td>
                          <td class="px-6 py-4 text-sm whitespace-nowrap">
                            {{ invoice.issue_date | moment("MM/D/YYYY") }}
                          </td>
                          <td class="px-6 py-4 text-sm whitespace-nowrap">
                             {{ invoice.due_date | moment("MM/D/YYYY") }}
                          </td>
                          <td class="px-6 py-4 text-sm whitespace-nowrap">
                             {{ invoice.state }}
                          </td>
                          <td class="px-6 py-4  text-sm whitespace-nowrap">
                            ${{ invoice.amount | formatNumber }}
                          </td>
                        </tr>
                      </div>
                      <div v-else>
                        <tr>
                          <td class="p-5" colspan="6">
                            No Invoices Were Found
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

        <div id="attachments" class="hidden pt-4 tabcontent">
          <div class="flex flex-wrap">
            <div
              class="grid md:grid-cols-4 sm:grid-cols-0 lg:grid-cols-4 gap-10"
            >
              <!-- card -->
              <div
                v-for="attachment in project_meta"
                v-bind:key="attachment.id"
                class="
                  shadow-lg
                  rounded-xl
                  lg:w-80
                  md:w-64
                  sm:w-80
                  bg-white
                  relative
                  overflow-hidden
                  border
                "
              >
                <div class="overflow-hidden h-40 border-b">
                  <img
                    class="rounded-t-lg"
                    :src="attachment.thumbnails.large.url"
                    alt=""
                  />
                </div>
                <div href="#" class="w-full p-4 h-full block">
                  <div class="flex items-center border-b-2 mb-2 py-2">
                    <img
                      class="w-10 h-10 object-cover rounded-full"
                      :alt="companyWebsite"
                      :src="`//logo.clearbit.com/${companyWebsite}`"
                    />

                    <div class="pl-3">
                      <div class="font-medium">{{ project.client.name }}</div>
                      <div class="text-gray-600 text-sm">
                        File ID: {{ attachment.id }}
                      </div>
                    </div>
                  </div>
                  <div class="w-full">
                    <p class="text-gray-800 text-xl font-medium mb-2">
                      {{ attachment.filename }}
                    </p>
                  </div>
                  <a
                    target="_blank"
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
                      mt-2
                    "
                    :href="`${attachment.url}`"
                  >
                    Download Attachment
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

