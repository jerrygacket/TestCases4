<?php

class TaskController extends Controller
{
    public $view = 'task';

    public function change($data)
    {
        if (isset($data['id'])) {
            if($task = Task::changeStatus($data['id'], $data['status'])) {
                return $task;
            }
        }
        return false;
    }

    public function new($data)
    {
        $result = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $taskData = Task::newTask($_POST);

            if (empty($taskData)) {
                $result['saveError'] = 'Неверные данные';
            } else {
                $result['tasks'] = Task::getMany();
                $result['saveSuccess'] = 'Создана новая задача';
                $result['newView'] = '../index/index';
            }
        }

        return $result;
    }

    public function edit($data)
    {
        $result = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $taskData = Task::editTask($_POST);

            if (empty($taskData)) {
                $result['saveError'] = 'Неверные данные';
            } else {
                $result['task'] = Task::getOne($data['id']);
                $result['saveSuccess'] = 'Задача сохранена';
            }

            return $result;
        }

        if (isset($data['id'])) {
            return ['task' => Task::getOne($data['id'])];
        }

        return $result;
    }
}