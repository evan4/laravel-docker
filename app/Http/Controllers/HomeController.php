<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Collections\LinksCollection;
use AmoCRM\Collections\NullTagsCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Filters\LeadsFilter;
use AmoCRM\Models\CompanyModel;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\CustomFieldsValues\BirthdayCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\DateTimeCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\NullCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use AmoCRM\Models\LeadModel;
use Carbon\Carbon;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{


    public function index(Request $request)
    {
        $clientId = 'db16ed71-b3fe-4d19-845c-36da2d61b666';
        $clientSecret = 'EmZDXNY2U0cFyI4vxF74P8OBDoqBzBedX4p8TkPb3vhv2NKcm35vl94Oy2Amxnul';
        $redirectUri = 'https://evan4mcgmailcom.amocrm.ru/';
        $apiClient = new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
        $code = "def502001f394412f89747c2be53169f8693670b4ed1d0022a25320409b9090a6c80e00103b55fa3b2395f205154c8d8b23b43f65b91723a4a0a4342ed6d929fd17c55b810efd012f439975f3488067b582e042cb5d2b61c7341359c0d9c8d4a957d240c59d52edf3d8842991bf5754fbab63d36f6aa7137d577c20523e772ac0f93fde855f13eec65533a70fa828172dc81518f68796e6d9cb71929dc74dd8515f5c8a505ab61ace9f476dc7d71256e65916ab20ab076a0e29107079427c58b3986192a19faf009f79485f2f508acc3efbd211c819286288e6ed9bcf71230210610426452ce44eb5770e321d149bca8b74162e8841753a4c10bba94ede44d8652f83fa23470446d6f01e59b4c6afd2f6f0e9820c2598c7635ca21c86aaa404c1ecb82448ae2f8410d461c52e87bced0737a47898af39133bb5f66d3cd82ed75d43e9c555b20e9a1924d4ead6d5f63f7f3cf8c0180e87e13b12b70bde06518e1752de9498e8982339d270435b6d04ee35d7215ec97e8927fb17ba041d71f9c46355d5f45bdcca43b6207451192d92d41de031990fae7a366f9fcf77d256f3e827410b6bdf048bbc527c71c3cae63940e7a332cabd545f65194f56e08e63849d8185d2af6f7c2d8337e6fd9c89ffda97e20dc8ad8693205a97b9dc48b5e4729ed713add0e";
        $baseDomain = "evan4mcgmailcom.amocrm.ru";

        try {
            $oauth = $apiClient->getOAuthClient();
            $oauth->setBaseDomain($baseDomain);
            $accessToken = $oauth->getAccessTokenByCode($code);
            //dd( $accessToken);
            $apiClient->setAccessToken($accessToken)
                ->setAccountBaseDomain($baseDomain)
                ->onAccessTokenRefresh(
                    function (AccessTokenInterface $accessToken, string $baseDomain) {
                        saveToken(
                            [
                                'accessToken' => $accessToken->getToken(),
                                'refreshToken' => $accessToken->getRefreshToken(),
                                'expires' => $accessToken->getExpires(),
                                'baseDomain' => $baseDomain,
                            ]
                        );
                    }
            );
            $leadsService = $apiClient->leads();
            //Получим сделки и следующую страницу сделок
            try {
                $leadsCollection = $leadsService->get();

                dd($leadsCollection);
                foreach ($leadsCollection as $key => $value) {
                    var_dump($value);
                }
                // DB::table('leads')->insert([
                //     'name' => '',
                //     'price' => '',
                //     'responsible_user_id' => '',
                //     'group_id' => '',
                //     'status_id' => '',
                //     'pipeline_id' => '',
                //     'loss_reason_id' => '',
                //     'source_id' => '',
                //     'created_by' => '',
                //     'updated_by' => '',
                //     'closed_at' => '',
                //     'created_at' => '',
                //     'updated_at' => '',
                //     'closest_task_at' => '',
                //     'is_deleted' => '',
                //     'custom_fields_values' => '',
                //     'score' => '',
                //     'account_id' => '',
                //     'is_price_modified_by_robot' => '',
                //     '_embedded' => ''
                // ]);
            } catch (AmoCRMApiException $e) {
                printError($e);
                die;
            }
        } catch (\AmoCRM\Exceptions\AmoCRMoAuthApiException $e) {
            echo $e->getMessage();
        }

        

        
        // можно добавить validate

        //store in db


           
    }

    public function redirectUrl()
    {
        echo 'Hello';
    }
}
