<script setup>
import { ref, nextTick, onUnmounted } from 'vue';
import { Html5Qrcode } from 'html5-qrcode';
import PrimaryButton from "./Form/PrimaryButton.vue";
import Modal from "./Form/Modal.vue";
import SecondaryButton from "./Form/SecondaryButton.vue";
import InputLabel from "./Form/InputLabel.vue";

const emit = defineEmits(['setActive']);

const showModal = ref(false);
const scanResult = ref('');
let html5Qrcode = null;

const isScanning = ref(false);

// List of cameras
const cameras = ref([]);
const selectedCamera = ref(null);
const config = {
  fps: 2,
  qrbox: 250,
};

// Initialize scanner and fetch camera devices
async function initializeScanner() {
  try {
    html5Qrcode = new Html5Qrcode("reader");
    const devices = await Html5Qrcode.getCameras();
    cameras.value = devices;

    if (devices.length > 0) {
      selectedCamera.value = devices[0].id; // Default to the first camera
      startScanner();
    } else {
      console.error("No cameras found.");
    }
  } catch (error) {
    console.error("Error initializing scanner:", error);
  }
};

// Start scanning using the selected camera
const startScanner = () => {
  if (!selectedCamera.value || !html5Qrcode) return;
  scanResult.value = '';
  isScanning.value = true;
  html5Qrcode.start(
    { deviceId: { exact: selectedCamera.value } }, // Camera ID
    config, // Options
    (decodedText, decodedResult) => {
      console.log(`Scan result: ${decodedText}`, decodedResult);
      scanResult.value = decodedText;
      stopScanner(); // Stop the scanner on a successful scan
    },
    (error) => {
      console.log(`Scan error: ${error}`);
    }
  ).catch((err) => {
    console.error("Failed to start scanner:", err);
  });
};

// Stop scanning and clear resources
const stopScanner = () => {
  if (html5Qrcode) {
    html5Qrcode.stop().then(() => {
      console.log("Scanner stopped.");
    }).catch((err) => {
      console.error("Error stopping scanner:", err);
    });
  }
};

const restartScanner = () => {
  stopScanner();
  nextTick(() => {
    startScanner();
  });
}

// Open modal and initialize scanner
const openModal = () => {
  showModal.value = true;
  nextTick(() => {
    initializeScanner();
  });
};

// Close modal and stop scanner
const closeModal = () => {
  isScanning.value = false;
  showModal.value = false;
  stopScanner();
};

// Clean up resources on component unmount
onUnmounted(() => {
  if (html5Qrcode) {
    // html5Qrcode.stop();
    html5Qrcode = null;
  }
});


function setActive(scanResult) {
  const foodItem = { barcode: scanResult }
  emit('setActive', foodItem);
  closeModal();
}
</script>

<template>

  <PrimaryButton type="button" @click="openModal" class="relative flex justify-center w-full h-full">
    <span class="lg:hidden w-20 font-bold text-center text-[10px]">Scan </span>
    <span class="w-2"></span>
    <span class="lg:hidden w-20 font-bold text-end text-[10px]"> Barcode</span>
    <i class="absolute mdi mdi-barcode-scan text-center -top-0.5 left-0 w-full h-full text-2xl pt-0.5"></i>
  </PrimaryButton>

  <Modal :show="showModal" @close="closeModal">

    <h1 class="text-center text-xl font-bold mt-12 mb-3">Scan a Barcode</h1>
    <h2 class="text-center text-sm px-4 mb-3">
      Search the USDA for a products UPC <br> *upc's and food items in general are submitted to the USDA
      Database
      voluntarily. Your upc may not be available.
    </h2>


    <section class="w-full h-56 lg:h-96" :class="isScanning && !scanResult ? 'bg-dark' : 'bg-white'">
      <!-- QR Code Scanner Area -->
      <div id="reader"
        class="flex justify-center items-center w-full h-56 lg:h-96 border-4 border-light rounded overflow-hidden">
        <p v-if="!isScanning && !scanResult" class="animate-pulse text-neutral-text font-bold text-2xl">Loading...</p>
        <p v-else-if="isScanning && scanResult" class="text-neutral-text font-bold lg:text-2xl">{{ scanResult }}</p>
      </div>
    </section>

    <section class="flex flex-col justify-between h-32 p-2">
      <!-- Camera Selection Dropdown -->
      <div v-if="cameras.length > 0" class="">
        <InputLabel for="camera" class="">Select Camera:</InputLabel>
        <select id="camera" v-model="selectedCamera" @change="restartScanner"
          class="w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-accent sm:text-sm sm:leading-6">
          <option v-for="camera in cameras" :key="camera.id" :value="camera.id">
            {{ camera.label || `Camera ${camera.id}` }}
          </option>
        </select>
      </div>

      <div v-if="scanResult" class="flex justify-between">
        <SecondaryButton @click="startScanner">Retry</SecondaryButton>
        <div>
          <PrimaryButton @click="setActive(scanResult)">Search USDA </PrimaryButton>
        </div>
      </div>
    </section>

  </Modal>
</template>