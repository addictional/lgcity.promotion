<?php

use Bitrix\Main\Loader,
    Lgcity\Promotion\Eloquent\Controllers\HBs,
    Lgcity\Promotion\Base,
    Carbon\Carbon;


class PromotionBanner extends CBitrixComponent
{
    public function  setArResult()
    {
        if($this->startResultCache())
        {
            $this->arResult = $this->getActiveBanner();
            $this->includeComponentTemplate();
        }
    }
    public function executeComponent()
    {
        $this->setArResult();
    }
    private function getActiveBanner()
    {
        Loader::includeModule('lgcity.promotion');
        new Base\Database();
        $banners = HBs::getActive();
        if(count($banners)<0)
            return false;
        $result = null;
        foreach ($banners as $index => &$banner)
        {
            if($index == 0 )
            {
                $currIndex = $index;
                $result = $banner;
                continue;
            }
            else
            {
                if($result->UF_SORT == $banner->UF_SORT)
                {
                    $curRes = Carbon::createFromTimeString($result->UF_ACTIVE_FROM);
                    $current = Carbon::createFromTimeString($banner->UF_ACTIVE_FROM);
                    if($curRes->greaterThan($current))
                        unset($banner);
                    else
                    {
                        unset($banners[$currIndex]);
                        $result = $banner;
                    }
                }
                else
                    {
                     unset($banners[$index]);
                     continue;
                    }
            }

        }
        return $result;
    }
}