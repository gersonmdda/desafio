<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;


class PersonalRecordRepository
{

    public function getRanking(int $movementId):? array
    {
       return DB::select(
        'SELECT best_ranking.record,best_ranking.user_name,pr_2.date
        FROM
        (SELECT max(pr.value) AS record,u.name as user_name,u.id as user_id, m.id as movement_id
            FROM personal_record AS pr 
            INNER JOIN movement AS m ON pr.movement_id = m.id
            INNER JOIN user as u on pr.user_id = u.id
            WHERE m.id = :movement_id
            GROUP BY  m.name,u.name,m.id,u.id
            ORDER BY record DESC) as best_ranking
        INNER JOIN personal_record AS pr_2 ON pr_2.movement_id = best_ranking.movement_id 
												AND pr_2.user_id=best_ranking.user_id 
                                                AND best_ranking.record = pr_2.value
                                                AND pr_2.date = (SELECT max(pr_3.date) FROM personal_record as pr_3 WHERE pr_3.movement_id = best_ranking.movement_id AND  pr_3.user_id=best_ranking.user_id AND best_ranking.record = pr_3.value)
        GROUP BY best_ranking.record,best_ranking.user_name,pr_2.date
        ORDER BY best_ranking.record DESC;',
        ['movement_id' => $movementId]);
    }

}
