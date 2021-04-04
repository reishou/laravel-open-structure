<?php

namespace App\Modules\User\ListUser;

use App\Infrastructure\Http\Controllers\Controller;

class ListUserController extends Controller
{
    /**
     * @var ListUserQuery
     */
    private ListUserQuery $query;

    /**
     * ListUserController constructor.
     *
     * @param ListUserQuery $query
     */
    public function __construct(ListUserQuery $query)
    {
        $this->query = $query;
    }

    public function __invoke(ListUserRequest $request): ListUserResource
    {
        $data = $this->query->query($request->criteria());

        return new ListUserResource($data);
    }
}
