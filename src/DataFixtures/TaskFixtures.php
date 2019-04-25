<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $task = new Task();
        $task->setTitle('Tâche 1');
        $task->setContent('Cette tâche a été créé via les Fixtures');
        $task->isDone(0);
        $manager->persist($task);

        $task = new Task();
        $task->setTitle('Tâche 2');
        $task->setContent('Cette tâche a été créé via les Fixtures');
        $task->isDone(0);
        $manager->persist($task);

        $task = new Task();
        $task->setTitle('Tâche 3');
        $task->setContent('Cette tâche a été créé via les Fixtures');
        $task->isDone(0);
        $manager->persist($task);

        $task = new Task();
        $task->setTitle('Tâche 4');
        $task->setContent('Cette tâche a été créé via les Fixtures');
        $task->isDone(0);
        $manager->persist($task);

        $task = new Task();
        $task->setTitle('Tâche 5');
        $task->setContent('Cette tâche a été créé via les Fixtures');
        $task->isDone(0);
        $manager->persist($task);

        $task = new Task();
        $task->setTitle('Tâche 6');
        $task->setContent('Cette tâche a été créé via les Fixtures');
        $task->isDone(0);
        $manager->persist($task);

        $task = new Task();
        $task->setTitle('Tâche 7');
        $task->setContent('Cette tâche a été créé via les Fixtures');
        $task->isDone(0);
        $manager->persist($task);

        $task = new Task();
        $task->setTitle('Tâche 8');
        $task->setContent('Cette tâche a été créé via les Fixtures');
        $task->isDone(0);
        $manager->persist($task);

        $task = new Task();
        $task->setTitle('Tâche 9');
        $task->setContent('Cette tâche a été créé via les Fixtures');
        $task->isDone(0);
        $manager->persist($task);

        $task = new Task();
        $task->setTitle('Tâche 10');
        $task->setContent('Cette tâche a été créé via les Fixtures');
        $task->isDone(0);
        $manager->persist($task);

        $task = new Task();
        $task->setTitle('Tâche 11');
        $task->setContent('Cette tâche a été créé via les Fixtures');
        $task->isDone(0);
        $manager->persist($task);

        $task = new Task();
        $task->setTitle('Tâche 12');
        $task->setContent('Cette tâche a été créé via les Fixtures');
        $task->isDone(0);
        $manager->persist($task);

        $task = new Task();
        $task->setTitle('Tâche 13');
        $task->setContent('Cette tâche a été créé via les Fixtures');
        $task->isDone(0);
        $manager->persist($task);

        $manager->flush();
    }
}
