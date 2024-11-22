<script setup>
import { StreamBarcodeReader } from "vue-barcode-reader";
import PrimaryButton from "./Form/PrimaryButton.vue";
import Modal from "./Form/Modal.vue";
import { ref } from "vue";

const showModal = ref(false);

const scanResult = ref('');

function onDecode(result) {
  scanResult.value = result;
  console.log('[onLoaded]', result);
}
function onLoaded() {
  console.log('[onLoaded]');
}

const closeModal = () => {
  showModal.value = false;
}

</script>


<template>
  <PrimaryButton @click="showModal = true">Scan Barcode</PrimaryButton>

  <Modal :show="showModal" @close="closeModal">
    <StreamBarcodeReader @decode="onDecode" @loaded="onLoaded">
    </StreamBarcodeReader>
    Result: {{ scanResult }}
  </Modal>
</template>