<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

class LocaleListener
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ($lang = $request->query->get('lang')) {
            if ($request->hasSession()) {
                $request->getSession()->set('_locale', $lang);
            }
            $request->setLocale($lang);
            return;
        }

        if ($request->hasSession() && $loc = $request->getSession()->get('_locale')) {
            $request->setLocale($loc);
        }
    }
}
