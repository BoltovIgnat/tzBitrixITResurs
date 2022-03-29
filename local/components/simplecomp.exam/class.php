<?
use \Bitrix\Main\Application;
use \Bitrix\Main\Loader;



class FeedbackComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($params)
    {

        return $params;
    }

    public function executeComponent()
    {
        Loader::includeModule("iblock");
        global $APPLICATION;
        $APPLICATION->SetPageProperty('title','Тестовое задание');

        $filter = array(
            "IBLOCK_ID" => $this->arParams['PRODUCTS_IBLOCK_ID'],
            "ACTIVE" => "Y"
        );

        $this->arResult['ITEMS'] = [];
        $entity = \Bitrix\Iblock\Model\Section::compileEntityByIblock($this->arParams['PRODUCTS_IBLOCK_ID']);

        $rsNews =  \Bitrix\Iblock\ElementTable::getList(array(
            "filter" => array(
                "IBLOCK_ID" => $this->arParams['NEWS_IBLOCK_ID'],
                "ACTIVE" => "Y"
            ),
            "select" => array("*"),

        ));

        while($arNews=$rsNews->Fetch()){
            $this->arResult['NEWS'][$arNews['ID']] = $arNews;
        }

        $rsSection = $entity::getList(array(
            "filter" => $filter,
            "select" => array("ID","NAME","DATE_CREATE","UF_NEWS_LINK"),

        ));

        while($arSection=$rsSection->Fetch()){
            foreach ($arSection['UF_NEWS_LINK'] as &$value) {
                $this->arResult['ITEMS'][$value]['SECTIONS'][$arSection["ID"]] = $arSection;

                $this->arResult['MAPPING'][$arSection["ID"]][] = $value;
            }
        }

        $elements = \Bitrix\Iblock\ElementTable::getList([
            'select' => ['ID', 'NAME', 'DATE_CREATE', 'IBLOCK_SECTION'],
            'filter' => $filter,
        ]);

        while ($obElement = $elements->fetch()) {
            foreach ($this->arResult['MAPPING'][$obElement['IBLOCK_ELEMENT_IBLOCK_SECTION_ID']] as &$value) {
                $this->arResult['ITEMS'][$value]['PRODUCTS'][$obElement["ID"]] = $obElement;
                $dbProperty = \CIBlockElement::getProperty(
                    $this->arParams['PRODUCTS_IBLOCK_ID'],
                    $obElement['ID'],
                    array("sort", "asc"),
                    array()
                );
                while ($arProperty = $dbProperty->GetNext()) {
                    if ($arProperty["CODE"] == "PRICE") $this->arResult['ITEMS'][$value]['PRODUCTS'][$obElement["ID"]]["PRICE"] = $arProperty["VALUE"];
                    if ($arProperty["CODE"] == "ARTNUMBER") $this->arResult['ITEMS'][$value]['PRODUCTS'][$obElement["ID"]]["ARTNUMBER"] = $arProperty["VALUE"];
                    if ($arProperty["CODE"] == "MATERIAL") $this->arResult['ITEMS'][$value]['PRODUCTS'][$obElement["ID"]]["MATERIAL"] = $arProperty["VALUE"];
                }
            }



        }

        $APPLICATION->SetTitle("Элементов - ".$elements->getSelectedRowsCount());


        $this->IncludeComponentTemplate();
    }
}


?>
