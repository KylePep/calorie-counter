<script setup>
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import Pop from "@/utils/Pop.js";
import { useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import NumberInput from "@/Components/Form/NumberInput.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import Modal from "@/Components/Form/Modal.vue";
import SecondaryButton from "@/Components/Form/SecondaryButton.vue";

const props = defineProps(['account', 'carrots']);
const account = computed(() => props.account);

const completedCarrots = computed(() => {
  if (props.carrots)
    return props.carrots.filter((c) => c.complete == true);
})
const uncompletedCarrots = computed(() => {
  if (props.carrots)
    return props.carrots.filter((c) => c.complete == false);
})

const showCreateForm = ref(false);

const editCarrotId = ref(null);

const confirmingCarrotDetails = ref(false);

const confirmCarrotDetails = () => {
  confirmingCarrotDetails.value = true;
};


const form = useForm({
  description: 'New socks',
  goalPost: 'Under 200lbs',
  value: 199,
  category: 'weightLoss',
  complete: false
});

function setEditForm(data) {
  editCarrotId.value = data.id;

  form.description = data.description;
  form.goalPost = data.goalPost;
  form.value = data.value;
  form.category = data.category;
  form.complete = data.complete;

  if (data.complete == false)
    confirmCarrotDetails();
}

const submitForm = () => {

  if (editCarrotId.value == null) {
    form.post(route('carrot.store', form.carrot), {
      preserveScroll: true,
      onSuccess: () => {
        Pop.success(`Carrot ${form.description} added!`);
        form.reset();
        closeModal();
      },
      onError: (errors) => {
        console.log(errors);
      },
    });
  } else {
    form.put(route('carrot.update', editCarrotId.value), {
      preserveScroll: true,
      onSuccess: () => {
        Pop.success(`Carrot ${form.description} updated!`);
        form.reset();
        closeModal();
      },
      onError: (errors) => {
        console.log(errors);
      },
    });
  }
};

const completeCarrot = (carrot) => {

  carrot.complete = true;
  setEditForm(carrot)

  form.put(route('carrot.update', carrot.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success(`Carrot ${form.description} added!`);
      form.reset();
      closeModal();
    },
    onError: (errors) => {
      console.log(errors);
    },
  });

};

async function deleteCarrot(carrot) {

  const confirmDelete = await Pop.confirm(`Delete ${carrot.description}?`)
  if (!confirmDelete) {
    return
  }

  form.delete(route('carrot.destroy', carrot.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success(`Carrot ${carrot.description} removed`);
      form.reset();
      closeModal();
    },
    onError: (errors) => {
      console.log(errors);
    },
  });

};

const closeModal = () => {
  confirmingCarrotDetails.value = false;

  editCarrotId.value = null;

  form.clearErrors();
  form.reset();
};

</script>


<template>

  <div v-if="account?.id" class="p-4 lg:p-8 space-y-3">


    <div class="grid grid-cols-5 bg-light rounded p-1">
      <h1 class="font-bold col-span-4 flex items-center ms-1 text-neutral-text">
        Create a carrot
      </h1>

      <div class="flex justify-end">
        <PrimaryButton v-if="!showCreateForm" @click="confirmCarrotDetails"
          class="relative lg:block h-8 w-8 lg:h-min lg:w-full">
          <span class="hidden lg:block">Create</span>
          <span class="absolute left-1.5 lg:hidden text-xl mdi mdi-plus-thick"></span>
        </PrimaryButton>
      </div>
    </div>

    <p>A carrot is a reward that you give yourself once you've reached your goal.</p>

    <h2 v-if="uncompletedCarrots.length" class="font-bold mdi mdi-human-male">Uncompleted</h2>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
      <div v-for="carrot in uncompletedCarrots" :key="carrot.id"
        class="flex justify-between text-xs bg-light/50 rounded px-2 py-2">
        <p class="font-semibold">{{ carrot.description }} : <span class="font-normal">{{ carrot.goalPost }}</span> </p>
        <div class="flex space-x-4">
          <button aria-label="Edit Carrot" @click="setEditForm(carrot)"
            class="mdi mdi-pencil text-light-text bg-yellow-800 hover:bg-yellow-500 hover:text-dark-text border border-dark px-1 rounded-sm duration-300"></button>
          <button aria-label="Complete Carrot" @click="completeCarrot(carrot)"
            class="mdi mdi-check-bold text-light-text bg-green-800 hover:bg-green-500 hover:text-dark-text border border-dark px-1 rounded-sm duration-300"></button>
          <button aria-label="Delete Carrot" @click="deleteCarrot(carrot)"
            class="mdi mdi-close-thick text-light-text bg-red-800 hover:bg-red-500 hover:text-dark-text border border-dark px-1 rounded-sm duration-300"></button>
        </div>
      </div>
    </div>

    <h3 v-if="completedCarrots.length" class="font-bold mdi mdi-weight-lifter">Completed</h3>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
      <div v-for="carrot in completedCarrots" :key="carrot.id"
        class="flex justify-between text-xs bg-neutral text-light-text rounded px-2 py-1">
        <p>{{ carrot.description }} : {{ carrot.goalPost }} </p>
        <div class="flex space-x-1">
          <button aria-label="Delete Carrot" @click="deleteCarrot(carrot)"
            class="mdi mdi-close-thick text-red-200 hover:text-red-400"></button>
        </div>
      </div>
    </div>
  </div>

  <Modal :show="confirmingCarrotDetails" @close="closeModal">
    <form @submit.prevent="submitForm" @cancel="closeModal" class="grid grid-cols-2 gap-3 justify-start">

      <h1 class="col-span-2 text-xl font-bold">Create new carrot</h1>

      <div class="col-span-2">
        <p>What is your reward and describe the goal in words.</p>
      </div>

      <div>
        <InputLabel id=description value="Description" />
        <TextInput for="description" v-model="form.description" class="w-full" />
      </div>

      <div>
        <InputLabel for="goalPost" value="Goal Post Description" />
        <TextInput id="goalPost" v-model="form.goalPost" class="w-full" />
      </div>

      <div class="col-span-2">
        <p>Enter a numeric value and a category to be tracked.</p>
      </div>

      <div>
        <InputLabel for="value" value="Metric Value" />
        <NumberInput id="value" v-model="form.value" class="w-full" />
      </div>

      <div class="mt-2">
        <InputLabel for="category" value="Metric Category" />
        <select v-model="form.category" id="category" name="category"
          class=" w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-accent sm:text-sm sm:leading-6">
          <option value='weightLoss'>Weight Loss</option>
          <option value='weightGain'>Weight Gain</option>
          <option value='none'>None</option>
        </select>
      </div>

      <div class=" col-span-2 flex justify-end mt-2 space-x-3">
        <SecondaryButton type="button" @click="closeModal">Cancel</SecondaryButton>
        <PrimaryButton v-if="editCarrotId == null">Add</PrimaryButton>
        <PrimaryButton v-else>Update</PrimaryButton>
      </div>
    </form>
  </Modal>

</template>
