<?php


namespace IQnectionProgramming\TeamworkOAuth2\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class TeamworkUser implements ResourceOwnerInterface
{
	/**
	 * @var array
	 */
	protected $data;

	/**
	 * @param  array $response
	 */
	public function __construct(array $response)
	{
		$this->data = $response;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->data['id'];
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		return (array) $this;
	}
}
