<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandedFoodItem extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'description',
        'fdcId',
        'brandOwner',
        'servingSize',
        'servingSizeUnit',
        'brandedFoodCategory',
        'labelNutrients',
        'ingredients',
    ];
}

//THIS IS WHAT I WANT ON THE FRONT END

// <p>
// {{ $page.props.foodData.description }}
// </p>
// <p>
// {{ $page.props.foodData.brandOwner }}

// </p>
// <p>
// Serving Size:
// {{ $page.props.foodData.servingSize }}

// {{ $page.props.foodData.servingSizeUnit }}
// </p>
// <p>
// Food Category:
// {{ $page.props.foodData.brandedFoodCategory }}

// </p>

// <ul>
// <li>Nutrients</li>
// <li class="my-2" v-for="(value, name, index) in $page.props.foodData.labelNutrients">
//     {{ name }}: {{ value.value }}
// </li>
// </ul>
// <p>
// {{ $page.props.foodData.ingredients }}
// </p>

//THIS IS WHAT THE DATA WILL LOOK LIKE

// BrandedFoodItem:
// type: object
// required:
//   - fdcId
//   - dataType
//   - description
// properties:
//   fdcId:
//     type: integer
//     example: 534358
//   availableDate:
//     type: string
//     example: "8/18/2018"
//   brandOwner:
//     type: string
//     example: "Kar Nut Products Company"
//   dataSource:
//     type: string
//     example: "LI"
//   dataType:
//     type: string
//     example: "Branded"
//   description:
//     type: string
//     example: "NUT 'N BERRY MIX"
//   foodClass:
//     type: string
//     example: 'Branded'
//   gtinUpc:
//     type: string
//     example: "077034085228"
//   householdServingFullText:
//     type: string
//     example: "1 ONZ"
//   ingredients:
//     type: string
//     example: "PEANUTS (PEANUTS, PEANUT AND/OR SUNFLOWER OIL). RAISINS. DRIED CRANBERRIES (CRANBERRIES, SUGAR, SUNFLOWER OIL). SUNFLOWER KERNELS AND ALMONDS (SUNFLOWER KERNELS AND ALMONDS, PEANUT AND/OR SUNFLOWER OIL)."
//   modifiedDate:
//     type: string
//     example: "8/18/2018"
//   publicationDate:
//     type: string
//     example: "4/1/2019"
//   servingSize:
//     type: integer
//     format: float32
//     example: 28
//   servingSizeUnit:
//     type: string
//     example: "g"
//   preparationStateCode:
//     type: string
//     example: "UNPREPARED"
//   brandedFoodCategory:
//     type: string
//     example: "Popcorn, Peanuts, Seeds & Related Snacks"
//   tradeChannel:
//     type: array
//     items:
//       type: string
//     example: ["CHILD_NUTRITION_FOOD_PROGRAMS", "GROCERY"]
//   gpcClassCode:
//     type: integer
//     example: 50161800
//   foodNutrients:
//     type: array
//     items:
//       $ref: '#/components/schemas/FoodNutrient'
//   foodUpdateLog:
//     type: array
//     items:  
//       $ref: '#/components/schemas/FoodUpdateLog'
//   labelNutrients:
//     type: object
//     properties:
//       fat:
//         type: object
//         properties:
//           value:
//             type: number
//             format: float
//             example: 8.9992
//       saturatedFat:
//         type: object
//         properties:
//           value:
//             type: number
//             format: float
//             example: 0.9996
//       transFat:
//         type: object
//         properties:
//           value:
//             type: number
//             format: float
//             example: 0
//       cholesterol:
//         type: object
//         properties:
//           value:
//             type: number
//             format: float
//             example: 0
//       sodium:
//         type: object
//         properties:
//           value:
//             type: number
//             format: float
//             example: 0
//       carbohydrates:
//         type: object
//         properties:
//           value:
//             type: number
//             format: float
//             example: 12.0008
//       fiber:
//         type: object
//         properties:
//           value:
//             type: number
//             format: float
//             example: 1.988
//       sugars:
//         type: object
//         properties:
//           value:
//             type: number
//             format: float
//             example: 7.9996
//       protein:
//         type: object
//         properties:
//           value:
//             type: number
//             format: float
//             example: 4.0012
//       calcium:
//         type: object
//         properties:
//           value:
//             type: number
//             format: float
//             example: 19.88
//       iron:
//         type: object
//         properties:
//           value:
//             type: number
//             format: float
//             example: 0.7196
//       potassium:
//         type: object
//         properties:
//           value:
//             type: number
//             format: float
//             example: 159.88
//       calories:
//         type: object
//         properties:
//           value:
//             type: number
//             format: float
//             example: 140