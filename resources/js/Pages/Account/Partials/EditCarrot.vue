<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import NumberInput from "@/Components/NumberInput.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
  account: {
    type: Object,
  }
});

const showCreateForm = ref(false);

const confirmingCarrotDetails = ref(false);

const confirmCarrotDetails = () => {
  confirmingCarrotDetails.value = true;

  // nextTick(() => nameInput.value.focus());
};

const goal = computed(() => props.account?.goal ?? 2000);
const account = computed(() => props.account);

const form = useForm({
  goal: goal.value,
  carrot: account.value?.carrot,
  carrotDescription: account.value?.carrot?.split(':')[0] || 'carrot',
  goalPost: account.value?.carrot?.split(':')[1] || '2000',
  metricValue: 200,
  metricCategory: 'weight',
});

const updateAccount = () => {

  form.carrot = form.carrotDescription + ':' + form.goalPost + '|' + form.metricValue + ':' + form.metricCategory
  Pop.success(form.carrot)

  // form.put(route('account.update', props.account.id), {
  //   preserveScroll: true,
  //   onSuccess: () => {
  //     Pop.success('Goal updated + This will take effect on a new day')
  // form.reset()
  // closeModal()
  //   },
  //   onError: (errors) => {
  //     console.log(errors);
  //   },
  // });
};

const closeModal = () => {
  confirmingCarrotDetails.value = false;

  form.clearErrors();
  form.reset();
};

</script>


<template>
  <div v-if="account?.id" class="p-4 sm:p-8 bg-main border-2 border-light rounded-lg shadow-xl p-12 space-y-3">
    <h1 class="font-bold">
      Create a carrot:
    </h1>
    <p>A carrot is a reward that give yourself once you've reached your goal.</p>

    <div v-if="!showCreateForm" @click="confirmCarrotDetails">
      <PrimaryButton>Create</PrimaryButton>
    </div>


    <h3 class="font-bold mdi mdi-human-male">Uncompleted</h3>
    <div class="grid grid-cols-3 gap-3">
      <div v-for="index in 3" class="flex justify-between text-xs bg-light rounded px-2 py-1">
        <p>{{ index + 3 }} Booster Packs : {{ 200 - (index * 10) }}</p>
        <div class="flex space-x-1">
          <i class="mdi mdi-check-bold text-green-800 hover:text-green-500"></i>
          <i class="mdi mdi-close-thick text-red-800 hover:text-red-500"></i>
        </div>
      </div>
    </div>

    <h3 class="font-bold mdi mdi-weight-lifter">Completed</h3>
    <div class="grid grid-cols-3 gap-3">
      <div v-for="index in 3" class="flex justify-between text-xs bg-neutral text-light rounded px-2 py-1">
        <p>{{ index }} Booster Packs : {{ 230 - (index * 10) }}</p>
        <div class="flex space-x-1">
          <i class="mdi mdi-close-thick text-red-200 hover:text-red-400"></i>
        </div>
      </div>
    </div>
  </div>

  <Modal :show="confirmingCarrotDetails" @close="closeModal">
    <form @submit.prevent="updateAccount" @cancel="closeModal" class="grid grid-cols-2 gap-3 justify-start p-6">

      <h1 class="col-span-2 text-xl font-bold">Create new carrot</h1>

      <div class="col-span-2">
        <p>What is your reward and describe the goal in words.</p>
      </div>

      <div>
        <InputLabel value="Description" />
        <TextInput v-model="form.carrotDescription" class="w-full" />
      </div>

      <div>
        <InputLabel value="Goal Post Description" />
        <TextInput v-model="form.goalPost" class="w-full" />
      </div>

      <div class="col-span-2">
        <p>Enter a numeric value and a category to be tracked.</p>
      </div>

      <div>
        <InputLabel value="Metric Value" />
        <NumberInput v-model="form.metricValue" class="w-full" />
      </div>

      <div class="mt-2">
        <InputLabel value="Metric Category" />
        <select v-model="form.metricCategory" id="metricCategory" name="metricCategory"
          class=" w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-accent sm:text-sm sm:leading-6">
          <option value='weight'>Weight</option>
          <option value='none'>None</option>
        </select>
      </div>

      <div class=" col-span-2 flex justify-end mt-2 space-x-3">
        <SecondaryButton type="button" @click="closeModal">Cancel</SecondaryButton>
        <PrimaryButton>Add</PrimaryButton>
      </div>
    </form>
  </Modal>

</template>
