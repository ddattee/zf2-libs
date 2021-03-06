<?php
/**
 * Ogone URL has generator
 *
 * @category  General
 * @package   General\Ogone
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Ogone;

/**
 * Description of Security
 *
 * SHA IN REF  : https://payment-services.ingenico.com/fr/fr/ogone/support/guides/integration%20guides/e-commerce/security-pre-payment-check#shainsignature
 * SHA OUT REF : https://payment-services.ingenico.com/fr/fr/ogone/support/guides/integration%20guides/e-commerce/transaction-feedback#redirectionwithdatabaseupdate
 *
 * @author ddattee
 */
class Security
{
    /**
     * Allowed keys for SHA-IN
     * @var array
     */
    const SHAIN_ALLOWED = array(
        'ACCEPTANCE', 'ACCEPTURL', 'ADDMATCH', 'ADDRMATCH', 'AIACTIONNUMBER', 'AIAGIATA', 'AIAIRNAME', 'AIAIRTAX', 'AIBOOKIND*XX*', 'AICARRIER*XX*', 'AICHDET', 'AICLASS*XX*', 'AICONJTI', 'AIDEPTCODE', 'AIDESTCITY*XX*', 'AIDESTCITYL*XX*', 'AIEXTRAPASNAME*XX*', 'AIEYCD', 'AIFLDATE*XX*', 'AIFLNUM*XX*', 'AIGLNUM', 'AIINVOICE', 'AIIRST', 'AIORCITY*XX*', 'AIORCITYL*XX*', 'AIPASNAME', 'AIPROJNUM', 'AISTOPOV*XX*', 'AITIDATE', 'AITINUM', 'AITINUML*XX*', 'AITYPCH', 'AIVATAMNT', 'AIVATAPPL', 'ALIAS', 'ALIASOPERATION', 'ALIASUSAGE', 'ALLOWCORRECTION', 'AMOUNT', 'AMOUNT*XX*', 'AMOUNTHTVA',
        'BACKURL', 'BATCHID', 'BGCOLOR', 'BLVERNUM', 'BIC', 'BIN', 'BRAND', 'BRANDVISUAL', 'BUTTONBGCOLOR', 'BUTTONTXTCOLOR',
        'CANCELURL', 'CARDNO', 'CATALOGURL', 'CAVV_3D', 'CAVVALGORITHM_3D', 'CERTID', 'CHECK_AAV', 'CIVILITY', 'CN', 'COM', 'COMPLUS', 'CONVCCY', 'COSTCENTER', 'COSTCODE', 'CREDITCODE', 'CUID', 'CURRENCY', 'CVC', 'CVCFLAG',
        'DATA', 'DATATYPE', 'DATEIN', 'DATEOUT', 'DCC_COMMPERC', 'DCC_CONVAMOUNT', 'DCC_CONVCCY', 'DCC_EXCHRATE', 'DCC_EXCHRATETS', 'DCC_INDICATOR', 'DCC_MARGINPERC', 'DCC_REF', 'DCC_SOURCE', 'DCC_VALID', 'DECLINEURL', 'DEVICE', 'DISCOUNTRATE', 'DISPLAYMODE',
        'ECI', 'ECI_3D', 'ECOM_BILLTO_POSTAL_CITY', 'ECOM_BILLTO_POSTAL_COUNTRYCODE', 'ECOM_BILLTO_POSTAL_COUNTY', 'ECOM_BILLTO_POSTAL_NAME_FIRST', 'ECOM_BILLTO_POSTAL_NAME_LAST', 'ECOM_BILLTO_POSTAL_POSTALCODE', 'ECOM_BILLTO_POSTAL_STREET_LINE1', 'ECOM_BILLTO_POSTAL_STREET_LINE2', 'ECOM_BILLTO_POSTAL_STREET_NUMBER', 'ECOM_CONSUMERID', 'ECOM_CONSUMER_GENDER', 'ECOM_CONSUMEROGID', 'ECOM_CONSUMERORDERID', 'ECOM_CONSUMERUSERALIAS', 'ECOM_CONSUMERUSERPWD', 'ECOM_CONSUMERUSERID', 'ECOM_ESTIMATEDELIVERYDATE', 'ECOM_PAYMENT_CARD_EXPDATE_MONTH', 'ECOM_PAYMENT_CARD_EXPDATE_YEAR', 'ECOM_PAYMENT_CARD_NAME', 'ECOM_PAYMENT_CARD_VERIFICATION', 'ECOM_SHIPMETHODDETAILS', 'ECOM_SHIPMETHODSPEED', 'ECOM_SHIPMETHODTYPE', 'ECOM_SHIPTO_COMPANY', 'ECOM_SHIPTO_DOB', 'ECOM_SHIPTO_ONLINE_EMAIL', 'ECOM_SHIPTO_POSTAL_CITY', 'ECOM_SHIPTO_POSTAL_COUNTRYCODE', 'ECOM_SHIPTO_POSTAL_COUNTY', 'ECOM_SHIPTO_POSTAL_NAME_FIRST', 'ECOM_SHIPTO_POSTAL_NAME_LAST', 'ECOM_SHIPTO_POSTAL_NAME_PREFIX', 'ECOM_SHIPTO_POSTAL_POSTALCODE', 'ECOM_SHIPTO_POSTAL_STATE', 'ECOM_SHIPTO_POSTAL_STREET_LINE1', 'ECOM_SHIPTO_POSTAL_STREET_LINE2', 'ECOM_SHIPTO_POSTAL_STREET_NUMBER', 'ECOM_SHIPTO_TELECOM_FAX_NUMBER', 'ECOM_SHIPTO_TELECOM_PHONE_NUMBER', 'ECOM_SHIPTO_TVA', 'ED', 'EMAIL', 'EXCEPTIONURL', 'EXCLPMLIST', 'EXECUTIONDATE*XX*',
        'FACEXCL*XX*', 'FACTOTAL*XX*', 'FIRSTCALL', 'FLAG3D', 'FONTTYPE', 'FORCECODE1', 'FORCECODE2', 'FORCECODEHASH', 'FORCEPROCESS', 'FORCETP',
        'GENERIC_BL', 'GIROPAY_ACCOUNT_NUMBER', 'GIROPAY_BLZ', 'GIROPAY_OWNER_NAME', 'GLOBORDERID', 'GUID',
        'HDFONTTYPE', 'HDTBLBGCOLOR', 'HDTBLTXTCOLOR', 'HEIGHTFRAME', 'HOMEURL', 'HTTP_ACCEPT', 'HTTP_USER_AGENT',
        'IBAN', 'INCLUDE_BIN', 'INCLUDE_COUNTRIES', 'INVDATE', 'INVDISCOUNT', 'INVLEVEL', 'INVORDERID', 'ISSUERID', 'IST_MOBILE', 'ITEM_COUNT', 'ITEMATTRIBUTES*XX*', 'ITEMCATEGORY*XX*', 'ITEMCOMMENTS*XX*', 'ITEMDESC*XX*', 'ITEMDISCOUNT*XX*', 'ITEMFDMPRODUCTCATEG*XX*', 'ITEMID*XX*', 'ITEMNAME*XX*', 'ITEMPRICE*XX*', 'ITEMQUANT*XX*', 'ITEMQUANTORIG*XX*', 'ITEMUNITOFMEASURE*XX*', 'ITEMVAT*XX*', 'ITEMVATCODE*XX*', 'ITEMWEIGHT*XX*',
        'LANGUAGE', 'LEVEL1AUTHCPC', 'LIDEXCL*XX*', 'LIMITCLIENTSCRIPTUSAGE', 'LINE_REF', 'LINE_REF1', 'LINE_REF2', 'LINE_REF3', 'LINE_REF4', 'LINE_REF5', 'LINE_REF6', 'LIST_BIN', 'LIST_COUNTRIES', 'LOGO',
        'MANDATEID', 'MAXITEMQUANT*XX*', 'MERCHANTID', 'MODE', 'MTIME', 'MVER',
        'NETAMOUNT',
        'OPERATION', 'ORDERID', 'ORDERSHIPCOST', 'ORDERSHIPMETH', 'ORDERSHIPTAX', 'ORDERSHIPTAXCODE', 'ORIG', 'OR_INVORDERID', 'OR_ORDERID', 'OWNERADDRESS', 'OWNERADDRESS2', 'OWNERCTY', 'OWNERTELNO', 'OWNERTELNO2', 'OWNERTOWN', 'OWNERZIP',
        'PAIDAMOUNT', 'PARAMPLUS', 'PARAMVAR', 'PAYID', 'PAYMETHOD', 'PM', 'PMLIST', 'PMLISTPMLISTTYPE', 'PMLISTTYPE', 'PMLISTTYPEPMLIST', 'PMTYPE', 'POPUP', 'POST', 'PSPID', 'PSWD',
        'RECIPIENTACCOUNTNUMBER', 'RECIPIENTDOB', 'RECIPIENTLASTNAME', 'RECIPIENTZIP', 'REF', 'REFER', 'REFID', 'REFKIND', 'REF_CUSTOMERID', 'REF_CUSTOMERREF', 'REGISTRED', 'REMOTE_ADDR', 'REQGENFIELDS', 'RNPOFFERT', 'RTIMEOUT', 'RTIMEOUTREQUESTEDTIMEOUT',
        'SCORINGCLIENT', 'SEQUENCETYPE', 'SETT_BATCH', 'SID', 'SIGNDATE', 'STATUS_3D', 'SUBSCRIPTION_ID', 'SUB_AM', 'SUB_AMOUNT', 'SUB_COM', 'SUB_COMMENT', 'SUB_CUR', 'SUB_ENDDATE', 'SUB_ORDERID', 'SUB_PERIOD_MOMENT', 'SUB_PERIOD_MOMENT_M', 'SUB_PERIOD_MOMENT_WW', 'SUB_PERIOD_NUMBER', 'SUB_PERIOD_NUMBER_D', 'SUB_PERIOD_NUMBER_M', 'SUB_PERIOD_NUMBER_WW', 'SUB_PERIOD_UNIT', 'SUB_STARTDATE', 'SUB_STATUS',
        'TAAL', 'TAXINCLUDED*XX*', 'TBLBGCOLOR', 'TBLTXTCOLOR', 'TID', 'TITLE', 'TOTALAMOUNT', 'TP', 'TRACK2', 'TXTBADDR2', 'TXTCOLOR', 'TXTOKEN', 'TXTOKENTXTOKENPAYPAL', 'TYPE_COUNTRY',
        'UCAF_AUTHENTICATION_DATA', 'UCAF_PAYMENT_CARD_CVC2', 'UCAF_PAYMENT_CARD_EXPDATE_MONTH', 'UCAF_PAYMENT_CARD_EXPDATE_YEAR', 'UCAF_PAYMENT_CARD_NUMBER', 'USERID', 'USERTYPE',
        'VERSION',
        'WBTU_MSISDN', 'WBTU_ORDERID', 'WEIGHTUNIT', 'WIN3DS', 'WITHROOT',
    );

    /**
     * Allowed keys for SHA-OUT
     * @var array
     */
    const SHAOUT_ALLOWED = array(
        'AAVADDRESS', 'AAVCHECK', 'AAVMAIL', 'AAVNAME', 'AAVPHONE', 'AAVZIP', 'ACCEPTANCE', 'ALIAS', 'AMOUNT',
        'BIC', 'BIN', 'BRAND',
        'CARDNO', 'CCCTY', 'CN', 'COMPLUS', 'CREATION_STATUS', 'CURRENCY', 'CVCCHECK',
        'DCC_COMMPERCENTAGE', 'DCC_CONVAMOUNT', 'DCC_CONVCCY', 'DCC_EXCHRATE', 'DCC_EXCHRATESOURCE', 'DCC_EXCHRATETS', 'DCC_INDICATOR', 'DCC_MARGINPERCENTAGE', 'DCC_VALIDHOURS', 'DIGESTCARDNO',
        'ECI', 'ED', 'ENCCARDNO',
        'FXAMOUNT', 'FXCURRENCY',
        'IBAN', 'IP', 'IPCTY',
        'NBREMAILUSAGE', 'NBRIPUSAGE', 'NBRIPUSAGE_ALLTX', 'NBRUSAGE', 'NCERROR', 'NCERRORCARDNO', 'NCERRORCN', 'NCERRORCVC', 'NCERRORED',
        'ORDERID',
        'PAYID', 'PM',
        'SCO_CATEGORY', 'SCORING', 'STATUS', 'SUBBRAND', 'SUBSCRIPTION_ID',
        'TRXDATE',
        'VC'
    );

    /**
     * Generate the SHA1 key based on the given params
     *
     * @param array  $params Array of paramas to use to generate the SHA1
     * @param string $secret Separator to split the string
     * @param string $io     Define the reference for the key : in/out
     *
     * @return string The generated SHASign
     *
     * @throws ParamException
     */
    public function generateShaSign($params, $secret, $io = 'in')
    {
        $str = '';
        //Change the key to upper case
        $params = array_change_key_case($params, CASE_UPPER);
        // Sort the array by keys
        ksort($params);
        //Build the string
        foreach ($params as $key => $value) {
            //Check that the keys are allowed in the sha1 string
            if ($this->isValidParam($key, $io)) {
                //Check that the value isn't empty
                if (strlen($value) > 0) {
                    $str .= strtoupper($key) . '=' . $value . $secret;
                }
            } else {
                throw new ParamException('Parameter "' . $key . '" is not allowed for Sha' . ucfirst($io));
            }
        }
        return strtoupper(sha1($str));
    }

    /**
     * Compare two shasigns to detect if they are equald
     * @param string $shasign
     * @param string $shasign_response
     * @return bool
     */
    public function isValidShasign($shasign, $shasign_response)
    {
        return (strtoupper($shasign) === strtoupper($shasign_response));
    }

    /**
     * Check if the param is allowed in the given IO
     *
     * @param string $param
     * @param string $io
     *
     * @return bool
     */
    public function isValidParam($param, $io = 'in')
    {
        $allowed = strtoupper('sha' . $io . '_allowed');
        return in_array($param, constant('self::' . $allowed));
    }
}
