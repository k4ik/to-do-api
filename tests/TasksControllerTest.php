<?php
use PHPUnit\Framework\TestCase;
use Controller\TasksController;

class TasksControllerTest extends TestCase
{
    private $controller;
    private $mockPdo;

    protected function setUp(): void
    {
        $this->mockPdo = $this->createMock(PDO::class);
        $this->controller = new TasksController($this->mockPdo);
    }

    public function testCreateTaskWithValidData()
    {
        $mockStmtInsert = $this->createMock(PDOStatement::class);
        $mockStmtInsert->expects($this->once())->method('execute')->willReturn(true);

        $this->mockPdo->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('INSERT INTO tasks'))
            ->willReturn($mockStmtInsert);

        $inputData = ['title' => 'Test Task', 'completed' => true];
        $result = $this->controller->create_task($inputData);
        $resultData = json_decode($result, true);

        $this->assertEquals('success', $resultData['status']);
    }

    public function testCreateTaskWithoutTitle()
    {
        $inputData = ['title' => '', 'completed' => true];
        $result = $this->controller->create_task($inputData);
        $resultData = json_decode($result, true);

        $this->assertEquals('error', $resultData['status']);
        $this->assertEquals('Title is required', $resultData['message']);
    }

    public function testViewTasks()
    {
        $mockStmtSelect = $this->createMock(PDOStatement::class);
        $mockStmtSelect->expects($this->once())->method('fetchAll')->willReturn([
            ['id' => 1, 'title' => 'Test Task', 'completed' => 1]
        ]);

        $this->mockPdo->expects($this->once())
            ->method('query')
            ->with($this->stringContains('SELECT * FROM tasks'))
            ->willReturn($mockStmtSelect);

        $result = $this->controller->view_tasks();
        $resultData = json_decode($result, true);

        $this->assertCount(1, $resultData);
        $this->assertEquals('Test Task', $resultData[0]['title']);
    }

    public function testUpdateTask()
    {
        $mockStmtUpdate = $this->createMock(PDOStatement::class);
        $mockStmtUpdate->expects($this->once())->method('execute')->willReturn(true);

        $this->mockPdo->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('UPDATE tasks SET title = :title'))
            ->willReturn($mockStmtUpdate);

        $data = ['title' => 'Updated Task', 'completed' => 0];
        $result = $this->controller->update_task(1, $data);
        $resultData = json_decode($result, true);

        $this->assertEquals('success', $resultData['status']);
    }

    public function testDeleteTask()
    {
        $mockStmtDelete = $this->createMock(PDOStatement::class);
        $mockStmtDelete->expects($this->once())->method('execute')->willReturn(true);

        $this->mockPdo->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('DELETE FROM tasks'))
            ->willReturn($mockStmtDelete);

        $result = $this->controller->delete_task(1);
        $resultData = json_decode($result, true);

        $this->assertEquals('success', $resultData['status']);
    }
}
