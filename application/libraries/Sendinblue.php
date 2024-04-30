<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(dirname(__FILE__, 3) . '/vendor/autoload.php');
class Sendinblue
{
    public function __construct()
    {

		// $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', SENDINBLUE_API_SECRET_KEY);
        // $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('partner-key', SENDINBLUE_API_SECRET_KEY);
		// $apiInstance = new SendinBlue\Client\Api\ContactsApi(
		// 	new GuzzleHttp\Client(),
		// 	$config
		// );
		
		// $identifier = 'yuhanghpro@gmail.com';
		
		// try {
		// 	$result = $apiInstance->getContactInfo($identifier);
		// 	print_r($result);
		// } catch (Exception $e) {
		// 	echo 'Exception when calling ContactsApi->getContactInfo: ', $e->getMessage(), PHP_EOL;
		// }
    }

    public function create_contact($mem)
    {
        $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', SENDINBLUE_API_SECRET_KEY);
        $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('partner-key', SENDINBLUE_API_SECRET_KEY);
        $apiInstance = new SendinBlue\Client\Api\ContactsApi(
            new GuzzleHttp\Client(),
            $config
        );

        $createContact['email'] = $mem->mem_email;
        // $createContact['listIds'] = [4];
        $createContact['attributes'] = ['FIRSTNAME'=> $mem->mem_fname, 'LASTNAME'=> $mem->mem_lname];

        
        try {
            $result = $apiInstance->createContact($createContact);
            // return true;
        } catch (Exception $e) {
            //     print_r($e);
            // echo 'Exception when calling ContactsApi->createContact: ', $e->getMessage(), PHP_EOL;
            // return true;
        }

		$listId = 4;
		$contactIdentifiers = new \SendinBlue\Client\Model\AddContactToList();
		$contactIdentifiers['emails'] = array($mem->mem_email);
		
		try {
			$result = $apiInstance->addContactToList($listId, $contactIdentifiers);
			// print_r($result);
			return true;
		} catch (Exception $e) {
			// echo 'Exception when calling ContactsApi->addContactToList: ', $e->getMessage(), PHP_EOL;
			return true;
		}
    }

	public function shift_from_nonsubscribed_to_subscribed($email)
	{
		$email = trim($email);
		$config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', SENDINBLUE_API_SECRET_KEY);
        $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('partner-key', SENDINBLUE_API_SECRET_KEY);
        $apiInstance = new SendinBlue\Client\Api\ContactsApi(
            new GuzzleHttp\Client(),
            $config
        );
		$listId = 2;
		$contactIdentifiers = new \SendinBlue\Client\Model\AddContactToList();
		$contactIdentifiers['emails'] = array($email);
		
		try {
			$result = $apiInstance->addContactToList($listId, $contactIdentifiers);
			// print_r($result);
			return true;
		} catch (Exception $e) {
			// echo 'Exception when calling ContactsApi->addContactToList: ', $e->getMessage(), PHP_EOL;
			return true;
		}


		$listId = 4;
		$contactIdentifiers = new \SendinBlue\Client\Model\RemoveContactFromList();
		$contactIdentifiers['emails'] = array($email);
		
		try {
			$result = $apiInstance->removeContactFromList($listId, $contactIdentifiers);
			// print_r($result);
			return true;
		} catch (Exception $e) {
			// echo 'Exception when calling ContactsApi->removeContactFromList: ', $e->getMessage(), PHP_EOL;
			return true;
		}
	}

	public function shift_from_subscribed_to_nonsubscribed($email)
	{
		$email = trim($email);
		$config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', SENDINBLUE_API_SECRET_KEY);
        $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('partner-key', SENDINBLUE_API_SECRET_KEY);
        $apiInstance = new SendinBlue\Client\Api\ContactsApi(
            new GuzzleHttp\Client(),
            $config
        );
		$listId = 4;
		$contactIdentifiers = new \SendinBlue\Client\Model\AddContactToList();
		$contactIdentifiers['emails'] = array($email);
		
		try {
			$result = $apiInstance->addContactToList($listId, $contactIdentifiers);
			// print_r($result);
			return true;
		} catch (Exception $e) {
			// echo 'Exception when calling ContactsApi->addContactToList: ', $e->getMessage(), PHP_EOL;
			return true;
		}


		$listId = 2;
		$contactIdentifiers = new \SendinBlue\Client\Model\RemoveContactFromList();
		$contactIdentifiers['emails'] = array($email);
		
		try {
			$result = $apiInstance->removeContactFromList($listId, $contactIdentifiers);
			// print_r($result);
			return true;
		} catch (Exception $e) {
			// echo 'Exception when calling ContactsApi->removeContactFromList: ', $e->getMessage(), PHP_EOL;
			return true;
		}
	}

    public function create_contact_subscribed($mem)
    {
        $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', SENDINBLUE_API_SECRET_KEY);
        $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('partner-key', SENDINBLUE_API_SECRET_KEY);
        $apiInstance = new SendinBlue\Client\Api\ContactsApi(
            new GuzzleHttp\Client(),
            $config
        );

        $createContact['email'] = $mem->mem_email;
        // $createContact['listIds'] = [4];
        $createContact['attributes'] = ['FIRSTNAME'=> $mem->mem_fname, 'LASTNAME'=> $mem->mem_lname];

        
        try {
            $result = $apiInstance->createContact($createContact);
            // return true;
        } catch (Exception $e) {
            //     print_r($e);
            // echo 'Exception when calling ContactsApi->createContact: ', $e->getMessage(), PHP_EOL;
            return true;
        }

		$listId = 2;
		$contactIdentifiers = new \SendinBlue\Client\Model\AddContactToList();
		$contactIdentifiers['emails'] = array($mem->mem_email);
		
		try {
			$result = $apiInstance->addContactToList($listId, $contactIdentifiers);
			// print_r($result);
			return true;
		} catch (Exception $e) {
			// echo 'Exception when calling ContactsApi->addContactToList: ', $e->getMessage(), PHP_EOL;
			return true;
		}
    }
}
