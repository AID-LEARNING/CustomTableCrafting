<?php

namespace SenseiTarzan\CustomTableCrafting;

use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockTypeIds;
use pocketmine\block\BlockTypeInfo;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Filesystem;
use SenseiTarzan\CustomTableCrafting\Block\CustomTableCraftingBlock;
use SenseiTarzan\Path\PathScanner;
use SenseiTarzan\SymplyPlugin\behavior\blocks\BlockIdentifier;
use SenseiTarzan\SymplyPlugin\behavior\SymplyBlockFactory;
use SenseiTarzan\SymplyPlugin\Main as SymplyMain;
use Symfony\Component\Filesystem\Path;

class Main extends PluginBase
{

	protected function onLoad(): void
	{
		$path = Path::join($this->getResourceFolder(), "craft") . "/";
		foreach (PathScanner::scanDirectoryGenerator($path, ['json']) as $file){
			$destinationPath = Path::join(SymplyMain::getInstance()->getSymplyCraftManager()->getPathCraft(), str_replace($path, "", $file));
			if (file_exists($destinationPath) && strcmp(md5(Filesystem::fileGetContents($destinationPath)), md5(Filesystem::fileGetContents($file))) === 0) continue;
			@mkdir(dirname($destinationPath), 0755, true);
			copy($this->getResourcePath(str_replace($this->getResourceFolder(), "", $file)), $destinationPath);
		}
		SymplyBlockFactory::getInstance()->register(static fn() => new CustomTableCraftingBlock(new BlockIdentifier("symply:custom_table", BlockTypeIds::newId()), "Custom Crafting", new BlockTypeInfo(BlockBreakInfo::axe(2.5)))) ;
	}
}