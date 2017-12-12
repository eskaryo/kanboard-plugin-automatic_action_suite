<?php

namespace Kanboard\Plugin\AutomaticActionSuite;

use Kanboard\Core\Plugin\Base;
use Kanboard\Plugin\AutomaticActionSuite\Action\AutoTrackSubtasks;
use Kanboard\Plugin\AutomaticActionSuite\Action\AssignCategoryBySwimlane;
use Kanboard\Plugin\AutomaticActionSuite\Action\CloseTasksInColumnOnDay;

class Plugin extends Base
{
    public function initialize()
    {
        //$this->actionManager->register(new AutoTrackSubtasks($this->container));
        $this->actionManager->register(new AssignCategoryBySwimlane($this->container));
        $this->actionManager->register(new CloseTasksInColumnOnDay($this->container));
    }

    public function onStartup()
    {
        //Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginName()
    {
        return 'AutomaticActionSuite';
    }

    public function getPluginDescription()
    {
        return t('Provides additional automatic actions for Kanboard');
    }

    public function getPluginAuthor()
    {
        return 'Jon Baird';
    }

    public function getPluginVersion()
    {
        return '0.0.1';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/kanboard/plugin-myplugin';
    }
}
