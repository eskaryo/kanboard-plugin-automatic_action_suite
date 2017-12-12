<?php

namespace Kanboard\Plugin\AutomaticActionSuite\Action;

use Kanboard\Model\TaskModel;
use Kanboard\Action\Base;

class AssignCategoryBySwimlane extends Base
{

    public function getDescription()
    {
        return t('Assign a Category to a Task when a moved to a Swimlane');
    }

    public function getCompatibleEvents()
    {

        return array(
	    TaskModel::EVENT_CREATE,
        TaskModel::EVENT_MOVE_SWIMLANE,
        );
    }

    public function getActionRequiredParameters()
    {
        return array(
            'swimlane_id' => t('Swimlane'),
            'category_id' => t('Category'),
	        
        );
    }

    public function getEventRequiredParameters()
    {
        return array(
            'task_id',
	        'task' => array(
                'project_id',
                'swimlane_id',
            ),
        );
    }

    public function doAction(array $data)
    {
        $values = array(
            'id' => $data['task_id'],
            'category_id' => $this->getParam('category_id'),
        );

        return $this->taskModificationModel->update($values);
    }

    public function hasRequiredCondition(array $data)
    {
        return $data['task']['swimlane_id'] == $this->getParam('swimlane_id') && !$data['task']['category_id'];
    }
}
