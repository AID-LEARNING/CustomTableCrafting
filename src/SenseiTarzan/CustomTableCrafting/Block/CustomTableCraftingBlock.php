<?php

namespace SenseiTarzan\CustomTableCrafting\Block;

use pocketmine\block\inventory\CraftingTableInventory;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use SenseiTarzan\SymplyPlugin\behavior\blocks\builder\BlockBuilder;
use SenseiTarzan\SymplyPlugin\behavior\blocks\component\CraftingTableComponent;
use SenseiTarzan\SymplyPlugin\behavior\blocks\component\OnInteractComponent;
use SenseiTarzan\SymplyPlugin\behavior\blocks\component\sub\MaterialSubComponent;
use SenseiTarzan\SymplyPlugin\behavior\blocks\enum\RenderMethodEnum;
use SenseiTarzan\SymplyPlugin\behavior\blocks\enum\TargetMaterialEnum;
use SenseiTarzan\SymplyPlugin\behavior\blocks\Opaque;

class CustomTableCraftingBlock extends Opaque
{
	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
		if($player instanceof Player){
			$player->setCurrentWindow(new CraftingTableInventory($this->position));
		}

		return true;
	}

	public function getBlockBuilder(): BlockBuilder
	{
		return parent::getBlockBuilder()
			->addComponent(new OnInteractComponent())
			->setMaterialInstance(
				materials: [
				new MaterialSubComponent(TargetMaterialEnum::ALL, "crafting_table_top", RenderMethodEnum::OPAQUE)
			])
			->addComponent(new CraftingTableComponent(
				[
					"custom_table_crafting"
				],
				3,
				"Custom Crafting"
			));
	}
}