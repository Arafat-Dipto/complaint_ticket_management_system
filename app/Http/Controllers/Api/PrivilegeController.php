<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Privilege\IPrivilegeRepository;
use Illuminate\Http\JsonResponse;

class PrivilegeController extends BaseController
{
    /**
     * __construct
     *
     * @param  IPrivilegeRepository $privilegeRepository
     * @return void
     */
    public function __construct(private readonly IPrivilegeRepository $privilegeRepository)
    {
    }

    /**
     *
     * Get privilege list
     *
     * @return JsonResponse
     */
    public function getPrivilegeList(): JsonResponse
    {
        $result = $this->privilegeRepository->allPrivileges();

        return $this->success($result, "Privilege list retrieved successfully");
    }
}
