<?php

namespace Kanboard\Plugin\AutomaticActionSuite\Action;

use Kanboard\Model\TaskModel;
use Kanboard\Action\Base;

/**
 * Close all tasks in specified column on specified day
 *
 * @package Kanboard\Action
 * @author  Jon Baird
 */
class CloseTasksInColumnOnDay extends Base
{
    /**
     * Get automatic action description
     *
     * @access public
     * @return string
     */
    public function getDescription()
    {
        return t('Close all tasks in specified column on specified day.');
    }

    /**
     * Get the list of compatible events
     *
     * @access public
     * @return array
     */
    public function getCompatibleEvents()
    {
        return array(TaskModel::EVENT_DAILY_CRONJOB);
    }

    /**
     * Get the required parameter for the action (defined by the user)
     *
     * @access public
     * @return array
     */
    public function getActionRequiredParameters()
    {
        return array(
            'duration' => t('!Numbered! (Monday = 1, Sunday = 7) Day of Week '),
            'column_id' => t('Column')
        );
    }

    /**
     * Get the required parameter for the event
     *
     * @access public
     * @return string[]
     */
    public function getEventRequiredParameters()
    {
        return array('tasks');
    }

    /**
     * Execute the action (close the task)
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool            True if the action was executed or false when not executed
     */
    public function doAction(array $data)
    {
        $results = array();

        foreach ($data['tasks'] as $task) {

            if (date('N') == $this->getParam('duration') && $task['column_id'] == $this->getParam('column_id')) {
                $results[] = $this->taskStatusModel->close($task['id']);
            }
        }

        return in_array(true, $results, true);
    }

    /**
     * Check if the event data meet the action condition
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool
     */
    public function hasRequiredCondition(array $data)
    {
        return count($data['tasks']) > 0;
    }
}