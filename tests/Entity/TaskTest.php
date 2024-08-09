<?php

namespace Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use App\Entity\Task;

class TaskTest extends TestCase
{
    public function testDefault()
    {
        $task = new Task();

        $task->setTitle("Task N°1");
        $task->setContent("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum");
        $task->setCreatedAt(new \DateTime());
        $task->setDone(true);
        $task->setOneUser(new User());

        $this->assertSame("Task N°1", $task->getTitle());
        $this->assertSame("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum", $task->getContent());
    }

}