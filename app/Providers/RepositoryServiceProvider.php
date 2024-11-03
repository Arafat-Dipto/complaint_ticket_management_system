<?php

namespace App\Providers;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\ICategoryRepository;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Comment\ICommentRepository;
use App\Repositories\ComplaintStatusHistory\ComplaintStatusHistoryRepository;
use App\Repositories\ComplaintStatusHistory\IComplaintStatusHistoryRepository;
use App\Repositories\Complaint\ComplaintRepository;
use App\Repositories\Complaint\IComplaintRepository;
use App\Repositories\Privilege\IPrivilegeRepository;
use App\Repositories\Privilege\PrivilegeRepository;
use App\Repositories\RolePrivilege\IRolePrivilegeRepository;
use App\Repositories\RolePrivilege\RolePrivilegeRepository;
use App\Repositories\Role\IRoleRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\UserRole\IUserRoleRepository;
use App\Repositories\UserRole\UserRoleRepository;
use App\Repositories\User\IUserRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(abstract :IUserRepository::class, concrete: UserRepository::class);
        $this->app->bind(abstract :IRoleRepository::class, concrete: RoleRepository::class);
        $this->app->bind(abstract :IPrivilegeRepository::class, concrete: PrivilegeRepository::class);
        $this->app->bind(abstract :IRolePrivilegeRepository::class, concrete: RolePrivilegeRepository::class);
        $this->app->bind(abstract :IUserRoleRepository::class, concrete: UserRoleRepository::class);
        $this->app->bind(abstract :IComplaintRepository::class, concrete: ComplaintRepository::class);
        $this->app->bind(abstract :IComplaintStatusHistoryRepository::class, concrete: ComplaintStatusHistoryRepository::class);
        $this->app->bind(abstract :ICommentRepository::class, concrete: CommentRepository::class);
        $this->app->bind(abstract :ICategoryRepository::class, concrete: CategoryRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
