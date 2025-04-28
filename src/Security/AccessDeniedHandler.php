<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;


class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function handle(Request $request, AccessDeniedException $accessDeniedException): RedirectResponse
    {
        //cette fonction est appelée quand l'utilisateur n'a pas le droit d'accéder à une page
        //on redirige vers la page d'accueil
        return new RedirectResponse('/'); //redirection vers la page d'accueil
    }
}
