<?php

namespace Skuio\Sdk\Resource;

use Exception;
use InvalidArgumentException;
use Skuio\Sdk\Model\Attribute;
use Skuio\Sdk\Request;
use Skuio\Sdk\Response;
use Skuio\Sdk\Sdk;

class Attributes extends Sdk
{
  protected $endpoint = 'attributes';

  /**
   * Retrieve attributes according to your request
   *
   * @param Request $request
   *
   * @return Response
   * @throws Exception
   */
  public function get( Request $request = null )
  {
    if ( ! $request )
    {
      $request = new Request();
    }

    return $this->authorizedRequest( $this->endpoint . '?' . $request->getParams() );
  }

  /**
   * Create a new attribute
   *
   * @param Attribute $attribute
   *
   * @return Response
   * @throws Exception
   */
  public function store( Attribute $attribute )
  {
    return $this->authorizedRequest( $this->endpoint, $attribute->toJson(), self::METHOD_POST );
  }

  /**
   * Update an attribute
   *
   * @param Attribute $attribute
   *
   * @return Response
   * @throws Exception
   */
  public function update( Attribute $attribute )
  {
    if ( empty( $attribute->id ) )
    {
      throw new InvalidArgumentException( 'The "id" field is required' );
    }

    return $this->authorizedRequest( "{$this->endpoint}/$attribute->id", $attribute->toJson(), self::METHOD_PUT );
  }

  /**
   * Archive an attribute
   *
   * @param int $id
   *
   * @return Response
   * @throws Exception
   */
  public function archive( int $id )
  {
    return $this->authorizedRequest( "{$this->endpoint}/{$id}/archive", null, self::METHOD_PUT );
  }

  /**
   * unarchived an attribute
   *
   * @param int $id
   *
   * @return Response
   * @throws Exception
   */
  public function unarchived( int $id )
  {
    return $this->authorizedRequest( "{$this->endpoint}/{$id}/unarchived", null, self::METHOD_PUT );
  }

  /**
   * Delete an attribute
   *
   * @param int $id
   *
   * @return Response
   * @throws Exception
   */
  public function delete( int $id )
  {
    return $this->authorizedRequest( $this->endpoint . '/' . $id, null, self::METHOD_DELETE );
  }
}