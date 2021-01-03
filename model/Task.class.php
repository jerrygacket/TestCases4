<?php

class Task {
    protected static $table = 'tasks';

    public static function getMany() {
        $sql = 'SELECT * FROM '.self::$table;

        return db::getInstance()->Query($sql);
    }

    public static function getOne($id) {
        $sql = 'SELECT * FROM '.self::$table.' WHERE id=:id';

        return db::getInstance()->Query($sql, [':id' => $id], true);
    }

    public static function changeStatus($id, $newStatus) {
        $sql = 'UPDATE '.self::$table.' SET ready = :newStatus, edited = true WHERE id=:id';

        return db::getInstance()->Update($sql, [':id' => $id, ':newStatus' => $newStatus]);
    }

    public static function newTask($taskData) {
        $taskData = array_intersect_key($taskData, ['username' => 1, 'email' => 1, 'description' => 1, ]);
        if (count($taskData) < 3) {
            return false;
        }

        $keys = array_keys($taskData);
        $columns = implode(',', $keys);
        $masks = ':' . implode(',:', $keys);

        $sql = 'INSERT INTO '.self::$table.' ('.$columns.') VALUES ('.$masks.')';

        return db::getInstance()->Insert($sql, $taskData);
    }

    public static function editTask($taskData) {
        if (!isset($taskData['id'])) {
            return false;
        }
        $oldTask = self::getOne($taskData['id']);
        if (empty($oldTask)) {
            return false;
        }

        $newTask = array_merge($oldTask, $taskData);
        $taskData = array_intersect_key($newTask, ['username' => 1, 'email' => 1, 'description' => 1, 'ready' => 1]);
        if (count($taskData) < 4) {
            return false;
        }

        $sets = [];
        foreach ($taskData as $key => $value) {
            $sets[] = $key.'=:'.$key;
        }
        $sets[] = 'edited=true';
        $sets_s = implode(',',$sets);

        $sql = 'UPDATE '.self::$table.' SET '.$sets_s.' WHERE id = '.$oldTask['id'];

        return db::getInstance()->Update($sql, $taskData);
    }
}