<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Transaction
      </h2>
    </template>

    <div class="">
      <form @submit.prevent="submit">
        <!-- <div class="p-2 mr-2 mb-2 ml-6 flex flex-wrap">
          <label class="w-28 inline-block text-right mr-4">Reference:</label>
         </div> -->
        <div class="p-2 mr-2 mb-2 ml-6 flex flex-wrap">
          <label class="w-28 inline-block text-right mr-4">Reference:</label>
          <select v-model="form.type_id" class="rounded-md lg:w-1/4">
            <option v-for="type in types" :key="type.id" :value="type.id">
              {{ type.name }}
            </option>
          </select>
        </div>

        <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
          <label class="w-28 inline-block text-right mr-4"></label>
          <!-- id="type" -->
          <input
            type="text"
            v-model="form.ref"
            class="rounded-md lg:w-1/4"
            label="description"
          />
          <!-- <div v-if="errors.description">{{ errors.description }}</div> -->
        </div>

        <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
          <label class="w-28 inline-block text-right mr-4">Date:</label>
          <!-- class="pr-2 pb-2 w-44 rounded-md leading-tight lg:w-4/4" -->

          <datepicker
            v-model="form.date"
            class="lg:w-4/4 rounded-md"
            label="received"
          />
          <!-- <div v-if="errors.date">{{ errors.date }}</div> -->
        </div>

        <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
          <label class="w-28 inline-block text-right mr-4">Description:</label>
          <input
            type="text"
            v-model="form.description"
            class="rounded-md lg:w-1/4"
            label="description"
          />
          <!-- <div v-if="errors.description">{{ errors.description }}</div> -->
        </div>

        <div class="p-2 mr-2 mb-2 ml-6 flex flex-wrap">
          <label class="w-28 inline-block text-right mr-4">Company:</label>
          <select
            v-model="form.company_id"
            class="rounded-md leading-tight lg:w-1/4"
          >
            <option
              v-for="company in companies"
              :key="company.id"
              :value="company.id"
            >
              {{ company.name }}
            </option>
          </select>
        </div>

        <div class="p-2 mr-2 mb-2 ml-6 flex flex-wrap">
          <label class="w-28 inline-block text-right mr-4">Year:</label>
          <select v-model="form.year_id" class="rounded-md lg:w-1/4">
            <option v-for="year in years" :key="year.id" :value="year.id">
              {{ year.id }}
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
                  <select v-model="balance.group_id" class="rounded-md w-36">
                    <option
                      v-for="group in groups"
                      :key="group.id"
                      :value="group.id"
                    >
                      {{ group.name }}
                    </option>
                  </select>
                </td>
                <!-- :disabled="!!balance.credit" -->
                <td>
                  <!-- v-if="balance.credit != null" -->
                  <!-- v-if="balance.credit != null || balance.debit == 0" -->
                  <input
                    v-model="balance.debit"
                    type="text"
                    @change="debitchange(index)"
                    class="rounded-md w-36"
                  />
                </td>
                <td>
                  <!-- :disabled="!!balance.debit" -->
                  <!-- v-if="balance.debit != null" -->
                  <!-- v-if="balance.debit != null || balance.credit == 0" -->
                  <input
                    v-model="balance.credit"
                    @change="creditchange(index)"
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
            <thead class="">
              <tr>
                <th>Diffrence</th>
                <th>Debit</th>
                <th>Credit</th>
                <!-- <th>Company</th>
                <th>Account</th>
                <th>Year</th> -->
                <!-- <th>Action</th> -->
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <input
                    v-model="diffrence"
                    type="text"
                    class="rounded-md w-36"
                  />
                </td>
                <td>
                  <input v-model="dr" type="text" class="rounded-md w-36" />
                </td>

                <td>
                  <!-- @change="total" -->
                  <input v-model="cr" type="text" class="rounded-md w-36" />
                </td>

                <td>
                  <input v-model="jj" type="text" class="rounded-md w-36" />
                </td>
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
          <div v-if="isError">{{ firstError }}</div>
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
// import format from "date-fns/format";
// import { reactive } from "vue";

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

    years: Object,
    year_first: Object,

    types: Object,
    type_first: Object,
  },

  data() {
    return {
      dr: 0,
      cr: 0,
      diffrence: 0,
      jj: "",
      // d: "balance.debit",

      form: this.$inertia.form({
        date: "",
        discription: null,
        ref: this.accounts[0].id,
        company_id: this.comp_first.id,
        year_id: this.years.year_id,
        type_id: this.type_first.id,

        balances: [
          {
            group_id: this.group_first.id,
            debit: null,
            credit: null,

            // company_id: 4,
            // year_id: 1,
          },
        ],
        // dtotal=0,
        // ctotal=0,
      }),
      isError: false,
      firstError: "",
    };
  },

  watch: {
    dr: function () {
      let diff = 0;
      diff = this.dr;
      // console.log("jsd" + diff);
      this.diffrence = diff;
    },

    cr: function () {
      let diff = 0;
      diff = this.cr;
      console.log("jsd" + diff);
      this.diffrence = diff;
    },

    diffrence: function () {
      let diff = 0;
      diff = this.dr - this.cr;
      // console.log("jsd" + diff);
      this.diffrence = diff;
    },

    jj: function () {
      let a = 0;
      a = this.form.type_id;

      // console.log("jsd" + diff);
    },
    // type: function (val) {
    //   this.form.type_id = val;
    //   this.val = form.ref;
    // },

    // balances: function () {
    //   let dtotal = 0;
    //   for (var i = 0; i < this.form.balances.length; i++) {
    //     dtotal += parseInt(this.form.balances[i].debit);
    //     console.log(dtotal);

    //     // console.log(i);
    //   }
    //   this.dr = dtotal;
    // },

    errors: function () {
      if (this.errors) {
        this.firstError = this.errors[Object.keys(this.errors)[0]];
        this.isError = true;
      }
    },
  },

  methods: {
    submit() {
      if (this.diffrence === 0) {
        //   // this.form.date = format(this.form.date, "yyyy-MM-dd");
        this.$inertia.post(route("documents.store"), this.form);
      } else {
        alert("Entry Diffrence are Not Equal");
      }
    },

    // total() {
    //   let dtotal = 0;

    //   for (var i = 0; i < this.form.balances.length; i++) {
    //     // if (this.form.balances[i].debit) {
    //     dtotal = dtotal + parseInt(this.form.balances[i].debit);
    //     // }
    //     console.log(dtotal + " ");

    //     // if (this.form.balances[i].credit) {
    //     //   ctotal = ctotal + this.form.balances.balances[i].credit;
    //     // }
    //   }

    //   this.dtotal = dtotal;
    //   this.ctotal = ctotal;
    // },

    //   for (var i = 0; i <= count(this.form.balances); i++) {
    //     if (this.form.balances[i + 1].debit) {
    //       dtotal = dtotal + this.form.balances.balances[i].debit;
    //     }
    //     if (this.form.balances[i].credit) {
    //       ctotal = ctotal + this.form.balances.balances[i].credit;
    //     }
    //   }
    //   this.form.dtotal = dtotal;
    //   this.form.ctotal = ctotal;
    // },

    debitchange(index) {
      let a = this.form.balances[index];
      a.credit = 0;
      // console.log(a.debit);
      this.dtotal();
      this.ctotal();
    },

    creditchange(index) {
      let b = this.form.balances[index];
      b.debit = 0;
      this.ctotal();
      this.dtotal();
      // console.log(b.credit);
    },

    dtotal() {
      let d = 0;
      for (let i = 0; i < this.form.balances.length; i++) {
        d += parseInt(this.form.balances[i].debit);
        // console.log("Juna11" + d);
      }
      this.dr = d;
    },

    ctotal() {
      let c = 0;
      for (let i = 0; i < this.form.balances.length; i++) {
        c += parseInt(this.form.balances[i].credit);
        // console.log("Juna11" + c);
      }
      this.cr = c;
    },

    addRow() {
      this.form.balances.push({
        group_id: this.group_first.id,
        debit: "",
        credit: "",
        // company_id: 4,
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
