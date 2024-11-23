<script setup>
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Head } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import ItemsDisplay from "@/Components/Displays/ItemsDisplay.vue";
import FoodEditModal from "@/Components/FoodComponents/FoodEditModal.vue";
import UsdaFoodEditModal from "@/Components/FoodComponents/UsdaFoodEditModal.vue";
import UsdaSearch from "@/Components/FoodComponents/UsdaSearch.vue";
import Modal from "@/Components/Form/Modal.vue";
import FoodMenuArray from "@/Components/Menu/FoodMenuArray.vue";

const props = defineProps(['account', 'with_fdcId', 'without_fdcId']);

const isSmallScreen = computed(() => { return window.innerWidth < 1024 });

const with_fdcId = computed(() => props.with_fdcId);
const without_fdcId = computed(() => props.without_fdcId);

const foodItems = computed(() => {
  return [...with_fdcId.value, ...without_fdcId.value].sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
});

const showModal = ref(false);
const modalContent = ref('foodDetails');
const ActiveFoodItem = ref({});

function setActive(type, foodItem) {
  console.log('[Modal Content Type]', type, foodItem);
  modalContent.value = type;
  showModal.value = true;
  if (foodItem) {
    ActiveFoodItem.value = foodItem;
  }
}

const closeModal = () => {
  showModal.value = false;
  ActiveFoodItem.value = {};
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

    <section v-if="props.account && isSmallScreen" class="">
      <FoodMenuArray :foodItems />
    </section>

    <section>
      <UsdaSearch @set-active="(item) => setActive('usda', item)" />
    </section>

    <section v-if="props.account">
      <h1 class="mb-2">Created Foods</h1>
      <ItemsDisplay size="lg" :list="without_fdcId" @set-active="(item) => setActive('foodItem', item)">
        <h1 class=" text-xl font-bold">Your Foods</h1>
      </ItemsDisplay>
    </section>

    <section v-if="props.account">
      <h1 class="mb-2">USDA Foods</h1>
      <ItemsDisplay size="lg" :list="with_fdcId" @set-active="(item) => setActive('foodItem', item)">
        <h1 class="text-xl font-bold">Favorite Foods</h1>
      </ItemsDisplay>
    </section>


    <template #leftSide></template>

    <template #rightSide>
      <div class="hidden lg:block" v-if="props.account">
        <FoodMenuArray :foodItems />
      </div>
    </template>

    <Modal :show="showModal" @close="closeModal">
      <FoodEditModal v-if="modalContent == 'foodItem'" @close-modal="closeModal" :foodItem="ActiveFoodItem" />
      <UsdaFoodEditModal v-if="modalContent == 'usda'" @close-modal="closeModal" @useItem="updateCalorieDayFoodItem"
        :foodItem="ActiveFoodItem" />
    </Modal>

  </GlobalLayout>
</template>