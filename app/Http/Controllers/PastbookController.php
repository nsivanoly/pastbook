<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Repositories\UserImagesRepository;
use App\Services\FacebookService;
use App\User;
use Carbon\Carbon;
use Facebook\Exceptions\FacebookSDKException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

/**
 * Class PastbookController
 * @package App\Http\Controllers
 */
class PastbookController extends Controller
{
    /**
     * Load landing page
     * @param FacebookService $facebookService
     * @return Factory|View
     */
    public function index(FacebookService $facebookService)
    {
        $login_url = $facebookService->facebookLogin();
        return view('facebook.login', compact('login_url'));
    }


    /**
     * @param FacebookService $facebookService
     * @param UserImagesRepository $userImagesRepository
     * @return RedirectResponse|Redirector
     * @throws FacebookSDKException
     */
    public function callback(FacebookService $facebookService, UserImagesRepository $userImagesRepository)
    {
        $images = $facebookService->facebookCallback();

        $userImagesRepository->addImages($images);

        $this->sendMail();

        return redirect('success');
    }

    /**
     * @return Factory|View
     */
    public function success(){
        $this->sendMail();
        return view('facebook.result');
    }

    /**
     * send Mail
     */
    public function sendMail(){
        $user_id = auth()->id();
        $user = User::where('id', $user_id)->with('user_images')->first();

        $emailJob = (new SendEmailJob($user))->delay(Carbon::now()->addSeconds(5));
        dispatch($emailJob);
    }
}
