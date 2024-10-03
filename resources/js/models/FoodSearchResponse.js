import { BrandedFoodItem } from "./BrandedFoodItem.js";

export class FoodSearchResponse {
  constructor(data) {
    this.totalHits = data.totalHits;
    this.currentPage = data.currentPage;
    this.totalPages = data.totalPages;
    // this.foods = data.foods.map(food => new BrandedFoodItem(food));
  }
}