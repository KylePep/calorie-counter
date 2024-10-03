export class FoodNutrient {
  constructor(data) {
    this.value = data.value;
    this.nutrientName = data.nutrientName;
    this.unitName = data.unitName;
    this.percentDailyValue = data.percentDailyValue;
  }
}