<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'noodle' => array(
		'field_types' => array(
    		'Color' => 'Zend/Form/Element/Color',
    		'Date' => 'Zend/Form/Element/Date',
    		'DateSelect' => 'Zend/Form/Element/DateTime',
    		'DateTime' => 'Zend/Form/Element/DateTime',
    		'DateTime Local' => 'Zend/Form/Element/DateTimeLocal',
    		'DateTime Select' => 'Zend/Form/Element/DateTimeSelect',
    		'E-mail' => 'Zend/Form/Element/Email',
    		'File' => 'Zend/Form/Element/File',
    		'Image' => 'Application\Form\Element\Picture',
    		'Month' => 'Zend/Form/Element/Month',
    		'MonthSelect' => 'Zend/Form/Element/MonthSelect',
    		'Number' => 'Zend/Form/Element/Number',
    		'Password' => 'Zend/Form/Element/Password',
    		'Range' => 'Zend/Form/Element/Range',
    		'Relation' => 'Application\Form\Element\Relation',
    		'Select' => 'Zend/Form/Element/Select',
    		'Text' => 'Zend/Form/Element/Text',
    		'Textarea' => 'Zend/Form/Element/Textarea',
    		'Time' => 'Zend/Form/Element/Time',
    		'Url' => 'Zend/Form/Element/Url',
    		'Week' => 'Zend/Form/Element/Week',
			'Zend image' => 'Zend/Form/Element/Image',
    	)
	)
);
