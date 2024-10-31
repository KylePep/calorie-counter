export class FoodSearchResponse {
  constructor(data) {
    this.totalHits = data.totalHits;
    this.currentPage = data.currentPage;
    this.totalPages = data.totalPages;
  }
}