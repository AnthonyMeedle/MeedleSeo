<?php

namespace MeedleSeo\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;

class MeedleSeoHook extends BaseHook {
    public function onTabSeoUpdateForm(HookRenderEvent $event){
		$html = $this->render("meedleseo.html", array("object_id" => $event->getArgument('id', null), "object_type" => $event->getArgument('type', null)));
		$event->add($html);		
    }
    public function onMainFooterJs(HookRenderEvent $event){
		$html = $this->render("scriptjs.html");
		$event->add($html);		
    }
    public function onMainHeadBottom(HookRenderEvent $event){
		$html = $this->render("meedleseo.html", array("object_type" => $this->getView()));
		$event->add($html);
    }
}
?>