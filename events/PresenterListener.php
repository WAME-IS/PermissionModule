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
        
        $action = $presenter->getAction();
        $resources = $this->permissionObject->getResources();
        $resource = 'Default';
        
        if(in_array($presenterName, $resources)) {
            $resource = $presenterName;
        } else if (in_array($presenterModule, $resources)) {
            $resource = $presenterModule;
        }
        
        if (!$presenter->user->isAllowed($resource, $action)) {
            \Tracy\Debugger::barDump("Not allowed!", "Resource: $resource | Action: $action");
//            $presenter->flashMessage(_('To enter this section you have not sufficient privileges.'), 'danger');
            // TODO: redirect to route parent
//            $presenter->redirect(':Admin:Dashboard:');
        }
    }

}
