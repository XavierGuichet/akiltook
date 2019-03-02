<?php

namespace App\OAuth\ResourceOwner;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use HWI\Bundle\OAuthBundle\OAuth\ResourceOwner\FacebookResourceOwner;
/**
 * FacebookResourceOwner.
 */
class CustomFacebookResourceOwner extends FacebookResourceOwner
{
    /**
     * {@inheritdoc}
     */
    public function getAccessToken(Request $request, $redirectUri, array $extraParameters = array())
    {
        $parameters = array();
        if ($request->query->has('fb_source')) {
            $parameters['fb_source'] = $request->query->get('fb_source');
        }

        if ($request->query->has('fb_appcenter')) {
            $parameters['fb_appcenter'] = $request->query->get('fb_appcenter');
        }

        // We force use of front login page for redirect
        // FB want the redirect path to be the same during the call from front and here
        $referer = $request->server->get('HTTP_REFERER');
        if ($url = parse_url($referer)) {
         $stripped_ref = $url['scheme'].'://'.$url['host'].$url['path'];
        }
        $redirectUri = $this->httpUtils->generateUri($request, $stripped_ref);

        return parent::getAccessToken($request, $this->normalizeUrl($redirectUri, $parameters), $extraParameters);
    }
}
