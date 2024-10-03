import { FoodNutrient } from "./FoodNutrient.js";

export class BrandedFoodItem {
  constructor(data) {
    this.fdcId = data.fdcId;
    this.gtinUpc = data.gtinUpc;
    this.description = data.description;
    this.brandName = data.brandName;
    this.brandOwner = data.brandOwner;
    this.servingSize = data.servingSize;
    this.servingSizeUnit = data.servingSizeUnit;
    this.foodCategory = data.foodCategory;
    this.labelNutrients = data.labelNutrients;
    this.ingredients = data.ingredients;
    this.foodNutrients = data.foodNutrients.map(nutrient => new FoodNutrient(nutrient));
  }
}