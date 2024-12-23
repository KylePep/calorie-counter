<script setup>
import { computed, ref } from "vue";
import NumberInput from "../Form/NumberInput.vue";
import PrimaryButton from "../Form/PrimaryButton.vue";
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";

const props = defineProps(["account"]);

const emit = defineEmits(['setSearch']);

const breakfastPercentage = ref(props.account.ratios ? props.account.ratios.breakfast : 30);
const lunchPercentage = ref(props.account.ratios ? props.account.ratios.lunch : 30);
const dinnerPercentage = ref(props.account.ratios ? props.account.ratios.dinner : 30);
const otherPercentage = computed(() => {
  const total = breakfastPercentage.value + lunchPercentage.value + dinnerPercentage.value;
  return total > 100 ? 0 : 100 - total;
});

const cellCount = ref(Math.ceil(props.account.bmr / 100));
const calorieCountRows = ref(Math.ceil(props.account.bmr / 1000));
const allCellsTotal = computed(() => calorieCountRows.value * 10);

const calculateCellRange = (percentage) => Math.round((percentage / 100) * cellCount.value);

const breakfastRange = computed(() => calculateCellRange(breakfastPercentage.value));
const lunchRange = computed(() => calculateCellRange(lunchPercentage.value));
const dinnerRange = computed(() => calculateCellRange(dinnerPercentage.value));
const otherRange = computed(() => allCellsTotal.value - (breakfastRange.value + lunchRange.value + dinnerRange.value));


function cellClasses(index) {
  if (index < breakfastRange.value) {
    return "bg-accent-light/50 border-accent-light";
  } else if (index < breakfastRange.value + lunchRange.value) {
    return "bg-accent/50 border-accent";
  } else if (index < breakfastRange.value + lunchRange.value + dinnerRange.value) {
    return "bg-accent-dark/50 border-accent-dark";
  } else {
    return "bg-special/50 border-special";
  }
}

function setSearch() {
  const ranges = {
    breakfast: breakfastPercentage.value,
    lunch: lunchPercentage.value,
    dinner: dinnerPercentage.value,
    snack: otherPercentage.value,
    beverage: otherPercentage.value
  }
  updateAccountRatios(ranges)
  emit('setSearch', ranges);
}

function updateAccountRatios(ranges) {
  const form = useForm({ ratios: ranges });
  form.patch(route('account.patch', props.account.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success(`Ratio's updated`);
    },
    onError: (errors) => {
      console.log(errors);
    },
  });
}
</script>

<template>

  <section id="calorie display" class="z-10 relative p-1.5 rounded border border border-light drop-shadow-xl bg-main">
    <div class="grid grid-cols-10 gap-1">
      <div v-for="cell in allCellsTotal" class="h-6 sm:h-10 text-sm bg-light/10 border-4 border-light/10 rounded-sm">
      </div>
    </div>

    <div class="absolute top-0 left-0 w-full grid grid-cols-10 gap-1 p-1.5">
      <div v-for="cell in cellCount" :class="cellClasses(cell)"
        class="h-6 sm:h-10 flex justify-center items-center text-sm  border-4 rounded-sm font-bold  duration-500"
        :title="cell * 100">
      </div>
    </div>

  </section>

  <section id="input-fields" class="mt-4">
    <form @submit.prevent="setSearch" class="grid grid-cols-4 gap-2">

      <div class="flex flex-col gap-1">
        <div class="bg-accent-light/50 p-1 rounded font-bold text-xs lg:text-base text-center">
          <label for="breakfast">Breakfast</label>
        </div>
        <NumberInput id="breakfast" v-model="breakfastPercentage" min="0" max="100" required class="text-center" />
      </div>

      <div class="flex flex-col gap-1">
        <div class="bg-accent/50 p-1 rounded font-bold text-xs lg:text-base text-center">
          <label for="lunch">Lunch</label>
        </div>
        <NumberInput id="lunch" v-model="lunchPercentage" min="0" max="100" required class="text-center" />
      </div>

      <div class="flex flex-col gap-1">
        <div class="bg-accent-dark/50 p-1 rounded font-bold text-xs lg:text-base text-center">
          <label for="dinner">Dinner</label>
        </div>
        <NumberInput id="dinner" v-model="dinnerPercentage" min="0" max="100" required class="text-center" />
      </div>

      <div class="flex flex-col gap-1">
        <div class="bg-special/50 p-1 rounded font-bold text-xs lg:text-base text-center">
          <label>Other</label>
        </div>
        <span class="text-lg py-1.5 text-center">{{ otherPercentage }}</span>
      </div>

      <div class="col-span-4">
        <PrimaryButton class="w-full flex justify-center">Update your calorie schedule
        </PrimaryButton>

      </div>

    </form>
  </section>

</template>
