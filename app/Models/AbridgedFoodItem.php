<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbridgedFoodItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'fdcId',
        'brandOwner',
    ];
}

// AbridgedFoodItem:
// type: object
// required:
//   - fdcId
//   - dataType
//   - description
// properties:
//   dataType:
//     type: string
//     example: "Branded"
//   description:
//     type: string
//     example: "NUT 'N BERRY MIX"
//   fdcId:
//     type: integer
//     example: 534358
//   foodNutrients:
//     type: array
//     items:
//       $ref: '#/components/schemas/AbridgedFoodNutrient'
//   publicationDate:
//     type: string
//     example: "4/1/2019"
//   brandOwner:
//     type: string
//     description: only applies to Branded Foods
//     example: "Kar Nut Products Company"
//   gtinUpc:
//     type: string
//     description: only applies to Branded Foods
//     example: "077034085228"
//   ndbNumber:
//     type: integer
//     description: only applies to Foundation and SRLegacy Foods
//     example: 7954
//   foodCode:
//     type: string
//     description: only applies to Survey Foods
//     example: "27415110"
    