<script setup>

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  }
});

</script>


<template>

  <div class="grid grid-cols-2 gap-2 py-4 max-w-2xl mx-auto ">
    <div class="text-2xl font-bold text-black/75">
      <Link href="/"
        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] uppercase">
      Calorie Counter
      </Link>
    </div>
    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
      <Link v-if="$page.props.auth.user" :href="route('dashboard')"
        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] ">
      Dashboard
      </Link>

      <template v-else>
        <Link :href="route('login')"
          class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] ">
        Log in
        </Link>

        <Link v-if="canRegister" :href="route('register')"
          class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] ">
        Register
        </Link>
        <Link v-if="canRegister" :href="route('calculator')"
          class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] ">
        Calculate
        </Link>
      </template>

    </nav>
  </div>
</template>


<style lang="scss" scoped></style>