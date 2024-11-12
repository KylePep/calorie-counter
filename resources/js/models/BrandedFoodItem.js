import { FoodNutrient } from "./FoodNutrient.js";

export class BrandedFoodItem {
  constructor(data) {
    this.fdcId = data.fdcId || 0;
    this.gtinUpc = data.gtinUpc || 0;
    this.ndbNumber = data.ndbNumber || 0;
    this.description = data.description;
    this.brandName = data.brandName || 'N/A';
    this.brandOwner = data.brandOwner || 'N/A';
    this.servingSize = data.servingSize || 1;
    this.servingSizeUnit = data.servingSizeUnit || 0;
    this.foodCategory = data.foodCategory || 'Food';
    this.labelNutrients = data.labelNutrients || 'N/A';
    this.ingredients = data.ingredients || 'N/A';
    this.foodNutrients = data.foodNutrients
      .filter(nutrient => ['protein', 'energy', 'caffeine', 'total lipid (fat)', 'iron, fe', 'carbohydrate, by difference', 'total sugars', 'calcium, ca', 'fiber, total dietary', 'sodium, na'].includes(nutrient.nutrientName.toLowerCase()))
      .map(nutrient => new FoodNutrient(nutrient));
  }
}