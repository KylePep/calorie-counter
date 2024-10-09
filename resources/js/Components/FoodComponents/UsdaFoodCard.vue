<script setup>
import FoodCardButton from "./FoodCardButton.vue";

const props = defineProps(['foodItems']);

// const friedEggs =
//   { "fdcId": 173423, "gtinUpc": 0, "ndbNumber": 1128, "description": "Egg, whole, cooked, fried", "brandName": "N/A", "brandOwner": "N/A", "servingSize": 1, "servingSizeUnit": 0, "foodCategory": "Dairy and Egg Products", "labelNutrients": "N/A", "ingredients": "N/A", "foodNutrients": [{ "value": 0, "nutrientName": "Caffeine", "unitName": "MG", "percentDailyValue": 0 }, { "value": 0, "nutrientName": "Fiber, total dietary", "unitName": "G", "percentDailyValue": 0 }, { "value": 1.89, "nutrientName": "Iron, Fe", "unitName": "MG", "percentDailyValue": 0 }, { "value": 207, "nutrientName": "Sodium, Na", "unitName": "MG", "percentDailyValue": 0 }, { "value": 13.6, "nutrientName": "Protein", "unitName": "G", "percentDailyValue": 0 }, { "value": 0.83, "nutrientName": "Carbohydrate, by difference", "unitName": "G", "percentDailyValue": 0 }, { "value": 0.4, "nutrientName": "Total Sugars", "unitName": "G", "percentDailyValue": 0 }, { "value": 62, "nutrientName": "Calcium, Ca", "unitName": "MG", "percentDailyValue": 0 }, { "value": 821, "nutrientName": "Energy", "unitName": "kJ", "percentDailyValue": 0 }, { "value": 196, "nutrientName": "Energy", "unitName": "KCAL", "percentDailyValue": 0 }] }


// const v8 =
//   { "fdcId": 2695771, "gtinUpc": "00051000196217", "ndbNumber": 0, "description": "V8 +Energy Pomegranate Blueberry Juice Energy Drink, 8 fl oz Can", "brandName": "V8", "brandOwner": "CAMPBELL SOUP COMPANY", "servingSize": 237, "servingSizeUnit": "MLT", "foodCategory": "Non Alcoholic Beverages - Ready to Drink", "labelNutrients": "N/A", "ingredients": "INGREDIENTS: WATER, VEGETABLE JUICE (WATER AND CONCENTRATED JUICES OF SWEET POTATOES, PURPLE CARROTS, CARROTS), FRUIT JUICE (WATER AND CONCENTRATED JUICES OF APPLES, BLUEBERRIES, POMEGRANATES), NATURAL FLAVORING, MALIC ACID, CITRIC ACID, CAFFEINE FROM BLACK AND GREEN TEA, VITAMIN C (ASCORBIC ACID), SUCRALOSE, NIACINAMIDE (VITAMIN B3), PYRIDOXINE HYDROCHLORIDE (VITAMIN B6), CYANOCOBALAMIN (VITAMIN B12).", "foodNutrients": [{ "value": 0, "nutrientName": "Protein", "unitName": "G", "percentDailyValue": 0 }, { "value": 4.98, "nutrientName": "Carbohydrate, by difference", "unitName": "G", "percentDailyValue": 4 }, { "value": 21, "nutrientName": "Energy", "unitName": "KCAL", "percentDailyValue": 0 }, { "value": 4.15, "nutrientName": "Total Sugars", "unitName": "G", "percentDailyValue": 0 }, { "value": 0, "nutrientName": "Fiber, total dietary", "unitName": "G", "percentDailyValue": 0 }, { "value": 4, "nutrientName": "Calcium, Ca", "unitName": "MG", "percentDailyValue": 0 }, { "value": 0.08, "nutrientName": "Iron, Fe", "unitName": "MG", "percentDailyValue": 0 }, { "value": 25, "nutrientName": "Sodium, Na", "unitName": "MG", "percentDailyValue": 3 }] }

const getCalories = (item) => {
  const energy = item.foodNutrients.find(fn => fn.nutrientName == 'Energy' && fn.unitName == 'KCAL');
  return energy.value;
}

const getBrandedCalories = (item) => {
  const energy = getCalories(item);
  const caloriesToSize = energy * (item.servingSize * .01);
  return Math.round(caloriesToSize);
}

</script>


<template>



  <div @click="$emit('increase-by', item)" v-for="item in foodItems" :key="item.fdcId">

    <section
      class="flex flex-col break-inside-avoid hover:bg-gray-200 bg-gray-300  rounded-t border-4 border-black/25 pb-3 min-h-40">

      <div class="grid grid-cols-4 gap-1 bg-gray-200 justify-between items-end px-1 border-b-2 border-black/25">

        <div class=" text-gray-800 font-bold text-3xl drop-shadow-2xl">
          <template v-if="item.gtinUpc != 0">
            {{ getBrandedCalories(item) }}
          </template>
          <template v-else>
            {{ getCalories(item) }}
          </template>
        </div>

        <FoodCardButton icon="pencil">Edit</FoodCardButton>
        <FoodCardButton icon="star">Favorite</FoodCardButton>
        <FoodCardButton icon="plus">Add</FoodCardButton>

      </div>

      <div class="text-gray-800 font-bold p-3 drop-shadow-2xl my-auto">
        <h1 class="font-bold" :class="[item.gtinUpc ? 'text-base' : 'text-lg']">{{ item.description }}</h1>
        <p class="text-xs" v-if="item.gtinUpc && item.brandOwner">
          ( {{ item.brandName + [item.brandName ? ' by' : ''] }} {{ item.brandOwner }} )
        </p>
      </div>

    </section>

    <section
      class="grid grid-cols-10 grid-rows-2 grid-flow-col gap-1 p-1 border-4 border-t-0 border-black/25 bg-gray-300">
      <div v-for="block in Math.round([item.gtinUpc ? getBrandedCalories(item) : getCalories(item)] / 50) "
        class="bg-gray-700 h-4 border-2 border-black rounded-sm">
      </div>
    </section>



  </div>
</template>
