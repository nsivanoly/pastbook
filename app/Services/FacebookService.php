<?php
namespace App\Services;

use App\User;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\GraphNodes\GraphEdge;
use Illuminate\Support\Facades\Auth;
use Nsivanoly\LaravelFacebookSdk\LaravelFacebookSdk;

/**
 * Class ExportReportService
 * @package App\Services
 */
class FacebookService
{
    /**
     * @var LaravelFacebookSdk
     */
    protected $fb;

    /**
     * FacebookService constructor.
     * @param LaravelFacebookSdk $fb
     */
    public function __construct(LaravelFacebookSdk $fb)
    {
        $this->fb = $fb;
    }

    /**
     * facebook Login
     * get fb auth url
     * @return string
     */
    public function facebookLogin(){
        return $this->fb->getLoginUrl(['email', 'public_profile', 'user_photos']);
    }

    /**
     * facebook Callback
     * @return GraphEdge
     * @throws FacebookSDKException
     */
    public function facebookCallback(){
        // Obtain an access token.
        try {
            $token = $this->fb->getAccessTokenFromRedirect();
        } catch (FacebookSDKException $e) {
            dd($e->getMessage());
        }

        // Access token will be null if the user denied the request
        // or if someone just hit this URL outside of the OAuth flow.
        if (! $token) {
            // Get the redirect helper
            $helper = $this->fb->getRedirectLoginHelper();

            if (! $helper->getError()) {
                abort(403, 'Unauthorized action.');
            }

            // User denied the request
            dd(
                $helper->getError(),
                $helper->getErrorCode(),
                $helper->getErrorReason(),
                $helper->getErrorDescription()
            );
        }

        if (! $token->isLongLived()) {
            // OAuth 2.0 client handler
            $oauth_client = $this->fb->getOAuth2Client();

            // Extend the access token.
            try {
                $token = $oauth_client->getLongLivedAccessToken($token);
            } catch (FacebookSDKException $e) {
                dd($e->getMessage());
            }
        }

        $this->createOrUpdateUser($this->fb, $token);

        return $this->fetchAndSaveUserImages($this->fb, $token);
    }

    /**
     * create Or Update User
     * @param $_fb
     * @param $token
     */
    private function createOrUpdateUser($_fb, $token){
        // Save for later
        session('fb_user_access_token', (string) $token);

        // Get basic info on the user from Facebook.
        $_fb->setDefaultAccessToken($token);
        try {
            $response = $_fb->get('/me?fields=id,name,email');
        } catch (FacebookSDKException $e) {
            dd($e->getMessage());
        }

        // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
        $facebook_user = $response->getGraphUser();

        // Create the user if it does not exist or update the existing entry.
        // This will only work if you've added the SyncableGraphNodeTrait to your User model.
        $user = User::createOrUpdateGraphNode($facebook_user);

        // Log the user into Laravel
        Auth::login($user);
    }

    /**
     * fetch And Save User Images
     * @param $_fb
     * @param $token
     * @return GraphEdge
     * @throws FacebookSDKException
     */
    private function fetchAndSaveUserImages($_fb, $token){
        $_fb->setDefaultAccessToken($token);
        // TODO need to implement with Carbon
        $response = $this->fb->get('me/photos?type=uploaded&fields=source,created_time,alt_text&since=2019-01-01&until=2019-12-31&limit=9');
        return $response->getGraphEdge();
    }
}
