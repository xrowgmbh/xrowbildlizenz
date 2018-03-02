<?php

/*!
  \class xrowImageLicensingType xrowimagelicensing.php
*/

class xrowImageLicensingType extends eZDataType
{
    const DATA_TYPE_STRING = "xrowimagelicensing";
    
    function xrowImageLicensingType()
    {
        $this->eZDataType( self::DATA_TYPE_STRING, ezpI18n::tr( 'extension/xrowimagelicensing/datatypes', "Image Licensing", 'Datatype name' ),
            array( 'serialize_supported' => true ) );
    }
    
    /*!
     Private method only for use inside this class
     */
    function validateDateTimeHTTPInput( $day, $month, $year, $hour, $minute, $contentObjectAttribute, $http )
    {
        $state = eZDateTimeValidator::validateDate( (int)$day, (int)$month, (int)$year );
        if ( $state == eZInputValidator::STATE_INVALID )
        {
            $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
                'Date is not valid.' ) );
            return eZInputValidator::STATE_INVALID;
        }
        
        $state = eZDateTimeValidator::validateTime( (int)$hour, (int)$minute );
        
        if ( $state == eZInputValidator::STATE_INVALID )
        {
            $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
                'Time is not valid.' ) );
            return eZInputValidator::STATE_INVALID;
        }
        
        if ( $http->hasPostVariable( $base . '_bildlizenz_selected_' . $contentObjectAttribute->attribute( 'id' ) ) and
            $http->postVariable( $base . '_bildlizenz_selected_' . $contentObjectAttribute->attribute( 'id' )) == "1" )
        {
            return eZInputValidator::STATE_ACCEPTED;
        }
        return $state;
    }
    
    /*!
     Validates the input and returns true if the input was
     valid for this datatype.
     */
    function validateObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        $classAttribute = $contentObjectAttribute->contentClassAttribute();
        
        if ( $http->hasPostVariable( $base . '_bildlizenz_year_' . $contentObjectAttribute->attribute( 'id' ) ) and
            $http->hasPostVariable( $base . '_bildlizenz_month_' . $contentObjectAttribute->attribute( 'id' ) ) and
            $http->hasPostVariable( $base . '_bildlizenz_day_' . $contentObjectAttribute->attribute( 'id' ) ) and
            $http->hasPostVariable( $base . '_bildlizenz_hour_' . $contentObjectAttribute->attribute( 'id' ) ) and
            $http->hasPostVariable( $base . '_bildlizenz_minute_' . $contentObjectAttribute->attribute( 'id' ) ) and 
            $http->hasPostVariable( $base . '_bildlizenz_selected_' . $contentObjectAttribute->attribute( 'id' ) )
            )
        {
            $year   = $http->postVariable( $base . '_bildlizenz_year_' . $contentObjectAttribute->attribute( 'id' ) );
            $month  = $http->postVariable( $base . '_bildlizenz_month_' . $contentObjectAttribute->attribute( 'id' ) );
            $day    = $http->postVariable( $base . '_bildlizenz_day_' . $contentObjectAttribute->attribute( 'id' ) );
            $hour   = $http->postVariable( $base . '_bildlizenz_hour_' . $contentObjectAttribute->attribute( 'id' ) );
            $minute = $http->postVariable( $base . '_bildlizenz_minute_' . $contentObjectAttribute->attribute( 'id' ) );
            $selected = $http->postVariable( $base . '_bildlizenz_selected_' . $contentObjectAttribute->attribute( 'id' ) );
             
            if ($selected == "1")
            {
                return eZInputValidator::STATE_ACCEPTED;
            } 
            else
            {
                if ( $year == '' or $month == '' or $day == '' or $hour == '' or $minute == '' )
                {
                    if ( !( $year == '' and $month == '' and $day == '' and $hour == '' and $minute == '' ) or
                         ( !$classAttribute->attribute( 'is_information_collector' ) and $contentObjectAttribute->validateIsRequired() ) )
                    {
                        $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes', 'Missing datetime input.' ) );
                        return eZInputValidator::STATE_INVALID;
                    }
                    else
                    {
                        return eZInputValidator::STATE_ACCEPTED;
                    }
                }
                else
                {
                    return $this->validateDateTimeHTTPInput( $day, $month, $year, $hour, $minute, $contentObjectAttribute, $http );
                }
            }
        }
        else if ( !$classAttribute->attribute( 'is_information_collector' ) and $contentObjectAttribute->validateIsRequired() )
        {
            $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes', 'Missing datetime input.' ) );
            return eZInputValidator::STATE_INVALID;
        }
        else
            return eZInputValidator::STATE_ACCEPTED;
    }
    
    /*!
     Fetches the http post var integer input and stores it in the data instance.
     */
    function fetchObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        $contentClassAttribute = $contentObjectAttribute->contentClassAttribute();
        if ( $http->hasPostVariable( $base . '_bildlizenz_selected_' . $contentObjectAttribute->attribute( 'id' ) ) and 
             $http->postVariable( $base . '_bildlizenz_selected_' . $contentObjectAttribute->attribute( 'id' )) == "0" )
        {
            if ( $http->hasPostVariable( $base . '_bildlizenz_year_' . $contentObjectAttribute->attribute( 'id' ) ) and
                $http->hasPostVariable( $base . '_bildlizenz_month_' . $contentObjectAttribute->attribute( 'id' ) ) and
                $http->hasPostVariable( $base . '_bildlizenz_day_' . $contentObjectAttribute->attribute( 'id' ) ) and
                $http->hasPostVariable( $base . '_bildlizenz_hour_' . $contentObjectAttribute->attribute( 'id' ) ) and
                $http->hasPostVariable( $base . '_bildlizenz_minute_' . $contentObjectAttribute->attribute( 'id' ) ) )
            {
                $year   = $http->postVariable( $base . '_bildlizenz_year_' . $contentObjectAttribute->attribute( 'id' ) );
                $month  = $http->postVariable( $base . '_bildlizenz_month_' . $contentObjectAttribute->attribute( 'id' ) );
                $day    = $http->postVariable( $base . '_bildlizenz_day_' . $contentObjectAttribute->attribute( 'id' ) );
                $hour   = $http->postVariable( $base . '_bildlizenz_hour_' . $contentObjectAttribute->attribute( 'id' ) );
                $minute = $http->postVariable( $base . '_bildlizenz_minute_' . $contentObjectAttribute->attribute( 'id' ) );
                $selected = $http->postVariable( $base . '_bildlizenz_selected_' . $contentObjectAttribute->attribute( 'id' ) );
                
                if ( ( $year == '' and $month == '' and $day == '' and $hour == '' and $minute == '' ) or !checkdate( $month, $day, $year ) )
                {
                    $stamp = null;
                }
                else
                {
                    $dateTime = new eZDateTime();
                    $dateTime->setMDYHMS( $month, $day, $year, $hour, $minute, 0 );
                    $stamp = $dateTime->timeStamp();
                }
                
                $contentObjectAttribute->setAttribute( 'data_int', $stamp );
                $contentObjectAttribute->setAttribute( 'data_text', $selected );
                return true;
            }
        } else {
            $contentObjectAttribute->setAttribute( 'data_int', null );
            $contentObjectAttribute->setAttribute( 'data_text', "1" );
            return true;
        }
        return false;
    }
    
    function validateCollectionAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        $contentClassAttribute = $contentObjectAttribute->contentClassAttribute();
        
        if ( $http->hasPostVariable( $base . '_bildlizenz_year_' . $contentObjectAttribute->attribute( 'id' ) ) and
            $http->hasPostVariable( $base . '_bildlizenz_month_' . $contentObjectAttribute->attribute( 'id' ) ) and
            $http->hasPostVariable( $base . '_bildlizenz_day_' . $contentObjectAttribute->attribute( 'id' ) ) and
            $http->hasPostVariable( $base . '_bildlizenz_hour_' . $contentObjectAttribute->attribute( 'id' ) ) and
            $http->hasPostVariable( $base . '_bildlizenz_minute_' . $contentObjectAttribute->attribute( 'id' ) ) and
            $http->hasPostVariable( $base . '_bildlizenz_selected_' . $contentObjectAttribute->attribute( 'id' ) )
            )
            
        {
            $year   = $http->postVariable( $base . '_bildlizenz_year_' . $contentObjectAttribute->attribute( 'id' ) );
            $month  = $http->postVariable( $base . '_bildlizenz_month_' . $contentObjectAttribute->attribute( 'id' ) );
            $day    = $http->postVariable( $base . '_bildlizenz_day_' . $contentObjectAttribute->attribute( 'id' ) );
            $hour   = $http->postVariable( $base . '_bildlizenz_hour_' . $contentObjectAttribute->attribute( 'id' ) );
            $minute = $http->postVariable( $base . '_bildlizenz_minute_' . $contentObjectAttribute->attribute( 'id' ) );
            $selected = $http->postVariable( $base . '_bildlizenz_selected_' . $contentObjectAttribute->attribute( 'id' ) );
            
            if ( $year == '' or
                $month == '' or
                $day == '' or
                $hour == '' or
                $minute == '' )
            {
                if ( !( $year == '' and
                    $month == '' and
                    $day == '' and
                    $hour == '' and
                    $minute == '' and
                    $selected == '1') or
                    $contentObjectAttribute->validateIsRequired() )
                {
                    $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
                        'Missing datetime input.' ) );
                    return eZInputValidator::STATE_INVALID;
                }
                else
                    return eZInputValidator::STATE_ACCEPTED;
            }
            else
            {
                if ( $selected == '0' )
                {
                    return $this->validateDateTimeHTTPInput( $day, $month, $year, $hour, $minute, $contentObjectAttribute, $http );
                } elseif ( $selected == '1' ) {
                    return eZInputValidator::STATE_ACCEPTED;
                }
            }
        }
        else
            return eZInputValidator::STATE_INVALID;
    }
    
    /*!
     Fetches the http post variables for collected information
     */
    function fetchCollectionAttributeHTTPInput( $collection, $collectionAttribute, $http, $base, $contentObjectAttribute )
    {
        $contentClassAttribute = $contentObjectAttribute->contentClassAttribute();
        
        if ( $http->hasPostVariable( $base . '_bildlizenz_year_' . $contentObjectAttribute->attribute( 'id' ) ) and
            $http->hasPostVariable( $base . '_bildlizenz_month_' . $contentObjectAttribute->attribute( 'id' ) ) and
            $http->hasPostVariable( $base . '_bildlizenz_day_' . $contentObjectAttribute->attribute( 'id' ) ) and
            $http->hasPostVariable( $base . '_bildlizenz_hour_' . $contentObjectAttribute->attribute( 'id' ) ) and
            $http->hasPostVariable( $base . '_bildlizenz_minute_' . $contentObjectAttribute->attribute( 'id' ) ) and
            $http->hasPostVariable( $base . '_bildlizenz_selected_' . $contentObjectAttribute->attribute( 'id' ) ) )
        {
            $year   = $http->postVariable( $base . '_bildlizenz_year_' . $contentObjectAttribute->attribute( 'id' ) );
            $month  = $http->postVariable( $base . '_bildlizenz_month_' . $contentObjectAttribute->attribute( 'id' ) );
            $day    = $http->postVariable( $base . '_bildlizenz_day_' . $contentObjectAttribute->attribute( 'id' ) );
            $hour   = $http->postVariable( $base . '_bildlizenz_hour_' . $contentObjectAttribute->attribute( 'id' ) );
            $minute = $http->postVariable( $base . '_bildlizenz_minute_' . $contentObjectAttribute->attribute( 'id' ) );
            $selected = $http->postVariable( $base . '_bildlizenz_selected_' . $contentObjectAttribute->attribute( 'id' ) );
            
            $contentClassAttribute = $contentObjectAttribute->contentClassAttribute();
            if ( ( $year == '' and $month == ''and $day == '' and $hour == '' and $minute == '' ) or !checkdate( $month, $day, $year ) )
            {
                $stamp = null;
            }
            else
            {
                $dateTime = new eZDateTime();
                $dateTime->setMDYHMS( $month, $day, $year, $hour, $minute, 0 );
                $stamp = $dateTime->timeStamp();
            }
            
            $collectionAttribute->setAttribute( 'data_int', $stamp );
            $collectionAttribute->setAttribute( 'data_text', $selected);
            return true;
        }
        return false;
    }
    
    /*!
     Returns the content.
     */
    function objectAttributeContent( $contentObjectAttribute )
    {
        $dateTime = new eZDateTime();
        $stamp = $contentObjectAttribute->attribute( 'data_int' );
        $dateTime->setTimeStamp( $stamp );
        return $dateTime;
    }
    
    function isIndexable()
    {
        return true;
    }
    
    function isInformationCollector()
    {
        return true;
    }
    
    /*!
     Returns the meta data used for storing search indeces.
     */
    function metaData( $contentObjectAttribute )
    {
        $selected = $contentObjectAttribute->attribute( 'data_text' );
        if($selected == "0")
        {
            return (int)$contentObjectAttribute->attribute( 'data_int' );
        } elseif ($selected == "1") {
            return (int)$selected;
        }
    }
    /*!
     \return string representation of an contentobjectattribute data for simplified export
     
     */
    function toString( $contentObjectAttribute )
    {
        $stamp = $contentObjectAttribute->attribute( 'data_int' );
        return $stamp === null ? '' : $stamp;
    }
    
    function fromString( $contentObjectAttribute, $string )
    {
        if ( empty( $string ) )
        {
            $string = null;
        }
        
        return $contentObjectAttribute->setAttribute( 'data_int', $string );
    }
    
    
    function classAttributeContent( $classAttribute )
    {
        $classAttrContent = eZDateTimeType::defaultClassAttributeContent();
        return $classAttrContent;
    }
    
    function defaultClassAttributeContent()
    {
        return array( 'year' => '',
            'month' => '',
            'day' => '',
            'hour' => '',
            'minute' => '',
            'selected' => '0'
        );
    }
    
    /*!
     Sets the default value.
     */
    function initializeObjectAttribute( $contentObjectAttribute, $currentVersion, $originalContentObjectAttribute )
    {
        if ( $currentVersion != false )
        {
            $dataInt = $originalContentObjectAttribute->attribute( "data_int" );
            $contentObjectAttribute->setAttribute( "data_int", $dataInt );
            $selectInt = $originalContentObjectAttribute->attribute( "data_text" );
            $contentObjectAttribute->setAttribute( "data_text", $selectInt);
        }
        else
        {
            $contentClassAttribute = $contentObjectAttribute->contentClassAttribute();
            $contentObjectAttribute->setAttribute( "data_int", null );
            $contentObjectAttribute->setAttribute( "data_text", '0' ); 
        }
    }
    
    /*!
     Returns the date.
     */
    function title( $contentObjectAttribute, $name = null )
    {
        $locale = eZLocale::instance();
        $retVal = $contentObjectAttribute->attribute( "data_int" ) === null ? '' : $locale->formatDateTime( $contentObjectAttribute->attribute( "data_int" ) );
       // $retValCombi = $contentObjectAttribute->attribute( "data_text" ) . '-' . $retVal;
        return $retVal;
    }
    
    function hasObjectAttributeContent( $contentObjectAttribute )
    {
        return $contentObjectAttribute->attribute( "data_int" ) !== null;
    }
    
    function sortKey( $contentObjectAttribute )
    {
        return (int)$contentObjectAttribute->attribute( 'data_int' );
    }
    
    function sortKeyType()
    {
        return 'int';
    }
    
    /*!
     \return a DOM representation of the content object attribute
     */
    function serializeContentObjectAttribute( $package, $objectAttribute )
    {
        $node = $this->createContentObjectAttributeDOMNode( $objectAttribute );
        
        $stamp = $objectAttribute->attribute( 'data_int' );
        
        if ( $stamp !== null )
        {
            $dom = $node->ownerDocument;
            $dateTimeNode = $dom->createElement( 'date_time' );
            $dateTimeNode->appendChild( $dom->createTextNode( eZDateUtils::rfc1123Date( $stamp ) ) );
            $node->appendChild( $dateTimeNode );
        }
        return $node;
    }
    
    function unserializeContentObjectAttribute( $package, $objectAttribute, $attributeNode )
    {
        $dateTimeNode = $attributeNode->getElementsByTagName( 'date_time' )->item( 0 );
        if ( is_object( $dateTimeNode ) )
        {
            $timestamp = eZDateUtils::textToDate( $dateTimeNode->textContent );
            $objectAttribute->setAttribute( 'data_int', $timestamp );
        }
    }
    
    function supportsBatchInitializeObjectAttribute()
    {
        return true;
    }
}

eZDataType::register( xrowImageLicensingType::DATA_TYPE_STRING, "xrowImageLicensingType" );

?>