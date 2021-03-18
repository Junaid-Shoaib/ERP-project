<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Transaction
      </h2>
    </template>
    <div v-if="$page.props.flash.success" class="bg-green-600 text-white">
      {{ $page.props.flash.success }}
    </div>
    <jet-button @click="create" class="mt-4 ml-8"
      >Create Transaction</jet-button
    >
    <div class="">
      <table class="shadow-lg border mt-4 ml-8 rounded-xl">
        <thead>
          <tr class="bg-indigo-100">
            <!-- 'ref', 'date','description','type_id','paid','posted','approved','enabled', 'company_id', 'year_id -->
            <!-- <th class="py-2 px-4 border">Voucher Id</th> -->
            <th class="py-2 px-4 border">Reference</th>
            <th class="py-2 px-4 border">date</th>
            <th class="py-2 px-4 border">description</th>
            <!-- <th class="py-2 px-4 border">type_id</th> -->
            <th class="py-2 px-4 border">group_id</th>
            <th class="py-2 px-4 border">paid</th>
            <th class="py-2 px-4 border">posted</th>
            <th class="py-2 px-4 border">approved</th>
            <th class="py-2 px-4 border">company_id</th>
            <th class="py-2 px-4 border">year_id</th>

            <th class="py-2 px-4 border">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in data" :key="item.id">
            <!-- <td class="py-1 px-4 border">{{ item.id }}</td> -->
            <td class="py-1 px-4 border">{{ item.ref }}</td>
            <td class="py-1 px-4 border">{{ item.date }}</td>
            <td class="py-1 px-4 border">{{ item.description }}</td>
            <td class="py-1 px-4 border">{{ item.type_id }}</td>
            <td class="py-1 px-4 border">{{ item.paid }}</td>
            <td class="py-1 px-4 border">{{ item.posted }}</td>
            <td class="py-1 px-4 border">{{ item.approved }}</td>
            <td class="py-1 px-4 border">{{ item.company_id }}</td>
            <td class="py-1 px-4 border">{{ item.year_id }}</td>

            <td class="py-1 px-4 border">
              <button
                class="border bg-indigo-300 rounded-xl px-4 py-1 m-1"
                @click="edit(item.id)"
              >
                <span>Edit</span>
              </button>
              <button
                class="border bg-indigo-300 rounded-xl px-4 py-1 m-1"
                @click="destroy(item.id)"
              >
                <span>Delete</span>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetButton from "@/Jetstream/Button";

export default {
  components: {
    AppLayout,
    JetButton,
  },

  props: ["data"],

  data() {
    return {};
  },

  methods: {
    create() {
      this.$inertia.get(route("documents.create"));
    },

    edit(id) {
      this.$inertia.get(route("documents.edit", id));
    },

    destroy(id) {
      this.$inertia.delete(route("documents.destroy", id));
    },
  },
};
</script>
