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
  description: 'carrot',
  goalPost: '2000',
  value: 200,
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

  const confirmDelete = await Pop.confirm(`Delete ${form.description}?`)
  if (!confirmDelete) {
    return
  }

  form.delete(route('carrot.destroy', carrot.id), {
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

const closeModal = () => {
  confirmingCarrotDetails.value = false;

  editCarrotId.value = null;

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


    <h3 v-if="uncompletedCarrots.length" class="font-bold mdi mdi-human-male">Uncompleted</h3>
    <div class="grid grid-cols-3 gap-3">
      <div v-for="carrot in uncompletedCarrots" class="flex justify-between text-xs bg-light rounded px-2 py-1">
        <p>{{ carrot.description }} : {{ carrot.goalPost }} </p>
        <div class="flex space-x-1">
          <button @click="setEditForm(carrot)" class="mdi mdi-pencil text-yellow-800 hover:text-yellow-500"></button>
          <button @click="completeCarrot(carrot)"
            class="mdi mdi-check-bold text-green-800 hover:text-green-500"></button>
          <button @click="deleteCarrot(carrot)" class="mdi mdi-close-thick text-red-800 hover:text-red-500"></button>
        </div>
      </div>
    </div>

    <h3 v-if="completedCarrots.length" class="font-bold mdi mdi-weight-lifter">Completed</h3>
    <div class="grid grid-cols-3 gap-3">
      <div v-for="carrot in completedCarrots"
        class="flex justify-between text-xs bg-neutral text-light rounded px-2 py-1">
        <p>{{ carrot.description }} : {{ carrot.goalPost }} </p>
        <div class="flex space-x-1">
          <i class="mdi mdi-close-thick text-red-200 hover:text-red-400"></i>
        </div>
      </div>
    </div>
  </div>

  <Modal :show="confirmingCarrotDetails" @close="closeModal">
    <form @submit.prevent="submitForm" @cancel="closeModal" class="grid grid-cols-2 gap-3 justify-start p-6">

      <h1 class="col-span-2 text-xl font-bold">Create new carrot</h1>

      <div class="col-span-2">
        <p>What is your reward and describe the goal in words.</p>
      </div>

      <div>
        <InputLabel value="Description" />
        <TextInput v-model="form.description" class="w-full" />
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
        <NumberInput v-model="form.value" class="w-full" />
      </div>

      <div class="mt-2">
        <InputLabel value="Metric Category" />
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
