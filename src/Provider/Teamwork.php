<?php


namespace IQnectionProgramming\TeamworkOAuth2\Provider;


use IQnectionProgramming\TeamworkOAuth2\Provider\Exception\TeamworkProviderException;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class Teamwork extends \League\OAuth2\Client\Provider\AbstractProvider
{
	use BearerAuthorizationTrait;

	const ACCESS_TOKEN_RESOURCE_OWNER_ID = 'user';

	/**
	 * @inheritDoc
	 */
	public function getBaseAuthorizationUrl()
	{
		return 'https://www.teamwork.com/launchpad/login';
	}

	/**
	 * @inheritDoc
	 */
	public function getBaseAccessTokenUrl(array $params)
	{
		return 'https://www.teamwork.com/launchpad/v1/token.json';
	}

	/**
	 * @inheritDoc
	 */
	public function getResourceOwnerDetailsUrl(AccessToken $token)
	{
		return null;
	}

	protected function getAuthorizationParameters(array $options)
	{
		$options = parent::getAuthorizationParameters($options);
		$options['redirect_uri'] = $this->redirectUri;
		unset($options['scope']);
		unset($options['response_type']);
		unset($options['approval_prompt']);
		return $options;
	}

	/**
	 * @inheritDoc
	 */
	protected function getDefaultScopes()
	{
		return [];
	}

	/**
	 * @inheritDoc
	 */
	protected function checkResponse(ResponseInterface $response, $data)
	{
		if (strtolower($data['status']) != 'ok')
		{
			throw new TeamworkProviderException('There was an error with authentication', 500, $response);
		}
	}

	/**
	 * @inheritDoc
	 */
	protected function createResourceOwner(array $response, AccessToken $token)
	{
		$tokenData = $token->getValues();
		return new TeamworkUser($tokenData[static::ACCESS_TOKEN_RESOURCE_OWNER_ID]);
	}
}
