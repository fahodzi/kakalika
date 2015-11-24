<?php
namespace kakalika\tests\cases;
use ntentan\dev\testing\DatabaseTestCase;
use kakalika\modules\issues\Issues;

class IssuesTest extends DatabaseTestCase
{
    public function testCreateIssue()
    {
        $issue = Issues::createNew();
        $issue->title = 'Test Issue';
        $issue->opener = 1;
        $issue->project_id = 1;
        $success = $issue->save();
        
        $this->assertEquals(true, $success);
    }
    
    protected function getDataSet()
    {
        return new \PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            'issues' => [],
            'users' => [
                [
                    'id' => 1, 
                    'username' => 'testuser', 
                    'password' => md5('testuser'),
                    'email' => 'testuser@kakalika.test',
                    'firstname' => 'Test'
                ]
            ],
            'projects' => [
                ['id' => 1, 'name' => 'Test Project', 'code' => 'test']
            ]
        ]);
    }
}
