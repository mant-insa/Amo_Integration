<?php

namespace App\Lib;

use AmoCRM\Models\ContactModel;
use AmoCRM\Models\LeadModel;
use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use League\OAuth2\Client\Token\AccessTokenInterface;
use AmoCRM\Models\CustomFieldsValues\MultitextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\MultitextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\MultitextCustomFieldValueModel;
use AmoCRM\Exceptions\AmoCRMApiException;

class AmoApiClient
{

    public function __construct(
        private AmoTokenManager $tokenManager, 
        private $clientParams
    )
    {}

    public function addOneComplexLead($leadName, $price, AmoContact $contact)
    {
		$apiClient = new \AmoCRM\Client\AmoCRMApiClient(
			$this->clientParams['clientId'], 
			$this->clientParams['clientSecret'], 
			$this->clientParams['redirectUri']
		);

        $token = $this->tokenManager->getToken();

		$apiClient->setAccessToken($token)
			->setAccountBaseDomain($token->getValues()['baseDomain'])
			->onAccessTokenRefresh(
				function (AccessTokenInterface $accessToken, string $baseDomain){
					$this->tokenManager->saveToken(
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

		$lead = new LeadModel();
		$lead->setName($leadName)
			->setPrice($price)
			->setContacts(
				(new ContactsCollection())
					->add(
						(new ContactModel())
							->setFirstName($contact->getContactName())
							->setCustomFieldsValues(
								(new CustomFieldsValuesCollection())
									->add(
										(new MultitextCustomFieldValuesModel())
											->setFieldCode('PHONE')
											->setValues(
												(new MultitextCustomFieldValueCollection())
													->add(
														(new MultitextCustomFieldValueModel())
															->setValue($contact->getContactPhone())
													)
											)
									)
									->add(
										(new MultitextCustomFieldValuesModel())
											->setFieldCode('EMAIL')
											->setValues(
												(new MultitextCustomFieldValueCollection())
													->add(
														(new MultitextCustomFieldValueModel())
															->setValue($contact->getContactEmail())
													)
											)
									)
							)
					)
				);

        $lead = $leadsService->addOneComplex($lead);
    }
}