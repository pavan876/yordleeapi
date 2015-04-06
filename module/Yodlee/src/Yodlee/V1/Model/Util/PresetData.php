<?php
/**
 * Project: PrivyPASS.com
 * Author: Hari Dornala
 * Date: 9/5/14
 * Time: 1:26 PM
 */

namespace Yodlee\V1\Model\Util;

class PresetData
{

    public static function getYelpMapCategories()
    {
        return array(
            'Restaurants/Dining',
//            'Clothing/Shoes',
//            'Groceries',
//            'Electronics',
//            'Travel',
//            'General Merchandise'
        );
    }

    public static function getCategoryMap()
    {
        return array(
            'Entertainment',
            'Cable/Satellite Services',
            'Hobbies',
            'Restaurants/Dining',
            'Charitable Giving',
            'Gifts',
            'Personal Care',
            'Travel',
            'Pets/Pet Care',
            'Clothing/Shoes',
            'Groceries',
            'Electronics',
            'General Merchandise'
        );
    }

    public static function getMajorCategoryMap()
    {
        return array(
            '1__Entertainment' => array(
                'Entertainment',
                'Cable/Satellite Services',
                'Hobbies'
            ),
            '2__Food & Dining' => array(
                'Restaurants/Dining'
            ),
            '3__Lifestyle'     => array(
                'Charitable Giving',
                'Gifts',
                'Personal Care',
                'Travel',
                'Pets/Pet Care',
                'Gasoline/Fuel'
            ),
            '4__Shopping'      => array(
                'Clothing/Shoes',
                'Groceries',
                'Electronics',
                'General Merchandise'
            )
        );
    }
} 