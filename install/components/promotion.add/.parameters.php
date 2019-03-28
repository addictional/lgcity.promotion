<?php
/**
 * Created by PhpStorm.
 * User: Ivan.Yakovlev
 * Date: 13.03.2019
 * Time: 16:31
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $DB;
if (!CModule::IncludeModule("lgcity.promotion")
    || !CModule::IncludeModule('iblock')
    || !CModule::IncludeModule('sale')
) return;

//$propParamsIblock = [1=> 'pidr',2=> 'pidor'];
$dbIBlockType = CIBlockType::GetList(
    ['sort' => 'asc'],
    ['ACTIVE' => 'Y']
);

while ($arIBlockType = $dbIBlockType->Fetch())
{
    if ($arIBlockTypeLang = CIBlockType::GetByIDLang($arIBlockType["ID"], LANGUAGE_ID))
    {
        $arIBlockTypes[$arIBlockType['ID']] = "[".$arIBlockType['ID']."] ".$arIBlockTypeLang["NAME"];
    }
}
$dbIBlocks = CIBlock::GetList(
    ['SORT' => 'ASC'],
    [
        'ACTIVE' => 'Y',
        'TYPE' => $arCurrentValues['IBLOCK_TYPE']
    ]
);
while ($IBlock = $dbIBlocks->Fetch())
{
    $paramsIBlock[$IBlock['ID']] = "[".$IBlock['ID']."] ".$IBlock['NAME'];
}

$sql = 'SELECT * FROM b_iblock_property WHERE PROPERTY_TYPE = "S" AND IBLOCK_ID = '.$arCurrentValues['IBLOCK'].
" ";
if(isset($arCurrentValues['IBLOCK']) && !empty($arCurrentValues['IBLOCK']))
{
    $query = $DB->Query($sql);

    while($prop = $query->Fetch())
    {
        $propParamsIblock[$prop['ID']] = "[".$prop['ID']."] ".$prop['NAME'];
    }
}

$arComponentParameters = array(
    "PARAMETERS" => array(
        "CACHE_TIME" => array("DEFAULT" => "3600"),
        "IBLOCK_TYPE" => [
            'PARENT' => 'BASE',
            'NAME' => 'Тип инфоблока',
            'TYPE' => 'LIST',
            'VALUES' => $arIBlockTypes,
            'REFRESH' => 'Y',
            'MULTIPLE' => 'N',
        ],
        "IBLOCK" => [
            'PARENT' => 'BASE',
            'NAME' => 'Инфоблок',
            'TYPE' => 'LIST',
            'VALUES' => $paramsIBlock,
            'REFRESH' => 'Y',
            'MULTIPLE' => 'N'
        ],
        "PROPERS" => [
            'PARENT' => 'BASE',
            'NAME' => 'Свойство для скидки',
            'TYPE' => 'LIST',
            'VALUES' => $propParamsIblock,
        ]

    ),
);
?>