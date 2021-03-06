<?php

namespace SmoDav\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

class UserGroup extends Model
{
    const PERM_USER_FULL_ACCESS = 'users_full_access';
    const PERM_ROLES_FULL_ACCESS = 'roles_full_access';
    const PERM_SALE_FULL_ACCESS = 'sale_full_access';
    const PERM_PETTY_CASH_FULL_ACCESS = 'petty_full_access';
    const PERM_STALL_ASSIGNMENT = 'stall_full_access';
    const PERM_DASHBOARD_VIEW = 'dashboard_view';
    const PERM_CONFIGURATION_FULL_ACCESS = 'configuration_full_access';
    const PERM_INVENTORY_FULL_ACCESS = 'inventory_full_access';
    const PERM_PURCHASE_ORDER_FULL_ACCESS = 'purchaseOrder_full_access';
    const PERM_REPORT_FULL_ACCESS = 'reports_full_access';
    const PERM_CUSTOMER_FULL_ACCESS = 'customers_full_access';
    const PERM_SUPPLIER_FULL_ACCESS = 'suppliers_full_access';
    const PERM_PRODUCT_FULL_ACCESS = 'products_full_access';
    const CACHE_KEY = 'USER_GROUP';

    protected $fillable = ['name', 'permissions'];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        self::updated(
            function () {
                recacheRoles();
            });

        self::created(
            function () {
                recacheRoles();
            });

        self::deleted(
            function () {
                recacheRoles();
            });
    }

    public function user()
    {
        return $this->hasMany(User::class);
     }
}
