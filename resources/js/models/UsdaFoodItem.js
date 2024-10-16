import { FoodNutrient } from "./FoodNutrient.js";

export class UsdaFoodItem {
  constructor(data) {
    this.fdcId = data.fdcId || 0;
    this.gtinUpc = data.gtinUpc || 0;
    this.ndbNumber = data.ndbNumber || 0;
    this.description = data.description;
    this.dataType = data.dataType;
    this.foodClass = data.foodClass;
    this.brandName = data.brandName || 'N/A';
    this.brandOwner = data.brandOwner || 'N/A';
    this.foodPortions = data.foodPortions;
    this.householdServingFullText = data.householdServingFullText;
    this.servingSize = data.servingSize || 0;
    this.servingSizeUnit = data.servingSizeUnit || '';
    this.foodCategory = data.brandedFoodCategory ? data.brandedFoodCategory : data.foodCategory.description;
    this.labelNutrients = data.labelNutrients || 'N/A';
    this.ingredients = data.ingredients || 'N/A';
    this.foodNutrients = data.foodNutrients
      .filter(nutrient => ['protein', 'energy', 'caffeine', 'iron, fe', 'carbohydrate, by difference', 'total sugars', 'calcium, ca', 'fiber, total dietary', 'sodium, na'].includes(nutrient.nutrient.name.toLowerCase()))
      .map(nutrient => new FoodNutrient({
        value: nutrient.amount,
        nutrientName: nutrient.nutrient.name,
        unitName: nutrient.nutrient.unitName,
      }));
  }
}