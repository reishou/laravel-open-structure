<?php

namespace App\Modules\Auth\Logout;

use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LogoutFeature extends BaseFeatures
{
    /**
     * @return JsonResponse
     */
    public function handle(): JsonResponse
    {
        $this->logout();

        return $this->success(true);
    }

    /**
     * @return void
     */
    protected function logout(): void
    {
        $this->run(LogoutJob::class, [
            'user' => Auth::user(),
        ]);
    }
}
