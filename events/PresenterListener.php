<?php

namespace Wame\PermissionModule\Events;

use Nette\Object;
use Nette\Application\Application;
use App\Core\Presenters\BasePresenter;
use Wame\Core\Event\PresenterStageChangeEvent;
use Wame\PermissionModule\Models\PermissionObject;

class PresenterListener extends Object 
{
    private $permissionObject;
    
    
	public function __construct(Application $application, PermissionObject $permissionObject)
    {
        $this->permissionObject = $permissionObject;
        
        $application->onPresenter[] = [$this, 'onPresenter'];
	}
    
    
    public function onPresenter($application, $presenter)
    {
        if ($presenter instanceof BasePresenter) {
            $presenter->onStageChange[] = function(PresenterStageChangeEvent $event) use ($presenter) {
                if ($event->enters('startup')) {
                    $this->checkPermission($presenter);
                }
            };
        }
    }
    
    
    /**
     * Check permission
     */
    private function checkPermission($presenter)
    {
        $presenterModule = substr(\Wame\Utils\Validators::validateModuleName($presenter->getModule()), 0, -6);
        $presenterName = $presenter->getName();
        
        $resource = 'Default';
        
        if(in_array($presenterName, $this->permissionObject->getResources())) {
            $resource = $presenterName;
        } else if (in_array($presenterModule, $this->permissionObject->getResources())) {
            $resource = $presenterModule;
        }
        
        if ($presenter->user->isAllowed($resource, $presenter->getAction())) {
            // TODO: redirect to parent
//            $this->redirect(':Admin:Dashboard:');
            \Tracy\Debugger::barDump("Not allowed!");
        }
    }

}
