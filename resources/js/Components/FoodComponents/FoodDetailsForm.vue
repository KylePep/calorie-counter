<script setup>
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import InputError from "@/Components/Form/InputError.vue";
import NumberInput from "@/Components/Form/NumberInput.vue";
import { computed, onUnmounted, ref } from "vue";
import CollapsableFolder from "../Displays/CollapsableFolder.vue";
import PrimaryButton from "../Form/PrimaryButton.vue";
import SecondaryButton from "../Form/SecondaryButton.vue";
import { Cropper } from "vue-advanced-cropper";
import "vue-advanced-cropper/dist/style.css";

const emit = defineEmits(['submitForm', 'cancel', 'imageState']);

const props = defineProps(['formData', 'currentImageState']);

const form = computed(() => props.formData);

const unitName = computed(() => {
  return {
    g: 'Gram(s)',
    u: 'Unit(s)',
    ml: 'MilliLiter(s)',
    MLT: 'MilliLiter(s)'
  }[props.formData.servingSizeUnit];
});

const fileInput = ref(null);
const selectedFile = ref("");
const previewImageURL = ref(null);
const cropperRef = ref(null);
const croppedFile = ref(null);

const triggerFileInput = () => {
  fileInput.value.click();
};

const handleFileChange = () => {
  const file = fileInput.value.files[0];

  if (file) {

    const reader = new FileReader();
    reader.onload = (e) => {
      previewImageURL.value = e.target.result;
    };
    reader.readAsDataURL(file);
    selectedFile.value = file.name;
    emit('imageState', 'selected');
  }
};

function crop() {
  const { coordinates, canvas } = cropperRef.value.getResult();
  const name = selectedFile.value.split('.')[0];
  const truncatedName = name.substring(0, 10);
  const currentDate = new Date().toISOString().slice(0, 10);
  const finalName = `${truncatedName}-${currentDate}-cropped`;

  canvas.toBlob((blob) => {
    blob.name = finalName;
    blob.lastModified = new Date();

    const myFile = new File([blob], blob.name + '.webp', { type: 'image/jpeg' });

    const objectURL = URL.createObjectURL(blob);

    croppedFile.value = objectURL;
    form.value.photo = myFile;

  }, 'image/jpeg');
  emit('imageState', 'cropped');
}

const photoDisplay = computed(() => {
  return croppedFile.value ? croppedFile.value : form.value.photo
});

function cancelImageUpload() {
  if (croppedFile.value) {
    URL.revokeObjectURL(croppedFile.value);
  }

  form.value.photo = '';
  fileInput.value = null;
  selectedFile.value = "";
  previewImageURL.value = null;
  cropperRef.value = null;
  croppedFile.value = null;
  emit('imageState', null);
}

onUnmounted(() => {
  if (croppedFile.value) {
    URL.revokeObjectURL(croppedFile.value);
  }
})

</script>


<template>

  <form @submit.prevent="" class="space-y-3">
    <!-- Header -->
    <div v-if="form.photo"
      :style="{ backgroundImage: `linear-gradient(to bottom, rgba(var(--hero-gradient), 0.25) 10%, rgba(var(--hero-gradient), 0.75) 80%, rgba(var(--hero-gradient), 1) 100%), url(${photoDisplay})`, backgroundPosition: `50% 50%`, backgroundSize: 'cover', backgroundRepeat: 'no-repeat' }"
      class="flex flex-col text-white text-shadow-2xl rounded">
      <div class="h-full w-full p-2 rounded" :style="{ backdropFilter: 'blur(3px)' }">

        <div class="w-1/2 mx-auto pb-2">
          <img :src="photoDisplay" :alt="photoDisplay" class="rounded shadow-lg shadow-light/25">
        </div>

        <slot name="title"></slot>
      </div>
    </div>

    <div v-else>
      <slot name="title"></slot>
    </div>

    <!-- Description -->
    <div class="flex">
      <div class="basis-3/5 me-3">
        <InputLabel for="description" value="Name or description"></InputLabel>
        <TextInput id="description" v-model="form.description" class="w-full text-sm" ref="nameInput" required>
        </TextInput>
        <InputError :message="form.errors.description"></InputError>
      </div>
      <div class="basis-2/5">
        <InputLabel for="category" value="Category"></InputLabel>
        <select v-model="form.foodCategory" id="category" name="category" required
          class=" w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-accent sm:text-sm sm:leading-6">
          <option value='breakfast'>Breakfast</option>
          <option value='lunch'>Lunch</option>
          <option value='dinner'>Dinner</option>
          <option value='beverage'>Beverage</option>
          <option value='snack'>Snack</option>
        </select>
        <InputError :message="form.errors.foodCategory"></InputError>

      </div>
    </div>

    <!-- Calories, Serving Size, Serving Unit -->
    <div class="flex flex-col sm:flex-row  sm:items-center space-y-2 sm:space-y-0">

      <div class="sm:basis-3/5 me-3">
        <InputLabel for="calories" value="Amount of calories"></InputLabel>
        <NumberInput id="calories" v-model="form.calories" class="w-full text-sm" required></NumberInput>
        <InputError :message="form.errors.calories"></InputError>
      </div>

      <div class="flex sm:basis-2/5">

        <div class="w-full relative">
          <InputLabel for="servingSize" value="Serving Size"></InputLabel>
          <NumberInput id="servingSize" v-model="form.servingSize" class="w-full text-sm" required></NumberInput>
          <span class="absolute right-0 bottom-0 pb-3 pe-3 font-bold text-black/50 text-xs">{{ unitName
            }}</span>
          <InputError :message="form.errors.servingSize"></InputError>
        </div>

        <div class="flex flex-col justify-between ms-2">
          <InputLabel for="servingSizeUnit" value="Unit"></InputLabel>
          <div class="flex font-bold">
            <button id="g" type="button" @click="form.servingSizeUnit = 'g'"
              class="rounded-l-lg px-3 py-2 border-r border-white"
              :class="[form.servingSizeUnit == 'g' ? 'bg-accent-dark text-white' : 'bg-light hover:bg-gray-400 ']">g</button>
            <button id="u" type="button" @click="form.servingSizeUnit = 'u'" class="border-r border-white px-3 py-2  "
              :class="[form.servingSizeUnit == 'u' ? 'bg-accent-dark text-white' : 'bg-light hover:bg-gray-400 ']">u</button>
            <button id="ml" type="button" @click="form.servingSizeUnit = 'ml'" class=" rounded-r-lg px-3 py-2"
              :class="[(form.servingSizeUnit == 'ml' || form.servingSizeUnit == 'MLT') ? 'bg-accent-dark text-white' : 'bg-light hover:bg-gray-400 ']">ml</button>
          </div>
        </div>
      </div>

    </div>

    <div>

      <!-- Brand -->
      <div class="flex ">
        <div class="basis-1/2 me-3">
          <InputLabel for="brandName" value="Brand Name"></InputLabel>
          <TextInput id="brandName" v-model="form.brandName" class="w-full text-sm"></TextInput>
          <InputError :message="form.errors.brandName"></InputError>

        </div>
        <div class="basis-1/2">

          <InputLabel for="brandOwner" value="Brand Owner"></InputLabel>
          <TextInput id="brandOwner" v-model="form.brandOwner" class="w-full text-sm"></TextInput>
          <InputError :message="form.errors.brandOwner"></InputError>

        </div>
      </div>
    </div>

    <!-- Ingredients -->
    <div>
      <InputLabel for="ingredients" value="Ingredients">
      </InputLabel>
      <textarea id="ingredients" v-model="form.ingredients" name="ingredients"
        class="w-full text-sm border-gray-300 focus:border-accent focus:ring-accent rounded-md shadow-sm"
        style="resize: none;"></textarea>
      <InputError :message="form.errors.ingredients"></InputError>
    </div>

    <!-- Photo -->

    <div v-if="!props.formData.photo">

      <InputLabel value="Add Image" for="photo" />

      <div class="grid grid-cols-4 gap-2">
        <input ref="fileInput" type="file" name="photo" id="photo" class="hidden" @change="handleFileChange">
        <PrimaryButton v-if="!selectedFile" type="button" @click="triggerFileInput"
          class="col-span-2 flex justify-center">From
          File
        </PrimaryButton>
        <SecondaryButton v-else type="button" @click="cancelImageUpload" class="col-span-2 flex justify-center">Cancel
          Image Upload
        </SecondaryButton>

        <div v-if="selectedFile" class="col-span-4 lg:col-span-3 text-sm truncate">
          {{ selectedFile }}
        </div>
      </div>
    </div>

    <div v-if="previewImageURL" class="mt-4">
      <Cropper v-if="!croppedFile" ref="cropperRef" :src="previewImageURL" :auto-zoom="true"
        :stencil-size="{ width: 280, height: 180 }" :canvas="{ width: 280, height: 180 }" image-restriction="stencil"
        class="border" />
      <div v-else class="space-y-2">
        <SecondaryButton type="button" @click="cancelImageUpload" class="col-span-2 flex justify-center">Cancel
          Image Upload
        </SecondaryButton>
        <img :src="photoDisplay" :alt="photoDisplay">
      </div>
      <PrimaryButton type="button" v-if="!croppedFile" @click="crop" class="mt-4">Crop</PrimaryButton>
      <SecondaryButton type="button" v-else class="mt-4">Cropped</SecondaryButton>
    </div>

    <!-- Nutrients -->
    <div class="pb-3">
      <CollapsableFolder :state="false">
        <template #title>
          <p> Nutrients</p>
        </template>


        <template #config />

        <template #content>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 text-center gap-2">
            <div v-for="(nutrient, index) in form.foodNutrients" :key="index">
              <InputLabel :for="nutrient.nutrientName" :value="nutrient.nutrientName"></InputLabel>
              <div class="relative">
                <NumberInput :id="nutrient.nutrientName" v-model="form.foodNutrients[index].value"
                  class="w-full text-sm text-center">
                </NumberInput>
                <div
                  class="absolute flex items-center justify-center pe-1 sm:pe-3 h-full right-0 top-0 text-black/50 text-xs sm:text-base font-bold">
                  {{
                    nutrient.unitName }}
                </div>
              </div>

            </div>
          </div>
        </template>
      </CollapsableFolder>

    </div>

    <div class="flex justify-end gap-4 mt-3">
      <slot name="buttons" />
    </div>

  </form>
</template>

<style></style>
