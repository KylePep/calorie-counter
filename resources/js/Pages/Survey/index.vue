<script setup>
import InputLabel from "@/Components/Form/InputLabel.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import GlobalLayout from "@/Layouts/GlobalLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps(['account']);

const form = useForm({
  peanut: 'butter'
});

</script>


<template>

  <Head title="Survey">
    <meta type="description" content="Calorie Counter Survey" head-key="Survey">
  </Head>

  <GlobalLayout heroImage="/assets/survey.jpeg" heroHeight="35">
    <template #header>
      Survey
    </template>

    <form @submit.prevent="" class="bg-main border-2 border-light rounded shadow-xl p-4 sm:p-12 space-y-4">
      <h1 class="text-center text-2xl font-bold">Calorie Counter Survey</h1>
      <h2>
        Hi, {{ $page.props.auth.user.name }}! Please take a moment to fill out this survey.
        Your answers will assist us in further developing Calorie Counter.
      </h2>
      <section class="space-y-4">
        <div>
          <InputLabel>Question 1:</InputLabel>
          <p>Do you find the app easy to use?</p>
          <TextInput class="w-full"></TextInput>
        </div>

        <div>
          <InputLabel>Question 2:</InputLabel>
          <p>Do you find the information gathered from the usda to be helpful?</p>
          <TextInput class="w-full"></TextInput>
        </div>

        <div>
          <InputLabel>Question 3:</InputLabel>
          <p>Do you find the block based approach to monitoring progress to be helpful?</p>
          <TextInput class="w-full"></TextInput>
        </div>

        <div>
          <InputLabel>Question 4:</InputLabel>
          <p>The apps intention is to provide an unbiased display of calories, do you feel this has been achieved?</p>
          <TextInput class="w-full"></TextInput>
        </div>

        <div class="space-y-1">
          <InputLabel>Question 5:</InputLabel>
          <p>Please rate (on a scale of 1 - 5) the "USDA Search" feature</p>
          <div class="flex space-x-3 ">
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">1</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">2</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">3</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">4</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">5</button>
          </div>
          <TextInput class="w-full" placeholder="Optional - Explain why"></TextInput>
        </div>

        <div class="space-y-1">
          <InputLabel>Question 6:</InputLabel>
          <p>Please rate (on a scale of 1 - 5) the "Create Food" feature</p>
          <div class="flex space-x-3 ">
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">1</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">2</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">3</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">4</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">5</button>
          </div>
          <TextInput class="w-full" placeholder="Optional - Explain why"></TextInput>
        </div>

        <div class="space-y-1">
          <InputLabel>Question 7:</InputLabel>
          <p>Please rate (on a scale of 1 - 5) the "Calculator" feature</p>
          <div class="flex space-x-3 ">
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">1</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">2</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">3</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">4</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">5</button>
          </div>
          <TextInput class="w-full" placeholder="Optional - Explain why"></TextInput>
        </div>

        <div class="space-y-1">
          <InputLabel>Question 8:</InputLabel>
          <p>Please rate (on a scale of 1 - 5) the "Track Macros" feature</p>
          <div class="flex space-x-3 ">
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">1</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">2</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">3</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">4</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">5</button>
          </div>
          <TextInput class="w-full" placeholder="Optional - Explain why"></TextInput>
        </div>

        <div class="space-y-1">
          <InputLabel>Question 9:</InputLabel>
          <p>Please rate (on a scale of 1 - 5) the "Journal Entry" feature</p>
          <div class="flex space-x-3 ">
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">1</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">2</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">3</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">4</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">5</button>
          </div>
          <TextInput class="w-full" placeholder="Optional - Explain why"></TextInput>
        </div>

        <div class="space-y-1">
          <InputLabel>Question 10:</InputLabel>
          <p>Please rate (on a scale of 1 - 5) the "Carrot" feature</p>
          <div class="flex space-x-3 ">
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">1</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">2</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">3</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">4</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">5</button>
          </div>
          <TextInput class="w-full" placeholder="Optional - Explain why"></TextInput>
        </div>

        <div class="space-y-1">
          <InputLabel>Question 11:</InputLabel>
          <p>Please rate (on a scale of 1 - 5) the "Weigh In" feature</p>
          <div class="flex space-x-3 ">
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">1</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">2</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">3</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">4</button>
            <button type="button" class="bg-accent w-full rounded hover:bg-dark hover:text-light-text">5</button>
          </div>
          <TextInput class="w-full" placeholder="Optional - Explain why"></TextInput>
        </div>

        <div class="space-y-1">
          <InputLabel>Question 12:</InputLabel>
          <p>If you could add a feature, or change one in a major way, what would it be and why?</p>
          <textarea
            class="w-full min-h-40 text-sm border-gray-300 focus:border-accent focus:ring-accent rounded-md shadow-sm"
            style="resize: none;"></textarea>
        </div>

      </section>

      <section class="flex justify-end">
        <PrimaryButton>Submit</PrimaryButton>
      </section>

    </form>

  </GlobalLayout>
</template>