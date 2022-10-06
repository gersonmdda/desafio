<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

use  App\Models\Movement;


class MovementRepository
{

    public function getMovement(int $movementId):? Movement
    {
       return Movement::find($movementId);
    }

}
