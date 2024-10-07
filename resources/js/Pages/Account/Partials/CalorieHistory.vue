<template>
  <h1>History</h1>
  <div>
    Last 7 days of tracking
  </div>
  <!-- <div>
    Calorie Progress 13993 : 14000
  </div> -->

  <div v-for="(day, index) in calorieDays" :key="index"
    class="min-h-40 min-w-40 bg-gray-300 p-3 justify-between m-1 scroll-ml-1 snap-start rounded">

    <div>
      <p class="font-bold text-lg">{{ getDayOfWeek(new Date(day.created_at).getDay()) }}, {{ new
        Date(day.created_at).toLocaleDateString() }}</p>
      <h2>Calories: {{ day.count }}</h2>
      <h3>Goal: {{ day.goal }}</h3>
      <p v-for="item in dayItems(day)" class="inline-block bg-gray-200 rounded-md mx-1 my-1 px-1 lowercase text-sm">{{
        item }}</p>
    </div>

  </div>

  <div v-if="sevenDayHistory?.length" id="scrollContainer"
    class="flex  gap-1  min-h-40 p-2 text-center border-4 rounded-lg border-black/25 overflow-x-auto whitespace-nowrap snap-x">



    <div v-for="(day, index) in sevenDayHistory" :key="index"
      class="min-h-40 min-w-40 bg-gray-300 p-3 justify-between m-1 scroll-ml-1 snap-start rounded">

      <template v-if="day.isPlaceholder">
        <div class="text-wrap">
          <p class="font-bold text-lg">
            {{ day.dayOfTheWeek }}
          </p>
          <p>
            Nothing got logged!
          </p>
        </div>
      </template>

      <template v-else>
        <p class="font-bold text-lg">{{ day.dayOfTheWeek }}</p>
        <h2>Calories: {{ day.count }}</h2>
        <h3>Goal: {{ day.goal }}</h3>
      </template>

    </div>
  </div>

</template>


<script>
import { computed, onMounted } from "vue";
export default {
  props: ({
    calorieDays: {
      type: Object
    }
  }),
  setup(props) {

    const getDayOfWeek = (date) => {
      const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
      return daysOfWeek[date];
    };

    const consecutiveDates = computed(() => {
      const totalDays = 7;
      let days = [];
      props.calorieDays.forEach(day => {
        const currentDay = new Date(day.created_at).getDay();

        if (days.length > 0) {
          const lastDay = days[days.length - 1];

          if (currentDay !== lastDay + 1) {
            for (let i = lastDay + 1; i < currentDay; i++) {
              days.push(i);
            }
          }
        }
        days.push(currentDay);
      });
      const placeholderDays = [];
      const remainingDays = totalDays - days.length;
      for (let ii = 1; ii < remainingDays + 1; ii++) {
        let dayValue = days[0] - ii
        if (dayValue < 0) {
          dayValue += 7
        }
        placeholderDays.unshift(dayValue)
      }

      const consecutiveDays = [...placeholderDays, ...days]

      return consecutiveDays;
    });


    // onMounted(() => {

    //   const scrollContainer = document.getElementById('scrollContainer')
    //   if (scrollContainer) {
    //     scrollContainer.scrollLeft = 1000
    //   }

    // })

    return {
      calorieDays: computed(() => props.calorieDays),
      consecutiveDates,
      getDayOfWeek,

      dayItems(calorieDay) {
        if (calorieDay.food_items.length == 0) {
          return []
        } else {
          return calorieDay.food_items
            .split('"')
            .filter((item, index) => index % 2 !== 0 && item.trim());
        }
      },

      sevenDayHistory: computed(() => {
        let daysHistory = [];
        const daysToCheck = [...consecutiveDates.value]; // Copy of consecutive days
        const addedDays = new Set(); // Track processed days

        daysToCheck.forEach((day) => {
          let foundDay = false;

          props.calorieDays.forEach(cd => {
            const dayValue = new Date(cd.created_at).getDay();

            if (dayValue === day && !addedDays.has(day)) {
              cd.dayOfTheWeek = getDayOfWeek(dayValue);
              cd.isPlaceholder = false;
              daysHistory.push(cd);
              addedDays.add(day);
              foundDay = true;
            }
          });

          if (!foundDay && !addedDays.has(day)) {
            daysHistory.push({ dayOfTheWeek: getDayOfWeek(day), isPlaceholder: true });
            addedDays.add(day);
          }
        });

        return daysHistory;
      })
    }
  }
}
</script>


<style lang="scss" scoped></style>