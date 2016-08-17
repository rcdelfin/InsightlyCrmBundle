<?php
/**
 * @copyright   2016 Mautic Contributors. All rights reserved.
 * @author      Mautic, Raymund Delfin
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\InsightlyCrmBundle\Api;

use Mautic\PluginBundle\Exception\ApiErrorException;
use MauticPlugin\MauticCrmBundle\Api\CrmApi;
use MauticPlugin\MauticCrmBundle\Integration\CrmAbstractIntegration;
use MauticPlugin\InsightlyCrmBundle\Lib\Insightly;

class InsightlyApi extends CrmApi
{
  
  private $insightly = null;

  public function __construct(CrmAbstractIntegration $integration)
  {
    parent::__construct($integration);

    // $hashKey = $this->integration->getInsightlyApiKey();
    // $this->insightly = new Insightly($hashKey);
  }

  /**
   * @return mixed
   */
  public function getLeadFields()
  {
    $leadInfo = [
      "LEAD_ID" => 'integer',
      "SALUTATION" => "string",
      "TITLE" => "string",
      "FIRST_NAME" => "string",
      "LAST_NAME" => "string",
      "ORGANIZATION_NAME" => "string",
      "PHONE_NUMBER" => "string",
      "MOBILE_PHONE_NUMBER" => "string",
      "FAX_NUMBER" => "string",
      "EMAIL_ADDRESS" => "string",
      "WEBSITE_URL" => "string",
      "OWNER_USER_ID" => 'integer',
      "DATE_CREATED_UTC" => "datetime",
      "DATE_UPDATED_UTC" => "datetime",
      "CONVERTED" => true,
      "CONVERTED_DATE_UTC" => "datetime",
      "CONVERTED_CONTACT_ID" => 'integer',
      "CONVERTED_ORGANIZATION_ID" => 'integer',
      "CONVERTED_OPPORTUNITY_ID" => 'integer',
      "VISIBLE_TO" => "string",
      "RESPONSIBLE_USER_ID" => 'integer',
      "INDUSTRY" => "string",
      "LEAD_STATUS_ID" => 'integer',
      "LEAD_SOURCE_ID" => 'integer',
      "VISIBLE_TEAM_ID" => 'integer',
      "EMPLOYEE_COUNT" => 'integer',
      "LEAD_RATING" => 'integer',
      "LEAD_DESCRIPTION" => "string",
      "VISIBLE_USER_IDS" => "string",
      "ADDRESS_STREET" => "string",
      "ADDRESS_CITY" => "string",
      "ADDRESS_STATE" => "string",
      "ADDRESS_POSTCODE" => "string",
      "ADDRESS_COUNTRY" => "string",
      "IMAGE_URL" => "string"
    ];
    return $leadInfo;
  }

  /**
   * Creates Insightly lead.
   *
   * @param array $data
   *
   * @return mixed
   */
  public function createLead(array $data)
  {
    $hashKey = $this->integration->getInsightlyApiKey();
    $insightly = new Insightly($hashKey);
    
    return $insightly->addLead($data);
  }   
}
