<?
use \Bitrix\Main\Localization\Loc,
	\Bitrix\Main\Config,
	\Bitrix\Main\Config\Option,
	\Bitrix\Main\Loader,
	\Bitrix\Main\Entity\Base,
	\Bitrix\Main\Application;

use Bitrix\Main\Diag\Debug;

Loc::loadMessages(__FILE__);

/**
	 * 
	 */
	class lgcity_promotion extends CModule
	{
		
		function __construct()
		{
			$arModuleVersion = array();
			include(__DIR__."/version.php");


			$this->MODULE_ID = 'lgcity.promotion';
			$this->MODULE_VERSION = $arModuleVersion['VERSION'];
			$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
			$this->MODULE_NAME = Loc::getMessage("LGCITY_PROMOTION_MODULE_NAME");
			$this->MODULE_DESCRIPTION = Loc::getMessage("LGCITY_PROMOTION_MODULE_DESC");
			$this->MODULE_GROUP_RIGHTS = 'N';

			$this->PARTNER_NAME = Loc::getMessage("LGCITY_PROMOTION_PARTNER_NAME");
			$this->PARTNER_URI = Loc::getMessage("LGCITY_PROMOTION_PARTNER_URI");
		}
		function DoInstall(){
			global $APPLICATION;
			if($this->isVersionD7() && $this->isRequiredModules())
			{
				\Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);
				$this->doInstallDB();
				$this->installFiles();
			}
			else
			{
				$APPLICATION->ThrowException(Loc::getMessage("LGCITY_PROMOTION_INSTALL_ERROR_VERSION"));
			}

			$APPLICATION->IncludeAdminFile(Loc::getMessage("LGCITY_PROMOTION_INSTALL_TITLE"),$this->GetPath()."/install/step.php");
		}
		function DoUninstall(){
			global $APPLICATION;

			$context = Application::getInstance()->getContext();
			$request = $context->getRequest();

			if($request['step'] <2)
			{
				$APPLICATION->IncludeAdminFile(Loc::getMessage('LGCITY_PROMOTION_UNINSTALL_TITLE'),$this->GetPath()."/install/unstep1.php");
			}
			elseif($request['step'] == 2){
				// $this->UnInstallFiles();
				// $this->UnInstallEvents();
                $this->doUninstallFiles();
				if ($request['savedata'] != "Y") {
					$this->doUninstallDB();
				}

				\Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);

				$APPLICATION->IncludeAdminFile(Loc::getMessage("LGCITY_PROMOTION_UNINSTALL_TITLE"),$this->GetPath()."/install/unstep2.php");
			}
		}
		public function isVersionD7(){
			return CheckVersion(\Bitrix\Main\ModuleManager::getVersion('main'), '14.00.00');
		}
		public function isRequiredModules(){
			return \Bitrix\Main\ModuleManager::isModuleInstalled('sale');
		}
		public function GetPath($notDocumentRoot=false){
			if($notDocumentRoot)
				return str_ireplace(Application::getDocumentRoot(),'',dirname(__DIR__));
			else
				return dirname(__DIR__);
		}
		public function doInstallDB(){
			global $APPLICATION;
			if(Loader::includeModule($this->MODULE_ID))
			{
			    global $DB,$DBType,$APPLICATION;
			    $error = $DB->RunSQLBatch($this->GetPath()."/install/db/".strtolower($DB->type)."/install.sql");
			    if($error)
			    {
                    $APPLICATION->ThrowException($error);
                }
			}
			else
			{
				$APPLICATION->ThrowException('Творится муть');
			}
			$this->installHB();
		}
		protected function installHB()
        {
            global $APPLICATION,$DB;
            if(!Loader::includeModule('highloadblock'))
            {
                $APPLICATION->ThrowException('Модуль HighLoadBlock не установлен');
                return 0;
            }
            $result = Bitrix\Highloadblock\HighloadBlockTable::add([
                'NAME' => 'PromotionRow',
                'TABLE_NAME' => 'promotion_row'
            ]);
            if (!$result->isSuccess())
            {
                $errors = $result->getErrorMessages();
                $APPLICATION->ThrowException($errors);
            }
            else
            {
                if(strtolower($DB->type) == 'mysql')
                {
                    $DB->Query("INSERT INTO `b_hlblock_entity_lang` 
                (ID,LID,NAME) VALUES(".$result->getId().",'ru','Акционная полоска') ");
                }
                $hLBId = $result->getId();
                $userTypeEntity = new CUserTypeEntity();
                $userTypeEntity->Add($this->massHLBProp($hLBId,
                    'ROW_TEXT','Полоска акции',
                    'Promotion row','string'));
                $userTypeEntity->Add($this->massHLBProp($hLBId,
                    'LINK','Ссылка',
                    'Link','string'));
                $userTypeEntity->Add($this->massHLBProp($hLBId,
                    'BACKGROUND_COLOR','Цвет фона',
                    'Background color','string'));
                $userTypeEntity->Add($this->massHLBProp($hLBId,
                    'FONT_COLOR','Цвет текста',
                    'Font color','string'));
                $userTypeEntity->Add($this->massHLBProp($hLBId,
                    'ACTIVE_FROM','Активно с',
                    'Active from','datetime'));
                $userTypeEntity->Add($this->massHLBProp($hLBId,
                    'ACTIVE_TO','Активно до',
                    'Active to','datetime'));
                $userTypeEntity->Add($this->massHLBProp($hLBId,
                    'SORT','Сортировка',
                    'Sort','integer'));
                $userTypeEntity->Add($this->massHLBProp($hLBId,
                    'ACTIVE','Активность',
                    'Active','boolean'));

            }

        }


        protected function massHLBProp($id,$name,$ruName,$engName,$type){
            $carcas = [
                'ENTITY_ID' => 'HLBLOCK_'.$id,
                'FIELD_NAME' => 'UF_'.$name,
                'USER_TYPE_ID' => $type,
                'XML_ID' => $name,
                'SORT' => 100,
                'MULTIPLE' => 'N',
                'MANDATORY'         => 'Y',
                'SHOW_FILTER'       => 'N',
                'SHOW_IN_LIST'      => '',
                'EDIT_IN_LIST'      => '',
                'IS_SEARCHABLE'     => 'N',
                'SETTINGS'          => []
            ];
            $this->langArr($ruName,$engName,$carcas);
            $this->setSettings($type,$carcas);
            return $carcas;
        }
        protected function langArr($ruName,$engName,&$array)
        {
                $array['EDIT_FORM_LABEL'] = [
                    'ru'    => $ruName,
                    'en'    => $engName,
                ];
                $array['LIST_COLUMN_LABEL'] = [
                    'ru'    => $ruName,
                    'en'    => $engName,
                ];
                $array['LIST_FILTER_LABEL'] = [
                    'ru'    => $ruName,
                    'en'    => $engName,
                ];
                $array['ERROR_MESSAGE'] = [
                    'ru'    => 'Ошибка при заполнении пользовательского свойства <'.$ruName.'>',
                    'en'    => 'An error in completing the user field <'.$engName.'>',
                ];
                $array['HELP_MESSAGE'] = [
                    'ru'    => '',
                    'en'    => '',
                ];

        }
        protected  function setSettings($type,&$array)
        {
            switch ($type)
            {
                case 'string':
                    $array['SETTINGS'] = [
                        'DEFAULT_VALUE' => '',
                        'SIZE'          => '20',
                        'ROWS'          => '1',
                        'MIN_LENGTH'    => '0',
                        'MAX_LENGTH'    => '0',
                        'REGEXP'        => '',
                    ];
                    break;
                case 'datetime':
                    $array['SETTINGS'] = [
                    ];
                    break;
                case 'boolean':
                    $array['SETTINGS'] = [
                        'DEFAULT_VALUE' => 1,
                    ];
                    break;
                case 'integer':
                    $array['SETTINGS'] = [
                        'DEFAULT_VALUE' => 1,
                    ];
                    break;
            }
        }
		public function doUninstallDB(){
            global $DB,$DBType,$APPLICATION;
			Loader::includeModule($this->MODULE_ID);
            global $DB,$DBType,$APPLICATION;
            $error = $DB->RunSQLBatch($this->GetPath()."/install/db/".strtolower($DB->type)."/uninstall.sql");
            if($error)
            {
                $APPLICATION->ThrowException($error);
            }
            Loader::includeModule('highloadblock');
            $id = $DB->Query("SELECT ID FROM b_hlblock_entity WHERE TABLE_NAME = 'promotion_row'")->fetch()["ID"];
            \Bitrix\Highloadblock\HighloadBlockTable::delete($id);
			Option::delete($this->MODULE_ID);
		}

		public function installFiles()
        {
            global $APPLICATION;
            $dirFrom = __DIR__."/components";
            $dirTo = str_replace('/modules/'.$this->MODULE_ID."/install",
                    '',__DIR__).'/components/lgcity.promotion';
            $it = new \RecursiveDirectoryIterator($dirFrom,
                \RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new \RecursiveIteratorIterator($it,
                \RecursiveIteratorIterator::CHILD_FIRST);
            foreach($files as $file) {
                if($file->isFile()) {
                    $path =  $files->getSubPath();
                    $inputFile = $file->getRealPath();
                    $outputFile = $dirTo.DIRECTORY_SEPARATOR
                        .$path.(!empty($path)? '/' : '').basename($inputFile);
                    try{
                        $destDir = dirname($outputFile);
                        if(!is_dir($destDir))
                            mkdir($destDir,0777,true);
                        copy($inputFile,$outputFile);
                    } catch (\Exception $e)
                    {
                        $APPLICATION->ThrowException($inputFile . ': ' . $e->getMessage());
                    }
                }
            }
        }
        public function doUninstallFiles()
        {
            $dir = str_replace('/modules/'.$this->MODULE_ID."/install",
                '',__DIR__).'/components/lgcity.promotion';
            if(!is_dir($dir))
                return true;
            else
            {
                $it = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
                $files = new \RecursiveIteratorIterator($it,
                    \RecursiveIteratorIterator::CHILD_FIRST);
                foreach($files as $file) {
                    if ($file->isDir()){
                        rmdir($file->getRealPath());
                    } else {
                        unlink($file->getRealPath());
                    }
                }
                rmdir($dir);
            }

        }
	}
