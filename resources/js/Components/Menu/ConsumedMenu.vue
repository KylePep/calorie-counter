<script setup>
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";

const props = defineProps(['dayItems', 'calorieDay']);

async function removeAndSubtractFoodItem(item) {

  const confirmRemove = await Pop.confirm(`Remove ${item.description} - ${item.count}? `)
  if (!confirmRemove) {
    return;
  }

  const useItemForm = useForm({
    remove: true,
    count: item.count,
    food_items: [{
      description: item.description,
      count: item.calories
    }]
  });

  useItemForm.put(route('calorieDay.update', props.calorieDay.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success(`removed ${item.description}`)
    },
    onError: (errors) => {
      console.log(errors);
    },
  });
};

</script>


<template>

  <div class="space-y-3">
    <h1 class="text-center text-xl font-bold">Consumed List</h1>
    <h2 class="text-center text-sm max-w-xs mx-auto">A simple list view of all of your foods for the day an their
      calories.
    </h2>

    <div class="">
      <button v-for="(item, index) in dayItems" :key="index" @click="removeAndSubtractFoodItem(item)"
        class="group relative flex justify-center items-center w-full hover:bg-dark bg-white border border-light rounded-sm py-2 duration-500 overflow-hidden shadow-lg mb-1">

        <p
          class="relative grid grid-cols-6 w-full text-neutral-text text-xs group-hover:text-light-text px-3 font-bold duration-400">
          <span class="text-start col-span-5 ">{{ item.description }}</span>
          <span class="text-end">{{ item.count }} cal</span>
        </p>
        <p class="absolute w-full group-hover:text-special text-transparent font-bold mdi mdi-close-thick duration-300">
        </p>

      </button>
    </div>
  </div>
</template>