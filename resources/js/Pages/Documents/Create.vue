<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Transaction
      </h2>
    </template>
    <div class="">
      <form @submit.prevent="submit">
        <div class="p-2 mr-2 mb-2 ml-6 flex flex-wrap">
          <label class="w-28 inline-block text-right mr-4">Reference:</label>
          <select v-model="form.ref" class="rounded-md w-65">
            <option
              v-for="account in accounts"
              :key="account.id"
              :value="account.id"
            >
              {{ account.ref }}
            </option>
          </select>
        </div>

        <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
          <label class="w-28 inline-block text-right mr-4">Date:</label>
          <datepicker
            v-model="form.date"
            class="pr-2 pb-2 w-44 rounded-md leading-tight"
            label="received"
          />
          <div v-if="errors.date">{{ errors.date }}</div>
        </div>
        <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
          <label class="w-28 inline-block text-right mr-4">Description:</label>
          <input
            type="text"
            v-model="form.description"
            class="pr-2 pb-2 w-full lg:w-1/4 rounded-md leading-tight"
            label="description"
          />
          <div v-if="errors.description">{{ errors.description }}</div>
        </div>

        <div class="p-2 mr-2 mb-2 ml-6 flex flex-wrap">
          <label class="w-28 inline-block text-right mr-4">Company:</label>
          <select v-model="form.company_id" class="rounded-md w-65">
            <option
              v-for="account in companies"
              :key="account.id"
              :value="account.id"
            >
              {{ account.name }}
            </option>
          </select>
        </div>

        <div class="panel-body">
          <button
            class="border bg-indigo-300 rounded-xl px-4 py-2 m-4"
            @click.prevent="addRow"
          >
            Add row
          </button>
          <div v-if="isError">{{ firstError }}</div>
          <table class="table border">
            <thead class="">
              <tr>
                <th>Account Group</th>
                <th>Debit</th>
                <th>Credit</th>
                <!-- <th>Company</th>
                <th>Account</th>
                <th>Year</th> -->
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(balance, index) in form.balances" :key="balance.id">
                <td>
                  <select v-model="balance.type_id" class="rounded-md w-36">
                    <option
                      v-for="account in groups"
                      :key="account.id"
                      :value="account.id"
                    >
                      {{ account.name }}
                    </option>
                  </select>
                </td>

                <td>
                  <input
                    v-model="balance.debit"
                    type="text"
                    class="rounded-md w-36"
                  />
                </td>
                <td>
                  <input
                    v-model="balance.credit"
                    type="text"
                    class="rounded-md w-36"
                  />
                </td>
                <button
                  @click.prevent="deleteRow(index)"
                  class="border bg-indigo-300 rounded-xl px-4 py-2 m-4"
                >
                  Delete
                </button>
              </tr>
            </tbody>
          </table>
        </div>
        <div
          class="px-4 py-2 bg-gray-100 border-t border-gray-200 flex justify-start items-center"
        >
          <button
            class="border bg-indigo-300 rounded-xl px-4 py-2 ml-4 mt-4"
            type="submit"
          >
            Create Balance
          </button>
        </div>

        <div
          class="px-4 py-2 bg-gray-100 border-t border-gray-200 flex justify-start items-center"
        >
          <!-- <button
            class="border bg-indigo-300 rounded-xl px-4 py-2 ml-4 mt-4"
            type="submit"
          >
            Create Transaction
          </button> -->
          <!-- <button
            class="border bg-indigo-300 rounded-xl px-4 py-2 ml-4 mt-4"
            type="submit"
          >
            Cancel
          </button> -->
          <!-- <button
            class="border bg-indigo-300 rounded-xl px-4 py-2 ml-4 mt-4"
            type="submit"
          >
            Add Row
          </button> -->
          <!-- <div class="ml-4 mt-4" v-if="errors.name">
            {{ errors.name }}
          </div> -->
        </div>
      </form>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Datepicker from "vue3-datepicker";
import format from "date-fns/format";

export default {
  components: {
    AppLayout,
    Datepicker,
  },

  props: {
    errors: Object,
    accounts: Object,
    companies: Object,
    comp_first: Object,
    groups: Object,
    group_first: Object,
    // documents: Object,
    // doc_first: Object,
  },

  data() {
    return {
      form: this.$inertia.form({
        date: "",
        discription: "",
        ref: this.accounts[0].id,
        company_id: this.comp_first.id,
        balances: [
          {
            type_id: this.group_first.id,
            debit: "",
            credit: "",
          },
        ],
      }),
      isError: false,
      firstError: "",
    };
  },
  watch: {
    errors: function () {
      if (this.errors) {
        this.firstError = this.errors[Object.keys(this.errors)[0]];
        this.isError = true;
      }
    },
  },

  methods: {
    submit() {
      this.$inertia.post(route("doucments.store"), this.form);
    },
    addRow() {
      this.form.balances.push({
        type_id: this.group_first.name,
        debit: "",
        credit: "",
        // company_id: "",
        // account_id: this.accounts[0].id,
        // year_id: "",
      });
    },
    deleteRow(index) {
      this.form.balances.splice(index, 1);
    },
    doFormat($item) {
      var $i = format($item, "yyyy-MM-dd");
      return $i;
    },
  },
};
</script>
