<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;


class PersonalRecordRepository
{
    private $table = 'personal_record';

    public function getRanking(int $movementId):? array
    {
       return DB::select(
        'SELECT m.name,max(pr.value) AS record,u.name FROM personal_record AS pr 
        INNER JOIN movement AS m ON pr.movement_id = m.id
        INNER JOIN user as u on pr.user_id = u.id
        WHERE m.id = :movement_id
        GROUP BY  m.name,u.name,m.id,u.id
        ORDER BY record DESC;',
        ['movement_id' => $movementId]);
    }

}
