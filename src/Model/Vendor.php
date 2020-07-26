<?php

namespace Skuio\Sdk\Model;

use Skuio\Sdk\Model;

/**
 * Class Vendor
 *
 * @package Skuio\Sdk\Model
 *
 * @property int $id
 * @property string $name
 * @property string $company_name
 * @property string|null $primary_contact_name
 * @property string|null $email
 * @property string|null $purchase_order_email
 * @property string|null $phone
 * @property string|null $website
 * @property float|null $leadtime
 * @property float|null $minimum_order_quantity
 * @property float|null $minimum_purchase_order
 * @property bool $is_supplier
 * @property Warehouse $warehouse
 */
class Vendor extends Model
{

}