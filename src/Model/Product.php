<?php

namespace Skuio\Sdk\Model;

use InvalidArgumentException;
use Skuio\Sdk\Model;

/**
 * Class Product
 *
 * @package Skuio\Sdk\Model
 *
 * @property int $id - sku.io id
 * @property int $parent_id - parent sku.io id
 * @property string $sku
 * @property string $barcode
 * @property string $mpn
 * @property string $brand_name
 * @property string $type
 * @property float $weight
 * @property string $weight_unit - lb,kg,oz
 * @property float $length
 * @property float $width
 * @property float $height
 * @property string $dimension_unit - in,cm
 * @property string|null $fba_prep_instructions
 * @property float|null $case_quantity
 * @property float|null $case_length
 * @property float|null $case_width
 * @property float|null $case_height
 * @property string|null $case_dimension_unit
 * @property float|null $case_weight
 * @property string|null $case_weight_unit
 * @property string $name
 * @property ProductImage[] $images
 * @property string[] $tags
 *
 * Pricing
 * @property ProductPricing[] $pricing
 *
 * Source
 * @property VendorProduct[] $vendors
 *
 * Taxonomy
 * @property ProductToCategory[] $categories
 * @property int[] $attribute_groups
 * @property ProductAttribute[] $attributes
 *
 * @property Product[] $variations
 */
class Product extends Model
{
  /**
   * Product Types
   */
  const TYPE_STANDARD  = 'standard';
  const TYPE_BUNDLE    = 'bundle';
  const TYPE_VIRTUAL   = 'virtual';
  const TYPE_BLEMISHED = 'blemished';
  const TYPES          = [ self::TYPE_STANDARD, self::TYPE_BUNDLE, self::TYPE_VIRTUAL, self::TYPE_BLEMISHED ];

  /**
   * Product weight units
   */
  const WEIGHT_UNIT_LB = 'lb';
  const WEIGHT_UNIT_KG = 'kg';
  const WEIGHT_UNIT_OZ = 'oz';
  const WEIGHT_UNITS   = [ self::WEIGHT_UNIT_LB, self::WEIGHT_UNIT_KG, self::WEIGHT_UNIT_OZ ];

  /**
   * Product dimension units
   */
  const DIMENSION_UNIT_INCH = 'in';
  const DIMENSION_UNIT_CM   = 'cm';
  const DIMENSION_UNITS     = [ self::DIMENSION_UNIT_INCH, self::DIMENSION_UNIT_CM ];

  /**
   * Set brand name
   *
   * @param string $brandName
   *
   * @return $this
   */
  public function setBrand( string $brandName )
  {
    $this->brand_name = $brandName;

    return $this;
  }

  /**
   * Set product type
   *
   * @param string $type
   *
   * @return Product
   */
  public function setProductType( string $type )
  {
    if ( ! in_array( $type, [ self::TYPE_STANDARD, self::TYPE_VIRTUAL ] ) )
    {
      throw new InvalidArgumentException( 'The type field must be ' . self::TYPE_STANDARD . ' or ' . self::TYPE_VIRTUAL );
    }

    $this->type = $type;

    return $this;
  }

  /**
   * Set weight unit
   *
   * @param string $weightUnit
   *
   * @return $this
   */
  public function setWeightUnit( string $weightUnit )
  {
    if ( ! in_array( $weightUnit, self::WEIGHT_UNITS ) )
    {
      throw new InvalidArgumentException( 'The weight_unit field must be one of ' . implode( ',', self::WEIGHT_UNITS ) );
    }

    $this->weight_unit = $weightUnit;

    return $this;
  }

  /**
   * Set Dimension unit
   *
   * @param string $dimensionUnit
   *
   * @return $this
   */
  public function setDimensionUnit( string $dimensionUnit )
  {
    if ( ! in_array( $dimensionUnit, self::DIMENSION_UNITS ) )
    {
      throw new InvalidArgumentException( 'The dimension_unit field must be one of ' . implode( ',', self::DIMENSION_UNITS ) );
    }

    $this->dimension_unit = $dimensionUnit;

    return $this;
  }

  /**
   * Set Primary image
   *
   * @param string $imageUrl
   * @param bool $downloadToServer
   *
   * @return $this
   */
  public function setPrimaryImage( string $imageUrl, bool $downloadToServer = false )
  {
    if ( ! isset( $this->images ) )
    {
      $this->images = [];
    }

    $this->images[] = [ 'url' => $imageUrl, 'is_primary' => true, 'download' => $downloadToServer ];

    return $this;
  }

  /**
   * Set primary image
   *
   * @param ProductImage $productImage
   *
   * @return $this
   */
  public function setPrimaryProductImage( ProductImage $productImage )
  {
    if ( ! isset( $this->images ) )
    {
      $this->images = [];
    }

    // set as primary image
    $productImage->is_primary = true;

    $this->images[] = $productImage;

    return $this;
  }

  /**
   * Add image
   *
   * @param ProductImage $productImage
   *
   * @return $this
   */
  public function addProductImage( ProductImage $productImage )
  {
    if ( ! isset( $this->images ) )
    {
      $this->images = [];
    }

    $this->images[] = $productImage;

    return $this;
  }

  /**
   * Set description attribute
   *
   * @param string $description
   *
   * @return $this
   */
  public function setDescription( string $description )
  {
    if ( ! isset( $this->attributes ) )
    {
      $this->attributes = [];
    }

    $this->attributes[] = [ 'name' => 'description', 'value' => $description ];

    return $this;
  }

  /**
   * Set tags to the product
   *
   * @param string|array $tags
   *
   * @return Product
   */
  public function setTags( $tags )
  {
    $this->tags           = is_array( $tags ) ? $tags : [ $tags ];
    $this->tags_operation = 'set';

    return $this;
  }

  /**
   * Add tags to the product
   *
   * @param string|array $tags
   *
   * @return Product
   */
  public function addTags( $tags )
  {
    if ( ! isset( $this->tags ) )
    {
      $this->tags = [];
    }

    $this->tags           = array_unique( array_merge( $this->tags, is_array( $tags ) ? $tags : [ $tags ] ) );
    $this->tags_operation = isset( $this->tags_operation ) ? ( $this->tags_operation == 'set' ? $this->tags_operation : 'append' ) : 'append';

    return $this;
  }

  /**
   * Add tags to the product
   *
   * @param string|array $tags
   *
   * @return Product
   */
  public function deleteTags( $tags )
  {
    $this->tags           = is_array( $tags ) ? $tags : [ $tags ];
    $this->tags_operation = 'delete';

    return $this;
  }

  /**
   * Add pricing
   *
   * @param ProductPricing $pricing
   *
   * @return $this
   */
  public function addPrice( ProductPricing $pricing )
  {
    if ( ! isset( $this->pricing ) )
    {
      $this->pricing = [];
    }

    $this->pricing[] = $pricing;

    return $this;
  }

  /**
   * Add a vendor product
   *
   * @param VendorProduct $vendorProduct
   *
   * @return $this
   */
  public function addVendor( VendorProduct $vendorProduct )
  {
    if ( ! isset( $this->vendors ) )
    {
      $this->vendors = [];
    }
    $vendorProduct->operation = 'updateOrCreate';

    $this->vendors[] = $vendorProduct;

    return $this;
  }

  /**
   * Update vendor product
   *
   * @param VendorProduct $vendorProduct
   *
   * @return $this
   */
  public function updateVendor( VendorProduct $vendorProduct )
  {
    return $this->addVendor( $vendorProduct );
  }

  /**
   * Delete vendor product
   *
   * @param VendorProduct $vendorProduct
   *
   * @return $this
   */
  public function deleteVendor( VendorProduct $vendorProduct )
  {
    if ( ! isset( $this->vendors ) )
    {
      $this->vendors = [];
    }
    $vendorProduct->operation = 'delete';

    $this->vendors[] = $vendorProduct;

    return $this;
  }

  /**
   * Add a category
   *
   * @param ProductToCategory $category
   *
   * @return $this
   */
  public function addToCategory( ProductToCategory $category )
  {
    if ( ! isset( $this->categories ) )
    {
      $this->categories = [];
    }

    $this->categories[] = $category;

    return $this;
  }

  /**
   * Add a category
   *
   * @param int $categoryId
   * @param bool $isPrimary
   *
   * @return $this
   */
  public function addCategory( int $categoryId, bool $isPrimary = false )
  {
    if ( ! isset( $this->categories ) )
    {
      $this->categories = [];
    }

    $this->categories[] = [ 'category_id' => $categoryId, 'is_primary' => $isPrimary ];

    return $this;
  }

  /**
   * Set/Add attribute groups by id
   *
   * @param int|array $attributeGroups
   *
   * @return Product
   */
  public function setAttributeGroups( $attributeGroups )
  {
    if ( ! isset( $this->attribute_groups ) )
    {
      $this->attribute_groups = [];
    }

    $this->attribute_groups = array_unique( array_merge( $this->attribute_groups, is_array( $attributeGroups ) ? $attributeGroups : [ $attributeGroups ] ) );

    return $this;
  }

  /**
   * Add an attribute
   *
   * @param ProductAttribute $attribute
   *
   * @return $this
   */
  public function addProductAttribute( ProductAttribute $attribute )
  {
    if ( ! isset( $this->attributes ) )
    {
      $this->attributes = [];
    }

    $this->attributes[] = $attribute;

    return $this;
  }

  /**
   * Add an attribute
   *
   * @param int $attributeId
   * @param $value
   *
   * @return $this
   */
  public function addAttribute( int $attributeId, $value )
  {
    if ( ! isset( $this->attributes ) )
    {
      $this->attributes = [];
    }

    $this->attributes[] = [ 'id' => $attributeId, 'value' => $value ];

    return $this;
  }

  /**
   * Add a variant
   *
   * @param Product $variant
   *
   * @return $this
   */
  public function addVariant( Product $variant )
  {
    if ( ! isset( $this->variations ) )
    {
      $this->variations = [];
    }

    $this->variations[] = $variant;

    return $this;
  }

  public function __set( $name, $value )
  {
    if ( $name == 'type' )
    {
      return $this->setProductType( $value );
    }

    if ( $name == 'weight_unit' )
    {
      return $this->setWeightUnit( $value );
    }

    if ( $name == 'dimension_unit' )
    {
      return $this->setDimensionUnit( $value );
    }

    if ( $name == 'case_dimension_unit' && ! in_array( $value, self::DIMENSION_UNITS ) )
    {
      throw new InvalidArgumentException( 'The case_dimension_unit field must be one of ' . implode( ',', self::DIMENSION_UNITS ) );
    }

    if ( $name == 'case_weight_unit' && ! in_array( $value, self::WEIGHT_UNITS ) )
    {
      throw new InvalidArgumentException( 'The case_weight_unit field must be one of ' . implode( ',', self::WEIGHT_UNITS ) );
    }

    $this->$name = $value;
  }
}