<?php
/**
 * @copyright   2016 Mautic Contributors. All rights reserved.
 * @author      Mautic, Raymund Delfin
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\InsightlyCrmBundle\Integration;

use MauticPlugin\MauticCrmBundle\Integration\CrmAbstractIntegration;

/**
 * Class InsightlyIntegration.
 */
class InsightlyIntegration extends CrmAbstractIntegration
{
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName()
    {
        return 'Insightly';
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getRequiredKeyFields()
    {
        return array(
            $this->getApiKey() => 'mautic.insightly.form.apikey',
        );
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return 'apikey';
    }

    /**
     * Get the array key for the auth token.
     *
     * @return string
     */
    public function getAuthTokenKey()
    {
        return 'apikey';
    }

    /**
     * @return array
     */
    public function getFormSettings()
    {
        return array(
            'requires_callback' => false,
            'requires_authorization' => false,
        );
    }
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getAuthenticationType()
    {
        return 'key';
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        return 'https://api.insight.ly';
    }

    /**
     * Get the API helper
     *
     * @return Object
     */
    public function getApiHelper()
    {
        static $helper;
        if (empty($helper)) {
            $class = '\\MauticPlugin\\InsightlyCrmBundle\\Api\\'.$this->getName().'Api';
            $helper = new $class($this);
        }

        return $helper;
    }

    /**
     * @return array|mixed
     */
    public function getAvailableLeadFields($settings = array())
    {
        $hubsFields = array();
        $silenceExceptions = (isset($settings['silence_exceptions'])) ? $settings['silence_exceptions'] : true;
        try {
            if ($this->isAuthorized()) {
                $leadFields = $this->getApiHelper()->getLeadFields();

                if (isset($leadFields)) {
                    foreach ($leadFields as $key => $value) {
                        $hubsFields[$key] = array(
                            'type' => $value,
                            'label' => str_replace("_", " ", $key)
                        );
                    }
                }
                // Email is Required for this kind of integration
                $hubsFields['EMAIL_ADDRESS']['required'] = true;
            }
        } catch (\Exception $e) {
            $this->logIntegrationError($e);

            if (!$silenceExceptions) {
                throw $e;
            }
        }

        return $hubsFields;
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function isAuthorized()
    {
        $keys = $this->getKeys();

        return isset($keys[$this->getAuthTokenKey()]);
    }

    public function getInsightlyApiKey()
    {
        $tokenData = $this->getKeys();

        return $tokenData[$this->getAuthTokenKey()];
    }
}
