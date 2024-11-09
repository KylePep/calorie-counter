<script setup>
import FoodList from "@/Components/FoodComponents/FoodList.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import CreateFood from "@/Components/FoodComponents/CreateFood.vue";
import ItemsDisplay from "@/Components/Displays/ItemsDisplay.vue";
import FoodEditModal from "@/Components/FoodComponents/FoodEditModal.vue";
import Pop from "@/utils/Pop.js";
import UsdaFoodEditModal from "@/Components/FoodComponents/UsdaFoodEditModal.vue";
import Side from "@/Components/Displays/Side.vue";
import TextInput from "@/Components/Form/TextInput.vue";

const props = defineProps(['account', 'with_fdcId', 'without_fdcId']);


const with_fdcId = computed(() => props.with_fdcId);
const without_fdcId = computed(() => props.without_fdcId);

const showEditForm = ref(false);
const showUsdaForm = ref(false);
const ActiveFoodItem = ref({})

function setActive(foodItem, type) {
  showEditForm.value = false;
  showUsdaForm.value = false;
  if (type == 'usda') {
    showUsdaForm.value = true;
  } else { showEditForm.value = true; }
  ActiveFoodItem.value = foodItem;
}
const closeModal = () => {
  showEditForm.value = false;
  showUsdaForm.value = false;
  ActiveFoodItem.value = {};
}

async function deleteFoodItem(foodItem) {

  const form = useForm(foodItem)

  const confirmDelete = await Pop.confirm(`Delete ${form.description}?`)
  if (!confirmDelete) {
    return
  }
  form.delete(route('foodItem.destroy', foodItem.id), {
    preserveScroll: true,
    onSuccess: () => {
      Pop.success(`${form.description} deleted`)
    },
    onError: (errors) => {
      console.log(errors);
    },
  });
}

function handleExtraButton(item, action, type) {
  if (action == 'edit') {
    setActive(item, type)
  } else if (action == 'add') {
    return
  } else {
    deleteFoodItem(item)
  }
}

</script>


<template>

  <Head title="Food">
    <meta type="description" content="Profile's Food" head-key="Food">
  </Head>

  <GlobalLayout heroImage="/assets/blueprintSammich.jpeg" heroHeight="60">
    <template #header>
      Your Foods
    </template>


    <section v-if="!props.account">
      <div class="font-bold text-2xl">
        Unlock more features by completing account setup!
      </div>
    </section>

    <section>
      <div class=" bg-main border border-light rounded">
        <div class="grid grid-cols-4">
          <div class="col-span-4 text-dark-text font-bold text-lg px-2 pt-2">Friend's food</div>
          <TextInput class="col-span-3" />
          <p class="flex items-center justify-center bg-accent text-dark-text font-bold">Find a Friend</p>
        </div>

        <select id="activity" name="activity"
          class=" w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-accent sm:text-sm sm:leading-6">
          <option value=1>Select a friend</option>
          <option value=1.2>Moose</option>
          <option value=1.375>Satchel</option>
          <option value=1.465>Oskar</option>
        </select>

        <div class="bg-light grid grid-cols-4 gap-4 py-2 px-1 text-center font-bold">
          <button class="bg-main px-2 py-1 rounded">breakfast</button>
          <button class="bg-main px-2 py-1 rounded">lunch</button>
          <button class="bg-main px-2 py-1 rounded">dinner</button>
          <button class="bg-main px-2 py-1 rounded">snack</button>
        </div>
        <div class="grid grid-cols-6 gap-2">

          <button class="bg-main border border-light mdi mdi-menu-left text-7xl"></button>

          <div v-for="index in 4"
            class="h-20 flex flex-col items-center justify-center text-center bg-main border border-light text-xs">
            <p> {{ index }}</p>
            <p>Food Item</p>

          </div>
          <button class="bg-main border border-light mdi mdi-menu-right text-7xl"></button>

        </div>
      </div>
    </section>

    <section v-if="props.account" class="block 2xl:hidden">
      <CreateFood />
    </section>

    <section v-if="props.account">
      <ItemsDisplay size="lg" :list="without_fdcId" @item-Activated="setActive" @extra-button="handleExtraButton">
        <h1 class="text-xl font-bold">Your Foods</h1>
      </ItemsDisplay>
    </section>

    <section v-if="props.account">
      <ItemsDisplay size="lg" :list="with_fdcId" @item-Activated="setActive" @extra-button="handleExtraButton">
        <h1 class="text-xl font-bold">Favorite Foods</h1>
      </ItemsDisplay>
    </section>

    <section>
      <FoodList @extra-button="(item, action) => handleExtraButton(item, action, 'usda')" />
    </section>

    <template #rightSide>
      <Side side="right" class="hidden 2xl:block" v-if="props.account">
        <CreateFood />
      </Side>
    </template>

    <FoodEditModal :showModal="showEditForm" @close-modal="closeModal" :foodItem="ActiveFoodItem" />

    <UsdaFoodEditModal :showModal="showUsdaForm" @close-modal="closeModal" :foodItem="ActiveFoodItem" />

  </GlobalLayout>
</template>