<?php declare(strict_types=1);

namespace IQnectionProgramming\TeamworkOAuth2\Test;

require_once __DIR__.'/../vendor/autoload.php';

use IQnectionProgramming\TeamworkOAuth2\Provider\Teamwork;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\ClientInterface;

final class TeamworkTest extends \PHPUnit\Framework\TestCase
{
	/**
	 * @var Teamwork
	 */
	protected $provider;

	protected function setUp(): void
	{
		$this->provider = new Teamwork([
			'clientId' => 'mock_client_id',
			'clientSecret' => 'mock_secret',
			'redirectUri' => 'mock_redirect_uri'
		]);
	}

	protected function getJsonFile($file, $encode = false)
	{
		$json = file_get_contents(__DIR__ . '/' . $file);
		$data = json_decode($json, true);

		if ($encode && json_last_error() == JSON_ERROR_NONE) {
			return $data;
		}

		return $json;
	}

	public function testAuthorizationUrl()
	{
		$url = $this->provider->getAuthorizationUrl();
		$uri = parse_url($url);
		parse_str($uri['query'], $query);

		$this->assertArrayHasKey('client_id', $query);
		$this->assertArrayHasKey('redirect_uri', $query);
		$this->assertArrayHasKey('state', $query);
		$this->assertArrayNotHasKey('scope', $query, http_build_query($query));
		$this->assertArrayNotHasKey('response_type', $query);
		$this->assertNotNull($this->provider->getState());
	}

	public function testGetAuthorizationUrl()
	{
		$url = $this->provider->getAuthorizationUrl();
		$uri = parse_url($url);

		$this->assertEquals('www.teamwork.com', $uri['host']);
		$this->assertEquals('/launchpad/login', $uri['path']);
	}

	public function testGetBaseAccessTokenUrl()
	{
		$params = [];

		$url = $this->provider->getBaseAccessTokenUrl($params);
		$uri = parse_url($url);

		$this->assertEquals('www.teamwork.com', $uri['host']);
		$this->assertEquals('/launchpad/v1/token.json', $uri['path']);
	}

	public function testGetAccessToken()
	{
		$accessToken = $this->getJsonFile('access_token_response.json');
		$responseMock = $this->getMockBuilder(ResponseInterface::class)->getMock();
		$responseMock->method('getBody')->willReturn($accessToken);
		$responseMock->method('getHeader')->willReturn(['content-type' => 'json']);
		$responseMock->method('getStatusCode')->willReturn(200);

		$clientMock = $this->getMockBuilder(ClientInterface::class)->getMock();
		$clientMock->expects($this->once())->method('send')->willReturn($responseMock);
		$this->provider->setHttpClient($clientMock);

		$token = $this->provider->getAccessToken('code', ['code' => 'mock_authorization_code']);

		$this->assertEquals('mock_access_token', $token->getToken());
		$this->assertEquals($token->getResourceOwnerId(), 123456);
	}
}
