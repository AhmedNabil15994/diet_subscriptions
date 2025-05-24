<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\User\Transformers\Api\UserResource;
use Modules\User\Http\Requests\Api\UpdateCVProfileRequest;
use Modules\User\Http\Requests\Api\UpdateExperienceRequest;
use Modules\User\Http\Requests\Api\UpdateCertificationRequest;
use Modules\User\Repositories\Api\UserRepository as User;
use Modules\Apps\Http\Controllers\Api\ApiController;

class UserProfileController extends ApiController
{
    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function updateCV(UpdateCVProfileRequest $request)
    {
        $this->user->updateCV($request);

        $user =  $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function experiences(UpdateExperienceRequest $request)
    {
        $this->user->updateExperiences($request);

        $user =  $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function target(Request $request)
    {
        $this->user->addTargetJob($request);

        $user =  $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function certifications(UpdateCertificationRequest $request)
    {
        $this->user->updateCertifications($request);

        $user =  $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function videoCv(Request $request)
    {
        $this->user->uploadVideo($request);

        $user =  $this->user->userProfile();

        return $this->response(new UserResource($user));
    }
}
