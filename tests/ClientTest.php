<?php

namespace AmazonAdvertisingApi;

use AmazonAdvertisingApi\Client;
use DateTime;
use Exception;

class ClientTest extends \PHPUnit\Framework\TestCase
{
    private $client = null;
    private $return_value = null;
    private $config = array(
        "clientId" => "amzn1.application-oa2-client.xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
        "clientSecret" => "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
        "region" => "na",
        "accessToken" => "Atza%7Ctest",
        "refreshToken" => "Atzr%7Ctest",
        "sandbox" => true,
        "delay" => 0
    );

    public function setUp(): void
    {
        $this->return_value = array(
            "code" => "200",
            "success" => true,
            "requestId" => "test",
            "response" => json_encode(["status" => "SUCCESS", "location" => ''])
        );

        $this->client = $this->getMockBuilder("AmazonAdvertisingApi\Client")
            ->setConstructorArgs(array($this->config))
            ->setMethods(array("_executeRequest"))
            ->getMock();

        $this->client->expects($this->any())
            ->method("_executeRequest")
            ->will($this->returnValue($this->return_value));
    }

    public function testValidateConfigNotNull()
    {
        $testConfig = null;
        try {
            $client = new Client($testConfig);
        } catch (Exception $expected) {
            $this->assertRegExp("/'config' cannot be null./", strval($expected));
        }
    }

    public function testValidateConfigRequiredParams()
    {
        $testConfig = $this->config;
        $testConfig['clientSecret'] = null;
        try {
            $client = new Client($testConfig);
        } catch (Exception $expected) {
            $this->assertRegExp("/Missing required parameter 'clientSecret'./", strval($expected));
        }
    }

    public function testValidateConfigRejectUnknownParameters()
    {
        $testConfig = $this->config;
        $testConfig['not_exists'] = true;
        try {
            $client = new Client($testConfig);
        } catch (Exception $expected) {
            $this->assertRegExp("/Unknown parameter 'not_exists' in config./", strval($expected));
        }
    }

    public function testValidateClientId()
    {
        $testConfig = $this->config;
        $testConfig["clientId"] = "bad";
        try {
            $client = new Client($testConfig);
        } catch (Exception $expected) {
            $this->assertRegExp("/Invalid parameter value for clientId./", strval($expected));
        }
    }

    public function testValidateClientSecret()
    {
        $testConfig = $this->config;
        $testConfig["clientSecret"] = "bad";
        try {
            $client = new Client($testConfig);
        } catch (Exception $expected) {
            $this->assertRegExp("/Invalid parameter value for clientSecret./", strval($expected));
        }
    }

    public function testSetEndpointToProduction()
    {
        $config = $this->config;
        $config['sandbox'] = false;

        try {
            $client = new Client($config);
            $this->assertEquals('https://advertising-api.amazon.com/v2', $client->getEndpoint());
        } catch (Exception $e) {
        }
    }

    public function testValidateRegion()
    {
        $testConfig = $this->config;
        $testConfig["region"] = "bad";
        try {
            $client = new Client($testConfig);
        } catch (Exception $expected) {
            $this->assertRegExp("/Invalid region./", strval($expected));
        }
    }

    public function testValidateAccessToken()
    {
        $testConfig = $this->config;
        $testConfig["accessToken"] = "bad";
        try {
            $client = new Client($testConfig);
        } catch (Exception $expected) {
            $this->assertRegExp("/Invalid parameter value for accessToken./", strval($expected));
        }
    }

    public function testValidateRefreshToken()
    {
        $testConfig = $this->config;
        $testConfig["refreshToken"] = "bad";
        try {
            $client = new Client($testConfig);
        } catch (Exception $expected) {
            $this->assertRegExp("/Invalid parameter value for refreshToken./", strval($expected));
        }
    }

    public function testValidateSandbox()
    {
        $testConfig = $this->config;
        $testConfig["sandbox"] = "bad";
        try {
            $client = new Client($testConfig);
        } catch (Exception $expected) {
            $this->assertRegExp("/Invalid parameter value for sandbox./", strval($expected));
        }
    }

    public function testValidateDelayType()
    {
        $testConfig = $this->config;
        $testConfig["delay"] = "0";
        try {
            $client = new Client($testConfig);
        } catch (Exception $expected) {
            $this->assertRegExp("/Invalid parameter value for delay, expected int got string./", strval($expected));
        }
    }

    public function testValidateDelayValue()
    {
        $testConfig = $this->config;
        $testConfig["delay"] = -1;
        try {
            $client = new Client($testConfig);
        } catch (Exception $expected) {
            $this->assertRegExp("/Invalid parameter value for delay, expected positive int got negative./", strval($expected));
        }
    }

    public function testListProfiles()
    {
        $request = $this->client->listProfiles();
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetProfile()
    {
        $request = $this->client->getProfile("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testUpdateProfiles()
    {
        $request = $this->client->updateProfiles("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetCampaign()
    {
        $request = $this->client->getCampaign("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetCampaignEx()
    {
        $request = $this->client->getCampaignEx("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testCreateCampaigns()
    {
        $request = $this->client->createCampaigns("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testArchiveCampaign()
    {
        $request = $this->client->archiveCampaign("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testListCampaigns()
    {
        $request = $this->client->listCampaigns();
        $this->assertEquals($this->return_value, $request);
    }

    public function testListCampaignsEx()
    {
        $request = $this->client->listCampaignsEx();
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetAdGroup()
    {
        $request = $this->client->getAdGroup("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetAdGroupEx()
    {
        $request = $this->client->getAdGroupEx("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testCreateAdGroups()
    {
        $request = $this->client->createAdGroups("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testUpdateAdGroups()
    {
        $request = $this->client->updateAdGroups("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testArchiveAdGroup()
    {
        $request = $this->client->archiveAdGroup("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testListAdGroups()
    {
        $request = $this->client->listAdGroups();
        $this->assertEquals($this->return_value, $request);
    }

    public function testListAdGroupsEx()
    {
        $request = $this->client->listAdGroupsEx();
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetBiddableKeyword()
    {
        $request = $this->client->getBiddableKeyword("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetBiddableKeywordEx()
    {
        $request = $this->client->getBiddableKeywordEx("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testCreateBiddableKeywords()
    {
        $request = $this->client->createBiddableKeywords("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testUpdateCreateBiddableKeywords()
    {
        $request = $this->client->updateBiddableKeywords("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testArchiveBiddableKeyword()
    {
        $request = $this->client->archiveBiddableKeyword("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testListBiddableKeywords()
    {
        $request = $this->client->listBiddableKeywords();
        $this->assertEquals($this->return_value, $request);
    }

    public function testListBiddableKeywordsEx()
    {
        $request = $this->client->listBiddableKeywordsEx();
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetNegativeKeyword()
    {
        $request = $this->client->getNegativeKeyword("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetNegativeKeywordEx()
    {
        $request = $this->client->getNegativeKeywordEx("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testCreateNegativeKeywords()
    {
        $request = $this->client->createNegativeKeywords("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testUpdateNegativeKeywords()
    {
        $request = $this->client->updateNegativeKeywords("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testArchiveNegativeKeyword()
    {
        $request = $this->client->archiveNegativeKeyword("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testListNegativeKeywords()
    {
        $request = $this->client->listNegativeKeywords();
        $this->assertEquals($this->return_value, $request);
    }

    public function testListNegativeKeywordsEx()
    {
        $request = $this->client->listNegativeKeywordsEx();
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetCampaignNegativeKeyword()
    {
        $request = $this->client->getCampaignNegativeKeyword("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetCampaignNegativeKeywordEx()
    {
        $request = $this->client->getCampaignNegativeKeywordEx("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testCreateCampaignNegativeKeywords()
    {
        $request = $this->client->createCampaignNegativeKeywords("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testUpdateCampaignNegativeKeywords()
    {
        $request = $this->client->updateCampaignNegativeKeywords("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testRemoveCampaignNegativeKeyword()
    {
        $request = $this->client->removeCampaignNegativeKeyword("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testListCampaignNegativeKeywords()
    {
        $request = $this->client->listCampaignNegativeKeywords();
        $this->assertEquals($this->return_value, $request);
    }

    public function testListCampaignNegativeKeywordsEx()
    {
        $request = $this->client->listCampaignNegativeKeywordsEx();
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetProductAd()
    {
        $request = $this->client->getProductAd("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetProductAdEx()
    {
        $request = $this->client->getProductAdEx("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testCreateProductAds()
    {
        $request = $this->client->createProductAds("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testUpdateProductAds()
    {
        $request = $this->client->updateProductAds("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testArchiveProductAd()
    {
        $request = $this->client->archiveProductAd("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testListProductAds()
    {
        $request = $this->client->listProductAds();
        $this->assertEquals($this->return_value, $request);
    }

    public function testListProductAdsEx()
    {
        $request = $this->client->listProductAdsEx();
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetAdGroupBidRecommendations()
    {
        $request = $this->client->getAdGroupBidRecommendations("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetKeywordBidRecommendations()
    {
        $request = $this->client->getKeywordBidRecommendations("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testBulkGetKeywordBidRecommendations()
    {
        $request = $this->client->bulkGetKeywordBidRecommendations(123, "test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetAdGroupKeywordSuggestions()
    {
        $request = $this->client->getAdGroupKeywordSuggestions(
            array("adGroupId" => 12345)
        );
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetAdGroupKeywordSuggestionsEx()
    {
        $request = $this->client->getAdGroupKeywordSuggestionsEx(
            array("adGroupId" => 12345)
        );
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetAsinKeywordSuggestions()
    {
        $request = $this->client->getAsinKeywordSuggestions(
            array("asin" => 12345)
        );
        $this->assertEquals($this->return_value, $request);
    }

    public function testBulkGetAsinKeywordSuggestions()
    {
        $request = $this->client->bulkGetAsinKeywordSuggestions(
            array("asins" => array("ASIN1", "ASIN2"))
        );
        $this->assertEquals($this->return_value, $request);
    }

    public function testRequestSnapshot()
    {
        $request = $this->client->requestSnapshot("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetSnapshot()
    {
        $request = $this->client->getSnapshot("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetSnapshotFailed()
    {
        $this->return_value = array(
            "code" => "422",
            "success" => false,
            "requestId" => "test",
            "response" => json_encode(["status" => "SUCCESS", "location" => ''])
        );

        $this->client = $this->getMockBuilder("AmazonAdvertisingApi\Client")
            ->setConstructorArgs(array($this->config))
            ->setMethods(array("_executeRequest"))
            ->getMock();

        $this->client->expects($this->any())
            ->method("_executeRequest")
            ->will($this->returnValue($this->return_value));

        $request = $this->client->getSnapshot("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testRequestReport()
    {
        $request = $this->client->requestReport("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetReport()
    {
        $request = $this->client->getReport("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetReportFailed()
    {
        $this->return_value = array(
            "code" => "422",
            "success" => false,
            "requestId" => "test",
            "response" => json_encode(["status" => "SUCCESS", "location" => ''])
        );

        $this->client = $this->getMockBuilder("AmazonAdvertisingApi\Client")
            ->setConstructorArgs(array($this->config))
            ->setMethods(array("_executeRequest"))
            ->getMock();

        $this->client->expects($this->any())
            ->method("_executeRequest")
            ->will($this->returnValue($this->return_value));

        $request = $this->client->getReport("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testListPortfolios()
    {
        $request = $this->client->listPortfolios();
        $this->assertEquals($this->return_value, $request);
    }

    public function testListPortfoliosEx()
    {
        $request = $this->client->listPortfoliosEx();
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetPortfolio()
    {
        $request = $this->client->getPortfolio("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetPortfolioEx()
    {
        $request = $this->client->getPortfolioEx("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testCreatePortfolios()
    {
        $request = $this->client->createPortfolios("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testUpdatePortfolios()
    {
        $request = $this->client->updatePortfolios("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testRegisterProfile()
    {
        $request = $this->client->registerProfile("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testRegisterProfileStatus()
    {
        $request = $this->client->registerProfileStatus("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testUpdateCampaignWithDelay()
    {
        $config = $this->config;
        $config['delay'] = 1000;
        $this->client = $this->getMockBuilder("AmazonAdvertisingApi\Client")
            ->setConstructorArgs(array($config))
            ->setMethods(array("_executeRequest"))
            ->getMock();

        $this->client->expects($this->any())
            ->method("_executeRequest")
            ->will($this->returnValue($this->return_value));

        $firstTime = new DateTime();
        $request = $this->client->updateCampaigns("test");
        $this->assertEquals($this->return_value, $request);

        $request = $this->client->updateCampaigns("test");
        $secondTime = new DateTime();
        $this->assertEquals($this->return_value, $request);
        $this->assertTrue($secondTime->diff($firstTime)->s > 1);
    }

    public function testSearchTermsReport()
    {
        $request = $this->client->searchTermsReport("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetTargetingClause()
    {
        $request = $this->client->getTargetingClause("test");
        $this->assertEquals($this->return_value, $request);
    }

    public function testGetTargetingClauseEx()
    {
        $request = $this->client->getTargetingClauseEx("test");
        $this->assertEquals($this->return_value, $request);
    }
}
