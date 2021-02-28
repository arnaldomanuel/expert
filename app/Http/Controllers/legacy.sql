 $days = DB::selectOne("SELECT DATEDIFF(now(), updated_at) +1 AS 'days' FROM course_grants
         WHERE course_id=" . $lesson->module->course_id . " and user_id = " . auth()->user()->id);

            $ids = DB::select("SELECT lessons.id from lessons JOIN modules 
        on module_id = modules.id LEFT JOIN courses on modules.course_id = courses.id 
        WHERE course_id = " . $lesson->module->course_id . "  ORDER BY lessons.order 
        ASC LIMIT " . $days->days);

            $found = false;
            foreach ($ids as $idArray) {
                if ($idArray->id == $id) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                abort(403, 'Termine as aulas anteriores');
            }